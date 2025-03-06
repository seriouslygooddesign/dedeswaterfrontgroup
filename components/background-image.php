<?php
global $is_first_content_block;
$args = wp_parse_args($args, [
    'img_id' => get_post_thumbnail_id(),
    'img_size' => IMG_SIZE_3XL,
    'img_lazy' => $is_first_content_block ? false : true,
    'img_lax_effect' => false,
    'curtain' => false,
    'img_class' => null
]);
extract($args);
if (!$img_id) return;
$img_lax_effect = $img_lax_effect ? ["data-lax-bg-img" => ''] : null;
echo get_core_image($img_id, $img_size, $img_class, true, $img_lazy, $img_lax_effect);
if ($curtain) get_template_part('components/curtain');
