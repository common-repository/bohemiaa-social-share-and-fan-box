<?php 
/* 
Plugin Name: Bohemiaa Fan Box
Plugin URI: http://www.bohemiaa.com/?L=info.developer
Description: Displays a Bohemiaa Fan Box
Version: 1.0
Author: Bohemiaa Social
Author URI: http://www.bohemiaa.com/
*/


$bha_options['widget_fields']['profile_id'] = array('label'=>'Blog ID:', 'type'=>'text', 'default'=>'', 'class'=>'widefat', 'size'=>'', 'help'=>'');


function bohemiaa_fan_box($profile_id, $css  = '' ) {
	

	
  $output = '';
  if ($profile_id != '') {

      
      $output = '<iframe scrolling="no" frameborder="0" class="iframe"  src="http://www.bohemiaa.com/fanbox/connect.php?article='.$profile_id.'&css=' . $css . '" >&nbsp;</iframe>';
    }
 
  echo $output;
}





function widget_bha_init() {

	if ( !function_exists('register_sidebar_widget') )
		return;
	
	$check_options = get_option('widget_bha');
  
	function widget_bha($args) {

		global $bha_options;
		
		// $args is an array of strings that help widgets to conform to
		// the active theme: before_widget, before_title, after_widget,
		// and after_title are the array keys. Default tags: li and h2.
		extract($args);
		
		$options = get_option('widget_bha');
		
		// fill options with default values if value is not set
		$item = $options;
		foreach($bha_options['widget_fields'] as $key => $field) {
			if (! isset($item[$key])) {
				$item[$key] = $field['default'];
			}
		}    
		
    
    $profile_id = $item['profile_id'];
    
	 $css = $item['css'];
    
  if ($css == ''){
		$css =   get_bloginfo('wpurl'). "/wp-content/plugins/bohemiaa-social-fan-box/fanbox.css";
	}

	
	
		// These lines generate our output.
    echo $before_widget;
    bohemiaa_fan_box($profile_id, $css);
		echo $after_widget;
				
	}

	// This is the function that outputs the form to let the users edit
	// the widget's title. It's an optional feature that users cry for.
	function widget_bha_control() {
	
		global $bha_options;

		// Get our options and see if we're handling a form submission.
		$options = get_option('widget_bha');
		if ( isset($_POST['bha-submit']) ) {

			foreach($bha_options['widget_fields'] as $key => $field) {
				$options[$key] = $field['default'];
				$field_name = sprintf('%s', $key);        
				if ($field['type'] == 'text') {
					$options[$key] = strip_tags(stripslashes($_POST[$field_name]));
				} elseif ($field['type'] == 'checkbox') {
					$options[$key] = isset($_POST[$field_name]);
				}
			}

			update_option('widget_bha', $options);
		}
    
		foreach($bha_options['widget_fields'] as $key => $field) {
			$field_name = sprintf('%s', $key);
			$field_checked = '';
			if ($field['type'] == 'text') {
				$field_value = (isset($options[$key])) ? htmlspecialchars($options[$key], ENT_QUOTES) : htmlspecialchars($field['default'], ENT_QUOTES);
			} elseif ($field['type'] == 'checkbox') {
				$field_value = (isset($options[$key])) ? $options[$key] :$field['default'] ;
				if ($field_value == 1) {
					$field_checked = 'checked="checked"';
				}
			}
      $jump = ($field['type'] != 'checkbox') ? '<br />' : '&nbsp;';
      $field_class = $field['class'];
      $field_size = ($field['class'] != '') ? '' : 'size="'.$field['size'].'"';
      $field_help = ($field['help'] == '') ? '' : '<small>'.$field['help'].'</small>';
			printf('<p class="bha_field"><label for="%s">%s</label>%s<input id="%s" name="%s" type="%s" value="%s" class="%s" %s %s /> %s</p>',
		  $field_name, __($field['label']), $jump, $field_name, $field_name, $field['type'], $field_value, $field_class, $field_size, $field_checked, $field_help);
		}

		echo '<input type="hidden" id="bha-submit" name="bha-submit" value="1" />';
	}	
	
	function widget_bha_register() {		
    $title = 'Bohemiaa Fan Box';
    // Register widget for use
    register_sidebar_widget($title, 'widget_bha');    
    // Register settings for use, 300x100 pixel form
    register_widget_control($title, 'widget_bha_control');
	}

	widget_bha_register();
}

// Run our code later in case this loads prior to any required plugins.
add_action('widgets_init', 'widget_bha_init');





?>

<?php 


// Create the options page
function bohemiaa_fan_options_page() { 
	$current_options = get_option('widget_bha');
	
	$insert = $current_options["profile_id"];
	if ($_POST['action']){ ?>
		<div id="message" class="updated fade"><p><strong>Options saved.</strong></p></div>
	<?php } ?>
	<div class="wrap" id="add-to-bohemiaa-options">
		<h2>Bohemiaa Fan Box Options</h2>
		
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']; ?>">
			<fieldset>
				
				<input type="hidden" name="action" value="save_bohemiaa_fan_options" />
				<table width="100%" cellspacing="2" cellpadding="5" class="editform">
				
					<tr>
						<th valign="top" scope="row"><label for="profile_id">Blog ID:</label></th>
						<td><input name="profile_id" title="text" value="<?php  print $insert; ?>"/>
						</td>
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

function bohemiaa_fan_add_options_page() {
	// Add a new menu under Options:
	add_options_page('Bohemiaa Fan Box', 'Bohemiaa Fan Box', 10, __FILE__, 'bohemiaa_fan_options_page');
}

function bohemiaa_fan_save_options() {
	// create array
	
	$bohemiaa_fan_options["profile_id"] = $_POST["profile_id"];
	
	update_option('widget_bha', $bohemiaa_fan_options);
	$options_saved = true;
}

add_action('admin_menu', 'bohemiaa_fan_add_options_page');

if (!get_option('bohemiaa_fan_options')){
	// create default options
	
	$bohemiaa_fan_options["profile_id"] = 'text';
	
	update_option('bohemiaa_fan_options', $bohemiaa_fan_options);
}

if ($_POST['action'] == 'save_bohemiaa_fan_options'){
	bohemiaa_fan_save_options();
}

?>




<?php
function fanboxcss() {
	?>
	<link rel="stylesheet" href="<?php bloginfo('wpurl'); ?>/wp-content/plugins/bohemiaa-social-fan-box/fanbox.css" type="text/css" media="screen" />
	<?php
}

add_action('wp_head', 'fanboxcss');
?>
