<?php

/*
Plugin Name: IMAGA Identity
Description: IMAGA Site Identity
Version: 2.0.0
Author: IMAGA
Author URI: http://imaga.nl/
Text Domain: imaga-identity

Blue:         #5980EC
Blue Darker:  #2F3D86
Red:          #C74337
Yellow:       #E8B92B
Green:        #66A459

TODO: Make this mess readable

*/

add_action( 'template_redirect', function( $template ) {

  if( !is_user_logged_in() && !is_page() && get_option( "DEVELOPMENT_MODE" )  ):

    $file_name = 'redirect.php';

    if ( locate_template( $file_name ) ):

      $template = locate_template( $file_name );

    else:

      $template = dirname( __FILE__ ) . '/templates/' . $file_name;

    endif;

    include($template);
    die;

  endif;


}, 99 );

add_action( 'admin_init', function(){

  wp_admin_css_color(
    'imaga',
    __('IMAGA'),
    plugins_url("scheme.css", __FILE__ ),
    array('#5980EC', '#C74337', '#E8B92B', '#66A459'),
    array( 'base' => '#000000', 'focus' => '#fff', 'current' => '#fff' )
  );
});

add_action( 'admin_bar_menu', function( $wp_admin_bar ){
    $wp_admin_bar->remove_node( 'wp-logo' );
}, 100 );


add_action( 'admin_bar_menu', function( $wp_admin_bar ) {
    $args = array(
        'id'    => 'imaga-brand',
        'meta'  => array( 'class' => 'imaga-brand', 'title' => 'IMAGA' )
    );
    $wp_admin_bar->add_node( $args );
}, 1 );

add_action( 'login_enqueue_scripts', function(){

  wp_register_style('imaga/login', plugins_url("login.css", __FILE__ ));
  wp_enqueue_style( 'imaga/login');

} );

register_activation_hook( __FILE__, function(){

  // Add 'Previewer' user role
  add_role( 'previewer', 'Previewer', array( 'read' => true ) );

});
add_filter( 'login_headerurl', function ($url) {
    return home_url();
});

add_filter( 'login_headertitle', function() {
    return 'IMAGA ~ ken Uw Klant';
});


add_action( 'admin_init', function(){

  global $current_user;

  $user_roles = $current_user->roles;

  $user_role = array_shift( $user_roles );

  if($user_role === 'previewer'){

      exit( wp_redirect( home_url( '/' ) ) );

  }

}, 100 );

add_action( 'admin_bar_menu', function( $wp_admin_bar ){

  global $current_user;

  $user_roles = $current_user->roles;

  $user_role = array_shift( $user_roles );

  if($user_role === 'previewer'){

    $nodes = $wp_admin_bar->get_nodes();

    // Remove all nodes
    foreach( $nodes as $node ) {
      $wp_admin_bar->remove_node( $node->id );
    }

    $args = array(
  		'id'    => 'preview-title',
  		'title' => 'PREVIEW',
      'href' => wp_logout_url( home_url() ),
  		'meta'  => array( 'class' => 'preview-title' )
  	);
  	$wp_admin_bar->add_node( $args );

  }

}, 100);

add_action( 'wp_enqueue_scripts', function(){
  global $current_user;

  $user_roles = $current_user->roles;

  $user_role = array_shift( $user_roles );

  if( $user_role === 'previewer' ){

    wp_register_style('imaga/wpadminbar', plugins_url("wpadminbar.css", __FILE__ ));
    wp_enqueue_style( 'imaga/wpadminbar');

  }

});


$new_general_setting = new new_general_setting();

class new_general_setting {
    function new_general_setting( ) {
        add_filter( 'admin_init' , array( &$this , 'register_fields' ) );
    }
    function register_fields() {
        register_setting( 'general', 'DEVELOPMENT_MODE', 'esc_attr' );
        add_settings_field('DEVELOPMENT_MODE', '<label for="DEVELOPMENT_MODE">'.__('DEVELOPMENT MODE' , 'DEVELOPMENT_MODE' ).'</label>' , array(&$this, 'fields_html') , 'general' );
    }
    function fields_html() {
        echo '<input type="checkbox" id="DEVELOPMENT_MODE" name="DEVELOPMENT_MODE" value="1" ' . checked(1, get_option('DEVELOPMENT_MODE'), false) . '/>';
    }
}


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

  require_once( dirname( __FILE__ ) . '/templates/dashboard_widget.php' );

}
