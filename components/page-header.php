<?php
$args = wp_parse_args($args,    [
    'object' => get_the_ID(),
]);
$object = $args['object'];
$args = wp_parse_args($args,    [
    'title' => get_the_title($object),
    'label' => get_sub_field('title_type') !== 'default' ? get_the_title($object) : null,
    'description' => false,
    'show_post_meta' => false,
    'height' => '',
    'img_lax_effect' => true,
    'img_id' => get_post_thumbnail_id($object),
    'img_lazy' => false,
]);
extract($args);

$page_label_before = $img_id ? '<div class="page-header-decor"><div data-animate="up"><div class="page-header-decor__label vertical-line vertical-line--top">' : null;
$page_label_after = $img_id ? '</div></div></div>' : null;
$page_label = get_sub_field('title_type') !== 'default' && $label ? "$page_label_before<p class='fs-lg uppercase'>" . esc_html($label) . "</p>$page_label_after" : null;

$block_name = CONTENT_BLOCK_CLASS . ' ' . CONTENT_BLOCK_MODIFIER . basename(__FILE__, '.php');
$block_class = get_core_filter_implode([
    $block_name,
    'bg-primary',
    $height,
]);
?>
<div class="<?= $block_class;  ?>">
    <div class="<?= CONTENT_BLOCK_CONTENT; ?> section-pt text-center">
        <div class="container section-pt">
            <div class="min-height-xs">
                <?php if ($show_post_meta) get_template_part('components/date'); ?>
                <?php if ($title): ?>
                    <h1><?= esc_html(strip_tags($title)); ?></h1>
                <?php endif; ?>
                <?php if ($description) echo $description; ?>
                <?php if (!$img_id) echo $page_label ?>
            </div>
        </div>
        <?php
        if ($img_id) :
            $img_args = [
                'curtain' => true,
                'img_id' => $img_id,
                'img_lazy' => $img_lazy,
                'img_lax_effect' => $img_lax_effect
            ]; ?>
            <div class="pos-rel min-height-lg" data-animate>
                <?php
                echo $page_label;
                echo "<div class='overflow-hidden stretch border-block'>";
                get_template_part('components/background-image', null, $img_args);
                echo "</div>";
                ?>
            </div>
        <?php endif ?>
    </div>
</div>