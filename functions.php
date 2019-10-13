<?php

// This theme styles the visual editor with editor-style.css to match the theme style.
add_editor_style();

// Add default posts and comments RSS feed links to head
add_theme_support('automatic-feed-links');

// Enable support for Post Thumbnails on posts and pages
add_theme_support('post-thumbnails');

// Add Thumbnail Theme Support
add_theme_support('post-thumbnails');
add_image_size('video_poster', 1920, 1080, true);
add_image_size('top-image', 1920, 600, true);
add_image_size('bio', 500, 700, true);
add_image_size('bio-thumb', 215, 300, true);
add_image_size('article', 380, 380, true);
add_image_size('article-thumb', 380, 235, true);

// This theme uses wp_nav_menu() in one location.
register_nav_menus(array(
	'primary'  => __('Header', 'rstyle'),
));

// Register widgetized area and update sidebar with default widgets
function rstyle_widgets_init() {
	register_sidebar([
		'name'          => __('Sidebar Left', 'rstyle'),
		'id'            => 'sidebar-left',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	]);

	register_sidebar([
		'name'          => __('Sidebar Right', 'rstyle'),
		'id'            => 'sidebar-right',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	]);
}

add_action('widgets_init', 'rstyle_widgets_init');

function register_cpts() {
	/**
	 * Post Type: Team Members.
	 */

	$labels = array(
		"name" => __( "Team Members", "rstyle" ),
		"singular_name" => __( "Team Member", "rstyle" ),
	);

	$args = array(
		"label" => __( "Team Members", "rstyle" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "bio", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title", "editor", "thumbnail" ),
	);

	register_post_type( "bio", $args );

	/**
	 * Post Type: Testimonials.
	 */

	$labels = array(
		"name" => __( "Testimonials", "rstyle" ),
		"singular_name" => __( "Testimonial", "rstyle" ),
	);

	$args = array(
		"label" => __( "Testimonials", "rstyle" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => false,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "testimonial", "with_front" => true ),
		"query_var" => true,
		"supports" => array( "title", "editor" ),
	);

	register_post_type( "testimonial", $args );
}

add_action( 'init', 'register_cpts' );


// Enqueue scripts and styles
function rstyle_scripts() {
	if (!is_admin()) {
		wp_enqueue_style('bootstrap-wp', get_template_directory_uri().'/assets/resources/bootstrap/css/bootstrap-wp.css');
		wp_enqueue_style('bootstrap', get_template_directory_uri().'/assets/resources/bootstrap/css/bootstrap.min.css');
		wp_enqueue_style('font-awesome', get_template_directory_uri().'/assets/styles/font-awesome.min.css', false, '1.6.1');
		wp_enqueue_style('aos', get_template_directory_uri().'/assets/styles/aos.css', false);
		wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Fjalla+One|Open+Sans:300,700', false);
		wp_enqueue_style('main-style', get_template_directory_uri().'/assets/styles/style.css');
		wp_enqueue_style('theme-style', get_stylesheet_uri());

		wp_enqueue_script('jquery');
		wp_enqueue_script('bootstrapjs', get_template_directory_uri().'/assets/resources/bootstrap/js/bootstrap.min.js', array('jquery')); // Bootstrap JS
		wp_enqueue_script('skip-link-focus-fix', get_template_directory_uri().'/assets/js/skip-link-focus-fix.js', array(), '20130115', true );
		wp_enqueue_script('animatescroll', get_template_directory_uri().'/assets/js/animatescroll.min.js', array(), '', true );
		wp_enqueue_script('aos', get_template_directory_uri().'/assets/js/aos.js', array(), '', true );

		if (is_single()) {
			wp_enqueue_script('addthis', '//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-587e68a88e133328', array(), '', true );
		}

		wp_enqueue_script('bootstrapwp', get_template_directory_uri().'/assets/js/bootstrap-wp.js', array('jquery'));
	}
}
add_action('wp_enqueue_scripts', 'rstyle_scripts');

// Move jQuery to footer
function move_wp_jquery() {
	wp_scripts()->add_data('jquery', 'group', 1);
	wp_scripts()->add_data('jquery-core', 'group', 1);
	wp_scripts()->add_data('jquery-migrate', 'group', 1);
}

add_action('wp_enqueue_scripts', 'move_wp_jquery');

//Remove Query Strings
function remove_script_version($src) {
  return remove_query_arg('ver', $src);
}

add_filter('script_loader_src', 'remove_script_version');
add_filter('style_loader_src', 'remove_script_version');

// Login Logo & Link
function custom_login_css() {
	wp_register_style('login-style', get_template_directory_uri() . '/includes/css/login.css', array(), '1.0', 'all');
	wp_enqueue_style('login-style');
}

add_action('login_head', 'custom_login_css');

function my_login_logo_url() {
	return 'http://therstyle.com';
}

add_filter('login_headerurl', 'my_login_logo_url');


// Custom excerpt length
function long_excerpt($length) { // call using custom_excerpt('function_name');
	return 150;
}

function short_excerpt($length) {
	return 25;
}

function custom_excerpt($length_callback = '', $more_callback = '') {
  global $post;
  if (function_exists($length_callback)) {
      add_filter('excerpt_length', $length_callback);
	}
	
  if (function_exists($more_callback)) {
      add_filter('excerpt_more', $more_callback);
	}
	
  $output = get_the_excerpt();
  $output = apply_filters('wptexturize', $output);
  $output = apply_filters('convert_chars', $output);
  $output = '<p>' . $output . '</p>';
  echo $output;
}

// Custom View Article link to Post
function custom_view_article($more) {
	global $post;
	return '... <a href="' . get_permalink($post->ID) . '">Read More</a>';
	}

add_filter('excerpt_more', 'custom_view_article'); // Add 'View Article' button instead of [...] for Excerpts

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function get_pagination() {
	global $wp_query;
	$big = 999999999;
	echo paginate_links([
		'base' => str_replace($big, '%#%', get_pagenum_link($big)),
		'format' => '?paged=%#%',
		'current' => max(1, get_query_var('paged')),
		'total' => $wp_query->max_num_pages,
		'type' => 'list'
	]);
}

add_action('init', 'get_pagination');

// Allow Shortcodes in widgets
add_filter('widget_text', 'do_shortcode');
add_filter('widget_title', 'do_shortcode');

// Search Shortcode
add_shortcode('search_form', 'get_search_form');

// Custom Header Images
$defaults = [
	'default-image'          => '',
	'width'                  => 0,
	'height'                 => 0,
	'flex-height'            => false,
	'flex-width'             => false,
	'uploads'                => true,
	'random-default'         => false,
	'header-text'            => false,
	'default-text-color'     => '',
	'wp-head-callback'       => '',
	'admin-head-callback'    => '',
	'admin-preview-callback' => '',
];

add_theme_support('custom-header', $defaults);

// Options Page
if ( function_exists('acf_add_options_page')) {
	acf_add_options_page();
	acf_add_options_sub_page('General');
	acf_add_options_sub_page('Footer');
}

// Custom WordPress nav walker.
require get_template_directory() . '/bootstrap-wp-navwalker.php';

//Loop through controller methods and create vars for views
function get_vars($class_name) {	
	$class_methods = get_class_methods($class_name);
	$data = [];

	foreach ($class_methods as $class_method) {
		$data[$class_method] = $class_name->{$class_method}();
	}

	return $data;
}