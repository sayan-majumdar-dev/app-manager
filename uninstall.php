<?php
/**
 * Trigger this file on plugin uninstall
 */
?>
<?php
if (!defined('WP_UNINSTALL_PLUGIN')) exit;
// Delete multiple options
$options = array(
    'app-image-uploader-settings_checkbox',

);
foreach ($options as $option) {
    if (get_option($option)) delete_option($option);
}
?>

