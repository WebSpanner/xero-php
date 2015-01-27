<?php

namespace XeroPHP\Models\Accounting;

use XeroPHP\Remote;

use XeroPHP\Models\Accounting\BankTransfer\FromBankAccount;
use XeroPHP\Models\Accounting\BankTransfer\ToBankAccount;

class BankTransfer extends Remote\Object {

    /**
     * See FromBankAccount
     *
     * @property FromBankAccount FromBankAccount
     */

    /**
     * See ToBankAccount
     *
     * @property ToBankAccount ToBankAccount
     */

    /**
     * 
     *
     * @property string Amount
     */

    /**
     * The date of the Transfer YYYY-MM-DD
     *
     * @property \DateTime Date
     */

    /**
     * The identifier of the Bank Transfer
     *
     * @property string BankTransferID
     */

    /**
     * The currency rate
     *
     * @property float CurrencyRate
     */

    /**
     * The Bank Transaction ID for the source account
     *
     * @property string FromBankTransactionID
     */

    /**
     * The Bank Transaction ID for the destination account
     *
     * @property string ToBankTransactionID
     */

    /**
     * Boolean to indicate if a Bank Transfer has an attachment
     *
     * @property bool HasAttachments
     */



    /*
    * Get the resource uri of the class (Contacts) etc
    *
    * @return string
    */
    public static function getResourceURI(){
        return 'BankTransfers';
    }


    /*
    * Get the root node name.  Just the unqualified classname
    *
    * @return string
    */
    public static function getRootNodeName(){
        return 'BankTransfer';
    }


    /*
    * Get the guid property
    *
    * @return string
    */
    public static function getGUIDProperty(){
        return 'BankTransferID';
    }


    /**
    * Get the stem of the API (core.xro) etc
    *
    * @return string|null
    */
    public static function getAPIStem(){
        return Remote\URL::API_CORE;
    }


    /*
    * Get the supported methods
    */
    public static function getSupportedMethods(){
        return array(
            Remote\Request::METHOD_GET,
            Remote\Request::METHOD_PUT
        );
    }

    /**
     *
     * Get the properties of the object.  Indexed by constants
     *  [0] - Mandatory
     *  [1] - Type
     *  [2] - PHP type
     *  [3] - Is an Array
     *
     * @return array
     */
    public static function getProperties(){
        return array(
            'FromBankAccount' => array (true, self::PROPERTY_TYPE_OBJECT, 'Accounting\\BankTransfer\\FromBankAccount', false),
            'ToBankAccount' => array (true, self::PROPERTY_TYPE_OBJECT, 'Accounting\\BankTransfer\\ToBankAccount', false),
            'Amount' => array (true, self::PROPERTY_TYPE_STRING, null, false),
            'Date' => array (false, self::PROPERTY_TYPE_DATE, '\\DateTime', false),
            'BankTransferID' => array (false, self::PROPERTY_TYPE_STRING, null, false),
            'CurrencyRate' => array (false, self::PROPERTY_TYPE_FLOAT, null, false),
            'FromBankTransactionID' => array (false, self::PROPERTY_TYPE_STRING, null, false),
            'ToBankTransactionID' => array (false, self::PROPERTY_TYPE_STRING, null, false),
            'HasAttachments' => array (false, self::PROPERTY_TYPE_BOOLEAN, null, false)
        );
    }


    /**
     * @return FromBankAccount
     */
    public function getFromBankAccount(){
        return $this->_data['FromBankAccount'];
    }

    /**
     * @param FromBankAccount $value
     * @return BankTransfer
     */
    public function setFromBankAccount(FromBankAccount $value){
        $this->propertyUpdated('FromBankAccount', $value);
        $this->_data['FromBankAccount'] = $value;
        return $this;
    }

    /**
     * @return ToBankAccount
     */
    public function getToBankAccount(){
        return $this->_data['ToBankAccount'];
    }

    /**
     * @param ToBankAccount $value
     * @return BankTransfer
     */
    public function setToBankAccount(ToBankAccount $value){
        $this->propertyUpdated('ToBankAccount', $value);
        $this->_data['ToBankAccount'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getAmount(){
        return $this->_data['Amount'];
    }

    /**
     * @param string $value
     * @return BankTransfer
     */
    public function setAmount($value){
        $this->propertyUpdated('Amount', $value);
        $this->_data['Amount'] = $value;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate(){
        return $this->_data['Date'];
    }

    /**
     * @param \DateTime $value
     * @return BankTransfer
     */
    public function setDate(\DateTime $value){
        $this->propertyUpdated('Date', $value);
        $this->_data['Date'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getBankTransferID(){
        return $this->_data['BankTransferID'];
    }

    /**
     * @param string $value
     * @return BankTransfer
     */
    public function setBankTransferID($value){
        $this->propertyUpdated('BankTransferID', $value);
        $this->_data['BankTransferID'] = $value;
        return $this;
    }

    /**
     * @return float
     */
    public function getCurrencyRate(){
        return $this->_data['CurrencyRate'];
    }

    /**
     * @param float $value
     * @return BankTransfer
     */
    public function setCurrencyRate($value){
        $this->propertyUpdated('CurrencyRate', $value);
        $this->_data['CurrencyRate'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getFromBankTransactionID(){
        return $this->_data['FromBankTransactionID'];
    }

    /**
     * @param string $value
     * @return BankTransfer
     */
    public function setFromBankTransactionID($value){
        $this->propertyUpdated('FromBankTransactionID', $value);
        $this->_data['FromBankTransactionID'] = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getToBankTransactionID(){
        return $this->_data['ToBankTransactionID'];
    }

    /**
     * @param string $value
     * @return BankTransfer
     */
    public function setToBankTransactionID($value){
        $this->propertyUpdated('ToBankTransactionID', $value);
        $this->_data['ToBankTransactionID'] = $value;
        return $this;
    }

    /**
     * @return bool
     */
    public function getHasAttachments(){
        return $this->_data['HasAttachments'];
    }

    /**
     * @param bool $value
     * @return BankTransfer
     */
    public function setHasAttachment($value){
        $this->propertyUpdated('HasAttachments', $value);
        $this->_data['HasAttachments'] = $value;
        return $this;
    }


}