<?php

/*
* create by user: thinhld.
* unit department: fresher 06.
*/

class SM_ProductLabel_Block_Product_List extends Mage_Catalog_Block_Product_List
{
    protected function getSaleProduct()
    {
        $collection = $this->getProductCollection('special_from_date', 'special_to_date');

        return $collection;
    }

    protected function getFeaturedProduct()
    {

        $collection = $this->getProductCollection('featured_from_date', 'featured_to_date');

        return $collection;

    }

    protected function getNewProduct()
    {

        $collection = $this->getProductCollection('news_from_date', 'news_to_date');

        return $collection;
    }

    protected function getHotProduct()
    {

    }

    protected function todayStart()
    {
        $todayStartOfDayDate = Mage::app()->getLocale()->date()
            ->setTime('00:00:00')
            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
        return $todayStartOfDayDate;
    }

    protected function todayEnd()
    {

        $todayEndOfDayDate = Mage::app()->getLocale()->date()
            ->setTime('23:59:59')
            ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
        return $todayEndOfDayDate;
    }

    public function getProductCollection($fieldFrom = null, $fieldTo = null, $id = null)
    {

        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection
            ->addStoreFilter()
            ->addAttributeToSelect('product_label');
        if ($fieldFrom != null && $fieldTo != null) {
            $collection->addAttributeToFilter($fieldFrom, array('or' => array(
                0 => array('date' => true, 'to' => $this->todayEnd()),
                1 => array('is' => new Zend_Db_Expr('null')))
            ), 'left')
                ->addAttributeToFilter($fieldTo, array('or' => array(
                    0 => array('date' => true, 'from' => $this->todayStart()),
                    1 => array('is' => new Zend_Db_Expr('null')))
                ), 'left')
                ->addAttributeToFilter(
                    array(
                        array('attribute' => $fieldFrom, 'is' => new Zend_Db_Expr('not null')),
                        array('attribute' => $fieldTo, 'is' => new Zend_Db_Expr('not null'))
                    )
                );
        }


        return $collection;

    }

    protected function isNew($id)
    {
        $product = $this->getNewProduct();

        $label = "";
        foreach ($product as $value) {
            if($id == $value->getId())
            {
                $label[$id] = $value->getProduct_label();
            }
        }
        $label_image = "";
        $type="new_label";
        if ($label[$id] != ""){
            $label_image = $this->_getLabelIds($label[$id], $type);
        }

        return $label_image;
    }

    protected function isFeatured($id)
    {
        $product = $this->getNewProduct();

        $label = "";
        foreach ($product as $value) {
            if($id == $value->getId())
            {
                $label[$id] = $value->getProduct_label();
            }
        }
        $label_image = "";
        $type="featured_label";
        if ($label[$id] != ""){
            $label_image = $this->_getLabelIds($label[$id], $type);
        }

        return $label_image;
    }

    protected function isSale($id)
    {
        $product = $this->getNewProduct();

        $label = "";
        foreach ($product as $value) {
            if($id == $value->getId())
            {
                $label[$id] = $value->getProduct_label();
            }
        }
        $label_image = "";
        $type="sale_label";
        if ($label[$id] != ""){
            $label_image = $this->_getLabelIds($label[$id], $type);
        }

        return $label_image;
    }

    protected function isHaveLabel($id)
    {
        $labelImage = array();

        if ($this->isNew($id) != null) {
            $labelImage['new'] = $this->getUrlLabel() . $this->isNew($id);
        }
        if ($this->isSale($id) != null) {
            $labelImage['sale'] = $this->getUrlLabel() . $this->isSale($id);
        }
        if
        ($this->isFeatured($id) != null
        ) {
            $$labelImage['featured'] = $this->getUrlLabel() . $this->isFeatured($id);
        }

        return $labelImage;
    }

    protected function _getStoreLabel($label)
    {
        $urlLabel = "";
        if ($label == 'new_label') {
            $label_id = Mage::getStoreConfig('productlabel/labelProduct/new');
            $label_image = Mage::getSingleton('productlabel/productlabel')->getCollection()
                ->addFieldToFilter('label_id', array('eq' => $label_id))
                ->getData();
            foreach($label_image as $value){
                $urlLabel = $value['label_logo'];
            };
        } else
            if ($label == 'sale_label') {
                $label_id = Mage::getStoreConfig('productlabel/labelProduct/sale');
                $label_image = Mage::getSingleton('productlabel/productlabel')->getCollection()
                    ->addFieldToFilter('label_id', array('eq' => $label_id))
                    ->getData();

                foreach($label_image as $value){
                    $urlLabel = $value['label_logo'];
                };
            } else
                if ($label == 'featured_label') {
                    $label_id = Mage::getStoreConfig('productlabel/labelProduct/featured');
                    $label_image = Mage::getSingleton('productlabel/productlabel')->getCollection()
                        ->addFieldToFilter('label_id', array('eq' => $label_id))
                        ->getData();
                    foreach($label_image as $value){
                        $urlLabel = $value['label_logo'];
                    };
                }

        return $urlLabel;
    }

    protected function _getLabelIds($labelType, $type)
    {
        $label_image = "";
        if ($labelType != null) {
            $listLabel = explode(",", $labelType);

            foreach ($listLabel as $label) {
                if ($label == $type) {
                    $label_image = $this->_getStoreLabel($type);

                    return $label_image;
                }
            }
        }
        return $label_image;

    }

    protected function getUrlLabel()
    {

        return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA);
    }

}