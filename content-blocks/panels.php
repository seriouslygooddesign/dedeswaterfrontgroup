<?php
get_template_part('components/block', 'start');
$row_class = get_core_filter_implode([
    CONTENT_BLOCK_CLASS . '__row row g-0',
    get_core_reverse_columns()
]);
if (have_rows('panels')) : ?>
    <div class="<?= $row_class; ?>">
        <?php while (have_rows('panels')) :
            the_row();
            $content = get_sub_field('content');
            $has_content = !empty($content);

            $bg = get_sub_field('background');
            $has_bg = $bg['bg_type'] === 'image' || $bg['bg_type'] === 'video' ? true : false;

            if ($has_content || $has_bg) :
                $col_class = get_core_filter_implode([
                    'col-md-6 pos-rel section-py d-flex',
                    $has_bg ? "has-bg" : null,
                    $has_content ? get_core_vertical_align() : null,
                ]);
        ?>
                <div class="<?= $col_class; ?>">
                    <?php get_template_part('components/background', null, ['img_size' => IMG_SIZE_2XL]);
                    if ($has_content) : ?>
                        <div class="<?= get_core_filter_implode(['container-sm', get_core_color_scheme_opposite()]) ?>" data-animate>
                            <?= $content; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
<?php
endif;
get_template_part('components/block', 'end');
