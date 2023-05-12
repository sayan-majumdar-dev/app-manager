<?php
?>
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

    table {
        max-width: 100%;
    }

    caption {
        font-size: 1.6em;
        font-weight: 400;
        padding: 10px 0;
    }

    thead th {
        font-weight: 400;
        background: #8a97a0;
        color: #fff;
    }

    tr {
        background: #f4f7f8;
        border-bottom: 1px solid #fff;
        margin-bottom: 5px;
    }

    tr:nth-child(even) {
        background: #e8eeef;
    }

    th, td {
        text-align: left;
        padding: 20px;
        font-weight: 300;
    }

    tfoot tr {
        background: none;
    }

    tfoot td {
        padding: 10px 2px;
        font-size: 0.8em;
        font-style: italic;
        color: #8a97a0;
    }

</style>
<table>
    <h1>App Notification Table View</h1>
    <thead>
    <tr>
        <th>ID</th>
        <th>TITLE</th>
        <th>MESSAGE</th>
        <th>IMAGE</th>
        <th>URL</th>
        <th>DATE & TIME</th>
        <th>ACTION</th>
    </tr>
    </thead>
    <tbody>
	<?php
    //Current filename
	$current_filename = $_SERVER['PHP_SELF'];
	// WP Globals
	global $table_prefix, $wpdb;
    // Db table name
	$notificationTable = $table_prefix . 'appnotification';
	// Get all the notification data
	$entriesList = $wpdb->get_results( "SELECT * FROM " . $notificationTable . " order by id asc" );
    // Counter variable
	$count = 1;
	if ( count( $entriesList ) > 0 ) {
		// Loop through all the entries
		foreach ( $entriesList as $entry ) {
			echo "<tr>";
			echo "<th>$count</th>";
			echo "<th>$entry->title</th>";
			echo "<th>$entry->message</th>";
			echo "<th>$entry->image</th>";
			echo "<th>$entry->url</th>";
			$datetime= new DateTime("$entry->dtime");
			$formatted_date = $datetime->format('n.j.Y');
			$formatted_time = date('h:i A', strtotime($datetime->format('H:i')));
			echo "<th>" . $formatted_date  ."  ".'-'."  ". $formatted_time . "</th>";
			echo "<th><a href='$current_filename?page=app-image-uploader-notification-view&id=$entry->id'>Delete</a></th>";
			echo "</tr>";
			$count ++;
		}
	}
	// Delete the specific row by using id
	if ( isset( $_GET["id"] ) ) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "delete from " . $notificationTable . " where id=%s", urldecode( $_GET["id"] ) ) );
		header("Refresh:0; url=$current_filename?page=app-image-uploader-notification-view");
	}
	?>
    </tbody>
</table>
