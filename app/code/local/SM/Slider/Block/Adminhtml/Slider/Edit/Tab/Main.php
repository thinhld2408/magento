<?php

/**
 * MenuManager menu edit page main tab
 *

 * @package     sm_slider
 */
class SM_Slider_Block_Adminhtml_Slider_Edit_Tab_Main
    extends Mage_Adminhtml_Block_Widget_Form
        implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        /* @var $model SM_Slider_Model_Slider */
        $model = Mage::registry('slidermanager_slider');

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('slider_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('sm_slider')->__('General Information'))
        );

        if ($model->getId()) {
            $fieldset->addField('slider_id', 'hidden', array(
                'name' => 'slider_id',
            ));
        }

        $fieldset->addField('name', 'text', array(
            'name'      => 'name',
            'label'     => Mage::helper('sm_slider')->__('Name'),
            'title'     => Mage::helper('sm_slider')->__('Name'),
            'required'  => true,
        ));

        $fieldset->addField('described', 'textarea', array(
            'name'      => 'described',
            'label'     => Mage::helper('sm_slider')->__('Described'),
            'title'     => Mage::helper('sm_slider')->__('Described'),
            'required'  => false
        ));

        $fieldset->addField('mode', 'select', array(
            'name'      => 'mode',
            'label'     => Mage::helper('sm_slider')->__('Mode'),
            'title'     => Mage::helper('sm_slider')->__('Mode'),
            'note'      => Mage::helper('sm_slider')->__('Effect of Slider . Ex : '),
            'options'   => $model->getAvailableTypes(),
            'required'  => true
        ));

        $fieldset->addField('width', 'text', array(
            'name'      => 'width',
            'label'     => Mage::helper('sm_slider')->__('Class width'),
            'class'     => 'validate-number',
            'title'     => Mage::helper('sm_slider')->__('Class width'),
            'note'      => Mage::helper('sm_slider')->__('Space Separated Class Names')
        ));

        $fieldset->addField('height', 'text', array(
            'name'      => 'height',
            'label'     => Mage::helper('sm_slider')->__('Class Height'),
            'class'     => 'validate-number',
            'title'     => Mage::helper('sm_slider')->__('Class width'),
            'note'      => Mage::helper('sm_slider')->__('Space Separated Class Names')
        ));

        $fieldset->addField('status', 'select', array(
            'label'     => Mage::helper('sm_slider')->__('Status'),
            'title'     => Mage::helper('sm_slider')->__('Slider Status'),
            'name'      => 'status',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('sm_slider')->__('Enabled'),
                '0' => Mage::helper('sm_slider')->__('Disabled'),
            ),
        ));

        if (!$model->getId()) {
            $model->setData('status', '1');
        }

        Mage::dispatchEvent(
            'adminhtml_slider_edit_tab_main_prepare_form',
            array('form' => $form)
        );

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return Mage::helper('sm_slider')->__('General Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('sm_slider')->__('General Information');
    }

    /**
     * Returns tab's status flag - can be shown or not
     *
     * @return boolean
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * Returns tab's status flag - hidden or not
     *
     * @return boolean
     */
    public function isHidden()
    {
        return false;
    }
}
