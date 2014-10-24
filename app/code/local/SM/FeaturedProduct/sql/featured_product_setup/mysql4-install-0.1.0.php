<?php

$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();
/**
 * Adding Different Attributes
 */

// adding attribute group

// the attribute added will be displayed under the group/tab Special Attributes in product edit page
$setup->addAttribute('catalog_product', 'featured_from_date', array(
    'label'             => 'Featured Product From Date',
    'group'             => 'Prices',
    'input'             => 'date',
    'type'              => 'datetime',
    'attribute_set'     =>  'Default',
    'backend'            => "eav/entity_attribute_backend_datetime",
    'frontend'          => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
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
$setup->addAttribute('catalog_product', 'featured_to_date', array(
    'label'             => 'Featured Product To Date',
    'group'             => 'Prices',
    'input'             => 'date',
    'type'              => 'datetime',
    'attribute_set'     =>  'Default',
    'backend'            => "eav/entity_attribute_backend_datetime",
    'frontend'          => '',
    'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
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