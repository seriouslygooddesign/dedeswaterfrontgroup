<?php
$block_args = wp_parse_args($args, [
	'class' => get_core_height() ? get_core_vertical_align() : null,
]);
get_template_part('components/block', 'start', $block_args);
get_template_part('components/block', 'header');
$row_class = get_core_filter_implode([
	'row',
	get_core_horizontal_align(),
	get_core_vertical_align(),
	get_core_reverse_columns()
]);
if (have_rows('columns')) : ?>
	<div class="<?= $row_class; ?>">
		<?php while (have_rows('columns')) : the_row();	?>
			<div class="<?= get_core_column_width() ?>" data-animate>
				<?= get_sub_field('column'); ?>
			</div>
		<?php endwhile; ?>
	</div>
<?php
endif;
get_template_part('components/block', 'end');
