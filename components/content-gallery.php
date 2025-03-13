<?php
$args = wp_parse_args($args, ['direction' => false]);

$condition = $args['direction'] ? get_row_index() % 2 == 0 : get_row_index() % 2 !== 0;
$row_reverse = $condition ? ' flex-md-row-reverse' : '';
$color_background = !$condition ? ' color-background-surface' : '';
$content = get_sub_field('content');
$gallery = get_sub_field('gallery');
$featured_image = get_sub_field('image');
$links = [
    'custom_link' => get_sub_field('custom_link'),
    'link' => get_sub_field('link'),
];
$link_result = '';
foreach ($links as $key => $link) {
    if ($link) :
        $link_title = $link['title'] ?? 'Visit website';
        $link_url = $link['url'] ?? $link;
        $link_target = $link['target'] ?? '_blank';
        $link_class = $key == 'link' ? ' button--backgroundless' : '';
        $link_arrow = $key == 'link' ? ' <span class="site-icon site-icon--arrow">' : '';
        $link_result .= "<a href='" . esc_url($link_url) . "' class='button$link_class' target='" . esc_url($link_target) . "'>" . esc_html($link_title) . "$link_arrow</span></a>";
    endif;
}
?>
<div class="row g-0<?= $row_reverse ?>">
    <div class="col-md-6 gallery-stretch pos-rel" data-animate>
        <div class='stretch color-background-muted'></div>
        <?php
        if ($gallery) {
            $images_string = implode(',', $gallery);
            $shortcode = sprintf('[gallery ids="%s" columns="1" size="1536x1536" autoheight="0"]', esc_attr($images_string));
            echo do_shortcode($shortcode);
        }
        ?>
    </div>
    <div class="col-md-6 d-flex pos-rel align-items-center<?= $color_background ?>" data-animate>
        <div class="container-sm section-py">
            <?= $content ?? '' ?>
            <?= $link_result ? "<div class='hstack gap-3'>$link_result</div>" : '' ?>
        </div>
    </div>
</div>