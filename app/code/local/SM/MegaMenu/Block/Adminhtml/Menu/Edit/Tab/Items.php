<?php

/**
 * MenuManager menu items grid
 *
 * @package     sm_megamenu
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Edit_Tab_Items extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('cmsMenuItemsGrid');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare collection for grid
     *
     * @return SM_MegaMenu_Block_Adminhtml_Menu_Edit_Tab_Items
     */
    protected function _prepareCollection()
    {
        /* @var $collection SM_MegaMenu_Model_Resource_Item_Collection */
        $collection = Mage::getModel('sm_megamenu/item')->getResourceCollection()
            ->addMenuFilter(Mage::registry('menumanager_menu'))
            ->setPositionOrder();

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return SM_MegaMenu_Block_Adminhtml_Menu_Edit_Tab_Items
     */
    protected function _prepareColumns()
    {
        /* @var $model SM_MegaMenu_Model_Menu*/
        $menuModel = Mage::registry('menumanager_menu');

        /* @var $model SM_MegaMenu_Model_Item*/
        $ItemModel = Mage::getModel('sm_megamenu/item');

        $this->addColumn('item_title', array(
            'header'    => Mage::helper('sm_megamenu')->__('Title'),
            'index'     => 'title',
        ));

        $this->addColumn('item_parent_id', array(
            'header'    => Mage::helper('sm_megamenu')->__('Parent'),
            'index'     => 'parent_id',
            'type'      => 'options',
            'renderer'  => 'SM_MegaMenu_Block_Adminhtml_Menu_Edit_Tab_Renderer_Parent',
            'options'   => $ItemModel->getCollection()
                ->addMenuFilter($menuModel)
                ->toItemOptionArray(),
        ));

        $this->addColumn('item_url', array(
            'header'    => Mage::helper('sm_megamenu')->__('Url'),
            'index'     => 'url',
        ));

        $this->addColumn('item_show_type', array(
            'header'    => Mage::helper('sm_megamenu')->__('Show Type'),
            'index'     => 'type_view',
            'type'      => 'options',
            'options'   => $ItemModel->getTypeView(),
        ));
        $this->addColumn('item_type', array(
            'header'    => Mage::helper('sm_megamenu')->__('Type Item'),
            'index'     => 'item_type',
            'type'      => 'options',
            'options'   => $ItemModel->getItemsTypes(),
        ));

        $this->addColumn('item_position', array(
            'header'    => Mage::helper('sm_megamenu')->__('Position'),
            'index'     => 'position',
        ));

        $this->addColumn('item_is_active', array(
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
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit_item', array(
            'item_id' => $row->getId(),
            'active_tab' => 'menu_page_tabs_items_section',
            'menu_id' => $this->getRequest()->getParam('menu_id'),
        ));
    }
}