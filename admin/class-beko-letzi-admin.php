<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://1daywebsite.ch
 * @since      1.0.0
 *
 * @package    Beko_Letzi
 * @subpackage Beko_Letzi/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Beko_Letzi
 * @subpackage Beko_Letzi/admin
 * @author     Andreas Feuz <info@1daywebsite.ch>
 */
class Beko_Letzi_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Beko_Letzi_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Beko_Letzi_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/beko-letzi-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Beko_Letzi_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Beko_Letzi_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/beko-letzi-admin.js', array( 'jquery' ), $this->version, false );

	}
	
		/**
	 * Register a custom post type called "beko-letzi-form".
	 *
	 * @see get_post_type_labels() for label keys.
	 */
	public function beko_letzi_register_cpt_beko_letzi_form() {
		$labels = array(
			'name'                  => _x( 'Beko Letzi Form', 'Post type general name', 'beko-letzi' ),
			'singular_name'         => _x( 'Beko Letzi Form', 'Post type singular name', 'beko-letzi' ),
			'menu_name'             => _x( 'Beko Letzi Forms', 'Admin Menu text', 'beko-letzi' ),
			'name_admin_bar'        => _x( 'Beko Letzi Form', 'Add New on Toolbar', 'beko-letzi' ),
			'add_new'               => __( 'Add New', 'beko-letzi' ),
			'add_new_item'          => __( 'Add New Beko Letzi Form', 'beko-letzi' ),
			'new_item'              => __( 'New Beko Letzi Form', 'beko-letzi' ),
			'edit_item'             => __( 'Edit Beko Letzi Form', 'beko-letzi' ),
			'view_item'             => __( 'View Beko Letzi Form', 'beko-letzi' ),
			'all_items'             => __( 'All Beko Letzi Form', 'beko-letzi' ),
			'search_items'          => __( 'Search Beko Letzi Forms', 'beko-letzi' ),
			'not_found'             => __( 'No Beko Letzi Forms found.', 'beko-letzi' ),
			'not_found_in_trash'    => __( 'No Beko Letzi Forms found in Trash.', 'beko-letzi' ),
		);
	 
		$args = array(
			'labels'             	=> $labels,
			'public'             	=> false,
			'publicly_queryable' 	=> true,
			'exclude_from_search'	=> true,
			'show_ui'            	=> true,
			'show_in_menu'       	=> true,
			'query_var'          	=> true,
			'rewrite'            	=> array( 'slug' => 'beko-letzi-form' ),
			'has_archive'       	=> false,
			'hierarchical'       	=> false,
			'supports'           	=> array( 'title', 'editor', 'revisions')
		);
	 
		register_post_type( 'beko-letzi-form', $args );
	}

}
