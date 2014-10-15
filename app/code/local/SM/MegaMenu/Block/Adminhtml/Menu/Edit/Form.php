<?php

/**
 * MenuManager menu edit form block
 *

 * @package     sm_megamenu
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'method' => 'post',
            'id' => 'edit_form',
            'action'  => $this->getUrl('*/*/save')
        ));

        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
