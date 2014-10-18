<?php

$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
/**
 * Adding Different Attributes
 */

// adding attribute group
$setup->addAttributeGroup('catalog_product', 'Default', 'Special Attributes', 1000);

// the attribute added will be displayed under the group/tab Special Attributes in product edit page
$setup->addAttribute('catalog_product', 'is_featured', array(
    'label'             => 'Featured Product',
    'type'              => 'int',
    'input'             => 'select',
    'backend'           => 'eav/entity_attribute_backend_array',
    'frontend'          => '',
    'source'            => 'featured_product/source_option',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible'           => true,
    'required'          => true,
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