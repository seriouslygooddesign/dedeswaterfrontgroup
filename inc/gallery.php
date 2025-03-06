<?php
add_filter('post_gallery', 'custom_gallery', 10, 2);
function custom_gallery($output, $attr)
{
    $images = get_posts([
        'post_type' => 'attachment',
        'include' => $attr['ids'],
        'orderby' => $attr['orderby'] ?? 'post__in'
    ]);
    if ($images) {

        $slides_per_view = isset($attr['columns']) ? intval($attr['columns']) : 3;
        $size = $attr['size'] ?? IMG_SIZE_XS;
        $link = $attr['link'] ?? 'attachment';
        $link_none = $link === 'none';

        $swiper_parameters = [
            "slidesPerView" => 1,
            "spaceBetween" => 20,
            "loop" => true,
            "autoHeight" => true,
        ];
        if ($slides_per_view >= 4) {
            $swiper_parameters["slidesPerView"] = 2;
            $swiper_parameters["breakpoints"][640]["slidesPerView"] = round($slides_per_view / 2);
            $swiper_parameters["breakpoints"][1024]["slidesPerView"] = $slides_per_view;
        } elseif ($slides_per_view === 3) {
            $swiper_parameters["breakpoints"][640]["slidesPerView"] = 2;
            $swiper_parameters["breakpoints"][1024]["slidesPerView"] = 3;
        } elseif ($slides_per_view === 2) {
            $swiper_parameters["breakpoints"][640]["slidesPerView"] = $slides_per_view;
        }

        $swiper_parameters = json_encode($swiper_parameters);
        $output = "<div class='swiper swiper--center' data-swiper='$swiper_parameters'><div class='swiper-wrapper'>";

        foreach ($images as $image) {
            $image_id = $image->ID;
            $output .= "<figure class='swiper-slide text-center'>";
            if (!$link_none) {
                $href = get_attachment_link($image_id);
                $target = '_self';
                if ($link === 'file') {
                    $href = wp_get_attachment_image_src($image->ID, $size)[0];
                    $target = '_blank';
                }
                $output .= "<a href='$href' target='$target'>";
            }
            $output .= wp_get_attachment_image($image_id, $size);
            if (!$link_none) {
                $output .= "</a>";
            }
            $caption = wp_get_attachment_caption($image_id);
            if ($caption) $output .= "<figcaption class='fs-sm'>$caption</figcaption>";
            $output .= "</figure>";
        }

        $output .= "</div>"; //swiper-wrapper
        ob_start();
        get_template_part('components/slider-controls', null, ['swiper_navigation_class' => 'flex-xl-column swiper-navigation--inside']);
        $slider_controls = ob_get_clean();
        $output .= $slider_controls;
        $output .= "</div>"; //swiper
    }

    return $output;
}
