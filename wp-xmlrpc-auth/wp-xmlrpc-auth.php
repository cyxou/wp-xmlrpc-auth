<?php
/**
 * Plugin Name: xmlrpc-authenticate
 * Description: Responds with the user ID if the supplied user succesfully logged in.
 * Version: 1.0
 * Author: Wordpress Example
 * License: MIT
 */

function mynamespace_getUserID( $args ) {
    global $wp_xmlrpc_server;
	/*error_log( 'blog_id: ' . print_r( $args[0], true ) );
	error_log( 'username: ' . print_r( $args[1], true ) );
	error_log( 'password: ' . print_r( $args[2], true ) );*/
    $wp_xmlrpc_server->escape( $args );

    $blog_id  = $args[0];
    $username = $args[1];
    $password = $args[2];


    if ( ! $user = $wp_xmlrpc_server->login( $username, $password ) )
        return $wp_xmlrpc_server->error;

    return array(
        "wpid" => $user->ID,
        "email" => $user->user_email,
        "registeredOn" => $user->user_registered,
        "first_name" => $user->first_name,
        "last_name" => $user->last_name
        );
}

function mynamespace_new_xmlrpc_methods( $methods ) {
    $methods['mynamespace.getUserID'] = 'mynamespace_getUserID';
    return $methods;
}
add_filter( 'xmlrpc_methods', 'mynamespace_new_xmlrpc_methods');
