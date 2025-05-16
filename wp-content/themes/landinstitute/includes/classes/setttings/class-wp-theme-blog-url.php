<?php
/**
 * Custom blog URL handling and permalink structure
 *
 * @package Base Theme Package
 * @since 1.0.0
 */

namespace BaseTheme\Blog;

class WP_Theme_Blog_Url
{
	private $permalink_option = 'post_custom_permalink';
	private $cache_key = 'custom_blog_permalink';

	/**
	 * Initialize the class and set up hooks
	 */
	public function __construct()
	{
		$this->init_hooks();
	}

	/**
	 * Initialize WordPress hooks
	 */
	private function init_hooks()
	{
		if ($this->get_permalink_base()) {
			add_action('init', [$this, 'add_rewrite_rules']);
			add_filter('post_link', [$this, 'modify_post_permalink'], 10, 3);
			add_action('template_redirect', [$this, 'handle_redirect']);
		}

		add_action('admin_init', [$this, 'register_permalink_settings']);
		// Clear rewrite rules when permalink is updated
		add_action('update_option_' . $this->permalink_option, [$this, 'flush_rules_on_update'], 10, 2);
	}

	/**
	 * Get permalink base with caching
	 *
	 * @return string|null
	 */
	private function get_permalink_base()
	{
		$cached = wp_cache_get($this->cache_key);
		if (false !== $cached) {
			return $cached;
		}

		$base = get_option($this->permalink_option);
		wp_cache_set($this->cache_key, $base);
		return $base;
	}

	/**
	 * Add rewrite rules for custom blog structure
	 */
	public function add_rewrite_rules()
	{
		$base = $this->get_permalink_base();
		if (!$base) {
			return;
		}

		add_rewrite_rule(
			'^' . $base . '/([^/]+)/?$',
			'index.php?post_type=post&name=$matches[1]',
			'top'
		);
	}

	/**
	 * Modify post permalink structure
	 *
	 * @param string $post_link Original post link
	 * @param object $post Post object
	 * @param bool $leavename Whether to keep post name
	 * @return string Modified post link
	 */
	public function modify_post_permalink($post_link, $post, $leavename = false)
	{
		if (!$post || 'post' !== $post->post_type) {
			return $post_link;
		}

		$basename = basename($post_link);
		if ($this->is_numeric_permalink($basename)) {
			return $post_link;
		}

		$base = $this->get_permalink_base();
		$is_trailing_slash = str_ends_with($post_link, '/');

		// Handle WPML integration
		if (defined('ICL_SITEPRESS_VERSION')) {
			$lang = $this->get_wpml_language_code($post_link);
			$new_link = $this->build_multilingual_url($base, $basename, $lang, $is_trailing_slash);
			$new_link = apply_filters('wpml_permalink', $new_link);
		} else {
			$new_link = $this->build_url($base, $basename, $is_trailing_slash);
		}

		// Apply Yoast SEO sitemap filter
		$new_link = apply_filters('wpseo_sitemap_url', $new_link);

		return $new_link;
	}

	/**
	 * Build URL with proper structure
	 */
	private function build_url($base, $basename, $is_trailing_slash)
	{
		return home_url('/' . $base . '/' . $basename . ($is_trailing_slash ? '/' : ''));
	}

	/**
	 * Build multilingual URL
	 */
	private function build_multilingual_url($base, $basename, $lang, $is_trailing_slash)
	{
		return home_url('/' . $lang . '/' . $base . '/' . $basename . ($is_trailing_slash ? '/' : ''));
	}

	/**
	 * Handle redirects for custom permalink structure
	 */
	public function handle_redirect()
	{
		if ('post' !== get_post_type() || (int) get_option('page_for_posts') === get_queried_object_id()) {
			return;
		}

		$request_uri = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
		if (!$request_uri) {
			return;
		}

		if (!preg_match('/^\/([^\/]+)\/$/', $request_uri, $matches)) {
			return;
		}

		$slug = $matches[1] ?? null;
		if (!$slug) {
			return;
		}

		$base = $this->get_permalink_base();
		$is_trailing_slash = str_ends_with($request_uri, '/');

		if (defined('ICL_SITEPRESS_VERSION')) {
			$lang = $this->get_wpml_language_code(get_permalink(get_the_ID()));
			$new_url = $this->build_multilingual_url($base, $slug, $lang, $is_trailing_slash);
			$new_url = apply_filters('wpml_permalink', $new_url);
		} else {
			$new_url = $this->build_url($base, $slug, $is_trailing_slash);
		}

		// Apply Yoast SEO sitemap filter for redirects
		$new_url = apply_filters('wpseo_sitemap_url', $new_url);

		wp_safe_redirect($new_url, 301);
		exit;
	}

	/**
	 * Check if permalink is numeric (?p=123)
	 */
	private function is_numeric_permalink($string)
	{
		return (bool) preg_match('/\?p=\d+/', $string);
	}

	/**
	 * Extract language code from URL for WPML
	 */
	private function get_wpml_language_code($url)
	{
		$path = parse_url($url, PHP_URL_PATH);
		if (!$path) {
			return '';
		}

		$segments = array_filter(explode('/', $path));
		return $segments[0] ?? '';
	}

	/**
	 * Register permalink settings
	 */
	public function register_permalink_settings()
	{
		register_setting('permalink', $this->permalink_option, [
			'type' => 'string',
			'sanitize_callback' => 'sanitize_text_field',
			'default' => null,
		]);

		add_settings_field(
			$this->permalink_option,
			__('Post Permalink Structure', 'basetheme'),
			[$this, 'render_permalink_field'],
			'permalink',
			'optional',
			['label_for' => $this->permalink_option]
		);

		$this->maybe_update_permalink();
	}

	/**
	 * Render permalink field
	 */
	public function render_permalink_field()
	{
		$value = esc_attr($this->get_permalink_base());
		echo sprintf(
			'<input name="%1$s" type="text" id="%1$s" value="%2$s" class="regular-text code">',
			$this->permalink_option,
			$value
		);
	}

	/**
	 * Update permalink if needed
	 */
	private function maybe_update_permalink()
	{
		if (!isset($_POST['permalink_structure'], $_POST[$this->permalink_option])) {
			return;
		}

		$new_value = sanitize_text_field(wp_unslash($_POST[$this->permalink_option]));
		update_option($this->permalink_option, $new_value);
	}

	/**
	 * Flush rewrite rules when permalink is updated
	 */
	public function flush_rules_on_update($old_value, $new_value)
	{
		if ($old_value !== $new_value) {
			flush_rewrite_rules();
			wp_cache_delete($this->cache_key);
		}
	}
}

new WP_Theme_Blog_Url();