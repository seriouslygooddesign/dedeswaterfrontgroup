<?php
//Decode manifest.json to string to get a path to a file
function get_core_enqueue_path($name, $template_directory_uri = true)
{
    $manifest_file_path = get_template_directory() . '/dist/manifest.json';
    if (!file_exists($manifest_file_path)) return;
    $manifest_file = file_get_contents($manifest_file_path);
    $manifest_data = json_decode($manifest_file, true);
    $result = $manifest_data[$name] ?? null;
    $before_path = null;
    if ($template_directory_uri) {
        $before_path = get_template_directory_uri();
    }
    return $result ? $before_path . $result : null;
}

//Filter & Implode
function get_core_filter_implode(array $array)
{
    return implode(' ', array_filter($array));
}

//Remove Image Width And Height Attributes
function get_core_remove_width_height_attr($html)
{
    $html = preg_replace('/(width|height)="\d*"/', '', $html);
    return $html;
}

//Hide Block Logic
function get_core_hide_block()
{
    return get_sub_field('hide_block') === true ? false : true;
}

//Spacer
function get_core_spacer()
{
    $padding = get_sub_field('padding');
    if (!$padding) {
        return;
    }
    $top = 'top';
    $bottom = 'bottom';
    if (in_array($bottom, $padding) && in_array($top, $padding)) {
        $class = 'section-py';
    } elseif (in_array($bottom, $padding)) {
        $class = 'section-pb';
    } elseif (in_array($top, $padding)) {
        $class = 'section-pt';
    } else {
        $class = null;
    }
    return $class;
}

//Container Width
function get_core_container_width()
{
    $container_width = get_sub_field('container_width');
    if ($container_width && $container_width !== 'none') {
        $container_width = $container_width !== 'default' ? "-" . esc_attr($container_width) : null;
        return "container$container_width";
    }
}

//Height
function get_core_height()
{
    $height = get_sub_field('height');
    if ($height && $height !== 'auto') {
        return  "min-height-" . esc_attr($height);
    }
}

//Reverse Columns
function get_core_reverse_columns()
{
    $reverse_columns = get_sub_field('reverse_columns');
    if ($reverse_columns) {
        return "flex-column-reverse flex-md-row";
    }
}

//Vertical Align
function get_core_vertical_align()
{
    $vertical_align = get_sub_field('vertical_align');
    if ($vertical_align && $vertical_align !== 'start') {
        return "align-items-" . esc_attr($vertical_align);
    }
}

//Horizontal Align
function get_core_horizontal_align()
{
    $horizontal_align = get_sub_field('horizontal_align');
    if ($horizontal_align && $horizontal_align !== 'start') {
        return "justify-content-" . esc_attr($horizontal_align);
    }
}

//White Text Color
function get_core_color_scheme_opposite($smart = true)
{
    $background = get_sub_field('background');
    if (!$background) {
        return;
    }
    $color_text_opposite = $background['text_settings']['text_color_opposite'];
    $color_text_class = "color-scheme-opposite";
    if ($smart) {
        $bg_type = get_sub_field('background')['bg_type'];
        return $bg_type !== 'none' && $color_text_opposite ? $color_text_class : null;
    }
    return $color_text_opposite ? $color_text_class : null;
}

//Column Width
function get_core_column_width()
{
    $column_width = get_sub_field('column_width');

    $mobile_column_width = isset($column_width['mobile']) ? $column_width['mobile'] : 12;
    $tablet_column_width = isset($column_width['tablet']) ? $column_width['tablet'] : 'inherit';
    $desktop_column_width = isset($column_width['desktop']) ? $column_width['desktop'] : 'inherit';

    $prefix = "col";
    $class = $prefix;

    if ($mobile_column_width !== 'default') {
        $class .= "-$mobile_column_width";
    }

    if ($tablet_column_width !== 'inherit' && $tablet_column_width !== $mobile_column_width) {
        $class .= " $prefix-md" . ($tablet_column_width !== 'default' ? "-$tablet_column_width" : '');
    }

    if ($desktop_column_width !== 'inherit' && $desktop_column_width !== $tablet_column_width) {
        $class .= " $prefix-xl" . ($desktop_column_width !== 'default' ? "-$desktop_column_width" : '');
    }

    return $class;
}

//Items Per Row
function get_core_items_per_row($items = 3)
{
    $items_per_row = get_sub_field('items_per_row');
    if ($items_per_row) {
        $items = intval($items_per_row);
    }
    $result = "row-cols-md-$items";
    if ($items > 3) {
        $result = "row-cols-md-2 row-cols-xl-$items";
    }
    return $result;
}

//Post categories
function get_core_categories()
{
    if ('post' === get_post_type()) {
        $categories = wp_get_post_categories(get_the_ID());
        $default_category_id = intval(get_option('default_category'));
        // Check if the post has only one category and if it is the default category
        if (count($categories) === 1 && $categories[0] === $default_category_id) {
            return null;
        }
        $categories_list = get_the_category_list(esc_html__(', ', 'core'));
        return sprintf("<p>" . esc_html__('%1$s', 'core') . '</p>', $categories_list);
    }
}

//Post tags
function get_core_tags()
{
    if ('post' === get_post_type()) {
        $tags_list = get_the_tag_list('', ', ');
        if ($tags_list) {
            return sprintf("<p>" . esc_html__('%1$s', 'core') . "</p>", $tags_list);
        }
    }
}

//Image
function get_core_image(int $id, $size = IMG_SIZE_MD,  $class = '', $stretch = false,  $lazy = true, $attr = [])
{
    $class = $stretch ? ($class ? "$class stretch" : "stretch") : $class;
    $attr['class'] = isset($attr['class']) ? $attr['class'] . " $class" : $class;

    $attr['loading'] = isset($attr['loading']) ? $attr['loading'] : (!$lazy ? 'eager' : 'lazy');

    $image = wp_get_attachment_image(
        $id,
        $size,
        false,
        $attr,
    );

    return $stretch ? get_core_remove_width_height_attr($image) : $image;
}

//Icon
function get_core_icon($icon = '', $class = '', $holder = false)
{
    $args = [
        'icon' => $icon,
        'class' => $class ? $class : null,
        'holder' => $holder,
    ];
    ob_start();
    get_template_part('components/icon', null, $args);
    return ob_get_clean();
}

//Pagination
function get_core_pagination()
{
    global $wp_query;
    $big = 999999999;

    return paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'prev_text' => "<span class='d-inline-flex' aria-label='Previous'>" . get_core_icon('chevron', 'rotate-90') . "</span>",
        'next_text' => "<span class='d-inline-flex' aria-label='Next'>" . get_core_icon('chevron', 'rotate-270') . "</span>",
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Links
function get_core_link($link, $class = "button", $before = "", $after = "")
{
    if (!is_array($link) || !isset($link['url']) || empty($link['url'])) {
        return;
    }
    $link_url = esc_url($link['url']);
    $link_title = $link['title'] ?? null  ?: "Learn More";
    $aria_label = ($stretch = $link['stretch'] ?? null) && $stretch === true ? " aria-label='$link_title'" : null;
    $link_title = !$aria_label ? esc_html($link_title) : null;
    $link_target = $link['target'] ?? null ? esc_attr($link['target']) : '_self';
    $class = $class ? " class='$class'" : null;

    return "$before<a$class href='$link_url' target='$link_target'$aria_label>$link_title</a>$after";
}
