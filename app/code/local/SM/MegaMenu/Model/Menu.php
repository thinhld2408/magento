<?php

/**
 * MenuManager menu model
 *
 * @category    Thinhld
 * @package     sm_megamenu
 */
class SM_MegaMenu_Model_Menu extends Mage_Core_Model_Abstract
{

    const TYPE_HORIZONTAL = 'horizontal';
    const TYPE_VERTICAL = 'vertical';
    const TYPE_NONE = 'none';


    const CACHE_TAG = 'menumanager_menu';

    protected function _construct()
    {
        $this->_init('sm_megamenu/menu');
    }

    public function getAvailableTypes()
    {
        $types = array(
            self::TYPE_NONE => Mage::helper('sm_megamenu')->__('None'),
            self::TYPE_VERTICAL => Mage::helper('sm_megamenu')->__('Vertical'),
            self::TYPE_HORIZONTAL => Mage::helper('sm_megamenu')->__('Horizontal'),
        );

        return $types;
    }
}
