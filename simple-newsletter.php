<?php 
/**
 * @package Simple Newsletter
 */
/*
Plugin Name: Simple Newsletter
Description: Plugin de Newsletter com Double Opt-in
Version: 0.7
Author: Robson Miranda
Text Domain: simple-newsletter-br
Domain Path: /languages
*/

require('class_newsletter.php');

function put_in_newsletter($type = 'email', $name = '', $nameOrNumber = '')
{
	$newsletter = new simplenewsletter();
	
	if( empty($name) || empty($nameOrNumber) ){
		return false;
	}
	
	$field = ($type = 'email')?'email':'cellphone';

	return $newsletter->insert(array('name' => $name, $field => $nameOrNumber));
}

if(!class_exists('simpleNewsletter')) {

	class simpleNewsletter {

		public function __construct()
		{
			define('SN_PATH_URL', plugins_url('', __FILE__));
			add_action( 'admin_menu', array(&$this,'settings'));
			add_action( 'wp_enqueue_scripts', array(&$this,'scripts' ));
			add_action( 'admin_enqueue_scripts', array(&$this,'admin_scripts' ) );
			add_action( 'init', array(&$this, 'load_sn_tranlate'));
			add_action( 'init', array(&$this, 'register_sn_taxonomy'));

			if(isset($_POST['simplenewsletter']))
			{
				add_action('after_setup_theme', array(&$this, 'generateForm'));
			}

			if(isset($_GET['sn_export_method']) && is_admin())
			{
				add_action('after_setup_theme', array(&$this, 'export'));
			}

			add_shortcode('simplenewsletter', array(&$this,'generateForm'));
		}

		public function load_sn_tranlate()
		{
			load_plugin_textdomain('simple-newsletter-br', FALSE, dirname(plugin_basename(__FILE__)).'/languages/');
		}

		public function register_sn_taxonomy()
		{
			register_taxonomy( 'sn_channels', array('simple-newsletter-br'),
			array( 'hierarchical' => false,
				'label' => __('Simple Newsletter - Subscription Channels', 'simple-newsletter-br'),
				'show_ui' => true,
				'query_var' => true,
				'show_admin_column' => false,
				'labels' => array (
					'search_items' => __('Channel', 'simple-newsletter-br'),
					'popular_items' => __('Popular', 'simple-newsletter-br'),
					'all_items' => __('All', 'simple-newsletter-br'),
					'parent_item' => '',
					'parent_item_colon' => '',
					'edit_item' => 'Edit',
					'update_item' => 'Update',
					'add_new_item' => 'Add',
					'new_item_name' => '',
					'separate_items_with_commas' => '',
					'add_or_remove_items' => '',
					'choose_from_most_used' => '',
					)
				)
			); 
		}

		/** This method render a submenu on configuration */
		public function settings()
		{
			add_options_page( '', 'Simple Newsletter', 'manage_options', 'simplenewsletter-admin', array( &$this, 'admin_updateSettings' ) );

			add_menu_page('Newsletter', 'Simple Newsletter', 'administrator', 'simplenewsletter-grid', array(&$this,'admin_gridSubscribers'), 'dashicons-groups');
			add_submenu_page('simplenewsletter-grid', 'Newsletter', 'Email', 'administrator', 'simplenewsletter-grid', array(&$this,'admin_gridSubscribers'), 'dashicons-groups');
			add_submenu_page('simplenewsletter-grid', 'Newsletter', 'Mobile', 'administrator', 'simplenewsletter-grid-mobile', array(&$this,'admin_gridSubscribersMobile'), 'dashicons-groups');

			add_submenu_page('simplenewsletter-grid', 'Newsletter', __('Subscription Channels', 'simple-newsletter-br'), 'administrator', 'edit-tags.php?taxonomy=sn_channels', array(), 'dashicons-groups');
			
		}

		/** Enqueue Scripts on site */

		public function scripts()
		{
			wp_enqueue_script( 'jquery_mask_input', plugins_url('js/mask/jquery.inputmask.bundle.js', __FILE__), array('jquery'));
			wp_enqueue_script( 'simplenewsletter', plugins_url('js/main.js', __FILE__), array('jquery'));
		}

		public function admin_scripts()
		{
			if( !isset($_GET['page']) || !in_array($_GET['page'], array('simplenewsletter-grid', 'simplenewsletter-grid-mobile')) ){
				return ;
			}
			
			wp_enqueue_script( 'simplenewsletter-admin', plugins_url('js/admin_main.js', __FILE__), array('jquery'));
		}

		/** Generate the subscription form */
		public function generateForm( $attr )
		{
			$newsletter = new controllerNewsletter();
			
			if(isset($_GET['sn_token']))
			{
				if($newsletter->confirm($_GET['sn_token']))
				{
					?>
					<div class="simplenewsletter-confirm-success">
						<p><?php echo get_option('simplenewsletter_confirmedmessage'); ?></p>
					</div>
					<?php
				}	
			}

			$errors = array();

			if(isset($_POST['simplenewsletter']) )
			{
				$newsletter->insert($_POST['simplenewsletter']);
				$errors = $newsletter->errors;
				$this->ajaxResponse($errors, $newsletter->success_message);
			}

			if( isset( $errors ) || empty( $_POST['simplenewsletter'] ) )
			{
				foreach( $errors as $field => $error )
				{
					echo "<span class='error'>$error</p>";
				}
				$this->render_form( $attr );
			}
		}

		public function render_form($attr)
		{
			$file = 'views/forms/email.php';
			
			if(isset($attr['type']) && $attr['type'] == 'mobile')
			{
				$file = 'views/forms/mobile.php';
			}

			include($file);
		}

		/** Set the token and API to generate the bill bank */
		public function admin_updateSettings()
		{
			if(!empty($_POST))
			{
				foreach($_POST as $name=>$value)
				{
					$value = sanitize_text_field($value);
					update_option($name, $value);
				}

				add_settings_error(
					'newsletterSaveSettings',
					esc_attr( 'settings_updated' ),
					'Configurações Atualizadas',
					'updated'
					);
			}

			include('views/admin_form.php');
		}

		public function admin_gridSubscribersMobile()
		{
			include ('views/admin_grid-mobile.php');
		}

		public function admin_gridSubscribers()
		{
			include ('views/admin_grid-email.php');
		}

		public function export()
		{
			$newsletter = new controllerNewsletter();
			$newsletter->export($_GET['sn_export_method'], $_GET['sn_channel'], $_GET['sn_type']);
			exit;
		}

		
		/** * Activate the plugin */
		public static function activate() {
			global $wpdb;
			//Cria as opções administrativas
			add_option("simplenewsletter_dbloptin", "1", null, "no");
			add_option("simplenewsletter_showname", "1", null, "no");
			add_option("simplenewsletter_successmessage", "Obrigado por se cadastrar", null, "no");
			add_option("simplenewsletter_confirmedmessage", "Obrigado por confirmar seu email", null, "no");
			add_option("simplenewsletter_confirmationemail", "Obrigado por se cadastrar, clique no link abaixo para confirmar o seu email", null, "no");
			add_option("simplenewsletter_logo", "", null, "no");
			add_option("simplenewsletter_showon", "append", null, "no");
			add_option("simplenewsletter_mobilemask", "(99)99999-9999", null, "no");
			//Executa a query de criação da tabela de armazenamento
			$file_install = fopen( plugin_dir_path(__FILE__).'/sql/install.sql', "r");
			$file_update = fopen( plugin_dir_path(__FILE__).'/sql/update_051.sql', "r");

			$query_install = fread($file_install, filesize(plugin_dir_path(__FILE__).'/sql/install.sql'));
			$query_update = fread($file_update, filesize(plugin_dir_path(__FILE__).'/sql/update_051.sql'));
			fclose($file_install);
			fclose($file_update);

			$wpdb->query($query_install);

			$columns = $wpdb->get_results("SELECT `COLUMN_NAME` FROM `INFORMATION_SCHEMA`.`COLUMNS` WHERE `TABLE_SCHEMA`='{$wpdb->dbname}' AND `TABLE_NAME`='simplenewsletter_subscriptions'", ARRAY_A);

			$names = array();

			if( is_array($columns) && !empty($columns)){
				foreach($columns as $key => $value){
					$names[] = $value['COLUMN_NAME'];
				}				
			}

			if(!in_array('cellphone', $names)){
				error_log('NAO ACHOU');
				$wpdb->query($query_update);
				error_log($query_update);
			}
		}

		/** * Deactivate the plugin */ 
		public static function deactivate() {
			delete_option("simplenewsletter_dbloptin");
			delete_option("simplenewsletter_logo");
			delete_option("simplenewsletter_confirmationemail");
			delete_option("simplenewsletter_showname");
			delete_option("simplenewsletter_successmessage");
			delete_option("simplenewsletter_confirmedmessage");
			delete_option("simplenewsletter_showon");
		}

		public function ajaxResponse($errors, $success_message)
		{
			//check if is ajax
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
			{
				if(!empty($errors))
				{
					echo json_encode( array( 'success' => '0', 'message' => $errors ) );
				}else{
					echo json_encode( array( 'success' => '1', 'message' => $success_message ) );
				}
				exit;

				return true;
			}
			
			return true;
		}

	}
}

if(class_exists("simpleNewsletter")){
	register_activation_hook(__FILE__, array('simpleNewsletter', 'activate'));
	register_deactivation_hook(__FILE__, array('simpleNewsletter', 'deactivate'));
	$simpleNewsletter = new simpleNewsletter;
	add_action( 'widgets_init', 'simplenewsletter_register_widgets' );
}

class widgetSimpleNewsletter extends WP_Widget {

	function widgetSimpleNewsletter() {
		// Instantiate the parent object
		parent::__construct( false, 'Simple Newsletter', array('description' => __('Add the subscription form on widget area', 'simple-newsletter-br')) );
	}

	function widget( $args, $instance ) {
		?>
		<aside id="simplenewsletter-widget" class="widget">
			<h2 class="widget-title"><?php echo $instance['title'] ?></h2>
			<p><?php echo ( isset($instance['boxtext']) && !empty($instance['boxtext']) ) ? $instance['boxtext'] : ''; ?></p>
			<?php do_shortcode('[simplenewsletter]'); ?>
		</aside>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['type'] = ( ! empty( $new_instance['type'] ) ) ? strip_tags( $new_instance['type'] ) : '';
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['boxtext'] = ( ! empty( $new_instance['boxtext'] ) ) ? strip_tags( $new_instance['boxtext'] ) : '';
		return $instance;
	}

	function form( $instance ) {
		$type = ! empty( $instance['type'] ) ? $instance['type'] : __( 'Type', 'simple-newsletter-br' );
		$title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'simple-newsletter-br' );
		$boxtext = ! empty( $instance['boxtext'] ) ? $instance['boxtext'] : __( 'Box Text', 'simple-newsletter-br' );
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'type' ); ?>"><?php _e( 'Type:' ); ?></label> 
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
			<label for="<?php echo $this->get_field_id( 'boxtext' ); ?>"><?php _e( 'Box Text:', 'simple-newsletter-br' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'boxtext' ); ?>" name="<?php echo $this->get_field_name( 'boxtext' ); ?>" type="text" value="<?php echo esc_attr( $boxtext ); ?>">
		</p>
		<?php 
	}
}

function simplenewsletter_register_widgets() {
	register_widget( 'widgetSimpleNewsletter' );
}