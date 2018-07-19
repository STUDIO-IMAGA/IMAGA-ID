<?php

/**
 * Add a widget to the dashboard.
 *
 * This function is hooked into the 'wp_dashboard_setup' action below.
 * https://codex.wordpress.org/Dashboard_Widgets_API
 */
function example_add_dashboard_widgets() {

  $status = ( get_option('DEVELOPMENT_MODE') == TRUE) ? 'DEVELOPMENT MODE' : 'LIVE' ;
	wp_add_dashboard_widget(
                 'site_status_dashboard_widget',         // Widget slug.
                 'Current Site Status: ' . $status ,         // Title.
                 'site_status_dashboard_widget_function' // Display function.
        );
}
add_action( 'wp_dashboard_setup', 'example_add_dashboard_widgets' );

/**
 * Create the function to output the contents of our Dashboard Widget.
 */
function site_status_dashboard_widget_function() {

  require_once( dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'dashboard_widget.php' );

}
