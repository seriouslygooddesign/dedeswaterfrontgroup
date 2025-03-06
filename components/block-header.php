<?php
$args = wp_parse_args(
	$args,
	[
		'show' => get_sub_field('block_header_show'),
		'content' => get_sub_field('block_header'),
		'class' => false,
	]
);
extract($args);
if (!$show) return;
$class_result = $class ? " class='$class'" : '';
echo "<div$class_result data-animate>" . $content . "</div>";
