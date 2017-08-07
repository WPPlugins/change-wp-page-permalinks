<?php
/*
Plugin Name: Change WP Page Permalinks
Plugin URI: https://www.isayantech.tk/wp-plugins
Description: This plugin is a very lightweight plugin for customize WordPress Page Permalinks.
Version: 1.1.0
Author: Sayan Datta
Author URI: https://www.isayantech.tk/
License: GPLv3
Text Domain: change-wp-page-permalinks
*/

/*  This plugin helps to customize WordPress Page Permalinks.

    Copyright 2017 Sayan Datta (email: blacknightwbs@gmail.com)

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
	
*/

//Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( !is_network_admin() ) {
//Redirect after activating plugin
register_activation_hook( __FILE__, 'cwpp_activate' );
}

add_action( 'admin_init', 'cwpp_redirect' );
function cwpp_activate() {
	add_option( 'cwpp_do_activation_redirect', true );
}

function cwpp_redirect() {
	if ( get_option( 'cwpp_do_activation_redirect', false ) ) {
		delete_option( 'cwpp_do_activation_redirect' );
		wp_redirect( 'options-general.php?page=change-wp-page-permalinks' );
	}
}

//Define custom permalink
add_action( 'init', 'cwpp_change_page_permas' );
function cwpp_change_page_permas() {
    global $wp_rewrite;
    $wp_rewrite->page_structure = $wp_rewrite->root . get_option( 'change-wp-page-perma-structure' ); 
    flush_rewrite_rules();
}

//Add admin menu
add_action( 'admin_menu', 'cwpp_admin_menu' );
function cwpp_admin_menu() {
	add_submenu_page( 'options-general.php', 'Change WP Page Permalinks', 'Change WP Page Permalinks', 'manage_options', 'change-wp-page-permalinks', 'cwpp_settings_page' );
}

function cwpp_settings_page() {
	?>
	<div class="wrap cwpp_welcome">
		<h1>Change WP Page Permalinks</h1>

		<div class="cwpp-about-text">
			Customize the default WordPress page permalink very easily.
		</div>
<form method="post" action="options.php" novalidate="novalidate">
			<?php wp_nonce_field( 'update-options' ) ?>
			<table class="form-table">
				<tr><th scope="row"><label for="change-wp-page-perma-structure">Custom Permalink Structure:</label></th>
					<td><input name="change-wp-page-perma-structure" type="text" id="change-wp-page-perma-structure" size="55"
						       value="<?php echo get_option( 'change-wp-page-perma-structure' ); ?>" placeholder="e.g. pageview/%pagename%.html" />
						<p><b>Note:</b> Use trailing slash only if it has been set in the <a href="./options-permalink.php" target="_blank">permalink structure</a>.
						</p></td></tr></table>
			<?php submit_button(); ?>		
			</p>If you like this plugin, please rate (&#9733;&#9733;&#9733;&#9733;&#9733;) this plugin. <a href="https://wordpress.org/plugins/change-wp-page-permalinks/#reviews" target="_blank">Click here</a>  to rate this plugin. Thank you!
		<br><br>Download <a href="https://wordpress.org/plugins/all-in-one-wp-solution/" target="_blank">All In One WP Solution</a> WordPress plugin for better WordPress Management.
		</form>
	</div>
	<?php
}
