<?php
$id = get_the_author_meta('ID');
$id_with_prefix = "user_" . $id;

$photo_id = get_field('user_photo', $id_with_prefix);
$name = esc_html(get_the_author_meta('display_name', $id));
$link = esc_url(get_author_posts_url($id));
$is_author_page = is_author();
$description = get_the_author_meta('description', $id);
$social_icons = get_field('social_icons', $id_with_prefix);
$subtitle = "Author";
?>
<div class="bg-surface">
    <div class="container section-py">
        <div class="row gy-3 gx-sm-4 gy-sm-0">
            <?php if ($photo_id) : ?>
                <div class="col-sm-2" data-animate>
                    <?php
                    if (!$is_author_page) echo "<a href='$link' aria-label='View all posts by $name'>";
                    echo get_core_image($photo_id, IMG_SIZE_XS, null, false, $is_author_page ? false : true);
                    if (!$is_author_page) echo "</a>";
                    ?>
                </div>
            <?php endif; ?>
            <div class="col col-lg-8" data-animate>
                <?php if ($is_author_page) : ?>
                    <p class="fs-sm m-0 fw-bold"><?= $subtitle; ?></p>
                    <h1 class="mt-0"><?= $name; ?></h1>
                <?php else : ?>
                    <h2 class="fs-sm m-0"><?= $subtitle; ?></h2>
                    <h3 class="mt-0 h4"><a href="<?= $link; ?>"><?= $name; ?></a></h3>
                <?php endif; ?>
                <?php
                if ($description) echo "<p>$description</p>";
                if ($social_icons) get_template_part('components/social-icons', null, ['social_icons' => $social_icons]);
                ?>
            </div>
        </div>
    </div>
</div>