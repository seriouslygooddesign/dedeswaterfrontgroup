<?php
//Disabling automatic scrolling on form submit
add_filter('gform_confirmation_anchor', '__return_false');

//Remove legend
add_filter('gform_required_legend', '__return_empty_string');

//Enable "Anti-spam honeypot" by default on form creation
add_action('gform_after_save_form', 'enable_honeypot_on_new_form_creation', 10, 2);
function enable_honeypot_on_new_form_creation($form, $is_new)
{
    if ($is_new && class_exists('GFAPI') && isset($form['enableHoneypot'])) {
        $form['enableHoneypot'] = true;
        GFAPI::update_form($form);
    }
}

add_action('wp_head', function () {
    $gf_inline_css = "
        body .gform-theme--foundation {
        --gf-form-gap-y: 2.25rem;
        --gf-ctrl-label-color-req: var(--color-danger);
        --gf-color-danger: var(--color-danger);
        --gf-ctrl-label-color-tertiary: var(--color-white-muted);
        --gf-ctrl-desc-color: var(--color-white-muted);
        }
 
    ";
    echo '<style>' . $gf_inline_css . '</style>';
});

//Custom Styles
function gform_custom_styles()
{
    $color_white = '#fff'; //Use HEX color
    $styles = [
        'inputSize' => 'lg',
        'inputBorderWidth' => '0',
        'inputBorderRadius' => '0',
        'inputBorderColor' => 'rgba(255,255,255,1)',
        'inputBackgroundColor' => 'var(--color-background)',
        'inputColor' => 'var(--color-foreground)',
        'inputPrimaryColor' => $color_white,
        'labelFontSize' => '16',
        'descriptionFontSize' => '14',
        'labelColor' => 'currentColor',
        'buttonPrimaryBackgroundColor' => $color_white,
        'buttonPrimaryColor' => '#061d41',
    ];
    return json_encode($styles);
}
add_filter('gform_default_styles', 'gform_custom_styles');
