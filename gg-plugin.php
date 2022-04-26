<?php
/*
 * Plugin Name: Mike Dion GG Code Challenge
 * Plugin URI: https://becomeindelible.com
 * Description: Code Challenge for Generation Genius
 * Author: Mike Dion
 * Version: 1.0.0
 * Author URI: https://becomeindelible.com
 * License: GPL2+
 */

defined( 'ABSPATH' ) or die( 'Sectumsempra!' );//For enemies

define( 'MDGG_ROOT_PATH', plugin_dir_path(__FILE__) );
define( 'MDGG_ROOT_URL', plugin_dir_url(__FILE__) );
define( 'MDGG_VERSION', "1.0.6" );

require_once( MDGG_ROOT_PATH . "shortcodes.php" );
require_once( MDGG_ROOT_PATH . "ajax-functions.php" );

function mdgg_enqueue(){
    wp_enqueue_style( 'mdgg-style', MDGG_ROOT_URL . 'css/style.min.css', MDGG_VERSION );
    wp_register_script( 'mdgg-js', MDGG_ROOT_URL . 'js/app.min.js', array( 'jquery' ), MDGG_VERSION );
    wp_localize_script( 'mdgg-js', 'mdgg_ajax',
       array(
          'ajaxurl' => admin_url( 'admin-ajax.php' ),
          'nonce' => wp_create_nonce( 'mdgg_nonce', 'security' ),
          'lostPwd' => wp_lostpassword_url(),
          'register' => site_url( '/wp-login.php?action=register&redirect_to=' . get_permalink() ),
          'loggedIn' => is_user_logged_in(),
       )
    );
    wp_enqueue_script( 'mdgg-js' );
  }
  add_action( 'wp_enqueue_scripts', 'mdgg_enqueue' );