<?php
class Orba_Ceneopl_Adminhtml_Ceneopl_OfferController extends Mage_Adminhtml_Controller_Action {

    protected function _isAllowed() {
        $session = Mage::getSingleton('admin/session');
        return $session->isAllowed('catalog/ceneopl/offer_' . $this->getRequest()->getActionName());
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