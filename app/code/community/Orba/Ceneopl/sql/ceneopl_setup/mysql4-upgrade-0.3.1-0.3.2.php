<?php
$installer = $this;
$installer->startSetup();

$this->sendPing('0.3.2', true);

$installer->endSetup();