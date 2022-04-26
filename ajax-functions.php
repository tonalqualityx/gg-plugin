<?php defined( 'ABSPATH' ) or die( 'Sectumsempra!' );//For enemies

function mdgg_ajax_login() {

    // Make sense of the data
    $vals = array();
    parse_str($_POST['content'], $vals);

    // Check the nonce and bail if it's bad
    if ( !is_string($vals['nonce']) || !wp_verify_nonce( $vals['nonce'], "mdgg_nonce") ) {
        echo 2;
        die();
     }  

    // Confirm that both the username and password are strings 
    if( is_string($vals['username']) && is_string($vals['pass']) ) {

        $creds = array(
            'user_login' => $vals['username'],
            'user_password' => $vals['pass'],
        );

        $user = wp_signon( $creds, false );
        if( !is_wp_error($user) ) {
            echo 1;
        } else {
            echo 2;
        }
    }

    die();
}

add_action( "wp_ajax_nopriv_mdgg_ajax_login", "mdgg_ajax_login" );
