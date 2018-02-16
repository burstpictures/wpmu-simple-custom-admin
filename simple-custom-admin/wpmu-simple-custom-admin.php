<?php
/**
 * @package wpmu-simple-custom-admin
 * @version 1.1
 */
/*
Plugin Name: WPMU Simple Custom Admin
Plugin URI: https://burst.pictures/
Description: Simplifies and Customizes the admin for wordpress single site and multisite, geared towards setting up multilingual sites on WPMU
Author: Eric Trometer
Version: 1.1
Author URI: https://burst.pictures/
*/

// Use this to redirect to a tempory page or old website folder on your domain whilst designing a wordpress theme on a live site
// if ( ! function_exists( 'simplify_temp_page_redirect' ) ) {
//	function simplify_temp_page_redirect() {
//	    if (!current_user_can('administrator')) {
//		wp_safe_redirect('/path/index.php',307);
//	    }
//	}
//}
//add_action('template_redirect','simplify_temp_page_redirect');

// Use and Force 1 column Dashboard
if ( ! function_exists( 'simplify_screen_layout_columns' ) ) {
	function simplify_screen_layout_columns( $columns ) {
		$columns['dashboard'] = 1;
		$columns['dashboard-network'] = 1;
		return $columns;
	}
}
add_filter( 'screen_layout_columns', 'simplify_screen_layout_columns' );

if ( ! function_exists( 'simplify_screen_layout_dashboard' ) ) {
	function simplify_screen_layout_dashboard() {
	    return 1;
	}
}
add_filter( 'get_user_option_screen_layout_dashboard', 'simplify_screen_layout_dashboard' );

// Force to 1 column on network admin page
if ( ! function_exists( 'simplify_network_screen_layout_dashboard' ) ) {
	function simplify_network_screen_layout_dashboard( $nr ) {
	    return 1;
	}
}
add_filter( 'get_user_option_screen_layout_dashboard-network', 'simplify_network_screen_layout_dashboard' );

// Remove annoying Dashboard widgets, Welcome Panel and access to help for all users
if ( ! function_exists( 'simplify_dashboard_widgets' ) ) {
	function simplify_dashboard_widgets() {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_wp_welcome_panel']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['high']['dashboard_browser_nag']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	}
}
add_action('wp_dashboard_setup', 'simplify_dashboard_widgets');

if ( ! function_exists( 'simplify_remove_welcome_panel' ) ) {
	function simplify_remove_welcome_panel() {
		remove_action('welcome_panel', 'wp_welcome_panel');
	    $user_id = get_current_user_id();
	    if (0 !== get_user_meta( $user_id, 'show_welcome_panel', true ) ) { update_user_meta( $user_id, 'show_welcome_panel', 0 ); }
	}
}
add_action( 'load-index.php', 'simplify_remove_welcome_panel' );

if ( ! function_exists( 'simplify_hide_help' ) ) {
	function simplify_hide_help() {
	    echo '<style type="text/css">
	            #contextual-help-link-wrap { display: none !important; }
	          </style>';
	}
	add_action('admin_head', 'simplify_hide_help');
}

if ( ! function_exists( 'simplify_remove_user_dashboard_widgets' ) && is_multisite( ) ) {
	function simplify_remove_user_dashboard_widgets() {
	    remove_meta_box ( 'dashboard_primary', 'dashboard-user', 'normal' ); //WordPress Blog
	    remove_meta_box ( 'dashboard_secondary', 'dashboard-user', 'normal' ); //Other WordPress News
	}
	add_action('wp_user_dashboard_setup', 'simplify_remove_user_dashboard_widgets' );
}

if ( ! function_exists( 'simplify_remove_network_dashboard_widgets' ) && is_multisite( ) ) {
	function simplify_remove_network_dashboard_widgets() {
	//   remove_meta_box ( 'network_dashboard_right_now', 'dashboard-network', 'normal' ); // Right Now
	    remove_meta_box ( 'dashboard_plugins', 'dashboard-network', 'normal' ); // Plugins
	    remove_meta_box ( 'dashboard_primary', 'dashboard-network', 'side' ); // WordPress Blog
	    remove_meta_box ( 'dashboard_secondary', 'dashboard-network', 'side' ); // Other WordPress News
	}
	add_action('wp_network_dashboard_setup', 'simplify_remove_network_dashboard_widgets' );
}

// Adds a 16px 16px logo to the admin bar when it is a single blog
if ( ! function_exists( 'simplify_add_logo' )  && ! is_multisite( ) ) {
	function simplify_add_logo() {
		echo '<style>
			#wp-admin-bar-site-name > a.ab-item:before {
				float: left;
				width: 20px;
				height: 20px;
				margin: 3px 7px 0 -5px;
				display: block;
				content: "";
				opacity: 1;
				background: url(' . content_url() .'/mu-plugins/simple-custom-admin/images/logo-20.png);
            		}
        		</style>';
	}
	add_action('admin_head', 'simplify_add_logo');
}

// White Label the footer and remove wordpress version
if ( ! function_exists( 'simplify_remove_footer_admin' ) ) {
	function simplify_remove_footer_admin () {
		echo '&copy; 2013 - <a href="http://yourdomain.com/" target="_blank">YOUR COMPANY</a>';
	}
}
add_filter('admin_footer_text', 'simplify_remove_footer_admin');

if ( ! function_exists( 'simplify_change_footer_version' ) ) {
	function simplify_change_footer_version() {
		return ' ';
	}
}
add_filter( 'update_footer', 'simplify_change_footer_version', 9999);

// custom admin login page styling
function custom_login_logo() {
	echo '<style type="text/css">
	 h1 a { background-image: url(' .content_url() .'/mu-plugins/simple-custom-admin/images/login-logo.png) !important; background-size: 90px 90px !important; height:90px !important;}
	 .login form .input {box-shadow: none; border: none; background: #fff; border-radius:0;}
	 #loginform {box-shadow: none !important; border: none !important; background: none !important;}
	 body.login {background: #efefef;}
	 .login .message, .login #login_error {border: none; border-radius:0;}
	 .login #nav, .login #backtoblog {text-shadow:none;}
	 .login #nav a, .login #backtoblog a, .login a {color: #575757 !important;}
	 .login #nav a:hover, .login #backtoblog a:hover, .login a:hover {color: #000 !important;}
	 #wp-submit {border: none; border-radius:0; background-image: none; background: #aaa; text-shadow:none; font-weight: bold; box-shadow: none;}
	 #wp-submit:hover {background: #333;}
	 select#wp_native_dashboard_language {color: #555; border: none; border-radius: 0; box-shadow: none ; background-image: none; background: #fff; -webkit-appearance: none; padding: 3px; font-family: "HelveticaNeue-Light","Helvetica Neue Light","Helvetica Neue",sans-serif; font-weight: 200; font-size: 24px; line-height: 1.2; height: 35px;}
	</style>';
}
add_action('login_head', 'custom_login_logo');

// Change the "My Sites" dropdown menu WP logos to the language flags and add the language locale at the end of the site name
if ( ! function_exists( 'simplify_add_mysites_logo' ) ) {
	function simplify_add_mysites_logo() {
		global $wp_admin_bar;
		foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {
			$menu_id  = 'blog-' . $blog->userblog_id;
			$blogname = empty( $blog->blogname ) ? $blog->domain : $blog->blogname;
			if ( is_multisite( ) ) $lang = get_blog_option( $blog->userblog_id, 'WPLANG' );
			else $lang = get_bloginfo( 'language' );
			switch($lang){
				case "":
				$language = "EN";
				$flag = "us";
				break;
				default:
				$flag = strtolower( substr( $lang, -2 ) );
				$language = strtoupper( substr( $lang, -2 ) );
				break;
			}
			$blavatar = '<img src="' . content_url() .'/mu-plugins/simple-custom-admin/flags/' . $flag .'.png" alt="' . esc_attr__( 'Blavatar' ) . '" width="16" height="11" class="blavatar"/>';
			$wp_admin_bar->add_menu( array(
				'parent'        => 'my-sites-list',
				'id'            => $menu_id,
				'title'         => $blavatar . $blogname . ' ' . $language ,
				'href'          => get_admin_url( $blog->userblog_id ) )
			);
                }
		//$wp_admin_bar->remove_node('blog-1'); // comment out this line if you are using blog-1 and want it do display in the Top Admin Bar My Sites list
		$wp_admin_bar->remove_node('comments');
		$wp_admin_bar->remove_node('new-content');
		$wp_admin_bar->remove_node('wp-logo');
		if ( is_multisite( ) ) { $wp_admin_bar->remove_node('site-name'); }
		$wp_admin_bar->remove_node('network-admin');
		$wp_admin_bar->remove_node('wpseo-menu');
		$wp_admin_bar->remove_node('search');

	if ( is_super_admin( ) && is_multisite( ) ) {
		$wp_admin_bar->add_menu( array(
					'id' 		=> 'network-administration',
					'title' 	=>  __('Network Admin') ,
					'href' 		=> get_admin_url( 1, 'network' ) 
					));

		$wp_admin_bar->add_menu( array(
					'id' 		=> 'my-sites',
					'href' 		=> '#',
					));
	}
    }
}
add_action( 'wp_before_admin_bar_render', 'simplify_add_mysites_logo' );

// Replace the name "Dashboard" for each site with the language
if ( ! function_exists( 'simplify_edit_admin_menus' ) ) {
	function simplify_edit_admin_menus() {
	    global $menu;
	    global $userblog_id;
// Uncomment if you have setup the main multisite blog as a language redirect without content
//	    if ( get_current_blog_id( ) == 1 ) {
//		$menu[2] = array( 'NOT IN USE', 'read', 'index.php', '', 'menu-top menu-top-first', 'menu-dashboard');
//	    }
//	    else {
		if ( is_multisite( ) ) { $lang = get_blog_option( $userblog_id, 'WPLANG' ); $blog_name = get_blog_option( $userblog_id, 'blogname') . " / "; }
		else { $lang = get_bloginfo( 'language' ); $blog_name = get_option('blogname') . " / "; }
		    switch($lang) {
			   case "":
				$flag = "us";
				$language = "EN";
				break;
				default:
				$flag = strtolower( substr( $lang, -2 ) );
				$language = strtoupper( substr( $lang, -2 ) );
				break;
			}
		$menu[2] = array( $blog_name . $language, 'read', 'index.php', '', 'menu-top menu-top-first', 'menu-dashboard', content_url() .'/mu-plugins/simple-custom-admin/flags/' . $flag .'.png' );
//	    }    //Uncomment if you have setup the main multisite blog as a language redirect without content
	}
}
add_action( 'admin_menu', 'simplify_edit_admin_menus' );

// switch media upload yy/mm off for newly created sites and force it for existing ones
if ( ! function_exists( 'simplify_upload_folder' ) && is_multisite( ) ) {
	function simplify_upload_folder($blog_id){
	  switch_to_blog($blog_id);
	  update_option('uploads_use_yearmonth_folders', false);
	  restore_current_blog();
	}
	add_action( 'wpmu_new_blog', 'simplify_upload_folder' );
}
add_filter( 'option_uploads_use_yearmonth_folders', '__return_false', 100 );

// Write to DB does not work!! Looking for a solution!
//if ( get_blog_option( $blog_id, 'uploads_use_yearmonth_folders' ) == true || get_option( $blog_id, 'uploads_use_yearmonth_folders' ) == '' ) {
//function simplify_upload_folder(){
//	  switch_to_blog($blog_id);
//	  update_blog_option($blog_id, 'uploads_use_yearmonth_folders', false);
//	  switch_to_blog($blog_id);
//	  update_option('uploads_use_yearmonth_folders', true);	  
//	  restore_current_blog();
//	  }
//	  add_action( 'update_wpmu_options', 'simplify_upload_folder' );
//}

// MultiSite redirect super admin to Network page after login
if ( ! function_exists( 'simplify_primary_login_redirect' ) && is_multisite( ) ) {
	function simplify_primary_login_redirect( $redirect_to, $request_redirect_to, $user ) {
	    if ( is_a( $user, 'WP_User' ) ) {
	        if ( is_super_admin( $user->ID ) ) {
	            $primary_url = network_admin_url( );
	        }
	        if ( $primary_url ) {
	            wp_redirect( $primary_url );
	            die();
	        }
	    }
	    return $redirect_to;
	} 
}
add_filter( 'login_redirect', 'simplify_primary_login_redirect', 100, 3 );
