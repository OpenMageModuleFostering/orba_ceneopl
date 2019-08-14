<?php
$installer = $this;

$installer->startSetup();

$installer->getConnection()->changeColumn(
    $installer->getTable('ceneopl/mapping'),
    'ceneo_category_id',
    'ceneo_category_id',
    array(
        'type'      => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable'  => true,
        'comment'   => 'Ceneo Category Internal ID'
    )
);

$this->sendPing('1.0.0');

$installer->endSetup();