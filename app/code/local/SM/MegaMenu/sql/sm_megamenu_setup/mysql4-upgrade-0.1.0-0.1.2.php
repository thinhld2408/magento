<?php

$installer = $this;

/* Create table "sm_megamenu/menu" */
$table = $installer->getConnection()
    ->newTable(
        $installer->getTable('sm_megamenu/menu')
    )
    ->addColumn(
        'menu_id', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
            'identity' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Menu ID'
    )
    ->addColumn(
        'title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false,
        ), 'Menu Title'
    )
    ->addColumn(
        'identifier', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false,
        ), 'Menu String Identifier'
    )
    ->addColumn(
        'type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false,
            'default'   => 'none',
        ), 'Menu Type'
    )
    ->addColumn(
        'css_class', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
            'default'  => null,
        ), 'Menu CSS Class'
    )
    ->addColumn(
        'is_active', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
            'nullable'  => false,
            'default'   => '1',
        ), 'Is Menu Active'
    )
    ->setComment('MenuManager Menu Table');

$installer->getConnection()->createTable($table);

/* Create table "sm_megamenu/menu_store" */
$table = $installer->getConnection()
    ->newTable(
        $installer->getTable('sm_megamenu/menu_store')
    )
    ->addColumn(
        'menu_id', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
            'nullable'  => false,
            'primary'   => true,
        ), 'Menu ID'
    )
    ->addColumn(
        'store_id', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'Store ID'
    )
    ->addIndex(
        $installer->getIdxName('sm_megamenu/menu_store', array('store_id')), array('store_id')
    )
    ->addForeignKey(
        $installer->getFkName(
            'sm_megamenu/menu_store', 'menu_id', 'sm_megamenu/menu', 'menu_id'
        ),
        'menu_id', $installer->getTable('sm_megamenu/menu'), 'menu_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->addForeignKey(
        $installer->getFkName(
            'sm_megamenu/menu_store', 'store_id', 'core/store', 'store_id'
        ),
        'store_id', $installer->getTable('core/store'), 'store_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('MenuManager Menu To Store Linkage Table');

$installer->getConnection()->createTable($table);

/* Create table "sm_megamenu/menu_item" */
$table = $installer->getConnection()
    ->newTable(
        $installer->getTable('sm_megamenu/menu_item')
    )
    ->addColumn(
        'item_id', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
            'identity' => true,
            'nullable' => false,
            'primary'  => true,
        ), 'Item ID'
    )
    ->addColumn(
        'menu_id', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
            'nullable'  => false,
        ), 'Menu ID'
    )
    ->addColumn(
        'parent_id', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
            'nullable'  => false,
        ), 'Parent ID'
    )
    ->addColumn(
        'title', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false,
        ), 'Item Title'
    )
    ->addColumn(
        'identifier', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false,
        ), 'Item String Identifier'
    )
    ->addColumn(
        'url', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
            'default'  => null,
        ), 'Item Url'
    )
    ->addColumn(
        'type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false,
            'default'   => 'same_window',
        ), 'Item Open Type'
    )
    ->addColumn(
        'item_type', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => false,
            'default'   => 'custom_link',
        ), 'Item Show Type'
    )
    ->addColumn(
        'item_category', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => true,
            'default'   => NULL,
        ), ' Category'
    )
    ->addColumn(
        'cms_block', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable'  => true,
            'default'   => NULL,
        ), ' Block'
    )
    ->addColumn(
        'css_class', Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(
            'nullable' => true,
            'default'  => null,
        ), 'Item CSS Class'
    )
    ->addColumn(
        'position', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
            'nullable'  => false,
            'default'   => '0',
        ), 'Item Position'
    )
    ->addColumn(
        'is_active', Varien_Db_Ddl_Table::TYPE_TINYINT, null, array(
            'nullable'  => false,
            'default'   => '1',
        ), 'Is Item Active'
    )
    ->addIndex(
        $installer->getIdxName('sm_megamenu/menu_item', array('identifier')), array('identifier')
    )
    ->addForeignKey(
        $installer->getFkName(
            'sm_megamenu/menu_item', 'menu_id', 'sm_megamenu/menu', 'menu_id'
        ),
        'menu_id', $installer->getTable('sm_megamenu/menu'), 'menu_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE
    )
    ->setComment('MenuManager Menu Item Table');

$installer->getConnection()->createTable($table);
