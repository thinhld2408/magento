<?php

/**
 * MenuManager menu items grid
 *
 * @package     sm_slider
 */
class SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Items
    extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('sliderItemsGrid');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection for grid
     *
     * @return SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Items
     */
    protected function _prepareCollection()
    {
        /* @var $collection sm_slider_Model_Resource_Item_Collection */
        $collection = Mage::getModel('sm_slider/item')->getResourceCollection()
            ->addSliderFilter(Mage::registry('slidermanager_slider'))
            ->setPositionOrder();
//        var_dump($collection);
//        die();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Items
     */
    protected function _prepareColumns()
    {
//        /* @var $model SM_Slider_Model_Slider*/
//        $SliderModel = Mage::registry('slidermanager_slider');
//
//        /* @var $model sm_slider_Model_Item*/
//        $ItemModel = Mage::getModel('sm_slider/item');
        $this->addColumn('item_picture', array(
            'header'    => Mage::helper('sm_slider')->__('Picture'),
            'index'     => 'item_picture',
            'align' => 'center',
            'renderer'  => 'SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Renderer_Render',
        ));
        $this->addColumn('item_name', array(
            'header'    => Mage::helper('sm_slider')->__('Name'),
            'index'     => 'item_name',
        ));
        $this->addColumn('item_title', array(
            'header'    => Mage::helper('sm_slider')->__('Title'),
            'index'     => 'item_title',
        ));
        $this->addColumn('item_url', array(
            'header'    => Mage::helper('sm_slider')->__('Url'),
            'index'     => 'item_url',
        ));

        $this->addColumn('item_position', array(
            'header'    => Mage::helper('sm_slider')->__('Position'),
            'index'     => 'position',
        ));

        $this->addColumn('item_is_active', array(
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
     * Return row url
     *
     * @return string
     */
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit_item', array(
            'item_id' => $row->getId(),
            'active_tab' => 'slider_page_tabs_items_section',
            'slider_id' => $this->getRequest()->getParam('slider_id'),
        ));
    }
}