<?php
$args = wp_parse_args(
    $args,
    [
        'image' => null,
        'image_id' => get_post_thumbnail_id(),
        'image_holder_class' => '',
        'title' => get_the_title(),
        'title_tag' => 'h3',
        'title_extra_class' => 'h4',
        'content' => apply_filters('the_content', get_the_excerpt()),
        'card_link' => get_permalink(),
        'card_link_target' => '_self',
        'content_image' => null,
        'card_class' => null,
        'footer_content' => null
    ]
);
extract($args);

$title_result = $card_link && $title ? get_core_link(['url' => $card_link, 'title' => $title, 'target' => $card_link_target], null) : $title;
$title_extra_class = $title_extra_class ? " $title_extra_class" : null;
?>
<div class="card color-scheme-opposite<?= $card_class ? " $card_class" : null ?>">
    <?php if ($image || $image_id) : ?>
        <div class="card__img-holder bg-surface <?= $image_holder_class ?>">
            <?= $card_link ? "<a href='$card_link' tabindex='-1' target='$card_link_target'>" . "<div class='card__link-icon'>" . get_core_icon('arrow', 'fs-lg') . "</div>" : null ?>
            <?= $image ?? get_core_image($image_id, IMG_SIZE_SM, 'card__img', true); ?>
            <?= $card_link ? "</a>" : null ?>
        </div>
    <?php endif; ?>
    <div class="card__content-holder">
        <?php if ($title_result || $content) : ?>
            <div class="card__content">
                <?= $title_result ? "<h3 class='card__title underline-reverse$title_extra_class'>$title_result</h3>" : null ?>
                <?= $content_image ? get_core_image($content_image, IMG_SIZE_SM, 'card__content-img') : null ?>
                <?= $content ? "<div class='card__content-body trim-margin'>$content</div>" : null ?>
            </div>
        <?php endif; ?>
        <?php if ($footer_content) : ?>
            <div class="card__footer">
                <?= $footer_content ?>
            </div>
        <?php endif; ?>
    </div>
</div>