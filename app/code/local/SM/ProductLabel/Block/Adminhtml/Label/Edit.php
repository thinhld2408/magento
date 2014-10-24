<?php
/*
* Create by PhpStorm.
* User: quynh.
* Unit Department: Fresher06.
*/
class SM_ProductLabel_Block_Adminhtml_Label_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'label_product';
        $this->_controller = 'adminhtml_label';// call to container class edit

        $this->_updateButton('save', 'label', Mage::helper('productlabel')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('productlabel')->__('Delete Item'));

        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('productlabel_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'productlabel_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'productlabel_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('productlabel_data') && Mage::registry('productlabel_data')->getId() )
        {
            return Mage::helper('productlabel')->__("Edit group '" . strtoupper($this->escapeHtml(Mage::registry('productlabel_data')->getLabelName())) . "'");
        }
        else
        {
            return Mage::helper('productlabel')->__('Add item');
        }
    }
}
 