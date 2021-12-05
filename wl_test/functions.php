<?php
/**
 * WL Test Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WL_Test_Theme
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'wl_test_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wl_test_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on WL Test Theme, use a find and replace
		 * to change 'wl_test' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wl_test', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'wl_test' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'wl_test_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'wl_test_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wl_test_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'wl_test_content_width', 640 );
}
add_action( 'after_setup_theme', 'wl_test_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wl_test_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'wl_test' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'wl_test' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'wl_test_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function wl_test_scripts() {
	wp_enqueue_style( 'wl_test-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'wl_test-style', 'rtl', 'replace' );

	wp_enqueue_script( 'wl_test-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'wl_test_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

function fn_add_phone_number($wp_customize) {
	$wp_customize->add_setting('phone_number');
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'phone_number',
	array(
	'label' => 'Phone Number',
	'section' => 'title_tagline',
	'settings' => 'phone_number',
	'type' => 'number'
	) ) );
}

add_action('customize_register', 'fn_add_phone_number');

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}
add_action( 'admin_enqueue_scripts', 'fn_add_color_picker');

if ( ! function_exists( 'fn_add_color_picker' ) ){
	function fn_add_color_picker( $hook ) {
		wp_enqueue_style( 'wp-color-picker');
		wp_enqueue_script( 'wp-color-picker');
	}
}

add_action( 'init', 'fn_add_cars' );
function fn_add_cars() {
    register_post_type( 'cars',
        array(
            'labels' => array(
                'name' => __( 'Cars' ),
                'singular_name' => __( 'Car' )
            ),
            'supports' => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions' ),
            'hierarchical'        => false,
		    'public'              => true,
		    'show_ui'             => true,
		    'show_in_menu'        => true,
		    '_builtin'            => false,
		    'menu_position'       => 9,
		    'map_meta_cap'        => true,
            'rewrite' => array('slug' => 'cars'),
			'register_meta_box_cb' => 'add_cars_metaboxes'
        )
    );
}

add_action( 'init', 'fn_add_car_models', 0 );
function fn_add_car_models() {
	$labels = array(
    	'name' => __( 'Car Models' ),
		'singular_name' => __( 'Car Model' ),
		'menu_name' => __( 'Car Models' )
	);    
 
	register_taxonomy('models',array('cars'), array(
    	'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'models' ),
	));
}

add_action( 'init', 'fn_add_car_countries', 0 );
function fn_add_car_countries() {
	$labels = array(
    	'name' => __( 'Countries' ),
		'singular_name' => __( 'Country' ),
		'menu_name' => __( 'Countries' )
	);    
 
	register_taxonomy('countries',array('cars'), array(
    	'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'countries' ),
	));
}

function add_cars_metaboxes() {

	add_meta_box(
		'car_color',
		'Car Color',
		'fn_add_car_color',
		'cars',
		'side',
		'default'
	);

	add_meta_box(
		'car_fuel',
		'Car Fuel',
		'fn_add_car_fuel',
		'cars',
		'side',
		'default'
	);

	add_meta_box(
		'car_power',
		'Car Power',
		'fn_add_car_power',
		'cars',
		'side',
		'default'
	);

	add_meta_box(
		'car_price',
		'Car Price',
		'fn_add_car_price',
		'cars',
		'side',
		'default'
	);
}

function fn_add_car_color() {
	global $post;
	$custom = get_post_custom( $post->ID );
	$header_color = ( isset( $custom['carcolor'][0] ) ) ? $custom['carcolor'][0] : '';
	wp_nonce_field( basename( __FILE__ ), 'car_fields' );
	$carcolor = get_post_meta( $post->ID, 'carcolor', true );
	?>
	<script>
	jQuery(document).ready(function($){
	    $('.color_field').each(function(){
    		$(this).wpColorPicker();
    	});
	});
	</script>
	<div class="pagebox">
	    <p>Choose a color</p>
	    <input class="color_field" type="hidden" name="carcolor" value="<?php esc_attr_e( $header_color ); ?>"/>
	</div>
	<?php

}

function fn_add_car_fuel() {
	global $post;
	$fuel = get_post_meta( $post->ID, 'car_fuel', true );
	?>
	<select name="car_fuel" id="">
	  <option value="none" <?php selected( $fuel, 'none' ); ?>>none</option>
      <option value="gas" <?php selected( $fuel, 'gas' ); ?>>gas</option>
      <option value="diesel" <?php selected( $fuel, 'diesel' ); ?>>diesel</option>
    </select>
	<?php 
}

function fn_add_car_power() {
	global $post;
	$power = get_post_meta( $post->ID, 'power', true );
	echo '<input type="number" name="power" value="' . esc_textarea( $power )  . '" class="widefat">';

}

function fn_add_car_price() {
	global $post;
	$price = get_post_meta( $post->ID, 'price', true );
	echo '<input type="number" name="price" value="' . esc_textarea( $price )  . '" class="widefat">';
}

function save_cars_meta( $post_id, $post ) {
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return $post_id;
	}
	
	if (! wp_verify_nonce( $_POST['car_fields'], basename(__FILE__) ) ) {
		return $post_id;
	}
	$cars_meta['carcolor'] = esc_textarea( $_POST['carcolor'] );
	$cars_meta['car_fuel'] = esc_textarea( $_POST['car_fuel'] );
	$cars_meta['power'] = esc_textarea( $_POST['power'] );
	$cars_meta['price'] = esc_textarea( $_POST['price'] );
	foreach ( $cars_meta as $key => $value ) :
		if ( 'revision' === $post->post_type ) {
			return;
		}

		if ( get_post_meta( $post_id, $key, false ) ) {
			update_post_meta( $post_id, $key, $value );
		} else {
			add_post_meta( $post_id, $key, $value);
		}

		if ( ! $value ) {
			delete_post_meta( $post_id, $key );
		}

	endforeach;

}
add_action( 'save_post', 'save_cars_meta', 1, 2 );

function fn_register_shortcodes() {
	add_shortcode('latest_cars', 'fn_show_latest_cars');
}

function fn_show_latest_cars() {
	ob_start();
	$recent_posts = wp_get_recent_posts(array('post_type'=>'cars', 'posts_per_page' => 10));
	echo('<ul>');
	foreach( $recent_posts as $recent ){
		echo '<li><a href="' . get_permalink($recent["ID"]) . '" title="Look '.esc_attr($recent["post_title"]).'" >' .   $recent["post_title"].'</a> </li> ';
	}
	echo('</ul>');
	$output_string = ob_get_contents();
	return $output_string;
}

add_action( 'init', 'fn_register_shortcodes');