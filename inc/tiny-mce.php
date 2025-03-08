<?php

add_filter('mce_buttons', 'core_mce_buttons');
function core_mce_buttons($buttons)
{
    $formatselect_index = array_search('formatselect', $buttons);
    if ($formatselect_index !== false) {
        array_splice($buttons, $formatselect_index + 1, 0, 'styleselect');
    }
    return $buttons;
}

add_filter('tiny_mce_before_init', 'core_tiny_mce_before_init');
function core_tiny_mce_before_init($settings)
{
    $tag_selectors = 'p,a,h1,h2,h3,h4,h5,h6,span';
    $style_formats = array(
        array(
            'title' => 'Heading Size',
            'items' => array(
                array(
                    'title' => 'H1',
                    'selector' => $tag_selectors,
                    'attributes' => ['class' => 'h1']
                ),
                array(
                    'title' => 'H2',
                    'selector' => $tag_selectors,
                    'attributes' => ['class' => 'h2']
                ),
                array(
                    'title' => 'H3',
                    'selector' => $tag_selectors,
                    'attributes' => ['class' => 'h3']
                ),
                array(
                    'title' => 'H4',
                    'selector' => $tag_selectors,
                    'attributes' => ['class' => 'h4']
                ),
                array(
                    'title' => 'H5',
                    'selector' => $tag_selectors,
                    'attributes' => ['class' => 'h5']
                ),
                array(
                    'title' => 'H6',
                    'selector' => $tag_selectors,
                    'attributes' => ['class' => 'h6']
                ),
            ),
        ),
        array(
            'title' => 'Text Size',
            'items' => array(
                array(
                    'title' => 'Large',
                    'inline' => 'span',
                    'classes' => 'fs-lg'
                ),
                array(
                    'title' => 'Small',
                    'inline' => 'small',
                ),
            ),
        ),
        array(
            'title' => 'Text Color',
            'items' => array(
                array(
                    'title' => 'Primary',
                    'inline' => 'span',
                    'classes' => 'text-primary'
                ),
                array(
                    'title' => 'Muted',
                    'inline' => 'span',
                    'classes' => 'text-muted'
                ),
            ),
        ),
        array(
            'title' => 'Text Offset',
            'inline' => 'span',
            'classes' => 'text-offset'
        ),
        array(
            'title' => 'Vertical Line',
            'block' => 'div',
            'classes' => 'vertical-line',
        ),
        array(
            'title' => 'Text Label',
            'selector' => $tag_selectors,
            'inline' => 'span',
            'attributes' => ['class' => 'text-label']
        ),
        array(
            'title' => 'Buttons',
            'items' => array(
                array(
                    'title' => 'Button - Primary',
                    'selector' => 'a',
                    'attributes' => ['class' => 'button']
                ),
                array(
                    'title' => 'Button - Outline',
                    'selector' => 'a',
                    'attributes' => ['class' => 'button button--outline']
                ),
                array(
                    'title' => 'Button - White',
                    'selector' => 'a',
                    'attributes' => ['class' => 'button button--white']
                ),
            ),
        ),

    );

    $settings['style_formats'] = json_encode($style_formats);
    $settings['paste_as_text'] = true;
    return $settings;
}
