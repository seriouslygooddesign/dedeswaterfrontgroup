<?php
$args = wp_parse_args($args, [
    'icon' => '',
    'icon_holder' => true,
    'label' => '',
    'url' => '',
    'target_blank' => false,
    'aria_label' => '',
    'wrap' => false,
    'wrap_tag' => 'p',
    'noopener_noreferrer' => false
]);
extract($args);

$attributes = '';

//icon
if ($icon) {
    $icon = get_core_icon($icon, null, $icon_holder);
}

//url
$attributes .= "href='" . esc_url($url) . "'";

//target blank
if ($target_blank) $attributes .= " target='_blank'";

//aria label
if ($aria_label) $attributes .= " aria-label='" . esc_html($aria_label) . "'";

//wrap
$before = $wrap ? "<$wrap_tag>" : null;
$after = $wrap ? "</$wrap_tag>" : null;

//rel
if ($noopener_noreferrer) $attributes .= " rel='noopener noreferrer'";

echo  "$before<a class='icon-label' $attributes>$icon" . esc_html($label) . "</a>$after";
