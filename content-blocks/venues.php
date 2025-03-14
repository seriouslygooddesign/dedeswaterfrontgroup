<?php
$venues = [];
$venues_type = get_sub_field('type');

switch ($venues_type) {
    case 'select':
        $venues = get_sub_field('venues');
        break;

    case 'custom':
        if (have_rows('venues_custom_content')) {
            while (have_rows('venues_custom_content')) {
                the_row();
                $venue = get_sub_field('venue');
                if (isset($venue[0])) {
                    $venue[0]->post_content = get_sub_field('content');
                    $venues[] = $venue[0];
                }
            }
        }
        break;

    default:
        $venues = get_posts([
            'post_type'      => 'venue',
            'posts_per_page' => -1,
        ]);
        break;
}

if (!$venues) return;

$lax_id = wp_unique_id();
$layout_overlap = get_sub_field('layout') === 'rows';
$venue_content = $venue_content_before = $venue_content_after = null;
$featured_imgs = null;

foreach ($venues as $index => $post) : setup_postdata($post);
    $featured_img_id = get_post_thumbnail_id();
    $featured_img_variables = "--_overlap-mask-gradient: var(--_overlap-mask-gradient-$index)";
    $featured_img = get_core_image($featured_img_id, IMG_SIZE_3XL, 'layout-overlap__img stretch', true, true, ['style' => $featured_img_variables]);
    $featured_imgs .= $featured_img;

    $venue_link = get_field('link');
    $venue_secondary_link = get_field('secondary_link');
    $venue_address = get_field('address');

    $vanue_link_args = $venue_secondary_link_args = $venue_address_args = null;

    if ($venue_link) {
        $vanue_link_args = [
            'title' => get_the_title(),
            'url' => $venue_link,
            'target' => '_blank',
        ];
    };

    if ($venue_secondary_link) {
        $venue_secondary_link_args = [
            'title' => 'Enquire Now',
            'url' => $venue_secondary_link,
            'target' => '_blank',
        ];
    };

    if ($venue_address) {
        $venue_address_args = [
            'title' => $venue_address['label'],
            'url' => $venue_address['link'],
            'target' => '_blank',
        ];
    }

    $card_args = array(
        'card_link' => $venue_link,
        'title_extra_class' => 'h6',
        'card_link_target' => '_blank'
    );

    if ($layout_overlap) {
        $card_args['content_image'] = get_field('logo');
        $card_args['title_extra_class'] = 'h3';
        $card_args['image_holder_class'] = 'ratio-4-3';
        $card_args['card_class'] = 'card--row';
        $card_args['card_link'] = false;
        $card_args['title'] = $vanue_link_args ? get_core_link($vanue_link_args, null) : get_the_title();
        $card_args['content'] = apply_filters('the_content', get_the_content());

        $vanue_link_args['title'] = 'Visit Vebsite';

        $venue_link_output = get_core_link($vanue_link_args, null, '<div class="col-auto uppercase">', '</div>');
        $venue_address_output = get_core_link($venue_address_args, null, '<div class="col-auto hstack align-items-center gap-1">' . get_core_icon('pin') . '', '</div>');
        $left = get_core_link($venue_secondary_link_args, 'button', "<div class='col-md-auto'>", "</div>");
        $right = "<div class='col-xl'><div class='row align-items-center gy-4 justify-content-between'>$venue_link_output $venue_address_output</div></div>";

        $card_args['footer_content'] = "<div class='row align-items-center gy-4'>$left$right</div>";

        $gallery = get_field('gallery');
        if ($gallery) {
            $gallery_img_ids = $featured_img_id . "," . implode(',', $gallery);
            $gallery_shortcode = do_shortcode(sprintf('[gallery ids="%s" columns="1" size="' . IMG_SIZE_XL . '"]', esc_attr($gallery_img_ids)));
            $gallery = "<div class='stretch'>$gallery_shortcode</div>";
            $card_args['image'] = $gallery;
        }
        $venue_content_before = "<div class='layout-overlap__item'><div class='layout-overlap__inner container'><div class='layout-overlap__card'>";
        $venue_content_after = "</div></div></div>";
    }

    ob_start();
    get_template_part('components/card', null, $card_args);
    $venue_content .= $venue_content_before . ob_get_clean() . $venue_content_after;

endforeach;
wp_reset_postdata();

$block_args = [
    'class' => !$layout_overlap ? 'section-py min-height-custom' : null,
    'attr' => !$layout_overlap ? 'data-lax-slider' : 'data-lax-fade-offset-y',
];

get_template_part('components/block', 'start', $block_args);
?>

<?php if ($layout_overlap): ?>
    <div class="layout-overlap" style="--_min-height: <?= count($venues) ?>00vh;" data-lax-effect-bands>
        <div class="layout-overlap__body">
            <div class="layout-overlap__images stretch d-none d-md-block">
                <?= $featured_imgs ?>
            </div>
            <div class="layout-overlap__content">
                <?= $venue_content ?>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="layout-overflow overflow-hidden">
        <?php get_template_part('components/block', 'header', ['class' => 'layout-overflow__header container']); ?>
        <div class="layout-overflow__body">
            <div class="layout-overflow__content">
                <?= $venue_content ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php get_template_part('components/block', 'end'); ?>