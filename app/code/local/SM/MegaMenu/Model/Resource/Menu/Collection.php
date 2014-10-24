<?php


/**
 * MenuManager menu collection
 *
 * @category    Thinhld
 * @package     sm_megamenu
 */
class SM_MegaMenu_Model_Resource_Menu_Collection
    extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('sm_megamenu/menu');
    }

    /**
     * Add store filter to menu collection
     *
     * @param   int | Mage_Core_Model_Store $store
     * @param   bool $withAdmin
     * @return  sm_megamenu_Model_Resource_Menu_Collection
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Mage_Core_Model_Store) {
            $store = array($store->getId());
        }

        if (!is_array($store)) {
            $store = array($store);
        }

        if ($withAdmin) {
            $store[] = Mage_Core_Model_App::ADMIN_STORE_ID;
        }

        $this->addFilter('store_id', array('in' => $store), 'public');

        return $this;
    }

    /**
     * Join store relation table data if store filter is used
     *
     * @return SM_MegaMenu_Model_Resource_Menu_Collection
     */
    protected function _renderFiltersBefore()
    {
        if ($this->getFilter('store_id')) {
            $this->getSelect()->join(
                array('store_table' => $this->getTable('sm_megamenu/menu_store')),
                'main_table.menu_id = store_table.menu_id',array()
            )->group('main_table.menu_id');
        }

        return parent::_renderFiltersBefore();
    }
}