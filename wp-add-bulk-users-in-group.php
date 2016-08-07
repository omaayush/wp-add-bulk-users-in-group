<?php
/**
 * Plugin Name: wp_users_add_in_group
 * Plugin URI: https://github.com/rajuknit/wp-add-bulk-users-in-group
 * Description: It helps to add bulk users in a group.
 * Version: 1.0.0
 * Author: Raju Varshney
 * Author URI: facebook.com/rajuknit
 * License: GPL2
 */
class WP_Users_Add_In_Group {
// Constructor
    function __construct() {
        add_action( 'admin_menu', array( $this, 'wpa_add_menu' ));
    }

    /*
      * Actions perform at loading of admin menu
      */
    function wpa_add_menu() {

        add_menu_page( 'User Importer', 'User Importer', 'manage_options', 'importer-dashboard', array(
                          __CLASS__,
                         'wpa_page_file_path'
                        ), plugins_url('images/user.ico', __FILE__),'2.2.9');

        add_submenu_page( 'importer-dashboard', 'User Importer' . ' Dashboard', ' Dashboard', 'manage_options', 'importer-dashboard', array(
                              __CLASS__,
                             'wpa_page_file_path'
                            ));

    }

    /*
     * Actions perform on loading of menu pages
     */
    function wpa_page_file_path() {
    	 $screen = get_current_screen();
    	 
        if ( strpos( $screen->base, 'importer-settings' ) !== false ) {
            include( dirname(__FILE__) . '/includes/importer-settings.php' );
        } 
        else {
            include( dirname(__FILE__) . '/includes/importer-dashboard.php' );
        }

    }

}

new WP_Users_Add_In_Group();

?>
