<?php
$installer = $this;

$installer->startSetup();

$this->sendPing('1.0.2', true);

$installer->endSetup();