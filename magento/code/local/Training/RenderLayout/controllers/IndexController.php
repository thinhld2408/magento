<?php
class Training_RenderLayout_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $block_after_body_start = $this->create_block('core/text_list', 'after_body_start')
                                  ->setName("<span>after_body_start</span><span class='span-right'>core/text_list</span>");

        $block_global           = $this->create_block('page/html_notices', 'global_notices')
                                  ->setName("<span>global_notices</span><span class='span-right'>page/html_notices</span>");

        $block_head             = $this->create_block('page/html_head', 'head')
                                  ->setName("<span>head</span><span class='span-right'>page/html_head</span>");

        $block_header           = $this->create_block('page/html_header', 'header')
                                  ->setName("<span>header</span><span class='span-right'>page/html_header</span>");

        $block_top_links        = $this->create_block('page/template_links', 'top_links')
                                  ->setName("<span>top.links</span><span class='span-right'>page/template_links</span>");

        $block_store_language   = $this->create_block('page/switch', 'language')
                                  ->setName("<span>store_language</span><span class='span-right'>page/switch</span>");

        $block_top_menu         = $this->create_block('core/text_list', 'top_menu')
                                  ->setName("<span>top.menu</span><span class='span-right'>core/text_list</span>");

        $block_top_container    = $this->create_block('page/html_wrapper', 'top_container')
                                  ->setName("<span>top.container</span><span class='span-right'>page/html_wrapper</span>");

        $block_breadcrumbs      = $this->create_block('page/html_breadcrumbs', 'breadcrumbs')
                                  ->setName("<span>top.breadcrumbs</span><span class='span-right'>page/html_breadcrumbs</span>");

        $block_left             = $this->create_block('core/text_list', 'left')
                                  ->setName("<span>left</span><span class='span-right'>core/text_list</span>");

        $block_C                = $this->create_block('core/template', 'blockC');
        $block_left->append($block_C, 'blockC');

        $block_content          = $this->create_block('core/text_list', 'content')
                                  ->setName("<span>content</span><span class='span-right'>core/text_list</span><br/>");

        $block_global_messages  = $this->create_block('core/template', 'blockA');
        $block_content->append($block_global_messages, 'global_messages');

        $block_messages         = $this->create_block('core/template', 'blockB');
        $block_content->append($block_messages, 'messages');

        $block_right            = $this->create_block('core/text_list', 'right')
                                  ->setName("<span>right</span><span class='span-right'>core/text_list</span>");

        $block_D                = $this->create_block('core/template', 'blockD');
        $block_right->append($block_D, 'blockD');

        $block_footer           = $this->create_block('page/html_footer', 'footer')
                                  ->setName("<span>footer</span><span class='span-right'>page/html_footer</span>");

        $block_core_profiler    = $this->create_block('core/profiler', 'core_profiler')
                                  ->setName("<span>core.profiler</span><span class='span-right'>core/profiler</span>");

        $block        = $this->create_block('page/html', 'render')
                      ->append($block_head, 'my_head')
                      ->append($block_after_body_start, 'after_body')
                      ->append($block_global, 'global_notices')
                      ->append($block_header, 'myHeader')
                      ->append($block_top_links, 'top_links')
                      ->append($block_store_language, 'language')
                      ->append($block_top_menu, 'top_menu')
                      ->append($block_top_container, 'top_container')
                      ->append($block_breadcrumbs, 'top_breadcrumbs')
                      ->append($block_left, 'myLeft')
                      ->append($block_content, 'myContent')
                      ->append($block_right, 'myRight')
                      ->append($block_footer, 'myFooter')
                      ->append($block_core_profiler, 'core_profiler');
        echo $block->toHtml();
    }

    public function create_block($type, $block)
    {
        $block = $this->getLayout()
                ->createBlock($type, $block)
                ->setTemplate("render/" . $block . ".phtml");
        return $block;
    }
}