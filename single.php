<?php
get_header();
while (have_posts()) :
	the_post();
	$post_type_post = get_post_type() === 'post';
?>
	<div class="row g-0 min-height-full">
		<div class="col-md-6 pos-sticky-md align-self-start">
			<div class="min-height-full section-py d-flex align-items-center">
				<?php get_template_part('components/background-image', null, ['img_id' => get_post_thumbnail_id(), 'curtain' => true]) ?>
				<div class="container-sm text-center section-py" data-animate="">
					<div class="">
						<?php if ($post_type_post): ?>
							<a href="<?= esc_url(get_permalink(get_option('page_for_posts'))) ?>" class="hstack justify-content-center align-items-center gap-3"><?= get_core_icon('arrow', 'rotate-180 fs-lg') . 'Back to News & Media'; ?></a>
						<?php endif ?>

						<h1><?= get_the_title() ?></h1>

						<?php if ($post_type_post): ?>
							<p class="hstack justify-content-center align-items-center gap-2"><?= get_core_icon('calendar') . get_the_date(); ?></p>
						<?php endif ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 pos-rel section-py d-flex align-items-center">
			<div class="container-sm" data-animate="">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
<?php
endwhile;
get_template_part('content-blocks/posts', null, ['class' => 'section-py']);
get_footer();
