<?php
/*
* Create by PhpStorm.
* User: quynh.
* Unit Department: Fresher06.
*/
class SM_ProductLabel_Model_Resource_Productlabel extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        $this->_init('productlabel/productlabel', 'label_id');
    }
}
 