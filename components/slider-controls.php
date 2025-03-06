<?php
$args = wp_parse_args($args, [
    'id' => null,
    'pagination' => false,
    'swiper_navigation_class' => null
]);
extract($args);
$id = $id ? "='$id'" : '';
?>
<div class="swiper-navigation<?= $swiper_navigation_class ? " $swiper_navigation_class" : null ?> text-white">
    <button type="button" aria-label="Previous slide" class="button button--square" data-swiper-button-prev<?= $id; ?>>
        <?= get_core_icon('arrow', 'rotate-180 fs-lg') ?>
    </button>
    <?= $pagination ? "<div class='swiper-pagination' data-swiper-pagination$id></div>" : null ?>
    <button type="button" aria-label="Next slide" class="button button--square" data-swiper-button-next<?= $id; ?>>
        <?= get_core_icon('arrow', 'fs-lg') ?>
    </button>
</div>