<?php
get_header();
if (is_author()) {
	get_template_part('components/author-details');
} else {
	$page_for_posts = get_option('page_for_posts');
	$page_header_args = [
		'title' => 'Stay in the Know with Dedes Group',
		'label' => is_home() ? get_the_title($page_for_posts) : get_the_archive_title(),
		'img_id' => is_home() || is_category() || is_tax() ? get_post_thumbnail_id($page_for_posts) : false,
	];
	get_template_part('components/page-header', null, $page_header_args);
}
?>
<div class="container section-py">
	<?php if (have_posts()) : ?>
		<div class="layout-stairs">
			<?php while (have_posts()) : the_post();
				$link = [
					'title' => get_the_title(),
					'url' => get_permalink(),
					'target' => '_blank',
				];
				$card_args = [
					'content' => false,
					'footer_content' => "<p class='hstack gap-2 align-items-center'>" . get_core_icon('calendar') . get_the_date() . "</p>",
				]
			?>
				<div class="layout-stairs__item" data-animate>
					<?php get_template_part('components/card', null, $card_args); ?>
				</div>
			<?php endwhile; ?>
		</div>
		<?php get_template_part('components/pagination'); ?>
	<?php else : ?>
		<h2>Nothing Found</h2>
	<?php endif; ?>
</div>
<?php
get_footer();
