<?php
$args = wp_parse_args($args, [
	'field_name' => 'content_blocks',
	'object_id' => get_the_ID(),
	'is_first_content_block_check' => true,
]);
extract($args);

global $is_first_content_block;
global $content_block_name;

if (have_rows($field_name, $object_id)) {
	while (have_rows($field_name, $object_id)) {
		the_row();
		if (get_core_hide_block()) {
			$is_first_content_block = $is_first_content_block_check && get_row_index() === 1 ? true : false;
			$content_block_name = get_row_layout();
			get_template_part("content-blocks/$content_block_name", null, ['object' => $object_id]);
		}
	}
}
