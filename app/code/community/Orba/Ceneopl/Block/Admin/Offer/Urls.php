<?php
class Orba_Ceneopl_Block_Admin_Offer_Urls extends Mage_Adminhtml_Block_Widget_Container {
    
    public function __construct() {
        parent::__construct();
        $this->setTemplate('ceneopl/offer/urls.phtml');
    }

    protected function _prepareLayout() {
        $this->setChild('grid', $this->getLayout()->createBlock('ceneopl/admin_offer_urls_grid', 'ceneopl_offer_urls_grid'));
        return parent::_prepareLayout();
    }

    public function getGridHtml() {
        return $this->getChildHtml('grid');
    }
    
}
