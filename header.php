<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<?php
$cta_link_shortcode = do_shortcode('[cta_link]');
$social_icons_shortcode = do_shortcode('[social_icons]');
$phone_shortcode = do_shortcode('[phone wrap="false"]');
$logo = get_custom_logo();

$main_menu_keys = array_keys(MAIN_MENU);
$main_menu_slug = $main_menu_keys[0];
$secondary_menu_slug = $main_menu_keys[1];
$tertiary_menu_slug = $main_menu_keys[2];
$has_main_menu = has_nav_menu($main_menu_slug);
$has_secondary_menu = has_nav_menu($secondary_menu_slug);
$has_tertiary_menu = has_nav_menu($tertiary_menu_slug);
$has_overlay_menu = $has_main_menu || $has_secondary_menu || $has_tertiary_menu;
?>

<body <?php body_class('has-sticky-footer preload'); ?>>
	<?php wp_body_open(); ?>
	<a class="skip-link" href="#main-content">Skip to main content</a>

	<header class="main-header underline-reverse">
		<?php get_template_part('components/announcement'); ?>

		<div class="container-fluid">
			<div class="row align-items-center gx-3 main-header-space">
				<?php if ($logo) : ?>
					<div class="col col-md-auto order-md-1 d-flex"><?= $logo; ?></div>
				<?php endif; ?>

				<?php if ($has_overlay_menu) : ?>
					<div class="col-auto col-md order-2 order-xl-0">
						<div class="overlay-menu" data-overlay-menu>
							<div class="overlay-menu__curtain" data-overlay-menu-toggler></div>
							<div class="overlay-menu__main">
								<div class="overlay-menu__container show-on-overlay-menu">
									<div class="row align-items-center">
										<div class="col">
											<?php if ($phone_shortcode) : ?>
												<?= $phone_shortcode; ?>
											<?php endif; ?>
										</div>
										<div class="col-auto">
											<button class="toggler-button" type="button" aria-label="Close Menu" data-overlay-menu-toggler>
												<span class="toggler-button__label d-none d-sm-block">Close</span>
												<?= get_core_icon('close', 'toggler-button__icon'); ?>
											</button>
										</div>
									</div>
								</div>
								<div class="overlay-menu__body" data-overlay-menu-body>
									<?php
									if ($has_main_menu) {
										wp_nav_menu(
											[
												'main_menu' => true, //Custom parameter for inc/main-menu.php
												'theme_location' => $main_menu_slug,
												'container' => false,
												'menu_class' => 'main-menu--detached',
											]
										);
									}
									?>
									<?php
									if ($has_secondary_menu) {
										wp_nav_menu(
											[
												'main_menu' => true, //Custom parameter for inc/main-menu.php
												'theme_location' => $secondary_menu_slug,
												'container' => false,
												'menu_class' => '',
											]
										);
									}
									?>
									<?php
									if ($has_tertiary_menu) {
										wp_nav_menu(
											[
												'main_menu' => true, //Custom parameter for inc/main-menu.php
												'theme_location' => $tertiary_menu_slug,
												'container' => false,
												'menu_class' => 'show-on-overlay-menu',
											]
										);
									}
									?>
									<div class="overlay-menu__container show-on-overlay-menu">
										<p><?= $cta_link_shortcode; ?></p>
										<?= $social_icons_shortcode; ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>


				<div class="col-auto col-lg order-3">
					<div class="row align-items-center justify-content-end gx-xl-6">
						<?php
						if ($has_tertiary_menu) {
							wp_nav_menu(
								[
									'main_menu' => true, //Custom parameter for inc/main-menu.php
									'theme_location' => $tertiary_menu_slug,
									'container' => false,
									'menu_class' => 'hide-on-overlay-menu col-auto',
								]
							);
						}
						?>
						<?php if ($cta_link_shortcode) : ?>
							<div class="col-auto main-header__cta-button">
								<?= $cta_link_shortcode; ?>
							</div>
						<?php endif; ?>
						<?php if ($has_overlay_menu) : ?>
							<div class="col-auto show-on-overlay-menu">
								<button type="button" class="toggler-button" aria-label="Show Menu" data-overlay-menu-toggler>
									<span class="toggler-button__label d-none d-sm-block">Menu</span>
									<?= get_core_icon('menu', 'toggler-button__icon'); ?>
								</button>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</header>
	<main id="main-content">
		<?php if (is_singular() && post_password_required()) : ?>
			<div class="container-md section-py" data-animate>
				<h1 class="h3"><?php the_title(); ?></h1>
				<?= get_the_password_form(); ?>
			</div>
			<?php
			get_footer();
			exit();
			?>
		<?php endif; ?>