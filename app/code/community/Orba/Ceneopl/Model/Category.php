<?php
class Orba_Ceneopl_Model_Category extends Mage_Core_Model_Abstract {
    
    protected function _construct() {
        $this->_init('ceneopl/category');
    } 
    
    protected function getConfig() {
        return Mage::getModel('ceneopl/config');
    }
    
    public function getAllOptions($flat = true, $empty = true) {
        if ($flat) {
            $cache_id = 'ceneopl_categories_option_array_flat';
            if (false !== ($data = Mage::app()->getCache()->load($cache_id))) {
                $options = unserialize($data);
            } else {
                $options = $this->getFlatTree();
                Mage::app()->getCache()->save(serialize($options), $cache_id, array(Orba_Ceneopl_Model_Config::CACHE_GROUP));
            }
            if ($empty) {
                $options = array_merge(array(array('label' => '', 'value' => '')), $options);
            }
        } else {
            $cache_id = 'ceneopl_categories_option_array_tree';
            if (false !== ($data = Mage::app()->getCache()->load($cache_id))) {
                $options = unserialize($data);
            } else {
                $options = $this->getTree();
                Mage::app()->getCache()->save(serialize($options), $cache_id, array(Orba_Ceneopl_Model_Config::CACHE_GROUP));
            }
        }
        return $options;
    }
    
    public function getFlatTree($parent = null) {
        $res = array();
        $parent_id = ($parent === null) ? 0 : $parent->getId();
        $category_collection = $this->getCollection()
            ->addFieldToFilter('parent_id', $parent_id)
            ->setOrder('name', 'asc');
        foreach ($category_collection as $category) {
            if ($parent === null) {
                $category->setNamePath($category->getName());
            } else {
                $category->setNamePath($parent->getNamePath().' / '.$category->getName());
            }
            $res[] = array(
                'label' => $category->getNamePath(),
                'value' => $category->getId()
            );
            $res = array_merge($res, $this->getFlatTree($category));
        }
        return $res;
    }
    
    public function getTree($parent = null) {
        $res = array();
        $parent_id = ($parent === null) ? 0 : $parent->getId();
        $category_collection = $this->getCollection()
            ->addFieldToFilter('parent_id', $parent_id)
            ->setOrder('name', 'asc');
        foreach ($category_collection as $category) {
            if ($parent === null) {
                $category->setNamePath($category->getName());
            } else {
                $category->setNamePath($parent->getNamePath().' / '.$category->getName());
            }
            $res[$category->getId()] = array(
                'label' => $category->getNamePath(),
                'value' => $category->getId(),
                'children' => $this->getTree($category)
            );
        }
        return $res;
    }
    
    public function getPathArray($id) {
        $this->load($id);
        $name = $this->getName();
        if ($this->getParentId()) {
            return array_merge($this->getPathArray($this->getParentId()), array($name));
        } else {
            return array($name);
        }
    }
    
    public function getChildrenIds($id, $tree = null) {
        $res = array();
        if ($tree === null) {
            $tree = $this->getAllOptions(false);
        }
        if (isset($tree[$id])) {
            foreach ($tree[$id]['children'] as $child_id => $child) {
                $res[] = $child_id;
                $res = array_merge($res, $this->getChildrenIds($child_id, $tree[$id]['children']));
            }
        } else {
            foreach ($tree as $child) {
                $res = array_merge($res, $this->getChildrenIds($id, $child['children']));
            }
        }
        return $res;
    }
    
    public function toOptionHash($empty = true) {
        $e = $empty ? array(array('label' => Mage::helper('ceneopl')->__('not set'), 'value' => 'null')) : array();
        $options = array_merge($e, $this->getAllOptions(true, false));
        $option_hash = array();
        foreach ($options as $option) {
            $option_hash[$option['value']] = $option['label'];
        }
        return $option_hash;
    }
    
    public function getFlatColums() {
        $attributeCode = $this->getAttribute()->getAttributeCode();
        $column = array(
            'unsigned'  => true,
            'default'   => null,
            'extra'     => null
        );
        $helper = Mage::helper('core');
        if (!method_exists($helper, 'useDbCompatibleMode') || $helper->useDbCompatibleMode()) {
            $column['type']     = 'int';
            $column['is_null']  = true;
        } else {
            $column['type']     = Varien_Db_Ddl_Table::TYPE_INTEGER;
            $column['nullable'] = true;
        }
        return array($attributeCode => $column);
    }
    
    public function getFlatUpdateSelect($store) {
        return Mage::getResourceModel('eav/entity_attribute_option')
            ->getFlatUpdateSelect($this->getAttribute(), $store, false);
    }
    
    public function getOptionText($value) {
        $options = $this->getAllOptions();
        if (sizeof($options) > 0) foreach($options as $option) {
            if (isset($option['value']) && $option['value'] == $value) {
                return isset($option['label']) ? $option['label'] : $option['value'];
            }
        }
        if (isset($options[$value])) {
            return $options[$value];
        }
        return false;
    }

    public function getOptionId($value) {
        foreach ($this->getAllOptions() as $option) {
            if (strcasecmp($option['label'], $value)==0 || $option['value'] == $value) {
                return $option['value'];
            }
        }
        return null;
    }

    public function clearCache() {
        Mage::app()->getCache()->load($cache_id);
    }
    
}