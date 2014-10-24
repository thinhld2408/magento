<?php
/*
* create by user: quynh.
* unit department: fresher 06.
*/
class SM_ProductLabel_Model_Productlabel extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('productlabel/productlabel');
    }


}