<?php

/**
 * MenuManager menu edit form container
 *
 * @category    Thinhld
 * @package     sm_slider
 */
class SM_Slider_Block_Adminhtml_Slider_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        $this->_objectId   = 'slider_id';
        $this->_controller = 'adminhtml_slider';
        $this->_blockGroup = 'sm_slider';

        parent::__construct();

        $this->_addButton('saveandcontinue', array(
            'label'   => Mage::helper('adminhtml')->__('Save and Continue Edit'),
            'onclick' => 'saveAndContinueEdit(\'' . $this->_getSaveAndContinueUrl() . '\')',
            'class'   => 'save',
        ), -100);
//       $hello = Mage::registry('slidermanager_slider');

        if (Mage::registry('slidermanager_slider')->getId()) {
            $this->_addButton('addslideritem', array(
                'label'   => Mage::helper('sm_slider')->__('Add Slider Item'),
                'onclick' => 'setLocation(\'' . $this->_getAddSliderItemUrl() . '\')',
                'class'   => 'add'
            ), 0);
        }

        $this->_formScripts[] = "
            function saveAndContinueEdit(urlTemplate) {
                var template = new Template(urlTemplate, /(^|.|\\r|\\n)({{(\w+)}})/),
                    tabsIdValue = slider_page_tabsJsTabs.activeTab.id,
                    url = template.evaluate({tab_id:tabsIdValue});

                editForm.submit(url);
            }
        ";
    }

    /**
     * Retrieve text for header element depending on loaded page
     *
     * @return string
     */
    public function getHeaderText()
    {
        if (Mage::registry('slidermanager_slider')->getId()) {
            return Mage::helper('sm_slider')->__("Edit Slider".
                $this->escapeHtml(Mage::registry('slidermanager_slider')->getName()));
        } else {
            return Mage::helper('sm_slider')->__('New Slider');
        }
    }

    /**
     * Get header css class
     *
     * @return string
     */
    public function getHeaderCssClass()
    {
        return 'icon-head head-cms-block ' . strtr($this->_controller, '_', '-');
    }

    /**
     * Getter of url for "Save and Continue" button
     *
     * @return string
     */
    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('*/*/save', array(
            '_current'   => true,
            'back'       => 'edit',
            'active_tab' => '{{tab_id}}'
        ));
    }

    /**
     * Getter of url for "Add Menu Item" button
     *
     * @return string
     */
    protected function _getAddSliderItemUrl()
    {
        $request = $this->getRequest();

        return $this->getUrl('*/*/new_item', array(
            'slider_id' => $request->getParam('slider_id'),
            'active_tab' => $request->getParam('active_tab'),
        ));
    }
}