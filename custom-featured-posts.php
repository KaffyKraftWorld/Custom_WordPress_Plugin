<?php
/**
 * Plugin Name: Custom Featured Posts
 * Plugin URI: /#
 * Description: This plugin allows site administrators to select a specific category of posts to be featured on the homepage.
 * Version: 1.0.0
 * Author: Kafayat Faniran
 * Author URI: https://www.linkedin.com/in/kafayatfaniran
 * License: GPL -2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: custom-featured-posts
 */

// Preventing direct access to this file.
if (!defined('ABSPATH')) {
    die('Keep off!');
}

class CustomFeaturedPosts
{
    /**
     * Activate the plugin
     */
    public static function activate()
    {
        // No activation task needed.
    }

    /**
     * Deactivate the plugin
     */
    public static function deactivate()
    {
        // No deactivation task needed.
    }

    /**
     * Adding the admin menu page
     *
     * And hook it into WordPress admin menu to add the settings page.
     */
    public function add_admin_menu()
    {
        add_options_page(
            'Custom Featured Posts Settings',
            'Custom Featured Posts',
            'manage_options',
            'custom-featured-posts',
            array($this, 'render_settings_page')
        );
    }

    /**
     * Rendering the settings page
     *
     * To display the settings page content in the WordPress admin area.
     */
    public function render_settings_page()
    {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e('Custom Featured Posts Settings', 'custom-featured-posts'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('custom-featured-posts');
                do_settings_sections('custom-featured-posts');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    /**
     * Registering the plugin settings
     *
     * And hook into WordPress settings API so it can register the settings and sections.
     */
    public function register_settings()
    {
        add_settings_section(
            'custom_featured_posts_section',
            __('Featured Category Selection', 'custom-featured-posts'),
            array($this, 'section_callback'),
            'custom-featured-posts'
        );

        add_settings_field(
            'featured_category',
            __('Select Featured Category', 'custom-featured-posts'),
            array($this, 'category_dropdown_callback'),
            'custom-featured-posts',
            'custom_featured_posts_section'
        );

        register_setting('custom-featured-posts', 'featured_category');
    }

    /**
     * Settings section callback
     *
     * The callback function for the featured category settings section.
     */
    public function section_callback()
    {
        // !
    }

    /**
     * The category dropdown callback
     *
     * Callback function that will render the category dropdown in the settings page.
     */
    public function category_dropdown_callback()
    {
        $categories = get_categories();
        $featured_category = get_option('featured_category');

        if (!empty($categories)) {
            echo '<select name="featured_category">';
            echo '<option value="">Select a category</option>';
            foreach ($categories as $category) {
                echo '<option value="' . esc_attr($category->term_id) . '" ' . selected($featured_category, $category->term_id, false) . '>' . esc_html($category->name) . '</option>';
            }
            echo '</select>';
        } else {
            echo '<p>' . esc_html__('No categories found.', 'custom-featured-posts') . '</p>';
        }
    }

    /**
     * Displaying the featured posts
     *
     * And hooking it into the homepage so it can display the featured posts.
     */
    public function display_featured_posts()
    {
        $featured_category = get_option('featured_category');

        if ($featured_category) {
            $args = array(
                'cat'           => $featured_category,
                'posts_per_page' => get_option('posts_per_page'),
            );

            $featured_posts = new WP_Query($args);

            if ($featured_posts->have_posts()) {
                echo '<div class="custom-featured-posts">';
                while ($featured_posts->have_posts()) {
                    $featured_posts->the_post();
                    ?>
                    <article <?php post_class(); ?>>
                        <h2><?php the_title(); ?></h2>
                        <?php the_excerpt(); ?>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="featured-image"><?php the_post_thumbnail(); ?></div>
                        <?php endif; ?>
                    </article>
                    <?php
                }
                echo '</div>';
                wp_reset_postdata();
            }
        }
    }

    /**
     * Enqueueing the custom CSS styles
     *
     * Hooking it into WordPress to enqueue the stylesheet on the homepage.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style('custom-featured-posts-style', plugin_dir_url(__FILE__) . 'css/custom-featured-posts.css');
    }
}

// Now, registering the activation and deactivation hooks.
register_activation_hook(__FILE__, array('CustomFeaturedPosts', 'activate'));
register_deactivation_hook(__FILE__, array('CustomFeaturedPosts', 'deactivate'));

// Instantiating the plugin classes and setting up the hooks.
$custom_featured_posts = new CustomFeaturedPosts();

// This hook into the WordPress admin menu to add the settings page.
add_action('admin_menu', array($custom_featured_posts, 'add_admin_menu'));

// This hook into WordPress settings API to register settings.
add_action('admin_init', array($custom_featured_posts, 'register_settings'));

// This hook into the homepage to display the featured posts.
add_action('homepage', array($custom_featured_posts, 'display_featured_posts'));

// And this hook into WordPress to enqueue the stylesheet on the homepage.
add_action('wp_enqueue_scripts', array($custom_featured_posts, 'enqueue_styles'));
