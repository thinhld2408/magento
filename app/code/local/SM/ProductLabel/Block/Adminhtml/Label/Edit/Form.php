<?php
/*
* Create by PhpStorm.
* User: quynh.
* Unit Department: Fresher06.
*/
class SM_ProductLabel_Block_Adminhtml_Label_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Prepare form before rendering HTML
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        # create the form with the essential information, such as DOM ID, action
        # attribute, method and the enc type (this is needed if you have image
        # inputs in your form, and doesn't hurt to use otherwise)
        $form = new Varien_Data_Form(
            array(
                'id'      => 'edit_form',
                'action'  => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                'method'  => 'post',
                'enctype' => 'multipart/form-data'
            )
        );

        $model = Mage::registry('productlabel_data');

        # add a fieldset, this returns a Varien_Data_Form_Element_Fieldset object
        $fieldset = $form->addFieldset(
            'base_fieldset',
            array(
                'legend' => Mage::helper('productlabel')->__('General Information'),
            )
        );
        # now add fields on to the fieldset object, for more detailed info
        # see https://makandracards.com/magento/12737-admin-form-field-types
        $fieldset->addField(
            'label_name', # the input id
            'text', # the type
            array(
                'label'    => Mage::helper('productlabel')->__('Name'),
                'class'    => 'required-entry',
                'required' => true,
                'name'     => 'label_name',
            )
        );
        $fieldset->addField(
            'label_type',
            'select',
            array(
                'label' => Mage::helper('productlabel')->__('Type Label'),
                'name'  => 'label_type',
                'values'=> Mage::getSingleton('productlabel/source_label_type')->getTypeLabel(),
            )
        );
        $fieldset->addField('label_logo', 'image', array(
            'label'     => Mage::helper('productlabel')->__('Image Label'),
            'required'  => true,
            'name'      => 'label_logo',
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('productlabel')->__('Status'),
            'name'      => 'is_active',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('productlabel')->__('Enabled'),
                ),

                array(
                    'value'     => 2,
                    'label'     => Mage::helper('productlabel')->__('Disabled'),
                ),
            ),
        ));

        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }



        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();

    }
}
