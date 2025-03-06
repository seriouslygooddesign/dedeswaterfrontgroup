<?php

/**
 * Template name: Default Template
 */
get_header(); ?>
<div class="container-md section-py" data-animate>
    <?php
    the_title('<h1>', '</h1>');
    the_post_thumbnail(IMG_SIZE_XL);
    the_content();
    ?>
</div>
<?php
get_footer();
