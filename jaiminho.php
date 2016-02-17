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


require_once( ABSPATH . '/wp-content/plugins/sendpress/sendpress.php' );
require_once( ABSPATH . '/wp-content/plugins/sendpress/classes/views/class-sendpress-view.php' );
//require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-settings-account.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-send.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-overview.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-queue-all.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-queue.php' );
//Maurilio - A página settings possui um menu horizontal que é contruido pelo arquivo similar ao abaixo no sendpress. Aqui vou ter que fazer com que a página settings carregue o arquivo abaixo ao invez do arquivo original. TODO
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-settings.php' );
class Jaiminho extends SendPress
{
  protected $plugin_name;
  protected $sendpress_name;
  
  public function __construct()
  {
    add_action('init', array( $this , 'Init' ) );
  }

  public function Init()
  {
    $sendpress_name = __( 'SendPress', 'sendpress' );
    add_action( 'admin_init', array($this,'remove_menus'));
    add_action( 'admin_init', array($this,'add_menus'), 999);
    add_action( 'toplevel_page_sp-overview', array($this,'render_view_jaiminho'));
    add_action( 'jaiminho_page_sp-settings', array($this,'render_view_jaiminho'));
    // this works!!!
    //add_action( 'admin_footer' , array( $this , 'jaiminho_filter_html' ) );
    remove_action( 'in_admin_footer',array(SendPress_View::get_instance(),'footer'),10);
    //$this->remove_filters_for_anonymous_class('in_admin_footer','SendPress_View','footer',10);
    //new Jaiminho_View();
    add_filter( 'admin_footer_text', '__return_empty_string', 11 ); 
    add_filter( 'update_footer', '__return_empty_string', 11 );
    //add_filter( 'in_admin_footer', '__return_empty_string', -1 );
    //add_action( 'admin_init', array($this,'wpse_136058_debug_admin_menu'));
    //add_filter( 'sendpress_notices', array($this,'example_callback') );
    //apply_filter('sendpress_notices', array($this, 'example_callback'), 10);
    add_action( 'admin_print_styles' , array( $this , 'jaiminho_admin_footer_css_hide' ) );
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
  public function add_menus()
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
    add_menu_page( __('Jaiminho','sendpress'), __('Jaiminho','sendpress'), $role, 'sp-overview', array( $this , 'render_view_jaiminho' ), JAIMINHO_URL.'img/jaiminho-bg-16.png' );
    add_submenu_page('sp-overview', __('Overview','sendpress'), __('Overview','sendpress'), $role, 'sp-overview', array($this,'render_view_jaiminho'));
    $main = add_submenu_page('sp-overview', __('Emails','sendpress'), __('Emails','sendpress'), $role, 'sp-emails', array($this,'render_view_jaiminho'));
    add_submenu_page('sp-overview', __('Reports','sendpress'), __('Reports','sendpress'), $role, 'sp-reports', array($this,'render_view_jaiminho'));
    add_submenu_page('sp-overview', __('Subscribers','sendpress'), __('Subscribers','sendpress'), $role, 'sp-subscribers', array($this,'render_view_jaiminho'));
    add_submenu_page('sp-overview', __('Queue','sendpress'), __('Queue','sendpress')  . " " . $queue, $role, 'sp-queue', array($this,'render_view_jaiminho'));
    add_submenu_page('sp-overview', __('Settings','sendpress'), __('Settings','sendpress'), $role, 'sp-settings', array($this,'render_view_jaiminho'));
  }

  public function remove_menus()
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

  public function wpse_136058_debug_admin_menu()
  {
    echo '<pre>' . print_r( $GLOBALS[ 'menu' ], TRUE) . '</pre>';
  }

  public function render_view_jaiminho() {
    $this->_page = SPNL()->validate->page( $_GET['page'] );
    $this->_current_view = isset( $_GET['view'] ) ? sanitize_text_field( $_GET['view'] ) : '';
    $view_class = $this->get_view_class( $this->_page, $this->_current_view );
    var_dump(SendPress_Option::get('website-hosting-provider')); 
    echo "original: ".$view_class;
    
    //echo "About to render: $view_class, $this->_page";
    // se o nome da variavel é SendPress_View_Settings_Account troque por Jaiminho_View_Settings_Account

    if($view_class == "SendPress_View_Settings_Account")
    {
      $view_class = "Jaiminho_View_Settings_Account";
      // Maurilio - Hack Necessário pois não consegui direcionar para a função account_setup em jaiminho_settings_account
      $chars = array(".", ",", " ", ":", ";", "$", "%", "*", "-", "=");
      if($_POST['emails-credits'])
        SendPress_Option::set('emails-credits', str_replace($chars, "",$_POST['emails-credits']) ); 
      else if(SendPress_Option::get('emails-credits'))
       SendPress_Option::get('emails-credits');
      else 
        SendPress_Option::set('emails-credits', 1000 ); 

      if(isset($_POST['bounceemail']))
      {
        $bounceemail= $_POST['bounceemail'];
      }
      else if (SendPress_Option::get('bounce_email'))
        $bounceemail=SendPress_Option::get('bounce_email');
      if ( !isset( $bounceemail ) ) 
      {
        // Get the site domain and get rid of www.
        $sitename = strtolower( $_SERVER['SERVER_NAME'] );
        if ( substr( $sitename, 0, 4 ) == 'www.' ) {
          $sitename = substr( $sitename, 4 );
        }
        $bounceemail = 'bounce@' . $sitename;
      }
      SendPress_Option::set('bounce_email', $bounceemail );
    }
    if($view_class == "SendPress_View_Emails_Send")
      $view_class = "Jaiminho_View_Emails_Send";
    if($view_class == "SendPress_View_Overview")
      $view_class = "Jaiminho_View_Overview";
    if($view_class == "SendPress_View_Queue_All")
      $view_class = "Jaiminho_View_Queue_All";
    if($view_class == "SendPress_View_Queue")
      $view_class = "Jaiminho_View_Queue";
    echo " nova: ".$view_class;  

    $view_class = NEW $view_class;
    $queue      = '<span id="queue-count-menu-tab">-</span>';
    //$queue = //SendPress_Data::emails_in_queue();
    //add tabs
    $view_class->add_tab( __( 'Overview', 'sendpress' ), 'sp-overview', ( $this->_page === 'sp-overview' ) );
    $view_class->add_tab( __( 'Emails', 'sendpress' ), 'sp-emails', ( $this->_page === 'sp-emails' ) );
    $view_class->add_tab( __( 'Reports', 'sendpress' ), 'sp-reports', ( $this->_page === 'sp-reports' ) );
    $view_class->add_tab( __( 'Subscribers', 'sendpress' ), 'sp-subscribers', ( $this->_page === 'sp-subscribers' ) );
    $view_class->add_tab( __( 'Queue', 'sendpress' ) . ' <small>(' . $queue . ')</small>', 'sp-queue', ( $this->_page === 'sp-queue' ) );
    $view_class->add_tab( __( 'Settings', 'sendpress' ), 'sp-settings', ( $this->_page === 'sp-settings' ) );
    $view_class->prerender( $this );
    $view_class->render( $this );
  }
  function jaiminho_admin_footer_css_hide(){
    ?>
    <style type="text/css">
        #wpfooter{
            display: none !important;
        }
    </style>
    <?php
 
}

}

register_activation_hook( __FILE__, array( 'Jaiminho' , 'create_templates' ) );
register_deactivation_hook( __FILE__, array( 'Jaiminho' , 'remove_templates' ) );

global $Jaiminho;

$Jaiminho = new Jaiminho();
