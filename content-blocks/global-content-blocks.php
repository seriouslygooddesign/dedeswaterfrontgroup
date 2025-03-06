<?php
$args = wp_parse_args($args, [
    'global_content_blocks' => get_sub_field('global_content_blocks')
]);
$global_content_blocks = $args['global_content_blocks'];
if (!$global_content_blocks) return;

get_template_part('components/block', 'start');
foreach ($global_content_blocks as $object_id) {
    get_template_part('components/content-blocks', null, ['object_id' => $object_id, 'is_first_content_block_check' => false]);
}
get_template_part('components/block', 'end');
