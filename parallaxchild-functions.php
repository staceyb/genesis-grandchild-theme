<?php

/*
Plugin Name: Parallax Child Theme (grandchild of Genesis and child of Parallax)
Plugin URI: http://www.sunlitstud.io/
Description: A WordPress Grandchild Theme Plugin for Genesis Parallax
Author: Stacey Blaschke
Version: 1.0
Author URI: https://sunlitstud.io
*/

/* 
 * Allow editor role to edit widgets. 
 * Needed because home page uses widgets to contain some of its content
 */

function custom_admin_menu() {

    $user = new WP_User(get_current_user_id());
    $role = get_role('editor');
    $role->add_cap('edit_theme_options');
    if (!empty( $user->roles) && is_array($user->roles)) {
        foreach ($user->roles as $role)
            $role = $role;
    }

    if($role == "editor") {
       remove_submenu_page( 'themes.php', 'themes.php' );
       remove_submenu_page( 'themes.php', 'nav-menus.php' );
    }
}

add_action('admin_menu', 'custom_admin_menu');

/*
 *  Remove dashicons from front-end as we are not using
 *  them and this eliminates a http request and speeds up page
 */

function wpdocs_dequeue_dashicon() {
    if (current_user_can( 'update_core' )) {
        return;
    }
    wp_deregister_style('dashicons');
}
add_action( 'wp_enqueue_scripts', 'wpdocs_dequeue_dashicon' );

/*
 *    Create the foooter html
 */
function add_html_to_footer($output, $backtotop_text, $creds_text) {

  $output = '<div class="footer-logo">
  </div>
  <div class="footer-links">
    <ul>
      <li><h3>Content</h3></li>
      <li><a href="/xenon-ai-system">Xenon AI Overview</a></li>
      <li><a href="/property-monitoring-automation/">Property Automation</a></li>
      <li><a href="/contact-us">Contact</a></li>
    </ul>
    <ul class="aligncenter simple-social-icons">
    <li class="heading"><h3>Follow Us</h3></li>
    <li class="ssi-facebook"><a href="https://www.facebook.com/Xenon-Actionable-Intelligence-128152454553711/" target="_blank"><svg role="img" class="social-facebook" aria-labelledby="social-facebook"><title id="social-facebook">Facebook</title><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="https://www.xenon.ai/wp-content/plugins/simple-social-icons/symbol-defs.svg#social-facebook"></use></svg></a></li>
    <li class="ssi-gplus"><a href="https://googleplus.com/xenonai" target="_blank"><svg role="img" class="social-gplus" aria-labelledby="social-gplus"><title id="social-gplus">Google+</title><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="https://www.xenon.ai/wp-content/plugins/simple-social-icons/symbol-defs.svg#social-gplus"></use></svg></a></li>
    <li class="ssi-linkedin"><a href="http://www.linkedin.com/company/xenon-inc" target="_blank"><svg role="img" class="social-linkedin" aria-labelledby="social-linkedin"><title id="social-linkedin">Linkedin</title><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="https://www.xenon.ai/wp-content/plugins/simple-social-icons/symbol-defs.svg#social-linkedin"></use></svg></a></li>
    </ul>
    <ul>
      <li><h3>Legal</h3></li>
      <li><a href="/terms">Terms and Conditions</a></li>
      <li><a href="/privacy-policy">Privacy Policy</a></li>
    </ul>
  </div>

  <hr>';
  $output .= '<p>' . $creds_text . '</p>';
  $output .= $backtotop_text;
  return $output;
}
add_filter( 'genesis_footer_output','add_html_to_footer', 10, 3 );

/*
 * Created text that is animated to go with the header logo and add more
 * motion to the website. CSS animates the individual letters themselves.
 * @param string $title full title
 * @param string $inside text
 * @param string $wrap html wrapper
 * @return string full title
 */
function animate_title($title) {

   $inside = '<a href="/"><span class="animate three">
			<span>A</span><span>c</span><span>t</span><span>i</span><span>o</span><span>n</span><span>a</span><span>b</span><span>l</span><span>e</span><br/><span>I</span><span>n</span><span>t</span><span>e</span><span>l</span><span>l</span><span>i</span><span>g</span><span>e</span><span>n</span><span>c</span><span>e</span></a>';
    $wrap = ( is_home() || is_front_page() ) ? 'h1' : 'p';

     $title = genesis_markup( array(
       'open'    => sprintf( "<{$wrap} %s>", genesis_attr( 'site-title' ) ),
       'close'   => "</{$wrap}>",
       'content' => $inside,
       'context' => 'site-title',
       'echo'    => false,
       'params'  => array(
         'wrap' => $wrap,
       ),
     ) );
     return $title;
}
add_filter( 'genesis_seo_title','animate_title', 10, 1);

/*
*   Add additional style sheet and the Lato font
*/
function parallaxchild_add_styles () {
    wp_register_style ('parallaxchild-style', plugins_url('parallaxchild-styles.css', __FILE__).'', array('parallax-pro'), '1.0');
    wp_enqueue_style('parallaxchild-style');

    wp_dequeue_style('parallax-google-fonts');
    wp_enqueue_style( 'parallax-google-fonts', '//fonts.googleapis.com/css?family=Lato:400,400i,700,700i|Roboto:400,500', array(), CHILD_THEME_VERSION );

}

add_action( 'wp_enqueue_scripts', 'parallaxchild_add_styles');

/*
*   Selectively load addtion js files that certain pages need
*/
function parallaxchild_add_scripts() {
  if (is_page('contact-us') ) {
    wp_register_script( 'parallaxchild-map', plugins_url( 'js/parallaxchild-map.min.js', __FILE__ ), array( 'jquery'), '1.0' );
  	wp_enqueue_script( 'parallaxchild-map' );
    wp_register_script( 'googlemaps', '//maps.googleapis.com/maps/api/js?key=AIzaSyCJ9v_5RTqoezNfnfilwx9jiz4xOAtXUtI', array( 'jquery', 'parallaxchild-map'), '1.0' );
    wp_enqueue_script( 'googlemaps');
  }
  if (is_page('property-monitoring-automation') ) {
    wp_register_script( 'parallaxchild-hopscotch', plugins_url( 'js/hopscotch.min.js', __FILE__ ), array( 'jquery'), '1.0' );
    wp_enqueue_script( 'parallaxchild-hopscotch' );
    wp_register_script( 'parallaxchild-tour', plugins_url( 'js/featuretour.js', __FILE__ ), array( 'jquery'), '1.0' );
    wp_enqueue_script( 'parallaxchild-tour' );
  }
  if (is_page('smoke-and-carbon-monoxide-detector') ) {
    wp_register_script( 'jquery-easing', plugins_url( 'js/jquery.easing.js', __FILE__ ), array( 'jquery'), '1.0' );
    wp_enqueue_script( 'jquery-easing' );
    wp_register_script( 'jquery-mousewheel', plugins_url( 'js/jquery.mousewheel.js', __FILE__ ), array( 'jquery-easing'), '1.0' );
    wp_enqueue_script( 'jquery-mousewheel' );
    wp_register_script( 'flexslider', plugins_url( 'js/jquery.flexslider-min.js', __FILE__ ), array( 'jquery-easing'), '1.0' );
    wp_enqueue_script( 'flexslider' );
    wp_register_script( 'smoke-slider', plugins_url( 'js/smoke-slider.js', __FILE__ ), array( 'flexslider'), '1.0' );
    wp_enqueue_script( 'smoke-slider' );
  }

  wp_enqueue_style( 'fontawesome', '//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css' );

	wp_register_script( 'parallaxchild-script', plugins_url( 'js/parallaxchild-scripts.min.js', __FILE__ ), array( 'jquery' ), '1.0' );
	wp_enqueue_script( 'parallaxchild-script' );
}
add_action( 'wp_enqueue_scripts', 'parallaxchild_add_scripts' );

 /**
 * Search for templates in plugin 'templates' dir, and load if exists.
 *
 * @param  string $template Template check.
 * @return string $template Template to use.
 */
function parallaxchild_template_include( $template ) {
	if ( file_exists( untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' . basename( $template ) ) ) {
		$template = untrailingslashit( plugin_dir_path( __FILE__ ) ) . '/templates/' . basename( $template );
	}
	return $template;
}
add_filter( 'template_include', 'parallaxchild_template_include', 11 );



/**
 * Filter menu items, appending  a search form 
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 *
 * @return string Amended HTML string of list items.
 */
function theme_menu_extras( $menu, $args ) {
 	//Only add the search form to the primary menu
	if ( 'secondary' === $args->theme_location)
		  return $menu;

	ob_start();
	get_search_form();
	$search = ob_get_clean();
  $search = str_replace( ' name="s"', ' name="s" class="searchinput"', $search );
  $menu  .= '<li class="search-form-container menu-item"><div class="search-toggle"><i class="fa fa-search"></i>
  <a href="#search-container" class="screen-reader-text"></a>
  </div></li>';

	return $menu;
}
add_filter( 'wp_nav_menu_items', 'theme_menu_extras', 10, 2 );

/**
 * Allow PHP to run within the widgets
 */
function genesis_execute_php_widgets( $html ) {
   if ( strpos( $html, "<" . "?php" ) !==false ) {
   ob_start();
   eval( "?".">".$html );
   $html=ob_get_contents();
   ob_end_clean();
   }
   return $html;
}
add_filter( 'widget_text','genesis_execute_php_widgets' );

/**
 * Place the search form in a div with 
 * id search-form-container
 */
function themeprefix_search_widget() {
 genesis_widget_area ( 'search', array(
 'before' => '<div id="search-form-container">',
 'after'  => '</div>',));
}
add_action( 'genesis_after_header','themeprefix_search_widget' );


/**
 *  Add flex-width = true to bypass cropping button when using 
 * svg, rather than jpg, as image type for header logo  
 */
add_theme_support( 'custom-header', array(
    'width'           => 600,
    'height'          => 140,
    'header-selector' => '.site-title a',
    'header-text'     => false,
    'flex-width'     => true,
    'flex-height'     => true,
) );

/**
 * 
 * Disable the Genesis Favicon
 */
remove_action( 'wp_head', 'genesis_load_favicon' );


/**
 *  Remove WP embed script since we are not using and eliminates one request
 *  so speeds up page load
 */
function speed_stop_loading_wp_embed() {
	if (!is_admin()) {
		wp_deregister_script('wp-embed');
	}
}
add_action('init', 'speed_stop_loading_wp_embed');


/**
 * Disable the emoji's, another page load enhancement
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

/**
 * Filter function used to remove the tinymce emoji plugin.
 *
 * @param    array  $plugins
 * @return   array             Difference betwen the two arrays
 */
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

/**
 * Changing excerpt length increase it from the default of 55 words 
 * to 100 words
 */
function new_excerpt_length($length) {
  return 100;
}
add_filter('excerpt_length', 'new_excerpt_length');

/**
 * Changing excerpt more from [...] to just ...
 */
function new_excerpt_more($more) {
  return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');


?>
