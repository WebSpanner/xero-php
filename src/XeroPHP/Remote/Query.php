<?php

namespace XeroPHP\Remote;

use XeroPHP\Application;

class Query {

    const ORDER_ASC  = 'ASC';
    const ORDER_DESC = 'DESC';

    /** @var  \XeroPHP\Application */
    private $app;

    private $from_class;
    private $where;
    private $order;
    private $modifiedAfter;
    private $page;
    private $offset;

    public function __construct(Application $app) {
        $this->app = $app;
        $this->where = array();
        $this->order = null;
        $this->modifiedAfter = null;
        $this->page = null;
        $this->offset = null;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function from($class) {

        $this->from_class = $this->app->validateModelClass($class);

        return $this;
    }

    /**
     * Adds a WHERE statment to the query. Can also be used to chain an AND WHERE statement to
     * a query.
     *
     * @return $this
     */
    public function where() {
        return $this->addWhere('AND', func_get_args());
    }

    /**
     * Chains an OR WHERE statement on to the query
     *
     * @return $this
     **/
    public function orWhere() {
        return $this->addWhere('OR', func_get_args());
    }

    /**
     * Chains an AND WHERE statement on to the query.
     * ( Note this method is effectively an alias for where() to help make fluent
     * queries more readable and less ambiguous )
     *
     * @return $this
     **/
    public function andWhere() {
        return $this->addWhere('AND', func_get_args());
    }

    /**
     * @return $this
     **/
    public function addWhere($operator, $args)
    {
        // Add operator unless this is the first where statement
        if (count($this->where) > 0) {
            $this->where[] = $operator;
        }

        if(count($args) === 2) {
            if(is_bool($args[1])) {
                $this->where[] = sprintf('%s=%s', $args[0], $args[1] ? 'true' : 'false');
            } elseif(is_int($args[1])) {
                $this->where[] = sprintf('%s==%s', $args[0], $args[1]);
            } elseif(preg_match('/^(\'|")?(true|false)("|\')?$/i', $args[1])) {
                $this->where[] = sprintf('%s=%s', $args[0], $args[1]);
            } elseif(preg_match('/^([a-z]+)\.\1ID$/i', $args[0]) && preg_match('/^[0-9a-f]{8}-([0-9a-f]{4}-){3}[0-9a-f]{12}$/i', $args[1])) {
                $this->where[] = sprintf('%s=Guid("%s")', $args[0], $args[1]);
            } else {
                $this->where[] = sprintf('%s=="%s"', $args[0], $args[1]);
            }
        } else {
            $this->where[] = $args[0];
        }

        return $this;
    }

    /**
     * Concatenates the array of where statements stored in $this->where and returns
     * them as a string
     *
     * @return $string
     **/
    public function getWhere()
    {
        return implode(' ', $this->where);
    }

    /**
     * @param string $order
     * @param string $direction
     * @return $this
     */
    public function orderBy($order, $direction = self::ORDER_ASC) {
        $this->order = sprintf('%s %s', $order, $direction);

        return $this;
    }

    /**
     * @param \DateTimeInterface|null $modifiedAfter
     * @return $this
     */
    public function modifiedAfter(\DateTimeInterface $modifiedAfter = null) {
        if($modifiedAfter === null) {
            $modifiedAfter = new \DateTime('@0'); // since ever
        }

        $this->modifiedAfter = $modifiedAfter->format('c');

        return $this;
    }

    /**
     * @param int $page
     * @return $this
     * @throws Exception
     */
    public function page($page = 1) {
        /** @var ObjectInterface $from_class */
        $from_class = $this->from_class;
        if(!$from_class::isPageable()){
            throw new Exception(sprintf('%s does not support paging.', $from_class));
        }

        $this->page = intval($page);

        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset($offset = 0) {
        $this->offset = intval($offset);

        return $this;
    }

    /**
     * @return Collection
     */
    public function execute() {

        /** @var ObjectInterface $from_class */
        $from_class = $this->from_class;
        $url = new URL($this->app, $from_class::getResourceURI(), $from_class::getAPIStem());
        $request = new Request($this->app, $url, Request::METHOD_GET);

        // Concatenate where statements
        $where = $this->getWhere();

        if(!empty($where)) {
            $request->setParameter('where', $where);
        }

        if($this->order !== null) {
            $request->setParameter('order', $this->order);
        }

        if($this->modifiedAfter !== null) {
            $request->setHeader('If-Modified-Since', $this->modifiedAfter);
        }

        if($this->page !== null) {
            $request->setParameter('page', $this->page);
        }

        if($this->offset !== null) {
            $request->setParameter('offset', $this->offset);
        }

        $request->send();

        $elements = new Collection();
        foreach($request->getResponse()->getElements() as $element) {
            /** @var Object $built_element */
            $built_element = new $from_class($this->app);
            $built_element->fromStringArray($element);
            $elements->append($built_element);
        }

        return $elements;
    }

    /**
     * @return mixed
     */
    public function getFrom() {
        return $this->from_class;
    }
}
