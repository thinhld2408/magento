<?php

/**
 * MenuManager menu item edit form
 *
 * @package     sm_megamenu
 */
class SM_MegaMenu_Block_Adminhtml_Menu_Item_Edit_Form
    extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        /* @var $model SM_MegaMenu_Model_Item */
        $model = Mage::registry('menumanager_menu_item');


        $menuId = $this->getRequest()->getParam('menu_id');

        $form = new Varien_Data_Form(array(
            'method' => 'post',
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save_item', array('menu_id' => $menuId)),
        ));


        $fieldset = $form->addFieldset('base_fieldset', array(
                'legend' => Mage::helper('sm_megamenu')->__('General Information'))
        );

        if ($model->getItemId()) {
            $fieldset->addField('item_id', 'hidden', array(
                'name' => 'item_id',
            ));
        }

        if ($model->getMenuId()) {
            $fieldset->addField('menu_id', 'hidden', array(
                'name' => 'menu_id',
            ));
        }

        if ($model->getIdentifier()) {
            $fieldset->addField('identifier', 'hidden', array(
                'name' => 'identifier',
            ));
        }
        $fieldset->addField('title', 'text', array(
            'name' => 'title',
            'label' => Mage::helper('sm_megamenu')->__('Title'),
            'title' => Mage::helper('sm_megamenu')->__('Title'),
            'required' => true,
        ));
        ///////////////////

        $fieldset->addField('item_type', 'select', array(
            'label' => Mage::helper('sm_megamenu')->__('Type'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'item_type',
            'options' => $model->getItemsTypes(),
        ));

        $fieldset->addField('type_view', 'select', array(
            'label' => Mage::helper('sm_megamenu')->__('View Show Type'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'type_view',
            'options' => $model->getTypeView(),
        ));

        $fieldset->addField('number_column', 'select', array(
            'label' => Mage::helper('sm_megamenu')->__('Number Column'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'number_column',
            'options' => $model->getColumnView(),
        ));

//        $fieldset->setAfterElementHtml('<script>
//            function modifyTargetElement(checkboxElem){
//                if(checkboxElem.checked){
//
//                    $("target_element").disabled=true;
//                }
//                else{
//                    $("target_element").disabled=false;
//                }
//            }
//        </script>');


        $this->setChild('form_after', $this->getLayout()
                ->createBlock('adminhtml/widget_form_element_dependence')
                ->addFieldMap('item_type', 'item_type')
                ->addFieldMap('type_view', 'type_view')
                ->addFieldMap('number_column', 'number_column')
                ->addFieldMap('item_category', 'item_category')
                ->addFieldMap('category', 'category')
                ->addFieldMap('category_id', 'category_id')
                ->addFieldMap('url', 'url')
                ->addFieldMap('cms_block', 'cms_block')
                ->addFieldDependence('category_id', 'item_type', 'category_link')
                ->addFieldDependence('category_id', 'type_view', 'tree')
                ->addFieldDependence('cms_block', 'item_type', 'block_link')
                ->addFieldDependence('cms_block', 'type_view', 'column')
                ->addFieldDependence('url', 'item_type', 'custom_link')
                ->addFieldDependence('number_column', 'type_view', 'column')
                ->addFieldDependence('number_column', 'type_view', 'column')
                ->addFieldDependence('category', 'type_view', 'column')
                ->addFieldDependence('category', 'item_type', 'category_link')

        );

        $fieldset->addField('category_id', 'select', array(
                'label' => Mage::helper('sm_megamenu')->__('Categories'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'category_id',
                'values' =>
                    Mage::getModel('sm_megamenu/source_category_list')->getAllOptions(true),
            )
        );
        $fieldset->addField('category', 'multiselect', array(
                'label' => Mage::helper('sm_megamenu')->__('Categories'),
                'class' => 'required-entry',
                'required' => true,
                'name' => 'item_category[]',
                'values' =>
                    Mage::getModel('sm_megamenu/source_category_list')->getAllOptions(true),
            )
        );

        $fieldset->addField('cms_block', 'multiselect', array(
            'label' => Mage::helper('sm_megamenu')->__('Block'),
            'name' => 'cms_block[]',
            'values' => Mage::getModel('sm_megamenu/source_cms_block')->getAllBlock(),
        ));

        ////////////////////
        $fieldset->addField('url', 'text', array(
            'name' => 'url',
            'label' => Mage::helper('sm_megamenu')->__('Url'),
            'title' => Mage::helper('sm_megamenu')->__('Url'),
            'note' => Mage::helper('cms')->__('Use " / " For Item With Base Url.')
        ));



        $fieldset->addField('parent_id', 'select', array(
            'name' => 'parent_id',
            'label' => Mage::helper('sm_megamenu')->__('Parent'),
            'title' => Mage::helper('sm_megamenu')->__('Parent'),
            'options' => $model->getCollection()
                    ->addMenuFilter($menuId)
                    ->toItemOptionArray(),
            'required' => true,
        ));

        $fieldset->addField('position', 'text', array(
            'name' => 'position',
            'label' => Mage::helper('sm_megamenu')->__('Position'),
            'title' => Mage::helper('sm_megamenu')->__('Position'),
            'class' => 'validate-number',
            'required' => true
        ));

        $fieldset->addField('is_active', 'select', array(
            'label' => Mage::helper('sm_megamenu')->__('Status'),
            'title' => Mage::helper('sm_megamenu')->__('Menu Item Status'),
            'name' => 'is_active',
            'required' => true,
            'options' => array(
                '1' => Mage::helper('sm_megamenu')->__('Enabled'),
                '0' => Mage::helper('sm_megamenu')->__('Disabled'),
            ),
        ));

        if (!$model->getId()) {
            $model->setData('is_active', '1');
        }
        if($model->getData() != Null){
//            echo "<pre>";

            if( $model->getData("item_type")== "category_link" && $model->getData("type_view") == "column" ){
                $model->setData('category', $model->getData('item_list_id')) ;

            }
            if( $model->getData("item_type")== "category_link" && $model->getData("type_view") == "tree" ){
                $model->setData('category_id', $model->getData('item_list_id')) ;

            }
            if( $model->getData("item_type")== "block_link"){
                $model->setData('cms_block', $model->getData('item_list_id')) ;

            }


        }

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
