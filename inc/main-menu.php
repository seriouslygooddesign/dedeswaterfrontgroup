<?php
//Dropdown Structure
class Main_Menu_Dropdown extends Walker_Nav_Menu
{
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $parent_data = $args->parent_item;
        $parent_url = $parent_data->url;
        $parent_title = $parent_data->title;

        $menu_item_primary = null;
        if (wp_http_validate_url($parent_url)) {
            $target = $parent_data->target ?  " target='" . esc_attr($parent_data->target) . "'" : null;
            $url = $parent_data->url;
            $title = $parent_title;

            $rewrite_submenu_navigation_label = get_field('rewrite_submenu_navigation_label', $parent_data->id);
            if ($rewrite_submenu_navigation_label) {
                $enable = $rewrite_submenu_navigation_label['enable'];
                $label = $rewrite_submenu_navigation_label['label'];
                if ($enable && $label) {
                    $title = $label;
                }
            }

            $menu_item_primary = "<li class='main-menu__item main-menu__item--primary'><a class='main-menu__link' $target href='" . esc_url($url) . "'>" . strip_tags($title) . "</a></li>";
        }

        $icon = get_core_icon('chevron', 'main-menu__icon rotate-90');
        $menu_item_back = "<li class='main-menu__item main-menu__item--back'><button type='button' class='main-menu__dropdown-back' data-dropdown-toggler-back>" . $icon . "Back</button></li>";

        $output .= "<ul class='main-menu__dropdown-menu' data-dropdown-menu>\n$menu_item_back\n$menu_item_primary\n";
    }
    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $output .= "</ul>\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $args->parent_item = (object) ['title' => $item->title, 'url' => $item->url, 'target' => $item->target, 'id' => $item->ID];
        $classes = isset($item->classes) ? $item->classes : false;
        if (is_array($classes) && in_array('menu-item-has-children',  $classes)) {
            $icon = get_core_icon('chevron', 'main-menu__icon main-menu__icon--dropdown');
            $item->title .= $icon;
        }
        parent::start_el($output, $item, $depth, $args, $id);
    }
}

function is_menu_item_has_children($item)
{
    $classes = isset($item->classes) ? $item->classes : false;
    if (is_array($classes) && in_array('menu-item-has-children', $classes)) {
        return true;
    }
    return false;
}

function is_main_menu($args)
{
    if (gettype($args) === 'object') {
        $args = (array) $args;
    }
    return isset($args['main_menu']) && $args['main_menu'] === true ? true : false;
}

function main_menu_parameters($args)
{
    if (is_main_menu($args)) {
        $main_menu_class = 'main-menu';
        $extra_menu_class = $args['menu_class'];
        $args['menu_class'] = $extra_menu_class ? "$main_menu_class $extra_menu_class" : $main_menu_class;
        $args['items_wrap'] =  '<ul id="%1$s" class="%2$s" data-main-menu>%3$s</ul>';
        $args['walker'] = new Main_Menu_Dropdown;
    }
    return $args;
}
add_filter('wp_nav_menu_args', 'main_menu_parameters');

add_filter('nav_menu_item_attributes', 'custom_nav_menu_item_attributes', 10, 4);
function custom_nav_menu_item_attributes($atts, $item, $args, $depth)
{
    if (is_main_menu($args)) {
        $atts['class'] .= ' main-menu__item';
        if (is_menu_item_has_children($item)) {
            $atts['class'] .= ' main-menu__dropdown';
            $atts['data-dropdown'] = true;
            $atts['data-dropdown-location'] = 'overlay-menu';
        }
    }
    return $atts;
}

add_filter('nav_menu_link_attributes', 'custom_nav_menu_link_attributes', 10, 4);
function custom_nav_menu_link_attributes($atts, $item, $args, $depth)
{
    if (is_main_menu($args)) {
        $class = 'main-menu__link';
        $atts['class'] = isset($atts['class']) ? $atts['class'] . " " . $class : $class;
        if (is_menu_item_has_children($item)) {
            $atts['data-dropdown-toggler'] = true;
        }
    }
    return $atts;
}


// Disable Child Menu Items 
function disable_child_menu_items_by_location($menu_id, $menu_item_db_id, $args)
{
    $menu_keys = array_keys(MAIN_MENU);
    $restricted_menu_location = $menu_keys[0] ?? null;

    if (!$restricted_menu_location) return;

    $locations = get_nav_menu_locations();
    $restricted_menu_id = isset($locations[$restricted_menu_location]) ? wp_get_nav_menu_object($locations[$restricted_menu_location])->term_id : null;

    if ($restricted_menu_id && $menu_id == $restricted_menu_id) {
        update_post_meta($menu_item_db_id, '_menu_item_menu_item_parent', 0);
    }
}
add_action('wp_update_nav_menu_item', 'disable_child_menu_items_by_location', 10, 3);
