<?php

register_activation_hook( __FILE__, function(){
  // Add 'Previewer' user role
  add_role( 'previewer', 'Previewer', array( 'read' => true ) );
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
        add_filter( 'admin_init' , array( $this , 'register_fields' ) );
    }
    function register_fields() {
        register_setting( 'general', 'DEVELOPMENT_MODE', 'esc_attr' );
        add_settings_field('DEVELOPMENT_MODE', '<label for="DEVELOPMENT_MODE">'.__('DEVELOPMENT MODE' , 'DEVELOPMENT_MODE' ).'</label>' , array(&$this, 'fields_html') , 'general' );
    }
    function fields_html() {
        echo '<input type="checkbox" id="DEVELOPMENT_MODE" name="DEVELOPMENT_MODE" value="1" ' . checked(1, get_option('DEVELOPMENT_MODE'), false) . '/>';
    }
}
