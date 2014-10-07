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
	$gv->settings['header_img'] = get_bloginfo('stylesheet_directory') . '/images/rv-header-myriad-risingbold-600.png';

	/**
	 * Enable Featured posts - Tells GV Query Manipulation to prefetch featured posts before main loop and exclude their ids.
	 * @see gv_load_featured_posts()
	 */
	$gv->use_featured_posts = true;
	
	/**
	 * Hide tags interface completely to avoid people using them
	 * @see gv_hide_tags_ui()
	 */
	add_filter('gv_hide_tags_ui', '__return_true');
	
	/**
	 * Filter the favicon directory used by gv_display_head_icons()
	 * 
	 * @param string $dir Default directory (no trailing /) to find favicons in
	 * @return string desired directory (no trailing /)
	 */
	function risingvoices_theme_gv_favicon_dir($dir) {
		return 'https://s3.amazonaws.com/static.globalvoices/img/tmpl/favicon-rv';
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
		return gv_get_dir('theme_images') ."rv-logo-square-600.png";
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
	 * @see gv_lingua::reply_to_ping()
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
//	add_filter('gv_project_theme_home_truncate_count', 'rv_gv_project_theme_home_truncate_count', 10);
	
	/**
	 * Filter gv_post_archive_hide_dates to hide them on hoempage
	 * @param type $limit
	 * @param type $args
	 * @return int
	 */
	function rv_gv_post_archive_hide_dates($hide_dates) {
		if (is_home() AND !is_paged())
			return true;
		
		return $hide_dates;
	}
	add_filter('gv_post_archive_hide_dates', 'rv_gv_post_archive_hide_dates', 10);
	
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
	
/**
 * Register CSS variants specific to the this theme
 * 
 * Attached to 'wp' action so as to come before wp_head where gv_output_css_variants acts
 * 
 * @see gv_add_css_variant() which is used to register variants
 * @see gv_output_css_variants() which echos out the CSS of variants activated by ?gv_css_variant=$variant_label
 */
function risingvoices_css_variants() {

	gv_add_css_variant(array(
		'label' => 'logo_myriad_allbold',
		'css' => "",
	));
	gv_add_css_variant(array(
		'label' => 'dark_carolina_blue_header',
		'css' => "
#MEDIUM-BLUE-GRADIENT,
.header-container,
.header-nav-bar-container,
.medium-blue-gradient {
/*http://css-tricks.com/examples/CSS3Gradient/*/
	background-color: #5CABFF;
}
#TEXT-SHADOW-MEDIUM-BLUE-BACKGROUND,
.header-mission-statement,
.header-mission-statement a,
.header-container,
.header-nav-bar-container,
.header-nav-bar-container a,
.text-shadow-medium-blue {
	/*color: #fff;*/
	text-shadow: 1px 1px 2px #4794E6;
	}
#MEDIUM-BLUE-HIGHLIGHT-BORDER,
.header-menu li,
.header-menu-container input,
.medium-blue-hightlight-border {
	/* Lightest shade of green from medium-green-gradient*/
	border-color: #4794E6;
}
.header-container .site-search input[type='submit'] {
	background-color: #4794E6;
}
.header-container .site-search input {
	outline: 1px solid #4794E6;
}
		",
	));
	gv_add_css_variant(array(
		'label' => 'old_blue_header',
		'css' => "
#MEDIUM-BLUE-GRADIENT,
.header-container,
.header-nav-bar-container,
.medium-blue-gradient {
/*http://css-tricks.com/examples/CSS3Gradient/*/
	background-color: #6CBBFF;
}
#TEXT-SHADOW-MEDIUM-BLUE-BACKGROUND,
.header-mission-statement,
.header-mission-statement a,
.header-container,
.header-nav-bar-container,
.header-nav-bar-container a,
.text-shadow-medium-blue {
	/*color: #fff;*/
	text-shadow: 1px 1px 2px #3086D0;
	}
#MEDIUM-BLUE-HIGHLIGHT-BORDER,
.header-menu li,
.header-menu-container input,
.medium-blue-hightlight-border {
	/* Lightest shade of green from medium-green-gradient*/
	border-color: #3086D0;
}
.header-container .site-search input[type='submit'] {
	background-color: #3086D0;
}
.header-container .site-search input {
	outline: 1px solid #3086D0;
}
		",
	));
}
add_action('wp', 'risingvoices_css_variants');
	
/**
 * Red Header variant: jQuery to replace default header image
 * 
 * Makes it so that if red_header CSS variant is active the header image is automatically
 * replced with an all-white version. 
 * 
 * DELETE when the variant is no longer needed.
 */
function risingvoices_css_variant_js() {
	
	/**
	 * TEMPORARY: keep it emabled all the time, unless white_header is enabled
	 */
//	if (!gv_is_active_css_variant('white_header') AND !gv_is_active_css_variant('white_header_white_stripe'))
//		gv_activate_css_variant('red_header');
	
	/**
	 * If red header is active replace the logo with a white version
	 */
	if (gv_is_active_css_variant('logo_myriad_allbold')) :

		$alt_header_url = get_stylesheet_directory_uri() . '/images/rv-header-myriad-allbold-600.png';

		echo "
<script type='text/javascript'>
	jQuery(document).ready(function($) {
		$('#logo').attr('src', '$alt_header_url');
			console.log('test');
	});
</script>
		";
	endif;
}
add_action('wp_head', 'risingvoices_css_variant_js');
	
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