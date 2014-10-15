<?php
/**
 * Created by PhpStorm.
 * User: CITA
 * Date: 28/09/14
 * Time: 09:32
 */
class SM_FeaturedProduct_Model_Resource_List_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract {
    protected function _construct()
    {
        $this->_init('vendors/list');
    }
}

?>