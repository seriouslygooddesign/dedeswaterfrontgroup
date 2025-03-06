</main>
<footer class="main-footer section-py bg-primary">
	<div class="container underline-reverse">
		<div class="row">
			<?php
			$footer_widget_counter = 1;
			while ($footer_widget_counter <= FOOTER_SIDEBAR_QUANTITY) {
				$sidebar_name = "footer-sidebar-$footer_widget_counter";
				if (is_active_sidebar($sidebar_name)) {
					dynamic_sidebar($sidebar_name);
				}
				$footer_widget_counter++;
			}
			?>
		</div>
		<div class="section-pt">
			<h2 class="text-center" data-animate>Discover Dedes Venues</h2>
			<br>
			<?php get_template_part('components/sites'); ?>
		</div>
		<div class="row section-pt">
			<div class="col">&copy;<?php bloginfo('name'); ?> <?= esc_html(date('Y')); ?></div>
			<div class="col-auto">Website by <a href="https://sgd.com.au/" target="_blank">SGD</a></div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>

</body>

</html>