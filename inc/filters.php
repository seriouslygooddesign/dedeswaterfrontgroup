<?php
// Extra Image Sizes In Editor
function add_custom_image_sizes()
{
    return [
        IMG_SIZE_XS => __('X Small'),
        IMG_SIZE_SM => __('Small'),
        IMG_SIZE_MD => __('Medium'),
        IMG_SIZE_LG => __('Large'),
        IMG_SIZE_XL => __('X Large'),
        IMG_SIZE_2XL => __('2X Large'),
        IMG_SIZE_3XL => __('3X Large'),
        'full' => __('Full Size')
    ];
}
add_filter('image_size_names_choose', 'add_custom_image_sizes');

//Automatically convert all filenames on upload to lowercase
add_filter('sanitize_file_name', 'mb_strtolower');

//Remove WordPress Version Number
add_filter('the_generator', '__return_empty_string');

//Getting rid of archive "prefix"
function my_theme_archive_title($title)
{
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = get_the_author();
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    } elseif (is_tax()) {
        $title = single_term_title('', false);
    }
    return $title;
}
add_filter('get_the_archive_title', 'my_theme_archive_title');


//Read More
function new_excerpt_more($more)
{
    return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


//Excerpt Length
add_filter('excerpt_length', function () {
    return 20;
});

//Disable wpo-plugins-tables-list.json file
add_filter('wpo_update_plugin_json', '__return_false');

//Rename "Default template" to "Content Blocks"
add_filter('default_page_template_title', function () {
    return 'Content Blocks';
});

//Exclude post type from WordPress link builder
function exclude_post_type_from_link_builder($query)
{
    $cpts_to_remove = [
        'main-popup',
        'global-content-block',
    ];
    foreach ($cpts_to_remove as $cpt) {
        $key = array_search($cpt, $query['post_type']);
        if ($key) {
            unset($query['post_type'][$key]);
        }
    }
    return $query;
}
add_filter('wp_link_query_args', 'exclude_post_type_from_link_builder');


//Removes or edits the 'Protected:' part from titles
add_filter('protected_title_format', 'remove_protected_text');
function remove_protected_text()
{
    return __('%s');
}

//Add class 'menu-link' to all <a> in wp_nav_menu()
function add_extra_class_to_menu_link($atts, $item, $args, $depth)
{
    $class = 'menu-link';
    $atts['class'] = isset($atts['class']) ? $atts['class'] . " " . $class : $class;
    return $atts;
}
add_filter('nav_menu_link_attributes', 'add_extra_class_to_menu_link', 10, 4);

//Add "loading" to wp_get_attachment_image, get_the_post_thumbnail and the_post_thumbnail 
function add_lazy_loading_to_images($attr, $attachment, $size)
{
    if (!isset($attr['loading'])) {
        $attr['loading'] = 'lazy';
    }
    return $attr;
}
add_filter('wp_get_attachment_image_attributes', 'add_lazy_loading_to_images', 10, 3);

//Admin panel menu order
function core_custom_menu_order($menu_ord)
{
    if (!$menu_ord) return true;
    return array(
        'index.php',
        'edit.php?post_type=page',
        'edit.php',
        'upload.php',
        'separator1',
    );
}
add_filter('custom_menu_order', 'core_custom_menu_order', 10, 1);
add_filter('menu_order', 'core_custom_menu_order', 10, 1);
