<?php

// Everything related to the admin bar and admin interface.

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
