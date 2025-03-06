<?php
$args = wp_parse_args($args, [
    'id' => '',
    'title' => '',
    'content' => '',
    'popup_trigger_selector' => '',
    'active' => false,
]);
extract($args);

$popup_id_attr = $aria_labelledby_attr =  $title_id_attr = null;

if ($id) {
    $prefix = 'sgd-popup';
    $prefixed_id = "$prefix-$id";
    $popup_id_attr = 'id="' . esc_attr($prefixed_id) . '" ';

    $default_popup_trigger_selector = '[data-sgd-popup-trigger="' . esc_attr($id) . '"]';
    $popup_trigger_selector = $popup_trigger_selector ? "$default_popup_trigger_selector,$popup_trigger_selector" : $default_popup_trigger_selector;

    if ($title) {
        $title_id = "$prefixed_id-title";
        $aria_labelledby_attr = 'aria-labelledby="' . esc_attr($title_id) . '" ';
        $title_id_attr = 'id="' . esc_attr($title_id) . '"';
    }
}

?>
<div <?= $popup_id_attr; ?>role="dialog" aria-modal="true" <?= $aria_labelledby_attr; ?>class="main-popup<?= $active ? ' active' : ''; ?>" data-sgd-popup data-sgd-popup-trigger-selector="<?= esc_attr($popup_trigger_selector); ?>">
    <div class="main-popup__curtain" data-sgd-popup-toggler-close></div>
    <div class="main-popup__main">
        <div class="main-popup__header row g-0 justify-content-end">
            <?php if ($title) : ?>
                <div class="main-popup__title-wrap col">
                    <h2 <?= $title_id_attr; ?>class="h5 mt-0"><?= esc_html($title); ?></h2>
                </div>
            <?php endif; ?>
            <div class="col-auto">
                <button class="main-popup__close-button button button--square" aria-label="Close popup" type="button" data-sgd-popup-toggler-close>
                    <?= get_core_icon('close', 'toggler-button__icon'); ?>
                </button>
            </div>
        </div>
        <div class="main-popup__body">
            <?= $content; ?>
        </div>
    </div>
</div>