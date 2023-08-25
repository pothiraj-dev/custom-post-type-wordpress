<?php
/**
 * Theme functions and definitions
 *
 * @package HelloElementor
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

define('HELLO_ELEMENTOR_VERSION', '2.8.1');

if (!isset($content_width)) {
	$content_width = 800; // Pixels.
}

if (!function_exists('hello_elementor_setup')) {
	/**
	 * Set up theme support.
	 *
	 * @return void
	 */
	function hello_elementor_setup()
	{
		if (is_admin()) {
			hello_maybe_update_theme_version_in_db();
		}

		if (apply_filters('hello_elementor_register_menus', true)) {
			register_nav_menus(['menu-1' => esc_html__('Header', 'hello-elementor')]);
			register_nav_menus(['menu-2' => esc_html__('Footer', 'hello-elementor')]);
		}

		if (apply_filters('hello_elementor_post_type_support', true)) {
			add_post_type_support('page', 'excerpt');
		}

		if (apply_filters('hello_elementor_add_theme_support', true)) {
			add_theme_support('post-thumbnails');
			add_theme_support('automatic-feed-links');
			add_theme_support('title-tag');
			add_theme_support(
				'html5',
				[
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
					'script',
					'style',
				]
			);
			add_theme_support(
				'custom-logo',
				[
					'height' => 100,
					'width' => 350,
					'flex-height' => true,
					'flex-width' => true,
				]
			);

			/*
			 * Editor Style.
			 */
			add_editor_style('classic-editor.css');

			/*
			 * Gutenberg wide images.
			 */
			add_theme_support('align-wide');

			/*
			 * WooCommerce.
			 */
			if (apply_filters('hello_elementor_add_woocommerce_support', true)) {
				// WooCommerce in general.
				add_theme_support('woocommerce');
				// Enabling WooCommerce product gallery features (are off by default since WC 3.0.0).
				// zoom.
				add_theme_support('wc-product-gallery-zoom');
				// lightbox.
				add_theme_support('wc-product-gallery-lightbox');
				// swipe.
				add_theme_support('wc-product-gallery-slider');
			}
		}
	}
}
add_action('after_setup_theme', 'hello_elementor_setup');

function hello_maybe_update_theme_version_in_db()
{
	$theme_version_option_name = 'hello_theme_version';
	// The theme version saved in the database.
	$hello_theme_db_version = get_option($theme_version_option_name);

	// If the 'hello_theme_version' option does not exist in the DB, or the version needs to be updated, do the update.
	if (!$hello_theme_db_version || version_compare($hello_theme_db_version, HELLO_ELEMENTOR_VERSION, '<')) {
		update_option($theme_version_option_name, HELLO_ELEMENTOR_VERSION);
	}
}

if (!function_exists('hello_elementor_scripts_styles')) {
	/**
	 * Theme Scripts & Styles.
	 *
	 * @return void
	 */
	function hello_elementor_scripts_styles()
	{
		$min_suffix = defined('SCRIPT_DEBUG') && SCRIPT_DEBUG ? '' : '.min';

		if (apply_filters('hello_elementor_enqueue_style', true)) {
			wp_enqueue_style(
				'hello-elementor',
				get_template_directory_uri() . '/style' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}

		if (apply_filters('hello_elementor_enqueue_theme_style', true)) {
			wp_enqueue_style(
				'hello-elementor-theme-style',
				get_template_directory_uri() . '/theme' . $min_suffix . '.css',
				[],
				HELLO_ELEMENTOR_VERSION
			);
		}
	}
}
add_action('wp_enqueue_scripts', 'hello_elementor_scripts_styles');

if (!function_exists('hello_elementor_register_elementor_locations')) {
	/**
	 * Register Elementor Locations.
	 *
	 * @param ElementorPro\Modules\ThemeBuilder\Classes\Locations_Manager $elementor_theme_manager theme manager.
	 *
	 * @return void
	 */
	function hello_elementor_register_elementor_locations($elementor_theme_manager)
	{
		if (apply_filters('hello_elementor_register_elementor_locations', true)) {
			$elementor_theme_manager->register_all_core_location();
		}
	}
}
add_action('elementor/theme/register_locations', 'hello_elementor_register_elementor_locations');

if (!function_exists('hello_elementor_content_width')) {
	/**
	 * Set default content width.
	 *
	 * @return void
	 */
	function hello_elementor_content_width()
	{
		$GLOBALS['content_width'] = apply_filters('hello_elementor_content_width', 800);
	}
}
add_action('after_setup_theme', 'hello_elementor_content_width', 0);

if (is_admin()) {
	require get_template_directory() . '/includes/admin-functions.php';
}

/**
 * If Elementor is installed and active, we can load the Elementor-specific Settings & Features
 */

// Allow active/inactive via the Experiments
require get_template_directory() . '/includes/elementor-functions.php';

/**
 * Include customizer registration functions
 */
function hello_register_customizer_functions()
{
	if (is_customize_preview()) {
		require get_template_directory() . '/includes/customizer-functions.php';
	}
}
add_action('init', 'hello_register_customizer_functions');

if (!function_exists('hello_elementor_check_hide_title')) {
	/**
	 * Check hide title.
	 *
	 * @param bool $val default value.
	 *
	 * @return bool
	 */
	function hello_elementor_check_hide_title($val)
	{
		if (defined('ELEMENTOR_VERSION')) {
			$current_doc = Elementor\Plugin::instance()->documents->get(get_the_ID());
			if ($current_doc && 'yes' === $current_doc->get_settings('hide_title')) {
				$val = false;
			}
		}
		return $val;
	}
}
add_filter('hello_elementor_page_title', 'hello_elementor_check_hide_title');

if (!function_exists('hello_elementor_add_description_meta_tag')) {
	/**
	 * Add description meta tag with excerpt text.
	 *
	 * @return void
	 */
	function hello_elementor_add_description_meta_tag()
	{
		$post = get_queried_object();

		if (is_singular() && !empty($post->post_excerpt)) {
			echo '<meta name="description" content="' . esc_attr(wp_strip_all_tags($post->post_excerpt)) . '">' . "\n";
		}
	}
}
add_action('wp_head', 'hello_elementor_add_description_meta_tag');

/**
 * BC:
 * In v2.7.0 the theme removed the `hello_elementor_body_open()` from `header.php` replacing it with `wp_body_open()`.
 * The following code prevents fatal errors in child themes that still use this function.
 */
if (!function_exists('hello_elementor_body_open')) {
	function hello_elementor_body_open()
	{
		wp_body_open();
	}
}

function custom_recipe_post_type()
{
	$labels = array(
		'name' => 'Recipes',
		'singular_name' => 'Recipe',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Recipe',
		'edit_item' => 'Edit Recipe',
		'new_item' => 'New Recipe',
		'view_item' => 'View Recipe',
		'search_items' => 'Search Recipes',
		'not_found' => 'No recipes found',
		'not_found_in_trash' => 'No recipes found in Trash',
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'has_archive' => true,
		'menu_position' => 5,
		'menu_icon' => 'dashicons-carrot',
		// Example icon
		'supports' => array('title', 'editor', 'thumbnail'),
	);

	register_post_type('recipe', $args);
}
add_action('init', 'custom_recipe_post_type');

function add_recipe_metabox()
{
	add_meta_box(
		'recipe_ingredients',
		'Recipe',
		'render_recipe_metabox',
		'recipe',
		'normal',
		'high'
	);
}
add_action('add_meta_boxes', 'add_recipe_metabox');

function render_recipe_metabox($post)
{
	$ingredients = get_post_meta($post->ID, 'recipe_ingredients', true);
	$recipe_time = get_post_meta($post->ID, 'recipe_time', true);
	$recipe_servings = get_post_meta($post->ID, 'recipe_servings', true);
	$recipe_nutrition = get_post_meta($post->ID, 'recipe_nutrition', true);
	$recipe_editers_note = get_post_meta($post->ID, 'recipe_editers_note', true);
	$recipe_type = get_post_meta($post->ID, 'recipe_type', true);
	$recipe_options = array(
		'Veg' => 'Veg',
		'Non-Veg' => 'Non-Veg',
		// Add more options as needed
	);
	?>
	<label for="recipe_ingredients"><b>Ingredients :</b></label><br><br>
	<textarea style="width: 100%; max-width: 100%;" rows="10" id="recipe_ingredients"
		name="recipe_ingredients"><?php echo esc_textarea($ingredients); ?></textarea>
	<br><br>
	<label for="recipe_time"><b>Time :</b></label><br><br>
	<input style="width: 100%; max-width: 100%;" type="text" id="recipe_time" name="recipe_time"
		value="<?php echo esc_attr($recipe_time); ?>">
	<br><br>
	<label for="recipe_servings"><b>Servings :</b></label><br><br>
	<input style="width: 100%; max-width: 100%;" type="text" id="recipe_servings" name="recipe_servings"
		value="<?php echo esc_attr($recipe_servings); ?>">
	<br><br>
	<label for="recipe_nutrition "><b>Nutrition :</b></label><br><br>
	<textarea style="width: 100%; max-width: 100%;" rows="10" type="text" id="recipe_nutrition"
		name="recipe_nutrition"><?php echo esc_textarea($recipe_nutrition); ?></textarea>
	<br><br>
	<label for="recipe_editers_note "><b>Editor’s Note :</b></label><br><br>
	<textarea style="width: 100%; max-width: 100%;" rows="10" type="text" id="recipe_editers_note"
		name="recipe_editers_note"><?php echo esc_textarea($recipe_editers_note); ?></textarea>
	<br><br>
	<label for="recipe_type"><b>Type :</b></label><br><br>
	<select style="width: 100%; max-width: 100%;" id="recipe_type" name="recipe_type">
		<option value="">Select Type</option>
		<?php
		foreach ($recipe_options as $value => $label) {
			echo '<option value="' . esc_attr($value) . '"' . selected($recipe_type, $value, false) . '>' . esc_html($label) . '</option>';
		}
		?>
	</select>
	<?php
}
function save_recipe_metabox($post_id)
{
	if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
		return;
	if (isset($_POST['recipe_ingredients'])) {
		update_post_meta($post_id, 'recipe_ingredients', sanitize_text_field($_POST['recipe_ingredients']));
	}
	if (isset($_POST['recipe_time'])) { // Add this section
		update_post_meta($post_id, 'recipe_time', sanitize_text_field($_POST['recipe_time']));
	}
	if (isset($_POST['recipe_servings'])) { // Add this section
		update_post_meta($post_id, 'recipe_servings', sanitize_text_field($_POST['recipe_servings']));
	}
	if (isset($_POST['recipe_nutrition'])) { // Add this section
		update_post_meta($post_id, 'recipe_nutrition', sanitize_text_field($_POST['recipe_nutrition']));
	}
	if (isset($_POST['recipe_editers_note'])) { // Add this section
		update_post_meta($post_id, 'recipe_editers_note', sanitize_text_field($_POST['recipe_editers_note']));
	}
	if (isset($_POST['recipe_type'])) {
		update_post_meta($post_id, 'recipe_type', sanitize_text_field($_POST['recipe_type']));
	}
}
add_action('save_post_recipe', 'save_recipe_metabox');
function display_ingredients()
{
	$ingredients = get_post_meta(get_the_ID(), 'recipe_ingredients', true);
	if ($ingredients) {
		echo '<div class="recipe-ingredients">' . wpautop($ingredients) . '</div>';
	}

}
function display_recipe_time()
{
	$recipe_time = get_post_meta(get_the_ID(), 'recipe_time', true);

	if ($recipe_time) {
		echo '<div class="recipe-time">' . esc_html($recipe_time) . '</div>';
	}
}

function display_recipe_servings()
{
	$recipe_servings = get_post_meta(get_the_ID(), 'recipe_servings', true);

	if ($recipe_servings) {
		echo '<div class="recipe-servings">' . esc_html($recipe_servings) . '</div>';
	}
}
function display_recipe_nutrition()
{
	$recipe_nutrition = get_post_meta(get_the_ID(), 'recipe_nutrition', true);

	if ($recipe_nutrition) {
		echo '<div class="recipe-servings">' . esc_html($recipe_nutrition) . '</div>';
	}
}
function display_recipe_editers_note()
{
	$recipe_editers_note = get_post_meta(get_the_ID(), 'recipe_editers_note', true);
	if ($recipe_editers_note) {
		echo '<div class="recipe_editers_note">' . esc_html($recipe_editers_note) . '</div>';
	}
}
function display_recipe_type()
{
	$recipe_type = get_post_meta(get_the_ID(), 'recipe_type', true);

	$recipe_options = array(
		'Veg' => 'Veg',
		'Non-Veg' => 'Non-Veg',
		// Add more options as needed
	);

	if ($recipe_type) {
		echo '<div class="recipe-time">' . esc_html($recipe_options[$recipe_type]) . '</div>';
	}
}