<?php

/**
 * MenuManager menu grid
 *
 * @category    Thinhld
 * @package     sm_slider
 */
class SM_Slider_Block_Adminhtml_Slider_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

//        $this->setId('smSliderGrid');
        $this->setId('smSliderGrid');
        $this->setDefaultSort('slider_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection for grid
     *
     * @return SM_Slider_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareCollection()
    {
        /* @var $collection SM_Slider_Model_Resource_Slider_Collection */
        $collection = Mage::getModel('sm_slider/slider')
            ->getResourceCollection();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return SM_Slider_Block_Adminhtml_Slider_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('name', array(
            'header'    => Mage::helper('sm_slider')->__('Title'),
            'index'     => 'name',
        ));

        $this->addColumn('mode', array(
            'header'    => Mage::helper('sm_slider')->__('Mode'),
            'index'     => 'mode',
            'type'      => 'options',
            'options'   => Mage::getSingleton('sm_slider/slider')->getAvailableTypes(),
        ));

        $this->addColumn('width', array(
            'header'    => Mage::helper('sm_slider')->__('Class Width'),
            'index'     => 'width',
        ));
        $this->addColumn('height', array(
            'header'    => Mage::helper('sm_slider')->__('Class Height'),
            'index'     => 'height',
        ));

//        if (!Mage::app()->isSingleStoreMode()) {
//            $this->addColumn('store_id', array(
//                'header'        => Mage::helper('sm_slider')->__('Store View'),
//                'index'         => 'store_id',
//                'type'          => 'store',
//                'store_all'     => true,
//                'store_view'    => true,
//                'sortable'      => false,
//                'filter_condition_callback' => array($this, '_filterStoreCondition'),
//            ));
//        }

        $this->addColumn('is_active', array(
            'header'    => Mage::helper('sm_slider')->__('Status'),
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                0 => Mage::helper('sm_slider')->__('Disabled'),
                1 => Mage::helper('sm_slider')->__('Enabled')
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
     * @param $collection SM_Slider_Model_Resource_Slider_Collection
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
        return $this->getUrl('*/*/edit', array('slider_id' => $row->getId()));
    }
}