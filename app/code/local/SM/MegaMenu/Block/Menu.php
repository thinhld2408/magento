<?php
class SM_MegaMenu_Block_Menu extends Mage_Core_Block_Template
{
    public function getStoreMenu(){

    }
    public function getChildMenu()
    {
        $listMenu = Mage::getModel('sm_megamenu/item')->getCollection()->getData();
        $menuData = array();
        foreach ($listMenu as $value) {
            $menuData['items'][$value['item_id']] = $value; //Lưu dữ liệu các biến có id khác nh
            $menuData['parent'][$value['parent_id']][] = $value['item_id'];
        }
        return $menuData;
    }

    public function getMenu($parent, $menuData = null, $class, $start = true, $child = false)
    {
        $menuData = $this->getChildMenu();
        $html = "";
        if (!$child) {
            if ($start == true) {
                $html .= "<ul class='zetta-menu zm-response-simple zm-full-width'>";
                $html .= "<li class='zm-logo'>
                            <a href=''><img src='".Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA)."/logo.png' alt='logo'>
                            </a>
                        </li>";

            } else {
                $html .= "";
            }
        } else {
            $html .= "<ul class='w-150'>";
        }
        if (isset($menuData['parent'][$parent])) {
            foreach ($menuData['parent'][$parent] as $value) {
                if ($menuData['items'][$value]['item_type'] == 'block_link') {
//                    $html .= "<a href='" . $menuData['items'][$value]['url'] . "'>" . $menuData['items'][$value]['title'] . "<i class='zm-caret fa fa-angle-down'></i></a>";
                    $class = "zm-content-full";
                }
                if ($this->isHaveChild($menuData['items'][$value]['item_id'], $menuData['items'])) {
                    $html .= "<li class='" . $class . "' style='float:left'>";
                    if ($menuData['items'][$value]['item_type'] == 'custom_link') {
                        $html .= "<a href='" . $menuData['items'][$value]['url'] . "'>" . $menuData['items'][$value]['title'] . "<i class='zm-caret fa fa-angle-down'></i></a>";
                    } elseif ($menuData['items'][$value]['item_type'] == 'category_link') {
                        $html .= "<a href='" . $menuData['items'][$value]['url'] . "'>" . $menuData['items'][$value]['title'] . "<i class='zm-caret fa fa-angle-down'></i></a>";
                        $haveChild = $this->checkHaveChild($menuData['items'][$value]['item_category']);
                        if ($haveChild == true) {
                            $html .= $this->getTreeCategories($menuData['items'][$value]['item_category'], true);
                        }
                    }elseif($menuData['items'][$value]['item_type'] == 'block_link') {

                        $html .= $this->getBlockLink($menuData['items'][$value]['cms_block']);
                    }
                    $html .= $this->getMenu($value, $menuData, $class, false, true);

                } else {

                    $html .= "<li class='" . $class . "'style='float:left'>";
                    if ($menuData['items'][$value]['item_type'] == 'custom_link') {
                        $html .= "<a href='" . $menuData['items'][$value]['url'] . "'>" . $menuData['items'][$value]['title'] . "</a>";
                    } elseif ($menuData['items'][$value]['item_type'] == 'category_link') {
                        $html .= "<a href='" . $menuData['items'][$value]['url'] . "'>" . $menuData['items'][$value]['title'];

                        $haveChild = $this->checkHaveChild($menuData['items'][$value]['item_category']);
                        if ($haveChild == true) {
                            $html .= "<i class='zm-caret fa fa-angle-down'></i></a>";
                            $html .= $this->getTreeCategories($menuData['items'][$value]['item_category'], true);
                        } else {
                            $html .= "</a>";

                        }

                    }elseif($menuData['items'][$value]['item_type'] == 'block_link'){
//                        $html .= "<li class='zm-content'>";

                        $html .= $this->getBlockLink($menuData['items'][$value]['cms_block']);
//                        $html .= "</li>";
                    }
                    $html .= $this->getMenu($value, $menuData, $class, false);

                }

                $html .= "</li>";
            }
        }
        if (!$child) {
            if ($start == true) {
                $html .= "</ul>";
            } else {
                $html .= "";
        $allCats = Mage::getModel('catalog/category')->getCollection()
            ->addAttributeToSelect('*')
            ->addAttributeToFilter('is_active', '1')
            ->addAttributeToFilter('include_in_menu', '1')
            ->addAttributeToFilter('parent_id', array('eq' => $parentId))
            ->addAttributeToSort('position', 'asc')
            ->addUrlRewriteToResult();
            }

        } else {
            $html .= "</ul>";
        }
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

    function getTreeCategories($parentId, $haveChild)
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
//            $iClass = "<i class='zm-caret fa fa-angle-down'></i>";
        }
        foreach ($allCats as $category) {
            $html .= '<li><a href="'.$category->getUrl($category).'">' . $category->getName() ;
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

    public function getBlockLink($blockId)
    {
        $html ="";
//        $html .= "<li class='zm-content-full'>";
        $html .= "<a>Content</a>";
        $html .="<ul class='zetta-menu>";
        $html .= "<li class='zm-content-full'>";
        $html .="<div class='zm-row'>";
        $html .= $this->getLayout()->createBlock('cms/block')->setBlockId($blockId)->toHtml();
        $html .= "</div>";
        $html .= "</li>";
        $html .="</ul>";
//        $html .= "</li>";
        return $html;
    }

    public function getCustomLink()
    {

        return "custom_link";
    }

}

?>