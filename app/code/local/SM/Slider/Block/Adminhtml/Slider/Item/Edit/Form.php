<?php

/**
 * MenuManager menu item edit form
 *

 * @package     sm_slider
 */
class SM_Slider_Block_Adminhtml_Slider_Item_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        /* @var $model sm_slider_Model_Item*/
        $model = Mage::registry('slidermanager_slider_item');
        $sliderId = $this->getRequest()->getParam('slider_id');

        $form = new Varien_Data_Form(array(
            'method' => 'post',
            'id' => 'edit_form',
            'enctype' => 'multipart/form-data',
            'action' => $this->getUrl('*/*/save_item', array('slider_id' => $sliderId)),
        ));


        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('sm_slider')->__('General Information'))
        );

        if ($model->getItemId()) {
            $fieldset->addField('item_id', 'hidden', array(
                'name'  => 'item_id',
            ));
        }

        if ($model->getMenuId()) {
            $fieldset->addField('slider_id', 'hidden', array(
                'name'  => 'slider_id',
            ));
        }


        $fieldset->addField('item_name', 'text', array(
            'name'      => 'item_name',
            'label'     => Mage::helper('sm_slider')->__('Name'),
            'title'     => Mage::helper('sm_slider')->__('Name'),
            'required'  => true,
        ));

        $fieldset->addField('item_title', 'text', array(
            'name'      => 'item_title',
            'label'     => Mage::helper('sm_slider')->__('Title'),
            'title'     => Mage::helper('sm_slider')->__('Title'),
            'required'  => true,
        ));
        $fieldset->addField('item_picture', 'image', array(
            'name'      => 'item_picture',
            'label'     => Mage::helper('sm_slider')->__('Slide Image'),
            'title'     => Mage::helper('sm_slider')->__('Slide Image'),
            'note'      => Mage::helper('cms')->__('Image item for slider'),
            'required'  => true,
        ));

        $fieldset->addField('item_url', 'text', array(
            'name'      => 'item_url',
            'label'     => Mage::helper('sm_slider')->__('Url'),
            'title'     => Mage::helper('sm_slider')->__('Url'),
            'note'      => Mage::helper('cms')->__('Use " / " For Item With Base Url.')
        ));


        $fieldset->addField('position', 'text', array(
            'name'      => 'position',
            'label'     => Mage::helper('sm_slider')->__('Position'),
            'title'     => Mage::helper('sm_slider')->__('Position'),
            'class'     => 'validate-number',
            'required'  => true
        ));

        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('sm_slider')->__('Status'),
            'title'     => Mage::helper('sm_slider')->__('Menu Item Status'),
            'name'      => 'is_active',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('sm_slider')->__('Enabled'),
                '0' => Mage::helper('sm_slider')->__('Disabled'),
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
