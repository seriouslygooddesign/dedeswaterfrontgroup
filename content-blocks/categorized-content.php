<?php
get_template_part('components/block', 'start');
if (have_rows('categories')) :
?>
	<div class='section-navigation'>
		<ul class='section-navigation__list container-sm'>
			<?php
			$i = 0;
			while (have_rows('categories')) : the_row();
				$active_class = $i === 0 ? ' active' : '';
				$title = get_sub_field('title');
				$anchor = sanitize_title($title);
				echo $title ? "<li class='section-navigation__item'><a href='#$anchor' class='section-navigation__link$active_class' data-section-scroll-trigger>$title</a></li>" : null;
				$i++
			?>
			<?php endwhile; ?>
		</ul>
	</div>
<?php
endif;
if (have_rows('categories')) : ?>
	<?php while (have_rows('categories')) : the_row();
		$title = get_sub_field('title');
		$section_id = sanitize_title(get_sub_field('title'));
		$words = explode(' ', $title);
		if (count($words) > 1) {
			$title = array_shift($words) . ' <span class="text-offset">' . implode(' ', $words) . '</span>';
		}

	?>
		<div id="<?= $section_id ?>" data-section-scroll-section class="row g-0">
			<div class="col-md-6 pos-rel min-height-md" data-animate>
				<?php get_template_part('components/background', null, ['img_class' => 'element-sticky', 'img_lax_effect' => false]); ?>
			</div>
			<div class="col-md-6" data-animate>
				<?php
				if (have_rows('content_groups')) : ?>
					<div class="section-pt">
						<h2 class="pos-rel text-center section-scroll-title"><?php echo $title ?></h2>
						<br>
						<div class="container-sm">
							<?php while (have_rows('content_groups')) : the_row();
								$animate_direction = get_row_index() % 2 == 0 ? 'right' : 'left';
							?>
								<div class="section-pb" data-animate="<?= $animate_direction ?>">
									<?= get_sub_field('content') ?>
								</div>
							<?php endwhile; ?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div>
	<?php endwhile; ?>
<?php
endif;
get_template_part('components/block', 'end');
