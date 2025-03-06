<?php
get_header();

//Get Single What's On Data
$is_main_site = is_main_site();
switch_to_blog(1);

$id = get_the_ID();
if (!$is_main_site) {
    global $wp;
    $id = url_to_postid(home_url($wp->request));
}

get_template_part('components/content-blocks', null, ['object_id' => $id]);

restore_current_blog();

get_footer();
