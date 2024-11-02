=== Plugin Name ===
Plugin Name: Add To Bohemiaa
Version: 1
Plugin URI: http://www.bohemiaa.com/
Description: Adds a footer link to add the current post or page to a Bohemian Profile.
Author: Bohemiaa
Author URI: http://www.bohemiaa.com/?L=info.developer

This plugin adds a footer link to add the current post or page to a Bohemian Profile.

== Description ==
This plugin adds a footer link to add the current post or page to a Bohemiaa.  While the plugin is activated a link will appear after the content of the post with the text "Share on Bohemiaa" or the Bohemiaa icon or both. Clicking this link will bring the user to the Bohemiaa site.  If the user isn't logged in they will be prompted to do so. Once logged into Bohemiaa the post will be added to the Mini-Feed of the account.

This plugin is compatible with Wordpress 2.9+.

== Installation ==
1. Add a directory called 'add-to-bohemiaa-plugin' (without the quotes) to your '/wp-content/plugins/' directory.
2. Upload addtobohemiaa.php and addbohemiaa.png to the '/wp-content/plugins/add-to-bohemiaa-plugin/' directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Go to 'Options->Add to Bohemiaa' in your admin interface to select you options.

== CSS ==
The CSS for this plugin is found in the included bohemiaa.css file.  This file may be edited to change the style of the link.

== Options ==
There are two options on the options page: Link Type and Insertion Type.

Link Type - This option sets if you want your Bohemiaa link to be text, image or both.

Insertion Type - This option sets how you want to insert the link into your posts/pages.  There are two choices: auto or template.

* Auto - When insertion type is set to auto the Bohemiaa link will automatically be inserted right after the post.
* Template - When insertion type is set to template the Bohemiaa link will appear wherever the template tag for the plugin is added to your theme. This option requires a template tag to be added to your theme.

== Template Tag ==
The following template tag must be added to your theme in the location you want the link to appear when insertion type is set to template:

`<?php if(function_exists(addtobohemiaa)) : addtobohemiaa(); endif; ?>`