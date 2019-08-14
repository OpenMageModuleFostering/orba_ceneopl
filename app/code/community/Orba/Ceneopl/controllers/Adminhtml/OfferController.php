<?php
class Orba_Ceneopl_Adminhtml_OfferController extends Mage_Adminhtml_Controller_Action {
	
    protected function _initAction() {
		return $this;
	}

	public function indexAction() {
        $this->_title($this->__('Catalog'))
            ->_title($this->__('Ceneo.pl'))
            ->_title($this->__('Offer'));
        $this->loadLayout();
        $this->renderLayout();
    }
    
    public function urlsAction() {
        $this->_title($this->__('Catalog'))
            ->_title($this->__('Ceneo.pl'))
            ->_title($this->__('Feed URLs'));
        $this->loadLayout();
        $this->renderLayout();
    }
    
}