<?php


/*  Copyright 2009 David Gwyer (email : d.v.gwyer@presscoders.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// ------------------------------------------------------------------------
// PLUGIN PREFIX:                                                          
// ------------------------------------------------------------------------
// A PREFIX IS USED TO AVOID CONFLICTS WITH EXISTING PLUGIN FUNCTION NAMES.
// WHEN CREATING A NEW PLUGIN, CHANGE THE PREFIX AND USE YOUR TEXT EDITORS 
// SEARCH/REPLACE FUNCTION TO RENAME THEM ALL QUICKLY.                     
// ------------------------------------------------------------------------

// 'posk_' prefix is derived from [p]plugin [o]ptions [s]tarter [k]it

// ------------------------------------------------------------------------
// REGISTER HOOKS & CALLBACK FUNCTIONS:                                    
// ------------------------------------------------------------------------
// HOOKS TO SETUP DEFAULT PLUGIN OPTIONS, HANDLE CLEAN-UP OF OPTIONS WHEN
// PLUGIN IS DEACTIVATED AND DELETED, INITIALISE PLUGIN, ADD OPTIONS PAGE.
// ------------------------------------------------------------------------

// Set-up Hooks
register_activation_hook(__FILE__, 'posk_add_defaults');
register_uninstall_hook(__FILE__, 'posk_delete_plugin_options');
add_action('admin_init', 'posk_init' );
add_action('admin_menu', 'posk_add_options_page');

// --------------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_uninstall_hook(__FILE__, 'posk_delete_plugin_options')
// --------------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE USER DEACTIVATES AND DELETES THE PLUGIN. IT SIMPLY DELETES
// THE PLUGIN OPTIONS DB ENTRY (WHICH IS AN ARRAY STORING ALL THE PLUGIN OPTIONS).
// --------------------------------------------------------------------------------------

// Delete options table entries ONLY when plugin deactivated AND deleted
function posk_delete_plugin_options() {
	delete_option('posk_options');
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_activation_hook(__FILE__, 'posk_add_defaults')
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE PLUGIN IS ACTIVATED. IF THERE ARE NO THEME OPTIONS
// CURRENTLY SET, OR THE USER HAS SELECTED THE CHECKBOX TO RESET OPTIONS TO THEIR
// DEFAULTS THEN THE OPTIONS ARE SET/RESET.
//
// OTHERWISE, THE PLUGIN OPTIONS REMAIN UNCHANGED.
// ------------------------------------------------------------------------------

// Define default option settings
function posk_add_defaults() {
	$tmp = get_option('posk_options');
    if(($tmp['chk_default_options_db']=='1')||(!is_array($tmp))) {
		delete_option('posk_options'); // so we don't have to reset all the 'off' checkboxes too! (don't think this is needed but leave for now)
		$arr = array(	
			"width" => 130,
			"height" => 130,
			"front_bg_color" => "#f9f9f9",
			"front_text_color" => "#000000",
			"front_text_size" => 20,
			"back_bg_color" => "#000000",
			"back_text_color" => "#ffffff",
			"back_text_size" => 20,
		);
		update_option('posk_options', $arr);
	}
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_init', 'posk_init' )
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE 'admin_init' HOOK FIRES, AND REGISTERS YOUR PLUGIN
// SETTING WITH THE WORDPRESS SETTINGS API. YOU WON'T BE ABLE TO USE THE SETTINGS
// API UNTIL YOU DO.
// ------------------------------------------------------------------------------

// Init plugin options to white list our options
function posk_init(){
	register_setting( 'posk_plugin_options', 'posk_options', 'posk_validate_options' );
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: add_action('admin_menu', 'posk_add_options_page');
// ------------------------------------------------------------------------------
// THIS FUNCTION RUNS WHEN THE 'admin_menu' HOOK FIRES, AND ADDS A NEW OPTIONS
// PAGE FOR YOUR PLUGIN TO THE SETTINGS MENU.
// ------------------------------------------------------------------------------

// Add menu page
function posk_add_options_page() {
	add_options_page('Flashcard Settings Page', 'Flashcard', 'manage_options', __FILE__, 'posk_render_form');
}

// ------------------------------------------------------------------------------
// CALLBACK FUNCTION SPECIFIED IN: add_options_page()
// ------------------------------------------------------------------------------
// THIS FUNCTION IS SPECIFIED IN add_options_page() AS THE CALLBACK FUNCTION THAT
// ACTUALLY RENDER THE PLUGIN OPTIONS FORM AS A SUB-MENU UNDER THE EXISTING
// SETTINGS ADMIN MENU.
// ------------------------------------------------------------------------------

// Render the Plugin options form
function posk_render_form() {
	?>
	<div class="wrap">
		
		<!-- Display Plugin Icon, Header, and Description -->
		<div class="icon32" id="icon-options-general"><br></div>
		<h2>Flashcard Settings</h2>
		<p>Customize your flashcard appearance here.</p>

		<!-- Beginning of the Plugin Options Form -->
<form method="post" action="options.php">
	<?php settings_fields('posk_plugin_options'); ?>
	<?php $options = get_option('posk_options'); 

		if ($options['width']) $width = $options['width'];
		else $width = 130;

		if ($options['height']) $height = $options['height'];
		else $height = 130;

		if ($options['front_bg_color']) $front_bg_color = $options['front_bg_color'];
		else $front_bg_color = "#e9e9e9";

		if ($options['front_text_color']) $front_text_color = $options['front_text_color'];
		else $front_text_color = "#000000";

		if ($options['front_text_size']) $front_text_size = $options['front_text_size'];
		else $front_text_size = 20;

		if ($options['back_bg_color']) $back_bg_color = $options['back_bg_color'];
		else $back_bg_color = "#000000";

		if ($options['back_text_color']) $back_text_color = $options['back_text_color'];
		else $back_text_color = "#FFFFFF";

		if ($options['back_text_size']) $back_text_size = $options['back_text_size'];
		else $back_text_size = 20;


	?>

	<!-- Table Structure Containing Form Controls -->
	<!-- Each Plugin Option Defined on a New Table Row -->
	<div style="float:left;width:350px;">
		<h3 style="color:gray;margin:1em 0 .2em .2em;">Card size:</h3>
		<table class="form-table" style="background:#e9e9e9;border-radius:5px;margin:0;">
			<!-- Textbox Control -->
			<tr>
				<td style="width:60%;">Width:</td>
				<td><input type="text" size="10" name="posk_options[width]" value="<?php echo $width; ?>" />px</td>
			</tr>
			<tr>
				<td>Height:</td>
				<td><input type="text" size="10" name="posk_options[height]" value="<?php echo $height; ?>" />px</td>
			</tr>
		</table>
		<h3 style="color:gray;margin:1em 0 .2em .2em;">Front side:</h3>
		<table class="form-table" style="background:#e9e9e9;border-radius:5px;margin:0;">
			<tr>
				<td style="width:60%;">Background color(ie., #7EC0EE):</td>
				<td><input type="text" size="10" name="posk_options[front_bg_color]" value="<?php echo $front_bg_color; ?>" /></td>
			</tr>
			<tr>
				<td>Text color(ie., #000000):</td>
				<td><input type="text" size="10" name="posk_options[front_text_color]" value="<?php echo $front_text_color; ?>" /></td>
			</tr>

			<tr>
				<td style="width:60%;">Text size:</td>
				<td><input type="text" size="10" name="posk_options[front_text_size]" value="<?php echo $front_text_size; ?>" />px</td>
			</tr>
		</table>
		<h3 style="color:gray;margin:1em 0 .2em .2em;">Back side:</h3>
		<table class="form-table" style="background:#e9e9e9;border-radius:5px;margin:0;">
			<tr>
				<td style="width:60%;">Background color(ie., #C77826):</td>
				<td><input type="text" size="10" name="posk_options[back_bg_color]" value="<?php echo $back_bg_color; ?>" /></td>
			</tr>
			<tr>
				<td style="width:60%;">Text color(ie., #FFFFFF):</td>
				<td><input type="text" size="10" name="posk_options[back_text_color]" value="<?php echo $back_text_color; ?>" /></td>
			</tr>
			<tr>
				<td style="width:60%;">Text size:</td>
				<td><input type="text" size="10" name="posk_options[back_text_size]" value="<?php echo $back_text_size; ?>" />px</td>
			</tr>
		</table>
		<p class="submit">
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
		</p>
	</div>
</form>

	</div>
	<?php	
}

// Sanitize and validate input. Accepts an array, return a sanitized array.
function posk_validate_options($input) {
	 // strip html from textboxes
	$input['width'] =  wp_filter_nohtml_kses($input['width']); // Sanitize textbox input (strip html tags, and escape characters)
	$input['height'] =  wp_filter_nohtml_kses($input['height']);
	$input['front_bg_color'] =  wp_filter_nohtml_kses($input['front_bg_color']);
	$input['front_text_color'] =  wp_filter_nohtml_kses($input['front_text_color']);
	$input['front_text_size'] =  wp_filter_nohtml_kses($input['front_text_size']);
	$input['back_bg_color'] =  wp_filter_nohtml_kses($input['back_bg_color']);
	$input['back_text_color'] =  wp_filter_nohtml_kses($input['back_text_color']);
	$input['back_text_size'] =  wp_filter_nohtml_kses($input['back_text_size']);

	return $input;
}

