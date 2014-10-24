<?php

class SM_MegaMenu_Block_Menu extends Mage_Core_Block_Template
{
    /*
     * Start Build Menu
     *
     */
    public function buildMenu()
    {
        $id = Mage::getStoreConfig('');
    }

    protected function  getMenu($parent, $start = true)
    {
        $listMenu = Mage::getModel('sm_megamenu/item')->getCollection()
            ->addFieldToFilter("is_active", "1")
            ->getData();
        $html = "";

        if ($start == true) {
                $parentId = 0;
                $html .= "<ul class='zetta-menu zm-response-simple zm-full-width zm-effect-slide-right'>";
                $html .= "<li class='zm-logo'>
                            <a href='".Mage::getBaseUrl()."'><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."/logo.png' alt='logo'>
                            </a>
                          </li>";

            } else {
                $parentId = $parent;
                $html .= "<ul class='w-300'>";
            }
        $menuData = array();
        foreach ($listMenu as $value) {
            $menuData[$value['item_id']] = $value;
            if ($menuData[$value['item_id']]['parent_id'] == $parentId) {

                if ($menuData[$value['item_id']]['item_type'] == 'category_link') {

                    $html .= $this->buildCategoryLink($menuData[$value['item_id']]);

                }
                if ($menuData[$value['item_id']]['item_type'] == 'block_link') {
                    $html .= "<li class='zm-content-full'>";
                    $html .= "<span>" . $menuData[$value['item_id']]['title'] . "</span>";
                    $html .= $this->buildBlockLink($menuData[$value['item_id']]);

                }
                if ($menuData[$value['item_id']]['item_type'] == 'custom_link') {
                    $html .= "<li>";
                    if($menuData[$value['item_id']]['url'] != null){
                        $html .= "<a href='".$menuData[$value['item_id']]['url']."'>" . $menuData[$value['item_id']]['title'] . "</a>";
                    }else{
                        $html .= "<span>" . $menuData[$value['item_id']]['title'] . "</span>";
                    }
                     if($this->isHaveChild($menuData[$value['item_id']]['item_id'],$listMenu))
                     {
                         $html .= $this->buildCustomLink($menuData[$value['item_id']]['item_id']);
                     }
                }
                $html .= "</li>";
            }
        }
        $html .= "</ul>";
        return $html;
    }


    public function isHaveChild($id, $menu)
    {
        foreach ($menu as $value) {
            if ($value['parent_id'] == $id) {
                return true;
            }
        }
        return false;
    }

    public function buildCustomLink($id){
        $html  ="";
        $html .="<ul>";
        $listChild = Mage::getModel('sm_megamenu/item')->getCollection()
            ->addFieldToFilter("is_active", "1")
            ->addFieldToFilter("parent_id", array('eq'=>$id))
            ->getData();
        foreach($listChild as $value){
            $html .= "<li>";
            if($value['url'] != null){
                $html .= "<a href='".$value['url']."'>";
                $html .= $value['title'];
                $html .= "</a>";
            }else{
                $html .= "<span>";
                $html .= $value['title'];
                $html .= "</span>";
            }

            $haveChild = $this->isHaveChild($value['item_id'], $listChild);
            if($haveChild == true){
                $html .= $this->buildCustomLink($value['item_id']);
            }

            $html .= "</li>";
        }
        $html .="</ul>";

        return $html;
    }

    protected function buildCategoryLink($data)
    {
        $html = "";

        if ($data['type_view'] == "tree") {
            $html .= "<li class='zm-content'>";
            $html .= "<span>" . $data['title'] . "</span>";
            $haveChild = $this->checkHaveChild($data['item_list_id']);
            if ($haveChild == true) {
                $html .= $this->getTreeCategories($data['item_list_id'], true);
            } else {
                $html .= $this->getTreeCategories($data['item_list_id'], false);
            }
        } elseif ($data['type_view'] == "column") {
            $html .= "<li class='zm-content-full'>";
            $html .= "<a href=''>" . $data['title'] . "</a>";
            $html .= "<div>";
            $html .= "<div class='zm-row'>";
            $html .= $this->buildCategoryColumn($data['item_list_id']);
            $html .= "</div>";
            $html .= "</div>";

        }
        return $html;
    }

    public function checkHaveChild($id)
    {
        $cat = Mage::getModel('catalog/category')->load($id);
        $subCats = $cat->getChildren();
        if ($subCats != '') {
            return true;
        } else {
            return false;
        }

    }

    protected function buildCategoryColumn($data)
    {
        $html = "";
        $listCate = explode(",",$data);

        foreach ($listCate as $cateIds) {
            $cat = Mage::getModel('catalog/category')->load($cateIds);
            $img = $cat->getThumbnail();
            $name = $cat->getName();
            if ($cat != "") {
                $html .= "<div class='zm-col c-3'>";
                $html .= "<h4>".$name."</h4>";
                $_img_path = Mage::getBaseUrl('media') . 'catalog/category/'; // Get category image path
                $html .=   "<img width='60px' height='80px' src='".$_img_path.$img."'>";
                $html .= $this->getChildCategory($cateIds);
                $html .= "</div>";
            }
        }

        return $html;
    }
    protected function getChildCategory($id){
        $html ="";
        $allCats = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('is_active', '1')
            ->addAttributeToFilter('include_in_menu', '1')
            ->addAttributeToFilter('parent_id', array('eq' => $id))
            ->addAttributeToSort('position', 'asc')
            ->addUrlRewriteToResult();
        $html .="<ul>";
            foreach($allCats as $category){
                $html .= '<li><a href="' . $category->getUrl($category) . '">' . $category->getName();
                $html .= "</a>";
                $html .= '</li>';
            }
        $html .="</ul>";

        return $html;
    }

    public function getBlockLink($blockId)
    {

        $html = "";
        $html .= "<div class='zm-col'>";
        $html .= "<h3>Block</h3>";
        $html .= $this->getLayout()->createBlock('cms/block')->setBlockId($blockId)->toHtml();
        $html .= "</div>";

        return $html;
    }

    protected function buildBlockLink($data)
    {
        $html = "";
        $listBlock = explode(",", $data["item_list_id"]);
        $html .= "<div>";
        $html .= "<div class='zm-row'>";
        foreach ($listBlock as $block) {
            $html .= $this->getBlockLink($block);
        }
        $html .= "</div>";
        $html .= "</div>";
        return $html;
    }


    public function getTreeCategories($parentId, $haveChild)
    {
        $html = "";

        $allCats = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('is_active', '1')
            ->addAttributeToFilter('include_in_menu', '1')
            ->addAttributeToFilter('parent_id', array('eq' => $parentId))
            ->addAttributeToSort('position', 'asc')
            ->addUrlRewriteToResult();
        if ($haveChild == false) {
            $html .= "<ul class='w-150'>";


        } elseif ($haveChild == true) {
            $html .= '<ul class="w-150">';
             $html .= "<i class='zm-caret fa fa-angle-down'></i>";
        }
        foreach ($allCats as $category) {
            $html .= '<li><a href="' . $category->getUrl($category) . '">' . $category->getName();
            $html .= "</a>";
            $subCats = $category->getChildren();
            if ($subCats != '') {
                $html .= $this->getTreeCategories($category->getId(), true);
            }
            $html .= '</li>';
        }
        $html .= "</ul>";
        return $html;
    }




}

?>