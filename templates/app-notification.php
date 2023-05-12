<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    *, *:before, *:after {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    body {
        font-family: 'Nunito', sans-serif;
        color: #384047;
    }

    form {
        max-width: 300px;
        padding: 10px 20px;
        background: #f4f7f8;
        border-radius: 8px;
    }

    h1 {
        margin: 15px 0 30px 0;
        text-align: left;
    }

    input[type="text"],
    input[type="password"],
    input[type="date"],
    input[type="datetime"],
    input[type="email"],
    input[type="number"],
    input[type="search"],
    input[type="tel"],
    input[type="time"],
    input[type="url"],
    textarea,
    select {
        background: rgba(255, 255, 255, 0.1);
        border: none;
        font-size: 16px;
        height: auto;
        margin: 0;
        outline: 0;
        padding: 15px;
        width: 100%;
        background-color: #e8eeef;
        color: #8a97a0;
        box-shadow: 0 1px 0 rgba(0, 0, 0, 0.03) inset;
    }

    input[type="radio"],
    input[type="checkbox"] {
        margin: 0 4px 8px 0;
    }

    select {
        padding: 6px;
        height: 32px;
        border-radius: 2px;
    }

    button {
        padding: 19px 39px 18px 39px;
        color: #FFF;
        background-color: #4bc970;
        font-size: 18px;
        text-align: center;
        font-style: normal;
        border-radius: 5px;
        width: 100%;
        border: 1px solid #3ac162;
        border-width: 1px 1px 3px;
        box-shadow: 0 -1px 0 rgba(255, 255, 255, 0.1) inset;
        margin-bottom: 10px;
    }


    legend {
        font-size: 1.4em;
        margin-bottom: 10px;
    }

    label {
        display: block;
        margin-bottom: 8px;
    }

    label.light {
        font-weight: 300;
        display: inline;
    }


    .error {
        width: 100%;
        margin-top: 0.25rem;
        font-size: 80%;
        color: red;
        padding: 2px !important;
        display: inline-block !important;
    }

    .success-msg {
        margin: 10px 0;
        padding: 10px;
        border-radius: 3px 3px 3px 3px;
        color: #270;
        background-color: #DFF2BF;
    }

    @media screen and (min-width: 480px) {

        form {
            max-width: 480px;
        }

    }

</style>
<h1>App Notification</h1>
<?php
$is_valid = 1; // Set flag
$titleErr = $messageErr = $imageErr = $urlErr = $success = '';
if ( isset( $_POST['submit'] ) && ! empty( $_POST['submit'] ) ) {
	// Get the submitted form data and sanitize
	$title   = sanitize_text_field( $_POST['title'] );
	$message = sanitize_text_field( $_POST['message'] );
	$url     = sanitize_text_field( $_POST['url'] );
	$dtime   = $_POST['dtime'];

	// Validate input data
	if ( empty( $title ) ) {
		$titleErr = 'Please enter a title<br/>';
		$is_valid = false;
	}
	if ( empty( $message ) ) {
		$messageErr = 'Please enter a message<br/>';
		$is_valid   = false;
	}
	if ( isset( $_FILES['img'] ) ) {
		$image = $_FILES['img']['tmp_name'];
		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );
		$uploadedfile     = $_FILES['img'];
		$upload_overrides = array( 'test_form' => false );
		$movefile         = wp_handle_upload( $uploadedfile, $upload_overrides );
		$imageurl         = "";
		if ( $movefile && ! isset( $movefile['error'] ) ) {
			$imageurl = $movefile['url'];
		}
	} else {
		$imageErr = 'Please include an image. <br/>';
		$is_valid = false;
	}
	if ( empty( $url ) ) {
		$urlErr   = 'Please enter an url<br/>';
		$is_valid = false;
	}
	if ( $is_valid ) {
		// WP Globals
		global $wpdb;
        // Insert into DB
		$insert_notification = $wpdb->insert( "wp_appnotification", array(
			"title"   => $title,
			"message" => $message,
			"image"   => $imageurl,
			"url"     => $url,
			"dtime"   => $dtime,
		) );
        // If success
		if ( $insert_notification ) {
			echo "";
            // Display success message
			$success = "Notification has been added";
		}

	}
}
?>
<form method="post" action="" enctype="multipart/form-data">
    <label for="fname">Title:</label>
    <input type="text" id="title" name="title"><br>
    <span class="<?php if ( $titleErr == "" ) {
		echo "no-error";
	} else {
		echo "error";
	} ?>"><?php echo $titleErr; ?></span>
    <label for="message">Message:</label>
    <textarea name="message"><?php echo ! empty( $postData['message'] ) ? $postData['message'] : ''; ?></textarea>
    <span class="<?php if ( $messageErr == "" ) {
		echo "no-error";
	} else {
		echo "error";
	} ?>"><?php echo $messageErr; ?></span>
    <label>Image (upload)</label>
    <input type="file" name="img" accept="image/png, image/jpeg , image/jpg" class="form-control">
    <span class="<?php if ( $imageErr == "" ) {
		echo "no-error";
		echo "error";
	} else {
	} ?>"><?php echo $imageErr; ?></span>
    <label for="url">URL:</label>
    <input type="url" name="url" id="url"
           pattern="https://.*" size="30">
    <span class="<?php if ( $urlErr == "" ) {
		echo "no-error";
	} else {
		echo "error";
	} ?>"><?php echo $urlErr; ?></span>
    <label for="datetime">(date and time):</label>
    <input type="datetime-local" id="dtime" name="dtime">
    <input type="submit" name="submit" value="Submit">
    <script>
        jQuery(document).ready(function ($) {
            $('#successMessage').delay(2000).slideUp(300);
        });
    </script>
    <div class="<?php if ( $success == "" ) {
		echo "no-error";
	} else {
		echo "success-msg";
	} ?>" id="successMessage">
		<?php echo $success; ?>
    </div>
</form>
</html>
