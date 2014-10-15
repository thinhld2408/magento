<?php
/**
 * Created by PhpStorm.
 * User: CITA
 * Date: 27/09/14
 * Time: 17:05
 */
class SM_FeaturedProduct_Model_Resource_List extends Mage_Core_Model_Resource_Db_Abstract{

    protected function _construct()
    {
        $this->_init('vendors/list', 'vendor_id');
    }
}

?>