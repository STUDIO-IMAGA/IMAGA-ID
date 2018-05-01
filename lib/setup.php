<?php

//TODO: Make this prettier

namespace IMAGA\ID\Setup;


require 'login.php';

new IMAGA_Identity_login();

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
