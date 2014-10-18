<?php

/**
 * MenuManager menu edit page main tab
 *

 * @package     sm_megamenu
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Edit_Tab_Main extends Mage_Adminhtml_Block_Widget_Form
        implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        /* @var $model SM_MegaMenu_Model_Menu */
        $model = Mage::registry('menumanager_menu');

        $form = new Varien_Data_Form();
        $form->setHtmlIdPrefix('menu_');

        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend' => Mage::helper('sm_megamenu')->__('General Information'))
        );

        if ($model->getMenuId()) {
            $fieldset->addField('menu_id', 'hidden', array(
                'name' => 'menu_id',
            ));
        }

        $fieldset->addField('title', 'text', array(
            'name'      => 'title',
            'label'     => Mage::helper('sm_megamenu')->__('Title'),
            'title'     => Mage::helper('sm_megamenu')->__('Title'),
            'required'  => true
        ));

        $fieldset->addField('identifier', 'text', array(
            'name'      => 'identifier',
            'label'     => Mage::helper('sm_megamenu')->__('Identifier'),
            'title'     => Mage::helper('sm_megamenu')->__('Identifier'),
            'required'  => true,
            'class'     => 'validate-xml-identifier',
            'note'      => Mage::helper('cms')->__('Must Be Unique Identifier Per Store View')
        ));

        $fieldset->addField('type', 'select', array(
            'name'      => 'type',
            'label'     => Mage::helper('sm_megamenu')->__('Type'),
            'title'     => Mage::helper('sm_megamenu')->__('Type'),
            'options'   => $model->getAvailableTypes(),
            'required'  => true
        ));

        $fieldset->addField('css_class', 'text', array(
            'name'      => 'css_class',
            'label'     => Mage::helper('sm_megamenu')->__('CSS Class'),
            'title'     => Mage::helper('sm_megamenu')->__('CSS Class'),
            'note'      => Mage::helper('cms')->__('Space Separated Class Names')
        ));

        if (!Mage::app()->isSingleStoreMode()) {
            $fieldset->addField('store_id', 'multiselect', array(
                'name'      => 'stores[]',
                'label'     => Mage::helper('sm_megamenu')->__('Store View'),
                'title'     => Mage::helper('sm_megamenu')->__('Store View'),
                'required'  => true,
                'values'    => Mage::getSingleton('adminhtml/system_store')
                    ->getStoreValuesForForm(false, true)
            ));
        } else {
            $fieldset->addField('store_id', 'hidden', array(
                'name'      => 'stores[]',
                'value'     => Mage::app()->getStore(true)->getId()
            ));

            $model->setStoreId(Mage::app()->getStore(true)->getId());
        }

        $fieldset->addField('is_active', 'select', array(
            'label'     => Mage::helper('sm_megamenu')->__('Status'),
            'title'     => Mage::helper('sm_megamenu')->__('Menu Status'),
            'name'      => 'is_active',
            'required'  => true,
            'options'   => array(
                '1' => Mage::helper('sm_megamenu')->__('Enabled'),
                '0' => Mage::helper('sm_megamenu')->__('Disabled'),
            ),
        ));

        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }

        Mage::dispatchEvent(
            'adminhtml_cms_menu_edit_tab_main_prepare_form',
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
        return Mage::helper('sm_megamenu')->__('General Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return Mage::helper('sm_megamenu')->__('General Information');
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
?>
