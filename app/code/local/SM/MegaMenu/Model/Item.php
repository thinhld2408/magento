<?php

/**
 * MenuManager menu item model
 *
 * @category    Thinhld
 * @package     sm_megamenu
 */
class SM_MegaMenu_Model_Item extends Mage_Core_Model_Abstract
{
    /**
     * Menu item url open window types
     */
    const TYPE_NEW_WINDOW = 'new_window';
    const TYPE_SAME_WINDOW = 'same_window';
    const TYPE_CATEGORY_LINK = 'category_link';
    const TYPE_CUSTOM_LINK = 'custom_link';
    const TYPE_BLOCK_LINK = 'block_link';
    const TYPE_MEGA_MENU = 'mega_link';

    protected function _construct()
    {
        $this->_init('sm_megamenu/item');
    }

    /**
     * Prepare menu item url open window types
     *
     * @return array
     */
    public function getAvailableTypes()
    {
        $types = array(
            self::TYPE_SAME_WINDOW => Mage::helper('sm_megamenu')->__('Same Window'),
            self::TYPE_NEW_WINDOW => Mage::helper('sm_megamenu')->__('New Window'),
        );

        return $types;
    }
    public function getItemsTypes()
    {
        $types = array(
            self::TYPE_CATEGORY_LINK => Mage::helper('sm_megamenu')->__('Category Link'),
            self::TYPE_CUSTOM_LINK => Mage::helper('sm_megamenu')->__('Custom Link'),
            self::TYPE_BLOCK_LINK => Mage::helper('sm_megamenu')->__('Block Link'),
            self::TYPE_MEGA_MENU => Mage::helper('sm_megamenu')->__('Mega Menu Link'),
        );
        return $types;
    }
    public function getTypeView(){

        $types = array(
            'tree' => Mage::helper('sm_megamenu')->__('Tree Type Show'),
            'column' => Mage::helper('sm_megamenu')->__('Column Type Show')
        );
        return $types;

    }
    public function getColumnView(){

        $types = array(
            '1' => Mage::helper('sm_megamenu')->__('1 Column'),
            '2' => Mage::helper('sm_megamenu')->__('2 Columns'),
            '3' => Mage::helper('sm_megamenu')->__('3 Columns'),
            '4' => Mage::helper('sm_megamenu')->__('4 Columns')
        );
        return $types;

    }

}
