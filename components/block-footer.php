<?php
$args = wp_parse_args(
	$args,
	array(
		'show' => get_sub_field('block_footer_show'),
		'content' => get_sub_field('block_footer'),
		'class' => false,
	)
);
extract($args);
if (!$show) return;

$class_result = $class ? "class='$class'" : '';
echo "<div $class_result data-animate>" . $content . "</div>";
