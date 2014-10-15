<?php

/**
 * MenuManager menu item model
 *
 * @category    Thinhld
 * @package     sm_slider
 */
class SM_Slider_Model_Item extends Mage_Core_Model_Abstract
{
    /**
     * Menu item url open window types
     */


    protected function _construct()
    {
        parent::_construct();
        $this->_init('sm_slider/item');
    }




}
