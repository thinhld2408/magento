<?php


/**
 * MenuManager menu item edit form container
 *

 * @package     sm_slider
 */
class SM_Slider_Block_Adminhtml_Slider_Item_Edit
    extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId   = 'item_id';
        $this->_blockGroup = 'sm_slider';
        $this->_controller = 'adminhtml_slider_item';

        parent::__construct();

        $this->_updateButton('back', 'onclick', 'setLocation(\'' . $this->_getBackUrl() . '\')');
        $this->_updateButton('delete', 'onclick', 'setLocation(\'' . $this->_getDeleteUrl() . '\')');
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('slidermanager_slider_item')->getId()) {
            return Mage::helper('sm_slider')->__("Edit Slider Item '%s'",
                $this->escapeHtml(Mage::registry('slidermanager_slider_item')->getTitle()));
        } else {
            return Mage::helper('sm_slider')->__('New Slider Item');
        }
    }

    /**
     * get header css class
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'icon-head head-cms-block ' . strtr($this->_controller, '_', '-');
    }

    /**
     * Getter of url for "Back" button
     *
     * @return string
     */
    protected function _getBackUrl()
    {
        return $this->getUrl('*/*/edit', array(
            'slider_id' => $this->getRequest()->getParam('slider_id'),
            '_current' => true
        ));
    }

    /**
     * Getter of url for "Delete" button
     *
     * @return string
     */
    protected function _getDeleteUrl()
    {
        return $this->getUrl('*/*/delete_item', array(
            'slider_id' => $this->getRequest()->getParam('slider_id'),
            'item_id' => $this->getRequest()->getParam('item_id')
        ));
    }
}