<?php
class Orba_Ceneopl_Block_Admin_Offer_Grid extends Mage_Adminhtml_Block_Widget_Grid {
    
    public function __construct() {
        parent::__construct();
        $this->setId('ceneo_offer_grid');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('desc');
    }
    
    protected function _getStore() {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }
    
    protected function _prepareCollection(){
        $store = $this->_getStore();
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('ceneo_category_id', 'left');
        if ($store->getId()) {
            $collection->addStoreFilter($store);
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _prepareColumns() {
        $this->addColumn('entity_id', array(
            'header' => Mage::helper('catalog')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'entity_id',
        ));
        $this->addColumn('sku', array(
            'header' => Mage::helper('catalog')->__('SKU '),
            'align' => 'right',
            'width' => '100px',
            'index' => 'sku',
        ));
        $this->addColumn('name', array(
            'header' => Mage::helper('catalog')->__('Name'),
            'align' => 'left',
            'index' => 'name',
        ));
        $ceneo_categories = Mage::getModel('ceneopl/category')->toOptionHash();
        $this->addColumn('ceneo_category_id', array(
            'header' => Mage::helper('ceneopl')->__('Ceneo Category'),
            'align' => 'left',
            'index' => 'ceneo_category_id',
            'type' => 'options',
            'options' => $ceneo_categories,
            'filter_condition_callback' => array(
                $this,
                '_filterCeneoCategoriesCondition'
            )
        ));
        $this->addColumn('action', array(
            'header' => Mage::helper('catalog')->__('Action'),
            'width' => '50px',
            'type' => 'action',
            'getter' => 'getId',
            'actions' => array(
                array(
                    'caption' => Mage::helper('catalog')->__('Edit'),
                    'url' => array(
                        'base'=>'adminhtml/catalog_product/edit',
                        'params'=>array('store'=>$this->getRequest()->getParam('store'))
                    ),
                    'field' => 'id'
                )
            ),
            'filter' => false,
            'sortable' => false,
            'index' => 'stores',
        ));
        return parent::_prepareColumns();
    }
    
    protected function _filterCeneoCategoriesCondition($collection, $column) {
        $value = $column->getFilter()->getValue();
        if ($value && !empty($value) && $value != 'null') {
            $ids = array($value) + Mage::getModel('ceneopl/category')->getChildrenIds($value);
            $this->getCollection()->addAttributeToFilter('ceneo_category_id', array(
                'in' => $ids,
                'notnull' => true,
                'neq' => ''
            ));
        } else if ($value == 'null') {
            $this->getCollection()->addAttributeToFilter(array(
                array('attribute' => 'ceneo_category_id', 'null' => true),
                array('attribute' => 'ceneo_category_id', 'eq' => '')
            ));
        }
    }
    
    public function getRowUrl($row) {
        return $this->getUrl('adminhtml/catalog_product/edit', array(
            'store'=>$this->getRequest()->getParam('store'),
            'id'=>$row->getId())
        );
    }
    
}