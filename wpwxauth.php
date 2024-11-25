<?php
/**
 * Plugin Name: WPWXAuth
 * Plugin URI: 
 * Description: A toolkit that helps you auth with wechat.
 * Version: 0.0.1
 * Author: 
 * Author URI: 
 * Text Domain: wpwxauth
 * Domain Path: 
 * Requires at least: 6.5
 * Requires PHP: 7.4
 *
 * @package AyonLiu
 */

// Function to register our new routes from the controller.
function wxauth_register_routes() {
  // $controller = new WXLogin();
  // $controller->register_routes();
  require_once plugin_dir_path(__FILE__) . '/WXLogin.php';
  require_once plugin_dir_path(__FILE__) . '/WXDecrypt.php';

  $controllers = array(
    'WXDecrypt',
    'WXLogin'
  );

  foreach ( $controllers as $controller ) {
    ( new $controller() )->register_routes();
  }
}

add_action( 'rest_api_init', 'wxauth_register_routes' );