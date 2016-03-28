<?php
/*
   Plugin Name: Jaiminho Newsletters
   Version: 1.0
   Plugin URI: https://jaiminho.redelivre.org.br
   Description: Fork do Seedpress com algumas personalizações para a Rede Livre.
   Author: RedeLivre
   Author URI: https://redelivre.org.br

   Text Domain: jaiminho
   Domain Path: /languages/
 */

define( 'JAIMINHO_URL', plugin_dir_url( __FILE__ ) );
define( 'JAIMINHO_VERSION', 0.0 );
define( 'JAIMINHO_PATH', plugin_dir_path( __FILE__ ) );
define( 'SPNL_DISABLE_SENDING_DELIVERY',false);
define( 'SPNL_DISABLE_SENDING_GMAIL',false);
define( 'SPNL_DISABLE_SENDING_WP_MAIL',false);

// AutoLoad Classes

// sendpress classes
require_once( ABSPATH . '/wp-content/plugins/sendpress/sendpress.php' );
require_once( ABSPATH . '/wp-content/plugins/sendpress/classes/class-sendpress-option.php' );
//require_once( ABSPATH . '/wp-content/plugins/sendpress/classes/views/class-sendpress-view.php' );
// jaiminho classes
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-settings-account.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-send.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-overview.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-queue-all.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-queue.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-settings.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-templates.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-temp.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-social.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-systememail.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-tempstyle.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-systememailcreate.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-systememailedit.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-create.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-edit.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-send.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-send-confirm.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-send-queue.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-send-tempdelete.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-send-tempclone.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/class-jaiminho-sender-redelivre.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/class-jaiminho-sender-network.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/class-jaiminho-sender-gmail.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/class-tgm-plugin-activation.php' );

class Jaiminho extends SendPress
{
	protected $plugin_name;
	protected $sendpress_name;

	public function __construct()
	{
		add_action('init', array( $this , 'Init' ) );
		spl_autoload_register( array( 'Jaiminho', 'autoload' ) );
	}

	public function Init()
	{
		$sendpress_name = __( 'SendPress', 'sendpress' );
		add_action( 'init' , array( $this , 'jaiminho_check_rewrite' ) );
		sendpress_register_sender( 'Jaiminho_Sender_RedeLivre' );
		sendpress_register_sender( 'Jaiminho_Sender_Gmail' );
		remove_action( 'in_admin_footer',array(SendPress_View::get_instance(),'footer'),10);
		wp_register_script('jaiminho_disable',JAIMINHO_URL .'js/disable.js' ,'',JAIMINHO_VERSION);
		add_action( 'admin_menu', array($this,'remove_menu'));
		add_action( 'admin_menu', array($this,'admin_menu'));
		add_action( 'toplevel_page_sp-overview', array($this,'render_view_jaiminho'));
		add_action( 'jaiminho_page_sp-settings', array($this,'render_view_jaiminho'));
		add_filter( 'admin_footer_text', '__return_empty_string', 11 ); 
		add_filter( 'update_footer', '__return_empty_string', 11 );
		add_action( 'admin_print_styles' , array( $this , 'jaiminho_admin_footer_css_hide' ) );
		add_filter( 'tiny_mce_before_init', array( $this, 'myformatTinyMCE' ) );
		if (is_multisite())
		{
			add_action( 'network_admin_menu' , array( $this , 'jaiminho_network_settings' ) );
			sendpress_register_sender( 'Jaiminho_Sender_NetWork' );
		}
		add_action( 'tgmpa_register', array( $this , 'jaiminho_register_required_plugins' ) );
		remove_action( 'init' , array( SPNL() , 'toplevel_page_sp-overview' ) );
		//add_filter( 'sendpress_notices', '__return_empty_string' ); 
	}

	public function jaiminho_register_required_plugins()
	{
		$plugins = array(
				array(
					'name'      => 'sendpress',
					'slug'      => 'sendpress',
					'required'  => true
				     ),
				);
		$config = array(
				'id'           => 'jaiminho',              // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',                      // Default absolute path to bundled plugins.
				'menu'         => 'tgmpa-install-plugins', // Menu slug.
				'parent_slug'  => 'plugins.php',           // Parent menu slug.
				'capability'   => 'manage_options',        // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
				'has_notices'  => true,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.
			       );
		tgmpa( $plugins, $config );
	}

	public function jaiminho_check_rewrite() 
	{ 
		$rules = get_option( 'rewrite_rules' ); 
		$found = false; 
		if(is_array($rules)) 
		{ 
			foreach ($rules as $rule) 
			{ 
				if(strpos($rule, 'sendpress') !== false) 
				{ 
					$found = true; 
					break; 
				} 
			} 
			if ( ! $found ) 
			{ 
				global $wp_rewrite; 
				$wp_rewrite->flush_rules(); 
			} 
		} 
	}

	public function jaiminho_network_settings()
	{
		add_submenu_page(
				'settings.php',
				__('Configurações do Jaiminho','jaiminho'),
				__('Configurações do Jaiminho','jaiminho'),
				'manage_network_options',
				'jaiminho-network-settings',
				array( $this , 'jaiminho_settings_network_html' )
				);    
	}


	public function jaiminho_settings_network_html()
	{
		if (isset( $_POST["sendpress-sender"] ) )
		{
			if($_POST["sendpress-sender"] === "Jaiminho_Sender_NetWork" )
			{
				$args = array(
						'network_id' => null,
						'public'     => null,
						'archived'   => null,
						'mature'     => null,
						'spam'       => null,
						'deleted'    => null,
						'limit'      => null,
						'offset'     => 0,
					     ); 
				$blogs = wp_get_sites( $args );
				$post = array (
						'networkuser'   => $_POST['networkuser'] , 
						'networkpass'   => $_POST['networkpass'] ,
						'networkserver' => $_POST['networkserver'], 
						'networkport'   => $_POST['networkport'] ,
						'bounce_email'    => $_POST['bounce_email'] ,
						'sendmethod'      => $_POST['sendpress-sender']
					      );

				//create back up of options
				switch_to_blog( 1 );

				foreach($post as $key => $value )
					update_option( $key , $value);

				restore_current_blog();
				//add conf on all blogs
				if(isset($_POST['blogs']))
				{
					foreach( $_POST['blogs'] as $blog )
					{ 
						//var_dump($blog );
						echo "opa! pegamos i blog = " . $blog ;
						foreach( $post as $key => $value ) 
						{
							switch_to_blog( $blog );
							echo 'estamos no blog de numero = ' . get_current_blog_id() . '!';
							$method = SendPress_Option::set($key,$value);
						}
					}

				}
				else
				{
					foreach( $blogs as $blog )
					{ 
						foreach( $post as $key => $value ) 
						{
							switch_to_blog( $blog['blog_id'] );
							$method = SendPress_Option::set($key,$value);
						}
					}
				}
				restore_current_blog();
			}
		}
		global  $sendpress_sender_factory;
		$sender = $sendpress_sender_factory->get_sender('Jaiminho_Sender_NetWork');
		$method = SendPress_Option::get( 'sendmethod' );
		$key = 'Jaiminho_Sender_NetWork'; 
		?>
			<form method="post" id="post" >

			<div class="panel panel-default">
			<div class="panel-heading">
			<h3 class="panel-title"><?php _e('Sending Account Setup','sendpress'); ?></h3>
			</div>
			<div class="panel-body">

			<input type="hidden" name="action" value="account-setup" />
			<p>&nbsp;<input name="sendpress-sender" type="radio"  <?php if ( $method == $key || strpos(strtolower($key) , $method) > 0 ) { ?>checked="checked"<?php } ?> id="website" value="<?php echo $key; ?>" /> <?php _e('Send Emails via','sendpress'); ?>
			<?php
			echo $sender->label();
		echo "</p><div class='well'>";
		?>
			<p><?php echo __( 'Selecione os blogs que devem receber a configuração ou não selecione nenhum e todos os blogs serão configurados' , 'jaiminho' ); ?></p>
			<select name="blogs[]" multiple >
			<?php 
			$blogs = wp_get_sites( $args );
		foreach ($blogs as $blog)
		{
			switch_to_blog(  $blog['blog_id'] );
			echo '<option value="' . $blog['blog_id'] . '">' .get_bloginfo( 'name' ) . '</option>';
		}
		switch_to_blog( 1 );



		?>
			</select>
			<br><br>
			<!-- honeypot fields inserted for remove autocomplete, autocomplete dont work's on firefox -->
			<input type="text" style="display: none" id="fakeUsername" name="fakeUsername" value="" />
			<input type="password" style="display: none" id="fakePassword" name="fakePassword" value="" />
			<?php _e( 'Username' , 'sendpress'); ?>
			<p><input name="networkuser" type="text" value="<?php echo get_option( 'networkuser' ); ?>"  placeholder="<?php echo __( 'Insira o seu nome de usuário' , 'jaiminho' ); ?>" style="width:50%;" /></p>
			<?php _e( 'Password' , 'sendpress'); ?>
			<p><input name="networkpass" type="password" value="<?php echo get_option( 'networkpass' ); ?>" placeholder="<?php echo __( 'Insira sua Senha' , 'jaiminho' ); ?>"  style="width:50%;" /></p>
			<?php echo __( 'Servidor' , 'jaiminho'); ?>
			<p><input name="networkserver" type="text" value="<?php echo get_option( 'networkserver' ); ?>" placeholder="<?php echo __( 'Insira o ip ou o dns do seu servidor sem o http://' , 'jaiminho' ); ?>" style="width:50%;" /></p>
			<?php echo __( 'Porta' , 'jaiminho'); ?>
			<p><input name="networkport" type="text" placeholder="<?php echo __( 'Insira o numero da porta do serviço smtp do seu servidor' , 'jaiminho' ); ?>" value="<?php echo get_option( 'networkport' ); ?>" style="width:50%;" /></p>
			<?php echo __( 'Email de Retorno' , 'jaiminho'); ?>
			<p><input name="bounce_email" type="text" placeholder="<?php echo __( 'Insira o E-mail de retorno das mensagens' , 'jaiminho' ); ?>" value="<?php echo get_option( 'bounce_email' ); ?>" style="width:50%;" /></p>
			<?php
			echo "</div></div>";
		?>
			</div>
			</div>
			<?php submit_button(); ?>
			</form>
			<?php
			restore_current_blog();
	}

	public function myformatTinyMCE( $in ) 
	{
		if ( isset( $in['plugins'] ) ) {
			$in['plugins'] .= ' , wpeditimage';
		}
		$in['paste_data_images'] = true;

		return $in;
	}

	public function create_templates()
	{
		$post_id = wp_insert_post(
				array(
					'post_name'             =>      'nota',
					'post_title'            =>      'Nota',
					'post_status'           =>      'sp-standard',
					'post_type'             =>      'sp_template',
				     )
				);
		update_post_meta( $post_id, '_guid',  'cd8ab467-e236-49d3-bd6c-e84db055ae9a');
		update_post_meta( $post_id, '_footer_page', "" );
		update_post_meta( $post_id, '_header_content', "" );
		update_post_meta( $post_id, '_header_padding', 'pad-header' );
		add_option("note", $post_id );
	}

	public function remove_templates()
	{
		$post_id = get_option( "note" );
		wp_delete_post( $post_id );
		delete_option( "note" );
	}


	// Function for remove especific elements from seenpress
	public function admin_menu()
	{
		// Initialize!
		//$sendpress_instance = SendPress::get_instance();
		if ( current_user_can( 'sendpress_view' ) ) 
		{
			$role = "sendpress_view";
		}
		else{
			$role = "manage_options";
		}
		$queue = '';
		if ( isset( $_GET['page'] ) && in_array( SPNL()->validate->page( $_GET['page'] ), $this->adminpages ) ) {
			$queue = '(<span id="queue-count-menu">-</span>)';//SendPress_Data::emails_in_queue();
		}
		add_menu_page( __('Jaiminho','jaiminho'), __('Jaiminho','jaiminho'), $role, 'sp-emails', array( $this , 'render_view_jaiminho' ), JAIMINHO_URL.'img/jaiminho-bg-16.png' );
		// xxx: ainda não foi possivel descobrir onde esta o problema, simplesmente a página do overview repete o template - depois voltar de sp-emails para sp-overview
		//add_submenu_page('sp-emails', __('Overview','sendpress'), __('Overview','sendpress'), $role, 'sp-overview', array($this,'render_view_jaiminho'));
		$main = add_submenu_page('sp-emails', __('Emails','sendpress'), __('Emails','sendpress'), $role, 'sp-emails', array($this,'render_view_jaiminho'));
		add_submenu_page('sp-emails', __('Reports','sendpress'), __('Reports','sendpress'), $role, 'sp-reports', array($this,'render_view_jaiminho'));
		add_submenu_page('sp-emails', __('Subscribers','sendpress'), __('Subscribers','sendpress'), $role, 'sp-subscribers', array($this,'render_view_jaiminho'));
		add_submenu_page('sp-emails', __('Queue','sendpress'), __('Queue','sendpress')  . " " . $queue, $role, 'sp-queue', array($this,'render_view_jaiminho'));
		add_submenu_page('sp-emails', __('Settings','sendpress'), __('Settings','sendpress'), $role, 'sp-settings', array($this,'render_view_jaiminho'));
	}

	public function remove_menu()
	{
		remove_submenu_page('sp-overview','sp-overview');
		remove_submenu_page('sp-overview','sp-emails');
		remove_submenu_page('sp-overview','sp-reports');
		remove_submenu_page('sp-overview','sp-subscribers');
		remove_submenu_page('sp-overview','sp-queue');
		remove_submenu_page('sp-overview','sp-settings');
		remove_submenu_page('sp-overview','sp-help');
		remove_submenu_page('sp-overview','sp-pro');
		remove_menu_page('sp-overview');
	}

	public function jaiminho_settings_account_email( $emails_credits ){
		$chars = array(".", ",", " ", ":", ";", "$", "%", "*", "-", "=");
		SendPress_Option::set( 'emails-credits' , str_replace( $chars , "" , $emails_credits ) ); 
	}


	public function jaiminho_settings_account_bounce($bounce_email)
	{
		if( isset ( $bounce_email ) )
		{
			$_bounce_email = $bounce_email;
		}
		else if ( SendPress_Option::get( 'bounce_email' ) )
			$_bounce_email = SendPress_Option::get('bounce_email');
		else 
		{
			// Get the site domain and get rid of www.
			$sitename = strtolower( $_SERVER['SERVER_NAME'] );
			if ( substr( $sitename, 0, 4 ) == 'www.' ) {
				$sitename = substr( $sitename, 4 );
			}
			$sets['value'] = array_merge($sets['value'], get_option('plataform_defined_settings', array()));
			$_bounce_email = 'bounce@' . $sitename;
		}
		SendPress_Option::set('bounce_email', $_bounce_email );
		$method = SendPress_Option::get( 'sendmethod' );
		// General site configuration of email to replay
		if ( $method === 'SendPress_Sender_Website' )
		{
			$sets = get_option('plataform_defined_settings');
			$sets['value']['emailReplyTo'] = SendPress_Option::get('bounce_email');
			$sets['value'] = array_merge($sets['value'], get_option('plataform_defined_settings', array()));
		}
	}

	public function jaiminho_get_view_class($page, $current_view, $emails_credits, $bounce_email)
	{

		$view_class = $this->get_view_class( $page, $current_view );
		switch ( $view_class ) {
			case "SendPress_View_Emails_Send":
				return "Jaiminho_View_Emails_Send";
			case "SendPress_View_Overview":
				return "Jaiminho_View_Overview";
			case "SendPress_View_Queue_All":
				return "Jaiminho_View_Queue_All";
			case "SendPress_View_Queue":
				return "Jaiminho_View_Queue";
			case  "SendPress_View_Emails_Templates":
				return "Jaiminho_View_Emails_Templates";
			case "SendPress_View_Emails_Temp":
				return "Jaiminho_View_Emails_Temp";
			case "SendPress_View_Emails_Social":
				return "Jaiminho_View_Emails_Social";
			case "SendPress_View_Emails_Systememail":
				return "Jaiminho_View_Emails_Systememail";
			case "SendPress_View_Emails":
				return "Jaiminho_View_Emails";
			case "SendPress_View_Emails_Tempstyle":
				return "Jaiminho_View_Emails_Tempstyle";
			case "SendPress_View_Emails_Systememailcreate":
				return "Jaiminho_View_Emails_Systememailcreate";
			case "SendPress_View_Emails_Systememailedit":
				return "Jaiminho_View_Emails_Systememailedit";
			case "SendPress_View_Emails_Create":
				return "Jaiminho_View_Emails_Create";
			case "SendPress_View_Emails_Edit":
				return "Jaiminho_View_Emails_Edit";
			case "SendPress_View_Emails_Send":
				return "Jaiminho_View_Emails_Send";
			case "SendPress_View_Emails_Send_Confirm":
				return "Jaiminho_View_Emails_Send_Confirm";
			case "SendPress_View_Emails_Send_Queue":
				return "Jaiminho_View_Emails_Send_Queue";
			case "SendPress_View_Emails_Tempdelete":
				return "Jaiminho_View_Emails_Tempdelete";
			case "SendPress_View_Emails_Tempclone":
				return "Jaiminho_View_Emails_Tempclone";
			case "SendPress_View_Subscribers_Listcreate":
				wp_enqueue_script('jaiminho_disable');
				return $view_class;
			case "SendPress_View_Settings_Account":
				$this->jaiminho_settings_account_email( $emails_credits );
				$this->jaiminho_settings_account_bounce( $bounce_email );
				return "Jaiminho_View_Settings_Account";
			default:
				return $view_class;
		}
	}

	public function render_view_jaiminho() {
		// começando a pensar em um sistema de páginas para i jaiminho
		//if ($_GET['view'] != 'templates_edit')
		//{
		$this->_page = SPNL()->validate->page( $_GET['page'] );
		$this->_current_view = isset( $_GET['view'] ) ? sanitize_text_field( $_GET['view'] ) : '';
		$emails_credits = isset (  $_POST['emails-credits'] ) ?  $_POST['emails-credits'] : SendPress_Option::get( 'emails-credits' );
		$bounce_email = isset (  $_POST['bounceemail'] ) ?  $_POST['bounceemail'] : null;
		$view_class = $this->jaiminho_get_view_class( $this->_page , $this->_current_view ,  $emails_credits  , $bounce_email );

		//echo "About to render: $view_class, $this->_page";
		echo " nova: ".$view_class;  

		$view_class = NEW $view_class;
		$queue      = '<span id="queue-count-menu-tab">-</span>';
		//$queue = //SendPress_Data::emails_in_queue();
		//add tabs
		// xxx: ainda não foi possivel descobrir onde esta o problema, simplesmente a página do overview repete o template - depois reativar a aba
		// $view_class->add_tab( __( 'Overview', 'sendpress' ), 'sp-overview', ( $this->_page === 'sp-overview' ) );
		$view_class->add_tab( __( 'Emails', 'sendpress' ), 'sp-emails', ( $this->_page === 'sp-emails' ) );
		$view_class->add_tab( __( 'Reports', 'sendpress' ), 'sp-reports', ( $this->_page === 'sp-reports' ) );
		$view_class->add_tab( __( 'Subscribers', 'sendpress' ), 'sp-subscribers', ( $this->_page === 'sp-subscribers' ) );
		$view_class->add_tab( __( 'Queue', 'sendpress' ) . ' <small>(' . $queue . ')</small>', 'sp-queue', ( $this->_page === 'sp-queue' ) );
		$view_class->add_tab( __( 'Settings', 'sendpress' ), 'sp-settings', ( $this->_page === 'sp-settings' ) );
		$view_class->prerender( $this );
		$view_class->render( $this );
		//}
	}
	public function jaiminho_admin_footer_css_hide(){
		?>
			<style type="text/css">
#wpfooter{
	display: none !important;
}
</style>
<?php

}


public function jaiminho_define_redelivre_default_smtp()
{
	SendPress_Option::set('sendmethod','Jaiminho_Sender_RedeLivre');
}

public static function autoload( $className ) {

	if ( strpos( $className, 'SendPress' ) !== 0 ) {
		return;
	}
	// Convert Classname to filename
	$cls = str_replace( '_', '-', strtolower( $className ) );
	if ( substr( $cls, - 1 ) == '-' ) {
		//AutoLoad seems to get odd clasname sometimes that ends with _
		return;
	}
	if ( class_exists( $className ) ) {
		return;
	}

	if ( strpos( $className, '_SC_' ) != false ) {
		if ( defined( 'SENDPRESS_PRO_PATH' ) ) {
			$pro_file = SENDPRESS_PRO_PATH . "classes/sc/class-" . $cls . ".php";
			if ( file_exists( $pro_file ) ) {
				include SENDPRESS_PRO_PATH . "classes/sc/class-" . $cls . ".php";

				return;
			}
		}
		include SENDPRESS_PATH . "classes/sc/class-" . $cls . ".php";

		return;
	}

	if ( strpos( $className, '_Tag_' ) != false ) {

		include SENDPRESS_PATH . "classes/tag/class-" . $cls . ".php";

		return;
	}

	if ( strpos( $className, '_DB' ) != false ) {

		include SENDPRESS_PATH . "classes/db/class-" . $cls . ".php";

		return;
	}

	if ( strpos( $className, 'Public_View' ) != false ) {
		if ( defined( 'SENDPRESS_PRO_PATH' ) ) {
			$pro_file = SENDPRESS_PRO_PATH . "classes/public-views/class-" . $cls . ".php";
			if ( file_exists( $pro_file ) ) {
				include SENDPRESS_PRO_PATH . "classes/public-views/class-" . $cls . ".php";

				return;
			}
		}
		if ( file_exists( SENDPRESS_PATH . "classes/public-views/class-" . $cls . ".php" ) ) {
			include SENDPRESS_PATH . "classes/public-views/class-" . $cls . ".php";
		}

		return;
	}

	if ( strpos( $className, 'View' ) != false ) {
		if ( defined( 'SENDPRESS_PRO_PATH' ) ) {
			$pro_file = SENDPRESS_PRO_PATH . "classes/views/class-" . $cls . ".php";
			if ( file_exists( $pro_file ) ) {
				include SENDPRESS_PRO_PATH . "classes/views/class-" . $cls . ".php";

				return;
			}
		}
		include SENDPRESS_PATH . "classes/views/class-" . $cls . ".php";

		return;
	}

	if ( strpos( $className, 'Module' ) != false ) {
		if ( defined( 'SENDPRESS_PRO_PATH' ) ) {
			$pro_file = SENDPRESS_PRO_PATH . "classes/modules/class-" . $cls . ".php";
			if ( file_exists( $pro_file ) ) {
				include SENDPRESS_PRO_PATH . "classes/modules/class-" . $cls . ".php";

				return;
			}
		}

		include SENDPRESS_PATH . "classes/modules/class-" . $cls . ".php";

		return;
	}

	if ( defined( 'SENDPRESS_PRO_PATH' ) ) {
		$pro_file = SENDPRESS_PRO_PATH . "classes/class-" . $cls . ".php";
		if ( file_exists( $pro_file ) ) {
			include SENDPRESS_PRO_PATH . "classes/class-" . $cls . ".php";

			return;
		}
	}

	if ( file_exists( JAIMINHO_PATH . "classes/class-" . $cls . ".php" ) ) {
		include JAIMINHO_PATH . "classes/class-" . $cls . ".php";
	}

	return;

}
}

register_activation_hook( __FILE__, array( 'Jaiminho' , 'create_templates' ) );
register_activation_hook( __FILE__, array( 'Jaiminho' , 'jaiminho_define_redelivre_default_smtp' ) );
register_deactivation_hook( __FILE__, array( 'Jaiminho' , 'remove_templates' ) );

global $Jaiminho;

$Jaiminho = new Jaiminho();
