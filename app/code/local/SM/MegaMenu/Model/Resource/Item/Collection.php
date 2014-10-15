<?php

/**
 * MenuManager menu item collection
 *
 * @package     sm_megamenu
 */
class SM_MegaMenu_Model_Resource_Item_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('sm_megamenu/item');
    }

    /**
     * Add menu filter to item collection
     *
     * @param   int | sm_megamenu_Model_Menu $menu
     * @return  sm_megamenu_Model_Resource_Item_Collection
     */
    public function addMenuFilter($menu)
    {
        if ($menu instanceof SM_MegaMenu_Model_Menu) {
            $menu = $menu->getId();
        }

        $this->addFilter('menu_id', $menu);

        return $this;
    }

    /**
     * Add status filter to item collection
     *
     * @return  sm_megamenu_Model_Resource_Item_Collection
     */
    public function addStatusFilter()
    {
        $this->addFilter('is_active', 1);

        return $this;
    }

    /**
     * Set order to item collection
     *
     * @return sm_megamenu_Model_Resource_Item_Collection
     */
    public function setPositionOrder()
    {
        $this->setOrder('parent_id', 'asc');
        $this->setOrder('position', 'asc');

        return $this;
    }

    /**
     * Collection to option array method
     *
     * @return array
     */
    public function toItemOptionArray()
    {
        $result = array();
        $result['0'] = Mage::helper('sm_megamenu')->__('Root');

        foreach ($this as $item) {
//            if($item->getData('item_type') != 'category_link' || $item->getData('item_type') != 'block_link')
//            {
                $result[$item->getData('item_id')] = $item->getData('title');
//            }
        }

        return $result;
    }
}