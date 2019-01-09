<?php
/***********************************************************
** THEME SCRIPTS
** Add js to admin screen
************************************************************/
// Add scripts to wp-admin
add_action('admin_enqueue_scripts', 'substrate_load_admin_scripts');
function substrate_load_admin_scripts($hook) {
    // Only add to the edit.php admin page.
    if ('edit.php' === $hook) {
        return;
    }

    // Add script to Dom
    wp_enqueue_script('admin-functions', get_template_directory_uri() . '/_assets/js/admin.js', '', '', true);
}
