<?php

$this->startSetup();

@mail('magento@orba.pl', '[Upgrade] Ceneo.pl 0.1.4', "IP: ".$_SERVER['SERVER_ADDR']."\r\nHost: ".gethostbyaddr($_SERVER['SERVER_ADDR']));

$this->endSetup();