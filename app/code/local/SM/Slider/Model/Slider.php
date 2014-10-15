<?php

/**
 * MenuManager menu model
 *
 * @category    Thinhld
 * @package     sm_slider
 */
class SM_Slider_Model_Slider extends Mage_Core_Model_Abstract
{

    const TYPE_HORIZONTAL = 'horizontal';
    const TYPE_VERTICAL = 'vertical';
    const TYPE_NONE = 'none';


    const CACHE_TAG = 'slider';

    protected function _construct()
    {
        $this->_init('sm_slider/slider');
    }

    public function getAvailableTypes()
    {
        $types = array(
//            self::TYPE_NONE => Mage::helper('sm_slider')->__('None'),
            self::TYPE_VERTICAL => Mage::helper('sm_slider')->__('Vertical'),
            self::TYPE_HORIZONTAL => Mage::helper('sm_slider')->__('Horizontal'),
        );

        return $types;
    }
}
