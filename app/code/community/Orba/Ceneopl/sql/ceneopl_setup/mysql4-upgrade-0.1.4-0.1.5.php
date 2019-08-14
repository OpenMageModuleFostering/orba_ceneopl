<?php
$installer = $this;
$installer->startSetup();

$installer->run("
    SET FOREIGN_KEY_CHECKS = 0;
        
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 476;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 477;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 542;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 543;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 547;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 548;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 553;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 554;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 555;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 556;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 787;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 788;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 789;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 790;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 1107;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 1108;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 1160;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 1161;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 1824;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 1825;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 1826;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2049;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2050;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2152;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2153;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2157;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2180;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2181;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2340;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2341;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2342;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2343;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2501;
    DELETE FROM {$this->getTable('orba_ceneo_category')} WHERE `id` = 2502;
    
    SET FOREIGN_KEY_CHECKS = 1;
");

@mail('magento@orba.pl', '[Upgrade] Ceneo.pl 0.1.5', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']));

$installer->endSetup();