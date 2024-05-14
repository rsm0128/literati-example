<?php
/**
 * PostType class file.
 *
 * @package Literati\Example
 */

namespace Literati\Example;

/**
 * PostTypes class.
 */
class PostTypes {
	/**
	 * Init
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );

		add_action( 'add_meta_boxes', array( __CLASS__, 'add_meta_boxes' ) );
		add_action( 'save_post', array( __CLASS__, 'save_metabox' ) );
	}

	/**
	 * Register post types.
	 */
	public static function register_post_type() {
		// Register the promotion CPT.
		register_post_type(
			'promotion',
			array(
				'labels'   => array(
					'name'           => _x( 'Promotions', 'Post type general name', 'literati-example' ),
					'singular_name'  => _x( 'Promotion', 'Post type singular name', 'literati-example' ),
					'menu_name'      => _x( 'Promotions', 'Admin Menu text', 'literati-example' ),
					'name_admin_bar' => _x( 'Promotion', 'Add New on Toolbar', 'literati-example' ),
					'add_new'        => __( 'Add New', 'literati-example' ),
					'add_new_item'   => __( 'Add New promotion', 'literati-example' ),
					'new_item'       => __( 'New promotion', 'literati-example' ),
					'edit_item'      => __( 'Edit promotion', 'literati-example' ),
					'view_item'      => __( 'View promotion', 'literati-example' ),
				),
				'public'   => true,
				'supports' => array(
					'title',
					'thumbnail',
				),
			)
		);
	}

	/**
	 * Add meta box
	 */
	public static function add_meta_boxes() {
		add_meta_box(
			'promotion_metabox',
			'Promotion Details',
			array( __CLASS__, 'render_promotion_metabox' ),
			'promotion',
			'normal',
			'default'
		);
	}

	/**
	 * Render promotion metabox
	 *
	 * @param WP_Post $post Post object.
	 */
	public static function render_promotion_metabox( $post ) {
		// Add nonce field.
		wp_nonce_field( 'literati_metabox_nonce', 'literati_metabox_nonce' );

		// Retrieve the current value of the fields.
		$text_value   = get_post_meta( $post->ID, '_promotion_text', true );
		$button_value = get_post_meta( $post->ID, '_promotion_button', true );
		?>
		<p>
			<label for="promotion_text">Text: </label>
			<input type="text" id="promotion_text" class="regular-text" name="promotion_text" value="<?php echo esc_attr( $text_value ); ?>">
		</p>
		<p>
			<label for="promotion_button">Button: </label>
			<input type="text" id="promotion_button" class="regular-text" name="promotion_button" value="<?php echo esc_attr( $button_value ); ?>">
		</p>
		<?php
	}

	/**
	 * Save metabox data.
	 *
	 * @param int $post_id Post ID.
	 */
	public static function save_metabox( $post_id ) {
		if ( ! isset( $_POST['literati_metabox_nonce'] ) || ! wp_verify_nonce( $_POST['literati_metabox_nonce'], 'literati_metabox_nonce' ) ) {
			return $post_id;
		}

		// Verify if this is an auto save routine.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		if ( array_key_exists( 'promotion_text', $_POST ) ) {
			update_post_meta(
				$post_id,
				'_promotion_text',
				sanitize_text_field( $_POST['promotion_text'] )
			);
		}
		if ( array_key_exists( 'promotion_button', $_POST ) ) {
			update_post_meta(
				$post_id,
				'_promotion_button',
				sanitize_text_field( $_POST['promotion_button'] )
			);
		}
	}
}
