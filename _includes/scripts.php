<?php
/***********************************************************
** THEME SCRIPTS
** Add js to admin screen
************************************************************/
// Add scripts to wp-admin
add_action('admin_enqueue_scripts', 'sabre_load_admin_scripts');
function sabre_load_admin_scripts($hook) {
    // Only add to the edit.php admin page.
    // See WP docs.
    if ('edit.php' === $hook) {
        return;
    }
    wp_enqueue_script('admin-functions', get_template_directory_uri() . '/_assets/js/admin.js', '', '', true);
}
