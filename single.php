<?php
get_header();
while (have_posts()) :
	the_post();
?>
	<div class="row g-0 min-height-full">
		<div class="col-md-6 pos-rel section-py d-flex has-bg align-items-center">
			<?php get_template_part('components/background-image', null, ['img_id' => get_post_thumbnail_id(), 'curtain' => true]) ?>
			<div class="container-sm text-center" data-animate="">
				<h1><?= get_the_title() ?></h1>
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
