<?php


/**
 * MenuManager menu edit page left menu
 *
 * @category    Thinhld
 * @package     sm_slider
 */
class SM_Slider_Block_Adminhtml_Slider_Edit_Tabs
    extends Mage_Adminhtml_Block_Widget_Tabs
{
    public function __construct()
    {
        parent::__construct();

        $this->setId('slider_page_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('sm_slider')->__('Slider Information'));
    }

    /**
     * Add "Menu Items" tab and its content
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _beforeToHtml()
    {
        if ($this->getRequest()->getParam('slider_id')) {
            $itemsTabContent = $this->getLayout()
                ->createBlock('sm_slider/adminhtml_slider_edit_tab_items')
                ->toHtml();
        } else {
            $itemsTabContent = Mage::helper('sm_slider')->__(
                '<ul class="messages"><li class="notice-msg"><ul><li><span>%s</span></li></ul></li></ul>',
                Mage::helper('sm_slider')->__('You will be able to manage items after saving this Slider.')
            );
        }

        $itemSectionStatus = $this->getRequest()
            ->getParam('active_tab') == 'slider_page_tabs_items_section' ? true : false;

        $this->addTab('items_section', array(
            'label' => $this->__('Slider Items'),
            'title' => $this->__('Slider Items'),
            'active' => $itemSectionStatus,
            'content' => $itemsTabContent,
        ));

        return parent::_beforeToHtml();
    }
}
