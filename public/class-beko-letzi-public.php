<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://1daywebsite.ch
 * @since      1.0.0
 *
 * @package    Beko_Letzi
 * @subpackage Beko_Letzi/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Beko_Letzi
 * @subpackage Beko_Letzi/public
 * @author     Andreas Feuz <info@1daywebsite.ch>
 */
class Beko_Letzi_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	// Deregister Contact Form 7 styles
	function oneday_deregister_cf7styles() {
		if ( ! is_page( 'website-in-einem-tag-die-checkliste' ) ) {
			wp_deregister_style( 'contact-form-7' );
		}
	}
	
	// Deregister Contact Form 7 JavaScript files on all pages without a form
	public function oneday_deregister_cf7_javascript() {
		if ( ! is_page( 'website-in-einem-tag-die-checkliste' ) ) {
			wp_deregister_script( 'contact-form-7' );
		}
	}

	public function beko_letzi_after_form_submit ($response){
		global $wpcf7_contact_form;
		global $beko_letzi_password;
		global $beko_letzi_timestamp;
		
		$beko_letzi_url = site_url() . '/beko-letzi-form/' . $beko_letzi_timestamp . '/';
		
		$response["status"] = "mail_sent";
		$response["message"] = '<h2>Danke für deine Nachricht!</h2><h3>Wir versuchen, dir so schnell als möglich zu antworten, in der Regel innert 48 Stunden.</h3><h3>Dein Passwort, um die Antwort anzuschauen, lautet: </h3><h3>' . $beko_letzi_password . '</h3><h3>Unsere Antwort (eine ganze Konversation) findest du immer unter dieser Adresse: </h3><h3><a href="' . $beko_letzi_url . '" target="_blank">' . $beko_letzi_url . '</a></h3><h4>Zum Schutz deiner Privatsphäre bitte beachte, dass nur du dieses Passwort angezeigt bekommst. Sollte jemand das Passwort und das oben angzeigte Link von dir versehentlich erhalten, könnte diese Person deine Nachricht lesen.</h4>';
		return $response;
	}
	
	public function beko_letzi_custom_password_form() {
		global $post;
		$beko_letzi_pw_form = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
		' . __( '<h3>Hallo! Du kannst diesen Text nur lesen, wenn du das richtige Passwort hast. Falls du es verloren hast, schick uns einfach eine neue Nachricht und notiere dir das Passwort, das dir nach dem Abschicken der Nachricht angezeigt wird. Danke.</h3>', 'beko-letzi' ) . '

		<label for="password">' . __( '<h3>Passwort:</h3>', 'beko-letzi' ) . ' </label><input name="post_password" id="password" type="password" size="20" required/>
		<div class="beko-letzi-passwort"><input type="submit" name="Submit" value="' . esc_attr__( 'Abschicken', 'beko-letzi' ) . '" /></div>
		</form>
		';
		return $beko_letzi_pw_form;
	}	
	
	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/beko-letzi-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/beko-letzi-public.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * Defines function for CF7 hook 'wpcf7_before_send_mail', which allows manipulation of form data and creates the checkliste pdf as the form is sent
	 *
	 * @since 		1.0.0
	 * $param		$submission		CF7 instance containing the form
	 * $param		$posted_data	Contains all posted form data (after clicking submit)
	 * $param		$randommumber	For pdf file creation
	 * $param		$mpdf			Creating PDF with MPDF
	 * $param		$checkliste_pdf	Global variable for function oneday_checkliste_wpcf7_mail-components
	 */
	public function beko_letzi_anon_form_submit($cf7) {	
		
		$submission = WPCF7_Submission::get_instance();
		
		if ( $submission ) {
			
			if ( $cf7->id() == 13 ) {
		
				$posted_data = $submission->get_posted_data();
				
				global $beko_letzi_form_content;
				
				$beko_letzi_form_header = '<h3>Vollständige Nachricht:</h3>';
				
				$beko_letzi_form_content = $posted_data['bkletzi-anonyme-nachricht'];
				
				global $beko_letzi_timestamp;
				$beko_letzi_timestamp = time();
				
				$beko_letzi_datestamp = date("j. F Y, G:i");
				$beko_letzi_posttitle = 'Nachricht vom ' . $beko_letzi_datestamp;
				
				global $beko_letzi_password;
				$beko_letzi_password = $this->createRandomPassword();
				
				$posted_data['bkletzi-anonyme-nachricht-code'] = $beko_letzi_password;

				$post_data = array (
					'comment_status'    => 'closed',
					'ping_status'       => 'closed',
					'post_name'         => $beko_letzi_timestamp,
					'post_title'        => $beko_letzi_posttitle,
					'post_content'		=> $beko_letzi_form_content,
					'post_password'		=> $beko_letzi_password,
					'post_status'       => 'publish',
					'post_type'         => 'beko-letzi-form' 
				);
				wp_insert_post( $post_data );
			}
		}
	}	
	
	public function createRandomPassword($length=8,$chars="") { 
		if ( $chars=="" ) {
			$chars = "abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ0123456789"; 
		}	
		srand((double)microtime()*1000000); 
		$i = 0; 
		$pass = '' ; 
	 
		while ($i < $length) { 
			$num = rand() % strlen($chars); 
			$tmp = substr($chars, $num, 1); 
			$pass = $pass . $tmp; 
			$i++; 
		} 
		return $pass; 
	}

	public function beko_letzi_form_debugger() {
		
		$submission = WPCF7_Submission::get_instance();
		if ( $submission ) {
			//$posted_data = $submission->get_posted_data(); 
			
			/*$checkliste_checkbox_ziele = $posted_data['checkliste-checkbox-ziele'];
			
			if( !empty( $checkliste_checkbox_ziele[0] ) ) {
			$checkliste_checkbox_ziele_eval = $checkliste_checkbox_ziele_header . '<h3>Online-Präsentation meiner Firma, vor allem wie sie Besuchern beim Lösen von Problemen helfen kann</h3>
			<p>Alle Websites, die wir erstellen, präsentieren Ihre Firma, ihren Zweck, in einem zeitgemässen und gediegenen Design. Damit die Website mehr ist als nur eine "Online-Visitenkarte" empfehlen wir Inhalte, die tatsächlich den Nutzern beim Lösen von konkreten Problemen helfen können.</p>';
			}
		
			if( !empty( $checkliste_checkbox_ziele[1] ) ) {
			$checkliste_checkbox_ziele_eval .= "Testing testing testing";
			}*/
			
			$posted_data = $submission->get_posted_data(); 

			ob_start(); 

			echo '<pre>';
			print_r($posted_data);
			echo '</pre>';

			$content = ob_get_clean();

			wp_mail('ibmeister@gmail.com', 'Debug', $content);
			
			//wp_mail('ibmeister@gmail.com', 'Debug', $checkliste_checkbox_ziele_eval);
		}
	}
}
