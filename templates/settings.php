<?php /** * @package App Image Uploader * Settings Page Template */ ?>
<?php function checkbox_callback_page()
{ ?><input type="hidden" id="app-image-uploader-settings" name="app-image-uploader-settings" value="{enabled=false}">
    <input type="checkbox" id="app-image-uploader-settings_checkbox" name="app-image-uploader-settings_checkbox"
           value="1" <?php echo get_option('app-image-uploader-settings_checkbox') ? 'checked' : '' ?> /><?php } ?>
<?php
//Callback function for app version control for android
function app_version_android_input_field_callback() {
	$app_version_android_input_field = get_option('app_version_control_android');

	?>
    <input type="number" style="width: 12%;" name="app_version_control_android" class="regular-text" value="<?php echo isset($app_version_android_input_field) ? esc_attr( $app_version_android_input_field ) : ''; ?>" />
	<?php
}
?>
<?php
//Callback function for app version control for android
function app_version_ios_input_field_callback() {
	$app_version_ios_input_field = get_option('app_version_control_ios');

	?>
    <input type="number" style="width: 12%;" name="app_version_control_ios" class="regular-text" value="<?php echo isset($app_version_ios_input_field) ? esc_attr( $app_version_ios_input_field ) : ''; ?>" />
	<?php
}
?>
<?php function settings_callback()
{ ?>
    <div class="wrap">
    <?php settings_errors(); ?>
    <form action="options.php"
          method="post">
        <?php
        // security field
        settings_fields('app-image-uploader-settings');
        ?>
        <?php
        // output settings section here
        do_settings_sections('app-image-uploader-settings');
        ?>
        <?php
        // save settings button
        submit_button('Save Settings');
        ?>
    </form>
    </div>
<?php } ?>