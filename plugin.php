<?php
namespace ElementorSuperCat;

/**
 * Class Plugin
 *
 * Main Plugin class
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @access public
	 */
	public function widget_scripts() {
        wp_register_script( 'post-filter-js', plugins_url( '/assets/js/post-filter.js', __FILE__ ), [ 'jquery' ], null, true );
        wp_register_script( 'checkbox-filter-js', plugins_url( '/assets/js/checkbox-filter.js', __FILE__ ), [ 'jquery' ], null, true );
		wp_register_script( 'dropdown-filter-js', plugins_url( '/assets/js/dropdown-filter.js', __FILE__ ), [ 'jquery' ], null, true );
	}

    /**
	 * widget_styles
	 *
	 * Load required plugin core files.
	 *
	 * @access public
	 */
    public function widget_styles() {
        wp_register_style( 'checkbox-filter-css', plugins_url( '/assets/css/checkbox-filter.css', __FILE__ ));
        wp_register_style( 'autostop-video-css', plugins_url( '/assets/css/autostop-video.css', __FILE__ ));
        if(\Elementor\Plugin::$instance->preview->is_preview_mode() || \Elementor\Plugin::$instance->editor->is_edit_mode()){
            wp_enqueue_style('checkbox-filter-css');
            wp_enqueue_style('autostop-video-css');
        }
	}

	/**
	 * Include Widgets files
	 *
	 * Load widgets files
	 *
	 * @access private
	 */
	private function include_widgets_files() {
        require_once( __DIR__ . '/widgets/form-poster.php' );
        require_once( __DIR__ . '/widgets/post-filter.php' );
        require_once( __DIR__ . '/widgets/param-button.php' );
        require_once( __DIR__ . '/widgets/checkbox-filter.php' );
        require_once( __DIR__ . '/widgets/dropdown-filter.php' );
        require_once( __DIR__ . '/widgets/autostop-video.php' );
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @access public
	 */
	public function register_widgets() {
		// Its is now safe to include Widgets files
		$this->include_widgets_files();

		// Register Widgets
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Form_Poster() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Post_Filter() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Param_Button() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Checkbox_Filter() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Dropdown_Filter() );
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Autostop_Video() );
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @access public
	 */
	public function __construct() {
		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

        // Register widget styles
		add_action( 'elementor/frontend/after_register_styles', [ $this, 'widget_styles' ] );

		// Register widgets
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}
}

// Instantiate Plugin Class
Plugin::instance();
