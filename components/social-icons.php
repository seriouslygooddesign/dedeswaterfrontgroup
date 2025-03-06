<?php
$args = wp_parse_args($args, [
    'social_icons' => get_field('social_icons', 'option') ?? []
]);
$social_icons = array_filter($args['social_icons']);
if (!$social_icons) return;
?>
<ul class="social-icons">
    <?php foreach ($social_icons as $icon => $url) : ?>
        <?php if (!$url) continue; ?>
        <li class="social-icons__item">
            <?php
            $icon_label_args = [
                'icon' => $icon,
                'url' => $url,
                'target_blank' => true,
                'aria_label' => ucfirst($icon),
                'noopener_noreferrer' => true
            ];
            get_template_part('components/icon-label', null, $icon_label_args); ?>
        </li>
    <?php endforeach; ?>
</ul>