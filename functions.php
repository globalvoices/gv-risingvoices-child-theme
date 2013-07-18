<?php
/**
 * Functions.php file for GV Rising Voices Child Theme
 *
 * Assumes parent is gv-project-theme. 
 * This code will run before the functions.php in that theme.
 */

if (is_object($gv)) :


	/**
	 * Disable automatic plugin activation from parent theme. We need this theme to work in MU
	 */
	define('GV_NO_DEFAULT_PLUGINS', TRUE);


	/**
	 * Define an image to show in the header.
	 * Project theme generic has none, so it will use site title
	 */
	$gv->settings['header_img'] = get_bloginfo('stylesheet_directory') . '/images/rv-siteheader-transparent.png';

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
	 * Define Categories to be inserted into post data before returning content for translation during fetch
	 * @see gv_lingua::reply_to_ping()
	 */
	$gv->lingua_site_categories[] = 'rising-voices';

	/**
	 * Define the hierarchical structure of the taxonomy by its parents
	 * RV has no taxnomy sections, just a flat list.
	 */
//	$gv->taxonomy_outline = array();

	/**
	 *  Define the order of importance of the taxonomies (all taxonomy slugs should work...)
	 */
//	$gv->taxonomy_priority = array ('countries', 'special', 'topics', 'type');

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
	 * Set a custom site description using a lingua string. To be used in social media sharing etc.
	 */
	$gv->site_description = "Rising Voices aims to extend the benefits and reach of citizen media by connecting online media activists around the world and supporting their best ideas.";

	/**
	 * Sponsors definition to be used by gv_get_sponsors()
	 */
	$gv->sponsors = array(
		'omidyar' => array(
			"name" => "Omidyar Network",
			"slug" => "omidyar",
			'description' => 'Omidyar Network - Every person has the power to make a difference.',
			"url" => "http://www.omidyar.com/",
			'status' => 'featured',
			),
		'hivos' => array(
			"name" => "Hivos",
			"slug" => "hivos",
			"description" => 'Hivos, the Humanist Institute for Development Cooperation',
			"url" => "http://www.hivos.org/",
			"status" => 'featured',
			),		
		'knight' => array(
			"name" => "Knight Foundation",
			"slug" => "knight",
			"description" => 'John S. and James L. Knight Foundation',
			"url" => "http://www.knightfdn.org/",
			"status" => 'featured',
			),
		'fpu' => array(
			"name" => "Free Press Unlimited",
			"slug" => "fpu",
			"description" => 'Free Press Unlimited - People Deserve to Know',
			"url" => "http://www.freepressunlimited.org/",
			"status" => 'featured',
			),
		'osi' => array(
			"name" => "Open Society Institute",
			"slug" => "osi",
			"description" => 'Open Society Institute - Building vibrant and tolerant democracies.',
			"url" => "http://www.soros.org/",
			"status" => 'featured',
			),
		'heinrichboll' => array(
			"name" => "Heinrich Böll Stiftung",
			"slug" => "heinrichboll",
			"description" => 'Heinrich Böll Stiftung - Striving to promote democracy, civil society, equality and a healthy environment internationally.',
			"url" => "http://www.boell.org/",
			"status" => 'featured',
			),
	);
	
	/**
	 * Filter gv_post_archive_truncate_count limit to show more posts on homepage
	 * @param type $limit
	 * @param type $args
	 * @return int
	 */
	function rv_gv_project_theme_home_truncate_count($truncate_count) {
		return 4;
	}
	add_filter('gv_project_theme_home_truncate_count', 'rv_gv_project_theme_home_truncate_count', 10);
		
	/**
	 * Define badgeset arrays for use with [gvbadges id="$slug"] shortcode
	 */

	/**
	 * General GV Badges - Based on lingua site slug
	 */
	$gv->badgesets['rising_general'] = array (
		'label' => "Rising Voices - Helping the global population join the global conversation",
		'url' => 'http://rising.globalvoicesonline.org/',
		'css' => "border:1px solid #eee;margin:3px;",
		'files' => array(
			'http://img.globalvoicesonline.org/Badges/risingvoices/rv-badge-150.gif',
			'http://img.globalvoicesonline.org/Badges/risingvoices/rv-badge-231.gif',
			'http://img.globalvoicesonline.org/Badges/risingvoices/rv-badge-400.gif',
		)
	);

	/**
	 * Define new categories to force addition of on all sites using this theme.
	 *
	 * Used to add categories to all lingua sites automatically. Array used to be defined in the function.
	 */
//	$gv->new_categories = array(
//		// Nepali Lang dec31 09
//		'Nepali' => array(
//			'slug' => 'nepali',
//			'description' => 'ne',
//			'parent' => gv_slug2cat('languages')
//		),
//	);
	
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