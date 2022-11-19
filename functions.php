<?php
/**
 * Functions.php file for GV Rising Voices Child Theme
 *
 * Assumes parent is gv-project-theme. 
 * This code will run before the functions.php in that theme.
 */

/**
 * Filter how recently you must have posted to be considered active
 */
function gv_risingvoices_filter_active_days_ago($days_ago) {
	return 365 * 3;
}
add_filter('gv_active_days_ago', 'gv_risingvoices_filter_active_days_ago');

/**
 * TODO Move everything out of is_object($gv) and just use filters!
 */
if (!empty($gv) AND is_object($gv)) :


	/**
	 * Disable automatic plugin activation from parent theme. We need this theme to work in MU
	 */
	define('GV_NO_DEFAULT_PLUGINS', TRUE);

	/**
	 * Define an image to show in the header.
	 * Project theme generic has none, so it will use site title
	 */
	$gv->settings['header_img'] = get_bloginfo('stylesheet_directory') . '/images/rv-header-myriad-risingbold-600.png';

	/**
	 * Enable Featured posts - Tells GV Query Manipulation to prefetch featured posts before main loop and exclude their ids.
	 * @see gv_load_featured_posts()
	 */
	// $gv->use_featured_posts = true;
	
	/**
	 * Hide tags interface completely to avoid people using them
	 * @see gv_hide_tags_ui()
	 */
	add_filter('gv_hide_tags_ui', '__return_true');

	/**
	 * Set site colors for use in PHP-driven CSS (AMP templates)
	 * 
	 * Currently specifically intended for AMP plugin 
	 * 
	 * @see gv_get_site_colors()
	 * @return type
	 */
	function globalvoices_gv_site_colors() {
		return array(
			'solid_bg' => '45AF49',
			'solid_bg_text' => 'ffffff',
			'link_dark' => '1287c8',
			'link_light' => '5bb5e8',
		);
	}
	add_filter('gv_site_colors', 'globalvoices_gv_site_colors');

	/**
	 * Filter the favicon directory used by gv_display_head_icons()
	 * 
	 * @param string $dir Default directory (no trailing /) to find favicons in
	 * @return string desired directory (no trailing /)
	 */
	function risingvoices_theme_gv_favicon_dir($dir) {
		return 'https://globalvoices.org/wp-content/gv-static/img/tmpl/favicon-rv';
	}
	add_filter('gv_favicon_dir', 'risingvoices_theme_gv_favicon_dir');
	
	/**
	 * Filter the apple touch icon to be an RV logo
	 * 
	 * @param string $icon Default icon
	 * @return string desired icon
	 */
	function rising_theme_gv_apple_touch_icon($icon) {
		return gv_get_dir('theme_images') ."risingvoices-apple-touch-icon-precomposed-300.png";
	}
	add_filter('gv_apple_touch_icon', 'rising_theme_gv_apple_touch_icon');
		
	/**
	 * Filter the og:image (facebook/g+) default icon to be an RV logo
	 * 
	 * @param string $icon Default icon
	 * @return string desired icon
	 */
	function gvadvocacy_theme_gv_og_image_default($icon) {
		return gv_get_dir('theme_images') ."rv-logo-facebook-og-1200x631.png";
	}
	add_filter('gv_og_image_default', 'gvadvocacy_theme_gv_og_image_default');
	
	/**
	 * Filter ALL CASES OF og:image (facebook/g+) icon to be an RV logo
	 * 
	 * @param string $icon Default icon
	 * @return string desired icon
	 */
	function gvadvocacy_theme_gv_og_image($icon) {
		return gv_get_dir('theme_images') ."rv-logo-square-600.png";
	}
//	add_filter('gv_og_image', 'gvadvocacy_theme_gv_og_image');
	
	/**
	 * Define Categories to be inserted into post data before returning content for translation during fetch
	 * @see GV_Lingua_Manager->reply_to_ping()
	 */
	$gv->lingua_site_categories[] = 'rising-voices';

	/**
	 * Define special categories as content types and the conditions in which to segregate them
	 * Used by gv_get_segregated_categories() and gv_
	 * segregation_conditions apply to primary content only. sidebar headlines etc assume segregation
	 * segregate_headlines - use if headlines will be a waste for this , blocks them from showing as title only
	 */
	$gv->category_content_types = array(
		'feature' => array('title' => 'feature'),
	    );
	
	/**
	 * Geo Mashup maps options partial_overrides
	 */
	if (!isset($gv->option_overrides['partial_overrides'])) :
		$gv->option_overrides['partial_overrides'] = array();
	endif;
	if (!isset($gv->option_overrides['partial_overrides']['geo_mashup_options'])) :
		$gv->option_overrides['partial_overrides']['geo_mashup_options'] = array(
			'overall' => array(
				'copy_geodata' => true,
				'theme_stylesheet_with_maps' => false,
			),
			'global_map' => array(
				'width' => '100%',
				'height' => '480',
				'auto_info_open' => false, 
				'enable_scroll_wheel_zoom' => false,
				'zoom' => 2,
				'max_posts' => 50,
			),
			'single_map' => array(
				'width' => '100%',
				'height' => '480',
				'zoom' => 7,
				'enable_scroll_wheel_zoom' => false,
			),
			'context_map' => array(
				'width' => '100%',
				'height' => '480',
				'zoom' => 7,
				'enable_scroll_wheel_zoom' => false,
			),
		);
	endif;
	
	/**
	 * Set a custom site description using a lingua string. To be used in social media sharing etc.
	 * 
	 * DISABLED: It's out of date, and anyway, we should just use the description field that was added to GV Settings
	 * If anyting it's the custom context string that should be hardcoded 
	 * based on what's in the description setting of GV Settinvs.
	 */
	// $gv->site_description = "Rising Voices aims to extend the benefits and reach of citizen media by connecting online media activists around the world and supporting their best ideas.";

	/**
	 * Sponsors definition to be used by gv_get_sponsors()
	 */
	// $gv->sponsors = array(
	// 	'omidyar' => array(
	// 		"name" => "Omidyar Network",
	// 		"slug" => "omidyar",
	// 		'description' => 'Omidyar Network - Every person has the power to make a difference.',
	// 		"url" => "http://www.omidyar.com/",
	// 		'status' => 'featured',
	// 		),
	// 	'hivos' => array(
	// 		"name" => "Hivos",
	// 		"slug" => "hivos",
	// 		"description" => 'Hivos, the Humanist Institute for Development Cooperation',
	// 		"url" => "http://www.hivos.org/",
	// 		"status" => 'featured',
	// 		),		
	// 	'knight' => array(
	// 		"name" => "Knight Foundation",
	// 		"slug" => "knight",
	// 		"description" => 'John S. and James L. Knight Foundation',
	// 		"url" => "http://www.knightfdn.org/",
	// 		"status" => 'featured',
	// 		),
	// 	'fpu' => array(
	// 		"name" => "Free Press Unlimited",
	// 		"slug" => "fpu",
	// 		"description" => 'Free Press Unlimited - People Deserve to Know',
	// 		"url" => "http://www.freepressunlimited.org/",
	// 		"status" => 'featured',
	// 		),
	// 	'osi' => array(
	// 		"name" => "Open Society Institute",
	// 		"slug" => "osi",
	// 		"description" => 'Open Society Institute - Building vibrant and tolerant democracies.',
	// 		"url" => "http://www.soros.org/",
	// 		"status" => 'featured',
	// 		),
	// 	'heinrichboll' => array(
	// 		"name" => "Heinrich Böll Stiftung",
	// 		"slug" => "heinrichboll",
	// 		"description" => 'Heinrich Böll Stiftung - Striving to promote democracy, civil society, equality and a healthy environment internationally.',
	// 		"url" => "http://www.boell.org/",
	// 		"status" => 'featured',
	// 		),
	// );

endif; // is_object($gv)

// **************************************
// KSES Hacks for Rising MU installation only
//

function gv_modify_kses( $tags ) {
    global $allowedposttags;
    //found from donncha, good idea, add id and class to everything
    foreach( $allowedposttags as $tag => $attr ) {
        $attr[ 'class' ] = array();
        $attr[ 'id' ] = array();
        $allowedposttags[ $tag ] = $attr;
    }
    // now add our own tags for youtube etc.
    $allowedposttags['object'] = array(
    	'width' => array(), 'height' => array()
    );
    $allowedposttags['param'] = array(
    	'name' => array(), 'value' => array()
    );
    $allowedposttags['embed'] = array(
    	'src' => array(),'type' => array(),
    	'mode' => array(), 'height' => array(),
    	'width' => array()
    );
    $allowedposttags['script'] = array(
    	'src' => array(),'type' => array()
    );
    $allowedposttags['iframe'] = array(
       	'width' => array(),'height' => array(),
    	'title' => array(),'class' => array(),
    	'id' => array(),'style' => array(),
    	'src' => array(),'frameborder' => array()
    );
    $allowedposttags['input'] = array(
       	'type' => array(),'name' => array(),
    	'src' => array(),'border' => array(),
    	'alt' => array(),'name' => array(),
    	'value' => array()
    );



    return $allowedposttags;

}
add_filter( 'edit_allowedposttags', 'gv_modify_kses' );

?>