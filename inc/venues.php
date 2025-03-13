<?php
//Create ACF checkboxes to select where "what's on" should be displayed 
add_action('acf/init', 'custom_acf_fields');
function custom_acf_fields()
{

    $sites = get_sites();
    if (!$sites && count($sites) >= 1) {
        return;
    }

    //create field choices
    $choices = [0 => 'Not Specified'];
    foreach ($sites as $site) {
        $id = $site->blog_id;

        //skip main site
        if ($id === '1') {
            continue;
        }

        $title = get_blog_details($id)->blogname;
        $choices[$id] = $title;
    }

    //create field
    acf_add_local_field(array(
        'parent' => 'group_67a343daa5b8f', //group key, where it should be added
        'name' => 'related_site_id',
        'label' => 'Related Sites',
        'type' => 'button_group',
        'choices' => $choices,
        'return_format' => 'value',
    ));
}
