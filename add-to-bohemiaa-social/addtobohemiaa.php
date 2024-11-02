<?php
/*
Plugin Name: Add To Bohemiaa
Version: 1
Plugin URI: http://www.bohemiaa.com/
Description: Adds a footer link to add the current post or page to a Bohemiaa Mini-Feed.
Author: Bohemiaa
Author URI: http://www.bohemiaa.com/
*/

function add_to_bohemiaa($data){
	global $post;
	$current_options = get_option('add_to_bohemiaa_options');
	$linktype = $current_options['link_type'];
	switch ($linktype) {
		case "text":
			$data=$data."<p class=\"bohemiaa\"><a href=\"javascript:void(0);\" onclick=\"window.open('http://www.bohemiaa.com/index.php?L=users.share&link=".get_permalink($post->ID)."','BohemiaaShare','width=694,height=500');\"  title=\"Share on Bohemiaa\">Share on Bohemiaa</a></p>";
			break;
		case "image":
			$data=$data."<p class=\"bohemiaa\"><a href=\"javascript:void(0);\" onclick=\"window.open('http://www.bohemiaa.com/index.php?L=users.share&link=".get_permalink($post->ID)."','BohemiaaShare','width=694,height=500');\" ><img src=\"".get_bloginfo(wpurl)."/wp-content/plugins/add-to-bohemiaa-plugin/addbohemiaa.png\" width=\"48px\" alt=\"Share on Bohemiaa\" title=\"Share on Bohemiaa\" /></a></p>";
			break;
		case "both":
			$data=$data."<p class=\"bohemiaa\"><a href=\"javascript:void(0);\" onclick=\"window.open('http://www.bohemiaa.com/index.php?L=users.share&link=".get_permalink($post->ID)."','BohemiaaShare','width=694,height=500');\" ><img src=\"".get_bloginfo(wpurl)."/wp-content/plugins/add-to-bohemiaa-plugin/addbohemiaa.png\" width=\"48px\" alt=\"Share on Bohemiaa\" title=\"Share on Bohemiaa\" /></a><a href=\"javascript:void(0);\" onclick=\"window.open('http://www.bohemiaa.com/index.php?L=users.share&link=".get_permalink($post->ID)."','BohemiaaShare','width=694,height=500');\"  title=\"Share on bohemiaa\">Share on Bohemiaa</a></p>";
			break;
		}
		return $data;
}

function activate_add_to_bohemiaa(){
	global $post;
	$current_options = get_option('add_to_bohemiaa_options');
	$insertiontype = $current_options['insertion_type'];
	if ($insertiontype != 'template'){
		add_filter('the_content', 'add_to_bohemiaa', 10);
		add_filter('the_excerpt', 'add_to_bohemiaa', 10);
	}
}

activate_add_to_bohemiaa();

function addtobohemiaa(){
	global $post;
	$current_options = get_option('add_to_bohemiaa_options');
	$insertiontype = $current_options['insertion_type'];
	if ($insertiontype != 'auto'){
		$linktype = $current_options['link_type'];
		switch ($linktype) {
			case "text":
				echo "<p class=\"bohemiaa\"><a href=\"javascript:void(0);\" onclick=\"window.open('http://www.bohemiaa.com/index.php?L=users.share&link=".get_permalink($post->ID)."','BohemiaaShare','width=694,height=500');\"  title=\"Share on Bohemiaa\">Share on Bohemiaa</a></p>";
				break;
			case "image":
				echo "<p class=\"bohemiaa\"><a href=\"javascript:void(0);\" onclick=\"window.open('http://www.bohemiaa.com/index.php?L=users.share&link=".get_permalink($post->ID)."','BohemiaaShare','width=694,height=500');\" ><img src=\"".get_bloginfo(wpurl)."/wp-content/plugins/add-to-bohemiaa-plugin/addbohemiaa.png\" width=\"48px\" alt=\"Share on Bohemiaa\" title=\"Share on Bohemiaa\" /></a></p>";
				break;
			case "both":
				echo "<p class=\"bohemiaa\"><a href=\"http://www.bohemiaa.com/index.php?L=users.share&link=".get_permalink($post->ID)."\" ><img src=\"".get_bloginfo(wpurl)."/wp-content/plugins/add-to-bohemiaa-plugin/addbohemiaa.png\" width=\"48px\" alt=\"Share on Bohemiaa\" title=\"Share on Bohemiaa\" /></a><a href=\"javascript:void(0);\" onclick=\"window.open('http://www.bohemiaa.com/index.php?L=users.share&link=".get_permalink($post->ID)."','BohemiaaShare','width=694,height=500');\"  title=\"Share on Bohemiaa\">Share on Bohemiaa</a></p>";
				break;
			}
		}
}

// Create the options page
function add_to_bohemiaa_options_page() { 
	$current_options = get_option('add_to_bohemiaa_options');
	$link = $current_options["link_type"];
	$insert = $current_options["insertion_type"];
	if ($_POST['action']){ ?>
		<div id="message" class="updated fade"><p><strong>Options saved.</strong></p></div>
	<?php } ?>
	<div class="wrap" id="add-to-bohemiaa-options">
		<h2>Add to Bohemiaa Options</h2>
		
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
			<fieldset>
				<legend>Options:</legend>
				<input type="hidden" name="action" value="save_add_to_bohemiaa_options" />
				<table width="100%" cellspacing="2" cellpadding="5" class="editform">
					<tr>
						<th valign="top" scope="row"><label for="link_type">Link Type:</label></th>
						<td><select name="link_type">
						<option value ="text"<?php if ($link == "text") { print " selected"; } ?>>Text Only</option>
						<option value ="image"<?php if ($link == "image") { print " selected"; } ?>>Image Only</option>
						<option value ="both"<?php if ($link == "both") { print " selected"; } ?>>Image and Text</option>
						</select></td>
					</tr>
					<tr>
						<th valign="top" scope="row"><label for="insertion_type">Insertion Type:</label></th>
						<td><select name="insertion_type">
						<option value ="auto"<?php if ($insert == "auto") { print " selected"; } ?>>Auto</option>
						<option value ="template"<?php if ($insert == "template") { print " selected"; } ?>>Template</option>
						</select></td>
					</tr>
				</table>
			</fieldset>
			<p class="submit">
				<input type="submit" name="Submit" value="Update Options &raquo;" />
			</p>
		</form>
	</div>
<?php 
}

function add_to_bohemiaa_add_options_page() {
	// Add a new menu under Options:
	add_options_page('Add to Bohemiaa', 'Add to Bohemiaa', 10, __FILE__, 'add_to_bohemiaa_options_page');
}

function add_to_bohemiaa_save_options() {
	// create array
	$add_to_bohemiaa_options["link_type"] = $_POST["link_type"];
	$add_to_bohemiaa_options["insertion_type"] = $_POST["insertion_type"];
	
	update_option('add_to_bohemiaa_options', $add_to_bohemiaa_options);
	$options_saved = true;
}

add_action('admin_menu', 'add_to_bohemiaa_add_options_page');

if (!get_option('add_to_bohemiaa_options')){
	// create default options
	$add_to_bohemiaa_options["link_type"] = 'text';
	$add_to_bohemiaa_options["insertion_type"] = 'auto';
	
	update_option('add_to_bohemiaa_options', $add_to_bohemiaa_options);
}

if ($_POST['action'] == 'save_add_to_bohemiaa_options'){
	add_to_bohemiaa_save_options();
}

function bohemiaacss() {
	?>
	<link rel="stylesheet" href="<?php bloginfo('wpurl'); ?>/wp-content/plugins/add-to-bohemiaa-plugin/bohemiaa.css" type="text/css" media="screen" />
	<?php
}

add_action('wp_head', 'bohemiaacss');
?>