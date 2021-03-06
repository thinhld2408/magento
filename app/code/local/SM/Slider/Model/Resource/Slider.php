<?php


/**
 * MenuManager menu model
 *
 * @category    Thinhld
 * @package     sm_slider
 */
class SM_Slider_Model_Resource_Slider extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('sm_slider/slider', 'slider_id');
    }

    /**
     * Load an object using 'identifier' field
     *
     * @param   Mage_Core_Model_Abstract    $object
     * @param   mixed                       $value
     * @param   string                      $field
     * @return  SM_Slider_Model_Resource_Slider
     */
    public function load(Mage_Core_Model_Abstract $object, $value, $field = null)
    {
        if (!is_numeric($value) && is_null($field)) {
            $field = 'slider_id';
        }

        return parent::load($object, $value, $field);
    }


    protected function _beforeSave(Mage_Core_Model_Abstract $object)
    {


        Mage::app()->cleanCache(SM_Slider_Model_Slider::CACHE_TAG);

        return $this;
    }

    /**
     * Perform operations after object load - add stores data
     *
     * @param Mage_Core_Model_Abstract $object
     * @return SM_Slider_Model_Resource_Slider
     */
    protected function _afterLoad(Mage_Core_Model_Abstract $object)
    {
//        if ($object->getId()) {
//            $stores = $this->lookupStoreIds($object->getId());
//
//            $object->setData('store_id', $stores);
//            $object->setData('stores', $stores);
//        }

        return parent::_afterLoad($object);
    }

    /**
     * Perform operations after object save - update menu stores data
     *
     * @param Mage_Core_Model_Abstract $object
     * @return SM_Slider_Model_Resource_Slider
     */
//    protected function _afterSave(Mage_Core_Model_Abstract $object)
//    {
//        $oldStores = $this->lookupStoreIds($object->getId());
//        $newStores = (array)$object->getStores();
//
//        $table  = $this->getTable('sm_slider/slider_store');
//
//        $insert = array_diff($newStores, $oldStores);
//        $delete = array_diff($oldStores, $newStores);
//
//        if ($delete) {
//            $where = array(
//                'slider_id = ?'     => (int) $object->getId(),
//                'store_id IN (?)' => $delete
//            );
//
//            $this->_getWriteAdapter()->delete($table, $where);
//        }
//
//        if ($insert) {
//            $data = array();
//
//            foreach ($insert as $storeId) {
//                $data[] = array(
//                    'slider_id'  => (int) $object->getId(),
//                    'store_id' => (int) $storeId
//                );
//            }
//
//            $this->_getWriteAdapter()->insertMultiple($table, $data);
//        }
//
//        return parent::_afterSave($object);
//    }

    /**
     * Check if menu identifier is unique in store(s).
     *
     * @param Mage_Core_Model_Abstract $object
     * @return bool
     */
//    public function getIsUniqueMenuToStores(Mage_Core_Model_Abstract $object)
//    {
//        if (Mage::app()->isSingleStoreMode()) {
//            $stores = array(Mage_Core_Model_App::ADMIN_STORE_ID);
//        } else {
//            $stores = (array)$object->getData('stores');
//        }
//
//        $select = $this->_getReadAdapter()->select()
//            ->from(
//                array('slider' => $this->getMainTable())
//            )
//            ->join(
//                array('slider_stores' => $this->getTable('sm_slider/slider_store')),
//                'menu.slider_id = menu_stores.slider_id', array()
//            )
//            ->where('menu.identifier = ?', $object->getData('identifier'))
//            ->where('menu_stores.store_id IN (?)', $stores);
//
//        if ($object->getId()) {
//            $select->where('menu.menu_id <> ?', $object->getId());
//        }
//
//        if ($this->_getReadAdapter()->fetchRow($select)) {
//            return false;
//        }
//
//        return true;
//    }

    /**
     * Get store IDs to which menu is assigned
     *
     * @param int $id
     * @return array
     */
//    public function lookupStoreIds($id)
//    {
//        $adapter = $this->_getReadAdapter();
//
//        $select  = $adapter->select()
//            ->from($this->getTable('sm_slider/slider_store'), 'store_id')
//            ->where('slider_id = :slider_id');
//
//        $binds = array(
//            ':slider_id' => (int) $id
//        );
//
//        return $adapter->fetchCol($select, $binds);
//    }

    /**
     * Load only appropriate menu to specified store
     *
     * @param string $field
     * @param mixed  $value
     * @param SM_Slider_Model_Slider $object
     * @return Zend_Db_Select
     */
//    protected function _getLoadSelect($field, $value, $object)
//    {
//        $select = parent::_getLoadSelect($field, $value, $object);
//
//        if ($object->getStoreId()) {
//            $stores = array(
//                (int) $object->getStoreId(),
//                Mage_Core_Model_App::ADMIN_STORE_ID
//            );
//
//            $select->join(
//                array('menu_store' => $this->getTable('sm_slider/menu_store')),
//                $this->getMainTable() . '.menu_id = menu_store.menu_id',
//                array('store_id')
//            )
//            ->where('menu_store.store_id in (?) ', $stores)
//            ->where('is_active = ?', 1)
//            ->order('store_id DESC')
//            ->limit(1);
//        }
//
//        return $select;
//    }
}
