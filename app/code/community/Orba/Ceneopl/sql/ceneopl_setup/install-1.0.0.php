<?php
$installer = $this;
$installer->startSetup();

Mage::getModel('ceneopl/attribute')->addCeneoAttributeToProduct();

$categoryTableName = $this->getTable('ceneopl/category');
$categoryTable = $installer->getConnection()
    ->newTable($categoryTableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'	=> true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('external_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'	=> true,
        'nullable'  => false
    ), 'External ID')
    ->addColumn('parent_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'	=> true,
        'nullable'  => false,
        'default' => 0
    ), 'Parent ID')
    ->addColumn('path', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ), 'Path')
    ->addColumn('position', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'	=> true,
        'nullable'  => false,
        'default' => 0
    ), 'Position')
    ->addColumn('level', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'	=> true,
        'nullable'  => false,
        'default' => 0
    ), 'Level')
    ->addColumn('name', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ), 'Name');
$installer->getConnection()->createTable($categoryTable);

$mappingTableName = $this->getTable('ceneopl/mapping');
$mappingTable = $installer->getConnection()
    ->newTable($mappingTableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'	=> true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('ceneo_category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'	=> true,
        'nullable'  => true
    ), 'Ceneo Category Internal ID')
    ->addColumn('priority', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'	=> true,
        'nullable'  => false,
        'default' => 0
    ), 'Priority')
    ->addIndex($installer->getIdxName('ceneopl/mapping', array('ceneo_category_id')),
        array('ceneo_category_id')
    )
    ->addForeignKey(
        $installer->getFkName('ceneopl/mapping', 'ceneo_category_id', 'ceneopl/category', 'id'),
        'ceneo_category_id', $installer->getTable('ceneopl/category'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($mappingTable);

$mappingCatalogCategoryTableName = $this->getTable('ceneopl/mapping_catalog_category');
$mappingCatalogCategoryTable = $installer->getConnection()
    ->newTable($mappingCatalogCategoryTableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'	=> true,
        'nullable'  => false,
        'primary'   => true,
    ), 'ID')
    ->addColumn('mapping_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'	=> true,
        'nullable'  => false
    ), 'Mapping ID')
    ->addColumn('category_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned'	=> true,
        'nullable'  => false
    ), 'Magento category ID')
    ->addIndex($installer->getIdxName('ceneopl/mapping_catalog_category', array('mapping_id')),
        array('mapping_id')
    )
    ->addIndex($installer->getIdxName('ceneopl/mapping_catalog_category', array('category_id')),
        array('category_id')
    )
    ->addForeignKey(
        $installer->getFkName('ceneopl/mapping_catalog_category', 'mapping_id', 'ceneopl/mapping', 'id'),
        'mapping_id', $installer->getTable('ceneopl/mapping'), 'id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE)
    ->addForeignKey(
        $installer->getFkName('ceneopl/mapping_catalog_category', 'category_id', 'catalog/category', 'entity_id'),
        'category_id', $installer->getTable('catalog/category'), 'entity_id',
        Varien_Db_Ddl_Table::ACTION_CASCADE, Varien_Db_Ddl_Table::ACTION_CASCADE);
$installer->getConnection()->createTable($mappingCatalogCategoryTable);

Mage::getModel('ceneopl/config')->saveHash();

$this->sendPing('1.0.0');

$installer->endSetup();