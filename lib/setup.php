<?php

//TODO: Make this prettier

namespace IMAGA\ID\Setup;

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
