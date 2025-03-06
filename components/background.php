<?php
$args = wp_parse_args($args, [
    'img_size' => null,
    'img_class' => null,
    'img_lax_effect' => true
]);
extract($args);

$background = get_sub_field('background');
if (!$background) return;

$background_type = $background['bg_type'];
if ($background_type === 'none') return;

//Background Color
if ($background_type === 'color') {
    $background_type_color = $background['bg_type_color'];
    $background_color =  $background_type_color['bg_color'];
    if ($background_color !== 'custom') {
        echo "<div class='stretch bg-$background_color'></div>";
    } else {
        $background_color_custom = $background_type_color['bg_color_custom'];
        echo "<div class='stretch' style='background-color:$background_color_custom'></div>";
    }
}

//Background Image
if ($background_type === 'image') {
    $image = $background['bg_type_image'];
    if ($image) {
        $bg_image_args = [
            'img_id' => $image['ID'],
            'img_class' => $img_class,
            'img_lax_effect' => $img_lax_effect
        ];
        if ($img_size) {
            $bg_image_args['img_size'] = $img_size;
        }
        get_template_part('components/background-image', null, $bg_image_args);
    }
}

//Background Video
if ($background_type === 'video') {
    $video = $background['bg_type_video'];
    if ($video) {
        $src = $video['url'];
        $mime_type = $video['mime_type'];
        $poster = '';
        $poster_id = get_field('video_poster', $video['id']);
        if ($poster_id) {
            $poster_url = wp_get_attachment_image_url($poster_id, IMG_SIZE_LG);
            $poster = 'poster="' . esc_url($poster_url) . '"';
        }
        echo sprintf(
            "<div class='stretch'><video class='element-sticky' playsinline autoplay muted loop %s><source src='/' data-src='%s' type='%s'></video></div>",
            $poster,
            esc_url($src),
            esc_attr($mime_type)
        );
    }
}

//Background Overlay
$background_overlay = $background['text_settings']['background_overlay'];
if ($background_overlay && $background_type !== 'color') {
    get_template_part('components/curtain');
}
