<?php
$args = wp_parse_args($args, [
    'title' => get_sub_field('title'),
    'content' => get_sub_field('content'),
    'total' => 0,
    'current' => 1, // Start from 1
    'id' => wp_unique_id(),
    'faq_schema' => false,
]);
extract($args);
if ($total < 1 || !$title || !$content) return;

$accordion_id = "accordion-$id";
$accordion_panel_id = "accordion-panel-$id";

$faq_schema_page = $faq_schema_question = $faq_schema_name = $faq_schema_answer = $faq_schema_text = '';

if ($faq_schema) {
    $faq_schema_page = "itemscope itemtype='https://schema.org/FAQPage'";
    $faq_schema_question = "itemscope itemprop='mainEntity' itemtype='https://schema.org/Question'";
    $faq_schema_name = "itemprop='name'";
    $faq_schema_answer = "itemscope itemprop='acceptedAnswer' itemtype='https://schema.org/Answer'";
    $faq_schema_text = "itemprop='text'";
}

if ($current === 1) echo "<div class='accordion' $faq_schema_page>";
?>
<div class="accordion__item" <?= $faq_schema_question; ?> data-accordion-item data-animate>
    <div class="accordion__body">
        <h3 class="accordion__header" <?= $faq_schema_name; ?>>
            <button type="button" id="<?= $accordion_id; ?>" class="accordion__button" aria-expanded="false" aria-controls="<?= $accordion_panel_id; ?>" data-accordion-toggler>
                <div class="accordion__layout">
                    <span class="accordion__layout-num"><?= $current ?></span>
                    <span class="accordion__layout-content">
                        <span class="h5">
                            <?= esc_html($title); ?>
                        </span>
                        <?= get_core_icon('plus', 'accordion__icon'); ?>
                    </span>
                </div>
            </button>
        </h3>
        <div id="<?= $accordion_panel_id; ?>" class="element-hidden accordion__content-holder" role="region" aria-labelledby="<?= $accordion_id; ?>" <?= $faq_schema_answer; ?>>
            <div class="accordion__content accordion__layout" <?= $faq_schema_text; ?>>
                <?= $content; ?>
            </div>
        </div>
    </div>
</div>
<?php if ($current === $total) echo "</div>";
