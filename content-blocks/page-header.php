<?php
$args = wp_parse_args($args, [
    'object' => get_the_ID(),
]);
$object = $args['object'];

$page_header_args = [
    'object' => $object
];
$title_type = get_sub_field('title_type');
switch ($title_type) {
    case 'custom':
        $custom_title = get_sub_field('custom_title');
        $page_header_args['title'] = $custom_title;
        break;
    case 'none':
        $page_header_args['title'] = false;
}

$description_type = get_sub_field('description_type');
switch ($description_type) {
    case 'default':
        $page_header_args['description'] = apply_filters('the_content', get_the_excerpt());
        break;
    case 'custom':
        $custom_description = get_sub_field('custom_description');
        $page_header_args['description'] = $custom_description;
}
get_template_part('components/page-header', null, $page_header_args);
