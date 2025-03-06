<?php
get_template_part('components/block', 'start');
get_template_part('components/block', 'header');
$row_class = get_core_filter_implode([
	'row',
	'g-3',
	get_core_items_per_row(),
	get_core_horizontal_align()
]);
if (have_rows('cards')) : ?>
	<div class="<?= $row_class; ?>">
		<?php while (have_rows('cards')) : the_row(); ?>
			<div class="col-12" data-animate>
				<?php
				$title = get_sub_field('title');
				$card_link = get_sub_field('link');
				$default_link = [
					'title' => $card_link['title'] ?? null,
					'url' => $card_link['url'] ?? null,
					'target' => $card_link['target'] ?? null,
				];
				$card_args = [
					'image_id' => get_sub_field('image'),
					'title' => $title,
					'card_link' => $card_link['url'] ?? null,
					'content' => get_sub_field('content'),
				];
				get_template_part('components/card', null, $card_args);
				?>
			</div>
		<?php endwhile; ?>
	</div>
<?php
endif;
get_template_part('components/block', 'footer');
get_template_part('components/block', 'end');
