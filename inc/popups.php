<?php
$popup_cpt_name = 'sgd-popup';
$sgd_popups = [];
$popup_shortcode_field_name = 'popup_shortcode';
$copy_popup_shortcode_data_attr = 'data-copy-popup-shortcode';

function is_sgd_popup_exists($popup_id)
{
    global $popup_cpt_name;
    $popup = get_post($popup_id);
    return $popup && $popup->post_type === $popup_cpt_name;
}

function is_sgd_popup_published($popup_id)
{
    return is_sgd_popup_exists($popup_id) && get_post_status($popup_id) === 'publish';
}

function get_sgd_popup_preview_id()
{
    if (!current_user_can('manage_options')) return null;
    $popup_preview_id = isset($_GET['popup_preview']) ? (int) sanitize_text_field($_GET['popup_preview']) : null;
    return $popup_preview_id && is_sgd_popup_exists($popup_preview_id) ? $popup_preview_id : null;
}

function sgd_popup_admin_notification($message = '')
{
    return current_user_can('manage_options') ? "<span style='cursor:help;font-size:.875em;display:inline-block;' title='This is visible only to administrator users.'>$message</span>" : null;
}

//Prepare the shortcode ACF field
add_filter("acf/prepare_field/name=$popup_shortcode_field_name", function ($field) {
    global $copy_popup_shortcode_data_attr;
    global $post;
    $field['readonly'] = 'readonly';
    $field['value'] = '[sgd_popup id="' . esc_attr($post->ID) . '" label="Learn More"]';
    $field['append'] = "<a href='#' $copy_popup_shortcode_data_attr='" . esc_attr($field['id']) . "'>Copy</a>";
    return $field;
}, 10, 1);

//Add content before the shortcode ACF field
add_action("acf/render_field/type=text", function ($field) {
    global $popup_shortcode_field_name;
    if ($field['_name'] === $popup_shortcode_field_name) {
        echo '<div style="max-width:24rem">'; //Width limiter - start
    }
}, 9, 1);

//Add content after the shortcode ACF field
add_action("acf/render_field/type=text", function ($field) {
    global $popup_shortcode_field_name;
    if ($field['_name'] === $popup_shortcode_field_name) {
        echo "</div>"; //Width limiter - end
        ob_start(); ?>
        <details style="margin-top:1em">
            <summary style="cursor:pointer">Shortcode Parameters</summary>
            <p>
                <strong>Example Shortcode</strong><br><code>[sgd_popup id="1" label="Learn More" type="link" class="custom-class"]</code>
            </p>
            <table class="widefat striped">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Description</th>
                        <th>Example Usage</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>id</strong></td>
                        <td><strong>Required.</strong> The numeric ID of the popup.</td>
                        <td><code>id="1"</code></td>
                    </tr>
                    <tr>
                        <td><strong>label</strong></td>
                        <td><strong>Required.</strong> The text that will be displayed on the popup trigger.</td>
                        <td><code>label="Learn More"</code></td>
                    </tr>
                    <tr>
                        <td><strong>type</strong></td>
                        <td>
                            Define the style of the popup trigger. Possible values:
                            <ul style="padding-left: 1.5em; list-style-type: disc">
                                <li>button <code>default</code></li>
                                <li>button-outline</li>
                                <li>button-white</li>
                                <li>link</li>
                            </ul>
                        </td>
                        <td><code>type="link"</code></td>
                    </tr>
                    <tr>
                        <td><strong>class</strong></td>
                        <td>Adds CSS class to the popup trigger element.</td>
                        <td><code>class="custom-class"</code></td>
                    </tr>
                </tbody>
            </table>
        </details>
    <?php
        echo ob_get_clean();
    }
}, 10, 1);

//Popup preview link
add_action('post_submitbox_misc_actions', function () {
    global $popup_cpt_name;
    global $post;
    if ($post && $post->post_type === $popup_cpt_name && $post->post_status !== 'auto-draft') {
    ?>
        <div class="misc-pub-section">
            <a class="button" href="/?popup_preview=<?= esc_attr($post->ID); ?>" target="_blank">Popup Preview</a>
        </div>
    <?php
    }
});

//Show popup ID in popup cpt in admin panel 
add_filter("manage_{$popup_cpt_name}_posts_columns", function ($columns) {
    unset($columns['date']);
    $columns['sgd_popup_id'] = 'Popup ID';
    return $columns;
}, 10, 1);
add_action("manage_{$popup_cpt_name}_posts_custom_column", function ($column_name, $post_id) {
    if ($column_name === 'sgd_popup_id') echo "<code>" . esc_html($post_id) . "</code>";
}, 10, 2);

//JS for shortcode copy functionality
add_action('acf/input/admin_footer', function () {
    global $copy_popup_shortcode_data_attr;
    global $popup_cpt_name;
    global $post;
    if ($post && $post->post_type === $popup_cpt_name) {
    ?>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                let isPopupShortcodeCopied = false;
                document.querySelector('[<?= $copy_popup_shortcode_data_attr; ?>]')?.addEventListener('click', function(e) {
                    e.preventDefault();
                    const shortcodeField = document.getElementById(this.dataset.copyPopupShortcode);
                    if (!shortcodeField) return;
                    shortcodeField.select();
                    shortcodeField.setSelectionRange(0, 99999);
                    navigator.clipboard.writeText(shortcodeField.value);
                    const buttonText = this.innerText;
                    if (!isPopupShortcodeCopied) {
                        isPopupShortcodeCopied = true;
                        this.innerText = 'Copied!';
                        setTimeout(() => {
                            this.innerText = buttonText;
                            isPopupShortcodeCopied = false;
                        }, 1000);
                    }
                })
            })
        </script>
<?php
    }
});

//Check if current page/post has popups
add_action('template_redirect', function () {
    global $sgd_popups, $popup_cpt_name;

    $popup_meta_query_args_global = [
        'key'   => 'popup_trigger_selector_location',
        'value' => 'global',
        'compare' => '='
    ];

    $popup_meta_query_args = is_singular() ? [
        'relation' => 'OR',
        $popup_meta_query_args_global,
        [
            'relation' => 'AND',
            [
                'key'   => 'popup_trigger_selector_location',
                'value' => 'select',
                'compare' => '='
            ],
            [
                'key'   => 'popup_trigger_selector_relationship',
                'value' => serialize((string)get_the_ID()),
                'compare' => 'LIKE'
            ]
        ]
    ] : [
        $popup_meta_query_args_global
    ];

    $found_popups = get_posts([
        'post_type' => $popup_cpt_name,
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_query' => $popup_meta_query_args
    ]);

    if (!empty($found_popups)) $sgd_popups = $found_popups;
});

//Shortcode
add_shortcode('sgd_popup', function ($atts) {
    global $sgd_popups;

    $atts = shortcode_atts(
        [
            'id' => null, //Required
            'label' => 'Learn More', //Required
            'class' => '',
            'type' => 'button'
        ],
        $atts,
        'sgd_popup'
    );
    extract($atts);

    if (!$label) return;

    if (!$id || !is_numeric($id)) return sgd_popup_admin_notification('Not valid popup ID parameter.');

    $id = (int) $id;

    if (!is_sgd_popup_exists($id)) return sgd_popup_admin_notification('Popup with ID <strong>' . esc_html($id) . '</strong> not found.');

    if (!is_sgd_popup_published($id)) return sgd_popup_admin_notification('Popup with ID <strong>' . esc_html($id) . '</strong> not published.');

    if (!in_array($id, $sgd_popups)) {
        $sgd_popups[] = $id;
    };

    $trigger_attr = '';

    switch ($type) {
        case 'button':
            $class .= ' button';
            break;
        case 'button-outline':
            $class .= ' button button--outline';
            break;
        case 'button-white':
            $class .= ' button button--white';
            break;
    }

    $class = trim($class); //strip whitespace
    if ($class) $trigger_attr .= ' class="' . esc_attr($class) . '"';

    //Add default popup trigger selector
    $trigger_attr .= ' data-sgd-popup-trigger="' . esc_attr($id) . '"';

    return "<a href='#'$trigger_attr>" . esc_html($label) . "</a>";
});

//Display popups in footer
add_action('wp_footer', function () {
    global $sgd_popups;

    //Popup preview
    $popup_preview_id = get_sgd_popup_preview_id();
    if ($popup_preview_id && !in_array($popup_preview_id, $sgd_popups)) {
        $sgd_popups[] = $popup_preview_id;
    }

    if (is_array($sgd_popups) && count($sgd_popups) > 0) {
        foreach ($sgd_popups as $id) {
            if (!is_numeric($id)) continue;
            $is_preview_popup = $popup_preview_id === $id;
            if (is_sgd_popup_published($id) || $is_preview_popup) {
                $popup_args = [
                    'id' => $id,
                    'content' => apply_filters('the_content', get_the_content(false, false, $id)),
                    'title' => get_field('popup_title', $id),
                    'active' => $is_preview_popup ? true : false,
                    'popup_trigger_selector' => get_field('popup_trigger_selector', $id) ?: ''
                ];
                get_template_part('components/popup', null, $popup_args);
            };
        };
    }
});
