<?php

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

// Login Logo & Link
add_action( 'login_enqueue_scripts', function() {
	echo '<style type="text/css">
	#login h1 a, .login h1 a {
			background-image: url('.get_template_directory_uri().'/assets/images/rstyle-design-logo.svg);
	height:100px;
	width:300px;
	background-size: 310px 64px;
	background-repeat: no-repeat;
	padding-bottom: 10px;
	}
</style>';
});

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

?>