<?php

class IMAGA_Identity_login {

  function __construct(){

    $this->add_filters();

    wp_register_style('imaga/login', plugins_url("login.css", __FILE__ ));
    wp_enqueue_style( 'imaga/login');

  }

  private function add_filters(){
    add_filter( 'login_headertitle', array( $this, 'login_header_title' ) );
    add_filter( 'login_headerurl', array( $this, 'login_header_url' ) );
    add_filter( 'login_message', array( $this, 'login_message' ) );
    add_filter( 'login_errors', array( $this, 'login_errors' ) );
  }

  public function login_header_title(){
    return 'IMAGA ~ ken Uw Klant';
  }

  public function login_header_url(){
    return home_url();
  }

  public function login_message(){
    if( get_option('DEVELOPMENT_MODE') ):
      if ( empty($message) ){
        return '<div class="text-center mb-2">Restricted to Authorized Personel only</div>';
      } else {
        return $message;
      }
    else:
      if ( empty($message) ){
        return '<div class="text-center mb-2">Please log in to continue</div>';
      } else {
        return $message;
      }
    endif;
  }

  public function login_errors($error_message){
    global $errors;
    $error_codes = $errors->get_error_codes();

    // Empty username field
    if ( in_array( 'empty_username', $error_codes ) ):
      $error_message = __('Hey, we need a username or email to log you in.', 'imaga');

      if( get_option( 'users_can_register' ) ):
        $error_message .= '<br>'.__('We can help you <a href="'.wp_registration_url().'">create an account</a>.');
      endif;
    endif;

    // Empty password field
    if ( in_array( 'empty_password', $error_codes ) ):
      $error_message = __('A username alone isn\'t enough to login.', 'imaga');
    endif;


    // Invalid username.
    // Default: '<strong>ERROR</strong>: Invalid username. <a href="%s">Lost your password</a>?'
    if ( in_array( 'invalid_username', $error_codes ) ):
      $error_message = __('We didn\'t recognize this username. It could be a typo.');
    endif;

    // Incorrect password.
    // Default: '<strong>ERROR</strong>: The password you entered for the username <strong>%1$s</strong> is incorrect. <a href="%2$s">Lost your password</a>?'
    if ( in_array( 'incorrect_password', $error_codes ) ):
      $error_message = __('Sorry, this password isn\'t right. We can help you <a href="'.wp_lostpassword_url().'">recover your password</a>');
    endif;
    if ( in_array( 'invalid_email', $error_codes ) ):
      $error_message = __('We didn\'t recognize this emailaddress. It could be a typo.');
    endif;

    if ( in_array( 'invalidcombo', $error_codes ) ):
      $error_message = __('Oof, We don\'t recognize this combination.', 'imaga');
    endif;


    return $error_message;

  }

}
