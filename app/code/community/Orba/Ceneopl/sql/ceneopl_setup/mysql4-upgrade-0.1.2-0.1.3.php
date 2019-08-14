<?php

$this->startSetup();

Mage::getModel('ceneopl/config')->saveHash();

@mail('magento@orba.pl', '[Upgrade] Ceneo.pl 0.1.3', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']));

$this->endSetup();