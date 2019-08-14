<?php
$installer = $this;
$installer->startSetup();

$this->sendPing('0.3.3', true);

$installer->endSetup();