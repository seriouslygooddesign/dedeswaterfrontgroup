<?php get_template_part('components/block', 'start'); ?>
<div class="container">
    <?php get_template_part('components/block', 'header'); ?>
    <?php if (have_rows('tabs')) : ?>
        <?php
        $tabs = null;
        $tab_panels = null;
        $i = 1;
        while (have_rows('tabs')) : the_row(); ?>
            <?php
            $unique_id = wp_unique_id();

            ob_start();
            get_template_part('components/tab', null, ['unique_id' => $unique_id, 'i' => $i]);
            $tabs .= ob_get_clean();

            ob_start();
            get_template_part('components/tab-panel', null, ['unique_id' => $unique_id, 'i' => $i]);
            $tab_panels .= ob_get_clean();
            ?>
        <?php
            $i++;
        endwhile;
        ?>

        <div class="tabs row gx-md-4 gx-xl-6" data-tabs>
            <div class="col-md-4" data-animate>
                <div class="tabs__tablist" role="tablist" data-tablist>
                    <?= $tabs; ?>
                </div>
            </div>
            <div class="col-md" data-animate>
                <?= $tab_panels; ?>
            </div>
        </div>
    <?php endif; ?>
    <?php get_template_part('components/block', 'footer'); ?>
</div>
<?php get_template_part('components/block', 'end');
