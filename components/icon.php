<?php
$args = wp_parse_args($args, [
    'icon' => '',
    'class' => null,
    'holder' => false,
]);

extract($args);

if (!$icon) return;

$icon_class = 'icon';
$icon_holder_class = "$icon_class-holder";

if ($class) {
    $icon_class .= " $class";
}
if ($holder) echo "<span class='$icon_holder_class'>";
?>
<svg class="<?= $icon_class ?>" aria-hidden="true">
    <use href="#<?= $icon ?>-icon"></use>
</svg>
<?php if ($holder) echo "</span>";
