<?php

function university_files() {
  // include js files
  wp_enqueue_script( 'main-university-script', get_theme_file_uri( '/build/index.js' ), array('jquery'), '1.0', true );
  // include css files
  wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
  wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'university_main_style', get_theme_file_uri( '/build/style-index.css' ) );
  wp_enqueue_style( 'university_extra_style', get_theme_file_uri( '/build/index.css' ) );
}

add_action( 'wp_enqueue_scripts', 'university_files' );

function university_features() {
  // setup nav menus in wp dashboard
  // register_nav_menu( 'headerMenuLocation', 'Header Menu Location' );
  // register_nav_menu( 'footerLocationOne', 'Footer Location One' );
  // register_nav_menu( 'footerLocationTwo', 'Footer Location Two' );
  
  add_theme_support( 'title-tag' );
}

add_action( 'after_setup_theme', 'university_features' );

// Function file is not the best place to keep custom post types
// function university_post_types() {
//   register_post_type('event', array(
//     'public' => true,
//     'labels' => array(
//       'name' => 'Events'
//     ),
//     'menu_icon' => 'dashicons-calendar'
//   ));
// }

// add_action( 'init', 'university_post_types');

function university_adjust_queries($query) {
  if(!is_admin() AND is_post_type_archive( 'event' ) AND $query->is_main_query(  )) {
    $today = date('Ymd');
    $query->set(
      'meta_key', 'event_date'
    );
    $query->set(
      'orderby', 'meta_value_num'
    );
    $query->set(
      'order', 'ASC'
    );
    $query->set(
      'meta_query', array(
                array(
                  'key' => 'event_date',
                  'compare' => '>=',
                  'value' => $today,
                  'type' => 'numeric'
                )
              )
    );
  }
}

add_action( 'pre_get_posts', 'university_adjust_queries' );