<?php

/**
 * Product list
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class SM_FeaturedProduct_Block_Product_List extends Mage_Core_Block_Template
{
    protected $_productCollection;
    protected $_sort_by;

    /*
    * Load featured products collection
    * */
    protected function _getProductCollection($categoryIds)
    {
        if($categoryIds == null){
            if (is_null($this->_productCollection)) {
                $collection = Mage::getModel('catalog/product')->getCollection();
                $attributes = Mage::getSingleton('catalog/config')
                    ->getProductAttributes();
                $collection->addAttributeToSelect($attributes)
                    ->addMinimalPrice()
                    ->addFinalPrice()
                    ->addTaxPercents()
                    ->addAttributeToFilter('is_featured', 1, 'left')
                    ->addStoreFilter();
                Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
                Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
                $this->_productCollection = $collection;
            }
            return $this->_productCollection;
        }else{
                $collection = Mage::getModel('catalog/product')->getCollection();
                $attributes = Mage::getSingleton('catalog/config')
                    ->getProductAttributes();
                $collection->addAttributeToSelect($attributes)
                    ->addMinimalPrice()
                    ->addFinalPrice()
                    ->addTaxPercents()
                    ->joinField('category_id', 'catalog/category_product', 'category_id', 'product_id = entity_id', null, 'left')
                    ->addAttributeToFilter('is_featured', 1)
                    ->addAttributeToFilter('category_id', array('eq' => $categoryIds))
                    ->addStoreFilter();
                Mage::getSingleton('catalog/product_status')->addVisibleFilterToCollection($collection);
                Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
                $this->_productCollection = $collection;

            return $this->_productCollection;
        }


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

    public function _getSlidePerView(){

        return "auto";
    }

    public function _getSlide(){
        return "3d";
    }


    public function _getAutoplay(){
        return "3000";
    }



    public function _getSpeed(){
        return "200";
    }


    public function _getSwipperScript()
    {
        $script = "<script>
            \$j(function() {
                var featuredSwiper = \$j('.swiper-featured-container').swiper({
                    slidesPerView:".$this->_getSlidePerView().",
                    loop: true,";

        if ($this->_getSlide() == '3d') {
            $script .= "
                    centeredSlides: true,
                    initialSlide: 7,
                    tdFlow: {
                        rotate : 30,
                        stretch :10,
                        depth: 150
                    },
                    ";
        }
        $script .= "
                    offsetPxBefore:10,
                    offsetPxAfter:10,
                    calculateHeight: true,
                    autoplay: ".$this->_getAutoplay().",
                    speed: ".$this->_getSpeed().",
                ";

        $script .= '});
                $j(".swiper-featured-container .arrow-left").on("click", function(e){
                    e.preventDefault()
                    featuredSwiper.swipePrev()
                  });
                  $j(".swiper-featured-container .arrow-right").on("click", function(e){
                    e.preventDefault()
                    featuredSwiper.swipeNext()
                  });
            })</script>';
        return $script;
    }

}