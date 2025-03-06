<?php
// Remove wordpress css variables
remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');

// Remove Emoji
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

// Remove rss feed links
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'feed_links', 2);

// Disable wlwmanifest link
remove_action('wp_head', 'wlwmanifest_link');

// Remove Really Simple Discovery Link
remove_action('wp_head', 'rsd_link');
