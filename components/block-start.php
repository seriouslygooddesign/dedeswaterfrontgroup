<?php
global $content_block_name;
$args = wp_parse_args(
    $args,
    [
        'name' => $content_block_name,
        'class' => '',
        'attr' => '',
        'decorative_text' => get_sub_field('block_header_show') ? get_sub_field('decorative_text') ?? null : null,
    ]
);
extract($args);

$outer_class = get_core_filter_implode([
    CONTENT_BLOCK_CLASS,
    $name ? CONTENT_BLOCK_MODIFIER . $name : '',
    get_core_spacer(),
    get_core_height(),
    get_core_color_scheme_opposite(),
    $class
]);

$content_class = get_core_filter_implode([
    CONTENT_BLOCK_CONTENT,
    get_core_container_width()
]);

$block_id = get_sub_field('block_id');
$id = $block_id ? ' id="' . esc_attr($block_id) . '"' : null;
?>
<div<?= $id; ?> class="<?= $outer_class ?>" <?= $attr ?>>
    <?php get_template_part('components/background'); ?>
    <?= $decorative_text ? "<span class='bg-text display-1' data-lax-translate-easy>$decorative_text</span>" : null; ?>
    <div class="<?= $content_class; ?>">