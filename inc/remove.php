<?php
  function disable_emojis() {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
    remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  }
  add_action( 'init', 'disable_emojis' );

  remove_action('wp_head', 'wp_generator');
  add_filter('the_generator', '__return_empty_string');
  add_filter('xmlrpc_enabled', '__return_false');


  add_filter( 'script_loader_src', 'remove_wp_version_strings' );
  add_filter( 'style_loader_src', 'remove_wp_version_strings' );
  function remove_wp_version_strings( $src ) {
    parse_str( parse_url($src, PHP_URL_QUERY), $query );

    if ( !empty($query['ver']) && $query['ver'] === $GLOBALS['wp_version'] ) {
      $src = remove_query_arg( 'ver', $src );
    }

    return $src;
  }

  add_action('wp_head',function() { ob_start(function($o) {
    return preg_replace('/^\n?<!--.*?[Y]oast.*?-->\n?$/mi','',$o);
  }); },~PHP_INT_MAX);