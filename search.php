<?php
global $wp_query;
$title = 'Search';
$search_query = get_search_query();
if ($search_query) {
	$title = 'Search results for “' . $search_query . '”';
}
get_header();
?>
<div class="bg-surface section-py">
	<div class="container-md">
		<h1 class="h6"><?= esc_html($title); ?></h1>
		<?php get_search_form(); ?>
	</div>
</div>

<div class="container-md section-py">
	<?php if (have_posts()) : ?>
		<?php while (have_posts()) : the_post(); ?>
			<article class="row align-items-center">
				<div class="col-md">
					<h2 class="h4">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h2>
					<?php the_excerpt(); ?>
				</div>
				<?php if (has_post_thumbnail()) : ?>
					<div class="col-md-auto">
						<a href="<?php the_permalink(); ?>" tabindex="-1">
							<?php the_post_thumbnail(IMG_SIZE_XS); ?>
						</a>
					</div>
				<?php endif; ?>
			</article>
			<hr>
		<?php
		endwhile;
		get_template_part('components/pagination');
		?>
	<?php else : ?>
		<h2 class="h4">Nothing Found</h2>
		<p>Please try again with some different keywords</p>
	<?php endif; ?>
</div>
<?php
get_footer();
