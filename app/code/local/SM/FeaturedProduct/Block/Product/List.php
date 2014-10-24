<?php

/**
 * Product list
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class SM_FeaturedProduct_Block_Product_List extends Mage_Catalog_Block_Product_Abstract
    implements Mage_Widget_Block_Interface
{

    protected $_serializer = null;

    /**
     * Initialization
     */
    protected function _construct()
    {
        $this->_serializer = new Varien_Object();
        parent::_construct();
    }

    /**
     * Produce links list rendered as html
     *
     * @return string
     */
    protected function _toHtml()
    {


        return parent::_toHtml();
    }
    /**
     * Retrieve loaded featured products collection
     *
     * @return Mage_Eav_Model_Entity_Collection_Abstract
     */
    public function getFeaturedProductCollection($id)
    {

        return $this->_getProductCollection($id);
    }

        protected function _getProductCollection($categoryIds)
        {
            $todayStartOfDayDate  = Mage::app()->getLocale()->date()
                ->setTime('00:00:00')
                ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);

            $todayEndOfDayDate  = Mage::app()->getLocale()->date()
                ->setTime('23:59:59')
                ->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);

            $collection = Mage::getModel('catalog/product')->getCollection();
            $attributes = Mage::getSingleton('catalog/config')
                    ->getProductAttributes();
            $collection->addAttributeToSelect($attributes)
                ->addStoreFilter()
                ->addAttributeToFilter('featured_from_date', array('or'=> array(
                    0 => array('date' => true, 'to' => $todayEndOfDayDate),
                    1 => array('is' => new Zend_Db_Expr('null')))
                ), 'left')
                ->addAttributeToFilter('featured_to_date', array('or'=> array(
                    0 => array('date' => true, 'from' => $todayStartOfDayDate),
                    1 => array('is' => new Zend_Db_Expr('null')))
                ), 'left')
                ->addAttributeToFilter(
                    array(
                        array('attribute' => 'featured_from_date', 'is'=>new Zend_Db_Expr('not null')),
                        array('attribute' => 'featured_to_date', 'is'=>new Zend_Db_Expr('not null'))
                    )
                )
                ->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')

                ->addAttributeToSort('featured_from_date', 'desc')
                ->setPageSize(Mage::getStoreConfig('feature/config/loop'))
            ;
            if($categoryIds != null){
                $collection->addAttributeToFilter('category_id', array('eq' => $categoryIds));
            }

            return $collection;
        }

}