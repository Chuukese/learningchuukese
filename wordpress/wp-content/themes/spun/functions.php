<?php
/**
 * Spun functions and definitions
 *
 * @package Spun
 * @since Spun 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * @since Spun 1.0
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'spun_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * @since Spun 1.0
 */
function spun_setup() {

	/**
	 * Custom template tags for this theme.
	 */
	require( get_template_directory() . '/inc/template-tags.php' );

	/**
	 * Custom functions that act independently of the theme templates
	 */
	require( get_template_directory() . '/inc/tweaks.php' );

	/* Jetpack Infinite Scroll */
	add_theme_support( 'infinite-scroll', array(
		'container'  => 'content',
		'footer'     => 'page',
		'render'	 => 'spun_infinite_scroll',
		'posts_per_page' => 15,
		'footer_widgets' => array( 'sidebar-1', 'sidebar-2', 'sidebar-3' ),
	) );

	/* Load the proper content template */
	function spun_infinite_scroll() {
		while( have_posts() ) {
			the_post();

			get_template_part( 'content', 'home' );
		}
	}

	/**
	 * Make theme available for translation
	 * Translations can be filed in the /languages/ directory
	 * If you're building a theme based on Spun, use a find and replace
	 * to change 'spun' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'spun', get_template_directory() . '/languages' );

	/**
	 * Add default posts and comments RSS feed links to head
	 */
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Enable support for Post Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 360, 360, true );
	add_image_size( 'single-post', 700, 467, true );

	/**
	 * This theme uses wp_nav_menu() in one location.
	 */
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'spun' ),
	) );

	/**
	 * Add support for custom backgrounds
	 */

	add_theme_support( 'custom-background' );

	/**
	 * Add support for Post Formats
	 */
	add_theme_support( 'post-formats', array( 'aside', 'gallery', 'image', 'quote', 'status' ) );

}
endif; // spun_setup
add_action( 'after_setup_theme', 'spun_setup' );

/* Filter to add author credit to Infinite Scroll footer */
function spun_footer_credits( $credit ) {
	$credit = sprintf( __( '%3$s | Theme: %1$s by %2$s.', 'spun' ), 'Spun', '<a href="http://carolinemoore.net/" rel="designer">Caroline Moore</a>', '<a href="http://wordpress.org/" title="' . esc_attr( __( 'A Semantic Personal Publishing Platform', 'spun' ) ) . '" rel="generator">Proudly powered by WordPress</a>' );
	return $credit;
}
add_filter( 'infinite_scroll_credit', 'spun_footer_credits' );

/**
 * Filter archives to display one less post per page to account for the .page-title circle
 */
function limit_posts_per_archive_page() {

	if ( ! is_home() && is_archive() || is_search() ) {

		$posts_per_page = intval( get_option( 'posts_per_page' ) ) - 1;
		set_query_var( 'posts_per_page', $posts_per_page );
	}
}
add_filter( 'pre_get_posts', 'limit_posts_per_archive_page' );


/**
 * Register widgetized area and update sidebar with default widgets
 *
 * @since Spun 1.0
 */
function spun_widgets_init() {
	register_sidebar( array(
		'name' => __( 'Sidebar 1', 'spun' ),
		'id' => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar 2', 'spun' ),
		'id' => 'sidebar-2',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
	register_sidebar( array(
		'name' => __( 'Sidebar 3', 'spun' ),
		'id' => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h1 class="widget-title">',
		'after_title' => '</h1>',
	) );
}
add_action( 'widgets_init', 'spun_widgets_init' );


/**
 * Enqueue scripts and styles
 */
function spun_scripts() {

	wp_enqueue_style( 'style', get_stylesheet_uri() );

	wp_enqueue_script( 'spun-toggle', get_template_directory_uri() . '/js/toggle.js', array( 'jquery' ), '20121005', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	if ( is_singular() && wp_attachment_is_image() ) {
		wp_enqueue_script( 'keyboard-image-navigation', get_template_directory_uri() . '/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
	}

	wp_enqueue_style( 'spun-quicksand' );
	wp_enqueue_style( 'spun-playfair' );
	wp_enqueue_style( 'spun-nunito' );

}
add_action( 'wp_enqueue_scripts', 'spun_scripts', 1 );


/*
 * Change the theme's accent color
 * Not yet working with the Customizer
 * @todo find a way to reset to default values
 * /
 function spun_custom_color() {
	//If a custom accent color is set, use it!
	if ( '' != get_theme_mod( 'spun_color' ) ) {

		$color = esc_html( get_theme_mod( 'spun_color' ) ); ?>

		<style type="text/css">
			::selection,
			button:hover,
			html input[type="button"]:hover,
			input[type="reset"]:hover,
			input[type="submit"]:hover,
			.site-description,
			.hentry.no-thumbnail:hover,
			.page-links a:hover span.active-link,
			.page-links span.active-link,
			.page-header h1,
			a.comment-reply-link:hover,
			a#cancel-comment-reply-link:hover,
			.comments-link a:hover,
			.sidebar-link:hover {
				background-color: <?php echo $color; ?>;
			}
			.comments-link a:hover .tail {
				border-top-color: <?php echo $color; ?>;
			}
			.entry-title,
			.entry-title a,
			.entry-content a,
			.entry-content a:visited,
			.widget a,
			.widget a:visited,
			.main-navigation a,
			.main-navigation a:visited,
			.main-navigation ul ul .parent > a::after,
			.main-small-navigation a,
			.main-small-navigation a:visited,
			.menu-toggle {
				color: <?php echo $color; ?>;
			}
		</style>
	<?php
	}
}

if ( '' != get_theme_mod( 'spun_color' ) )
	add_action( 'wp_head', 'spun_custom_color', 99 );*/

/**
 * Enqueue scripts and styles in custom header admin
 */
function spun_admin_scripts( $hook_suffix ) {

	if ( 'appearance_page_custom-header' != $hook_suffix )
		return;

	wp_enqueue_style( 'spun-playfair' );

}
add_action( 'admin_enqueue_scripts', 'spun_admin_scripts' );

/**
 * Register Google Fonts
 */
function spun_register_fonts() {

	$protocol = is_ssl() ? 'https' : 'http';

	wp_register_style(
		'spun-quicksand',
		"$protocol://fonts.googleapis.com/css?family=Quicksand:300",
		array(),
		'20121005'
	);
	wp_register_style(
		'spun-playfair',
		"$protocol://fonts.googleapis.com/css?family=Playfair+Display:400,700,400italic,700italic",
		array(),
		'20121005'
	);
	wp_register_style(
		'spun-nunito',
		"$protocol://fonts.googleapis.com/css?family=Nunito:300",
		array(),
		'20121005'
	);
}
add_action( 'init', 'spun_register_fonts' );


/**
 * Implement the Custom Header feature
 */
require( get_template_directory() . '/inc/custom-header.php' );

/**
 * Remove widget title header if no title is entered.
 * @todo Remove this function when this is fixed in core.
 */

function spun_calendar_widget_title( $title = '', $instance = '', $id_base = '' ) {

	if ( 'calendar' == $id_base && '&nbsp;' == $title )
		$title = '';
	return $title;
}
add_filter( 'widget_title', 'spun_calendar_widget_title', 10, 3 );


/**
 * Count the number of active sidebars and generate an ID to style them.
 */

function spun_count_sidebars() {
	$count = 0;

	if ( is_active_sidebar( 'sidebar-1' ) || is_active_sidebar( 'sidebar-2' ) || is_active_sidebar( 'sidebar-3' ) )
		$count = 'one';

	if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ||
		 is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-3' ) ||
		 is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
		$count = 'two';

	if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) && is_active_sidebar( 'sidebar-3' ) )
		$count = 'three';

	print $count;
}


/**
 * Add color change theme options in the Customizer
 * @todo find a way to reset to default values

function spun_customize( $wp_customize ) {

	$wp_customize->add_setting( 'spun_color', array(
		'default' => '',
	) );

	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'spun_color', array(
		'label'   => 'Accent Color',
		'section' => 'colors',
		'default' => '',
		)
	) );

}

add_action( 'customize_register', 'spun_customize' );*/