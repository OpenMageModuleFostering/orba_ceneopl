<?php
$installer = $this;
$installer->startSetup();

Mage::getModel('catalog/product')->getResource()->getAttribute('ceneo_category_id')
    ->setUsedInProductListing(true)
    ->save();

@mail('magento@orba.pl', '[Upgrade] Ceneo.pl 0.1.9', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']), "From: ".(Mage::getStoreConfig('general/store_information/email_address') ? Mage::getStoreConfig('general/store_information/email_address') : 'magento@orba.pl'));

$installer->endSetup();