=== Custom Featured Posts ===

Contributors: Kafayat Faniran
Tags: custom, featured posts, homepage, category, settings
Requires at least: 5.0
Tested up to: 6.0
Stable tag: 1.0.0
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt

== Description ==

Custom Featured Posts is a WordPress plugin that allows site administrators to select a specific category of posts to be featured on the homepage. The plugin provides an easy way to showcase important posts and highlight specific content to attract visitors' attention.

== Installation ==

1. Upload the `custom-featured-posts` folder to the `/wp-content/plugins/` directory of your WordPress installation.

2. Activate the plugin through the "Plugins" menu in your WordPress admin dashboard.

3. Once activated, navigate to "Settings" > "Custom Featured Posts" in your WordPress admin dashboard to configure the plugin.

4. On the settings page, choose the category of posts you want to feature on the homepage from the dropdown list.

5. Save the settings.

6. Ensure your theme has a homepage template or a template file for the homepage content.

7. In your homepage template, call the `display_featured_posts()` function to display the featured posts section.

And the number of featured posts displayed is configurable in the plugin settings. By default, it uses the value set in the "Blog pages show at most" option in the WordPress Reading Settings.