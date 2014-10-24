<?php
/**
 * Created by PhpStorm.
 * User: cita-group
 * Date: 10/22/14
 * Time: 5:14 PM
 */

$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
/**
 * Adding Different Attributes
 */
// adding attribute group
//$setup->addAttributeGroup('catalog_product', 'Default', 'Product Label', 4);
//// the attribute added will be displayed under the group/tab Special Attributes in product edit page
$setup->addAttribute('catalog_product', 'product_label', array(
    'label'             => 'Label For Product',
    'group'             => 'Product Label',
    'input'             => 'multiselect',
    'type'              => 'varchar',
    'attribute_set'     =>  'Default',
    'frontend'          => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'source'            => 'productlabel/source_label',
    'backend'           => 'eav/entity_attribute_backend_array',
    'visible'           => true,
    'required'          => false,
    'user_defined'      => true,
    'searchable'        => false,
    'filterable'        => false,
    'comparable'        => false,
    'visible_on_front'  => false,
    'visible_in_advanced_search' => false,
    'unique'            => false
));

$installer->endSetup();

//
//$installer = $this;
//$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
//$installer->startSetup();
//// Remove Product Attribute
//$installer->removeAttribute('catalog_product', 'is_featured');
//
//$installer->endSetup();


?>