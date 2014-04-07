<?php
/*
Plugin Name: Donde Page Template - Store Locator
Plugin URI: http://www.donde.io
Author: donde.io
Version: 1.0.2
Description: Allows Donde users to easily integrate a store locator page into their Wordpress site
License: GPLv2
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} // end if

require_once( plugin_dir_path( __FILE__ ) . 'class-page-template.php' );
add_action( 'plugins_loaded', array( 'Donde_Page_Template_Plugin', 'get_instance' ) );

add_action('admin_menu', 'donde_add_menu');

function donde_add_menu() {
    add_menu_page(__('Donde','donde'), __('Donde','donde-settings'), 'manage_options', 'donde-settings', 'donde_settings_page' );
}

function donde_settings_page() {

//must check that the user has the required capability 
    if (!current_user_can('manage_options'))
    {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

    // variables for the field and option names 
    $hidden_field_name = 'br_submit_hidden';
	
    $opt_name_dondeid = 'dondeid';
	$opt_name_pageurl = 'pageurl';
	$opt_name_donde_navmenu = 'donde_navmenu';
	
    // Read in existing option value from database
    $opt_val_dondeid = get_option( $opt_name_dondeid );
    $opt_val_pageurl = get_option( $opt_name_pageurl );
    $opt_val_donde_navmenu = get_option( $opt_name_donde_navmenu );
		
	if (empty($opt_val_pageurl)) {
		$opt_val_pageurl = 'store-locator';
        update_option( $opt_name_pageurl, $opt_val_pageurl );
	}

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
	
        // Read their posted value
        $opt_val_dondeid = $_POST[ $opt_name_dondeid ];
        $opt_val_pageurl = $_POST[ $opt_name_pageurl ];
        $opt_val_donde_navmenu = $_POST[ $opt_name_donde_navmenu ];
        
        // Strip any slashes on pageurl slug
        $opt_val_pageurl = str_replace('/', '', $opt_val_pageurl);
		
        // Save the posted value in the database
        update_option( $opt_name_dondeid, $opt_val_dondeid );
        update_option( $opt_name_pageurl, $opt_val_pageurl );
        update_option( $opt_name_donde_navmenu, $opt_val_donde_navmenu );
		
        // Put an settings updated message on the screen
?>

		<div class="updated"><p><strong><?php _e('settings saved.', 'menu-test' ); ?></strong></p></div>
<?php

    }
			
	$baseurl = 'http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']);
	$baseurl = str_replace("wp-admin","",$baseurl);

	$permalink_structure = get_option('permalink_structure');
		
	echo '<div class="wrap">';
    echo "<h2>" . __( 'Donde Settings', 'menu-test' ) . "</h2><br />";
	echo 'Enter your Dónde account details below and then create a new Page for your Store Locator. You don\'t have to enter any content just select the \'Donde Store Locator\' page template and click \'Update\'.<br /><br />';
	echo "* If you don't have a Dónde account please visit <a href=\"http://donde.io/signup/?utm_source=WP&utm_medium=settings&utm_campaign=WP-S\" target='_blank' alt=\"Sign Up for Dónde\">donde.io/signup</a> to create an account and add your locations.";
	echo "<br><br><hr>";
	echo '<div style="width:500px;height:1px;" /></div><br />';
	echo '<form name="form1" method="post" action="">';
	echo '<input type="hidden" name="'. $hidden_field_name .'" value="Y">';
	echo '<div style="width:160px;">Your Donde ID:</div><input type=text name=dondeid value="'. $opt_val_dondeid .'" /> <font color="#afafaf"></font><br /><br /><br />';
	echo '<div style="width:160px;">Navigation Menu:</div>';
	$custom_menus = wp_get_nav_menus();
	foreach ( $custom_menus as $menu ){
		$menus[$menu->slug] = $menu->name;
	}
	if(!empty($menus)){
		echo '<br><select name=donde_navmenu style="width:200px;">';
		foreach ( $menus as $key => $menu_item ) {
			echo '<option value="'. $key .'"';
			if ($key == $opt_val_donde_navmenu) { echo ' selected'; }
			echo '>'. $menu_item .'</option>';
		}
		echo '</select><br /><br /><br />';	
	}else{
		echo "<br>* No menu found. Please create new menus from Appearance -> Menus and then try again.<br /><br /><br />";
	}
			
	echo '<input type=submit name=SUB value="Update" /><br /><br /><br />';
	echo '</form>';
	echo '</div>';
	
	echo '<br /><br /><br /><br /><br />';

}
