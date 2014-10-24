<?php

/**
 * MenuManager menu grid
 *
 * @category    Thinhld
 * @package     sm_megamenu
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('cmsMenuGrid');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection for grid
     *
     * @return SM_MegaMenu_Block_Adminhtml_Menu_Grid
     */
    protected function _prepareCollection()
    {
        /* @var $collection sm_megamenu_Model_Resource_Menu_Collection */
        $collection = Mage::getModel('sm_megamenu/menu')
            ->getResourceCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return sm_megamenu_Block_Adminhtml_Menu_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('title', array(
            'header'    => Mage::helper('sm_megamenu')->__('Title'),
            'index'     => 'title',
        ));

        $this->addColumn('identifier', array(
            'header'    => Mage::helper('sm_megamenu')->__('Identifier'),
            'index'     => 'identifier',
        ));

        $this->addColumn('type', array(
            'header'    => Mage::helper('sm_megamenu')->__('Type'),
            'index'     => 'type',
            'type'      => 'options',
            'options'   => Mage::getSingleton('sm_megamenu/menu')->getAvailableTypes(),
        ));



        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'        => Mage::helper('sm_megamenu')->__('Store View'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback' => array($this, '_filterStoreCondition'),
            ));
        }

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('sm_megamenu')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                0 => Mage::helper('sm_megamenu')->__('Disabled'),
                1 => Mage::helper('sm_megamenu')->__('Enabled')
            ),
        ));

        return parent::_prepareColumns();
    }

    /**
     * After collection load operations - load to add store data
     *
     * @return Mage_Adminhtml_Block_Widget_Grid | void
     */
    protected function _afterLoadCollection()
    {
        $this->getCollection()->walk('afterLoad');
        parent::_afterLoadCollection();
    }

    /**
     * Store filter condition callback - add store filter when needed
     *
     * @param $collection sm_megamenu_Model_Resource_Menu_Collection
     * @param $column Mage_Adminhtml_Block_Widget_Grid_Column
     */
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
    }

    /**
     * Return row url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('menu_id' => $row->getId()));
    }
}