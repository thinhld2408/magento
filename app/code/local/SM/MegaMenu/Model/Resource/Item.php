<?php



/**
 * MenuManager menu item model
 *
 * @category    Thinhld
 * @package     sm_megamenu
 */
class SM_MegaMenu_Model_Resource_Item extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('sm_megamenu/menu_item', 'item_id');
    }

    /**
     * Load an object using 'identifier' field
     *
     * @param   Mage_Core_Model_Abstract    $object
     * @param   mixed                       $value
     * @param   string                      $field
     * @return  sm_megamenu_Model_Resource_Item
     */
    public function load(Mage_Core_Model_Abstract $object, $value, $field = null)
    {
        if (!is_numeric($value) && is_null($field)) {
            $field = 'identifier';
        }

        return parent::load($object, $value, $field);
    }

    /**
     * Perform operations before object save - add unique 'identifier' and check item parent
     *
     * @param sm_megamenu_Model_Item $object
     * @return sm_megamenu_Model_Resource_Item
     */
    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {
        if ($object->getId() && $object->getId() == $object->getParentId()) {
            Mage::throwException(Mage::helper('sm_megamenu')
                ->__('Menu item can not be parent to itself.'));

            return $this;
        }

        if (!$object->getMenuId()) {
            Mage::throwException(Mage::helper('sm_megamenu')
                ->__('Menu item parent menu must be specified.'));

            return $this;
        }

        if (!$object->getIdentifier()) {
            $object->setIdentifier('menu_' . $object->getMenuId() . '_item_' . date('Y_m_d_H_i_s'));
        }

        Mage::app()->cleanCache(sm_megamenu_Model_Menu::CACHE_TAG);

        return $this;
    }
}
