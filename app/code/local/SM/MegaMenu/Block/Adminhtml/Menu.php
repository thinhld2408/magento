<?php

/**
 * MenuManager menu grid container
 *
 * @category    Thinhld
 * @package     sm_megamenu
 */
class SM_MegaMenu_Block_Adminhtml_Menu extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_menu';
        $this->_blockGroup = 'sm_megamenu';
        $this->_headerText = Mage::helper('sm_megamenu')->__('Manage Menu');

        parent::__construct();
    }

    /**
     * Get header css class
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'icon-head head-cms-block ' . parent::getHeaderCssClass();
    }
}