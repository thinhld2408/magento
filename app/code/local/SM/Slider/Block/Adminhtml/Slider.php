<?php

/**
 * MenuManager menu grid container
 *
 * @category    Thinhld
 * @package     sm_slider
 */
class SM_Slider_Block_Adminhtml_Slider extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_slider';
        $this->_blockGroup = 'sm_slider';
        $this->_headerText = Mage::helper('sm_slider')->__('Manage Slider');

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