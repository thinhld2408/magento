<?php
/**
 * Created by PhpStorm.
 * User: CITA
 * Date: 09/10/14
 * Time: 04:06
 */

class SM_MegaMenu_Model_Source_Category_List extends Varien_Object
{

    public function getAllOptions($optionList = false)
    {
        $categoriesArray = Mage::getModel('catalog/category')
            ->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('level')
            ->addFieldToFilter('parent_id', array('from'=> '1','to'=>'2' ))
            ->addFieldToFilter('is_active', array('eq'=>'1'))
            ->addUrlRewriteToResult();


        if (!$optionList) {
            return $categoriesArray;
        }
        $categories = array();
        foreach ($categoriesArray as  $category) {
            if(isset($category['name'] )){
                $categories[]=array(
                    'value' => $category->getId(),

                    'label' => Mage::helper('sm_megamenu')->__($category['name']),
                );
            }

        }
        return $categories;
    }

}
?>