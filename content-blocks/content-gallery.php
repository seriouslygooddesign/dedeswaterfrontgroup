<?php
$block_args = [
    'modifier' => basename(__FILE__, '.php')
];
get_template_part('components/block', 'start', $block_args);
$direction = get_sub_field('direction');
if (have_rows('block')) : ?>
    <?php while (have_rows('block')) : the_row();
        get_template_part('components/content-gallery', null, ['direction' => $direction]);
    endwhile; ?>
<?php
endif;
get_template_part('components/block', 'end');
