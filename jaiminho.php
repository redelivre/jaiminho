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
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-settings-account.php' );
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
    add_action( 'admin_init', array($this,'configure_credits'));
    // this works!!!
    //add_action( 'admin_footer' , array( $this , 'jaiminho_filter_html' ) );
    add_action( 'jaiminho_page_sp-settings' , array( $this , 'jaiminho_filter_html' ) );
    //add_action( 'admin_init', array($this,'wpse_136058_debug_admin_menu'));
  }

  public function jaiminho_filter_html() {
      echo "##############################";
  }


  public function configure_credits()
  {
    $options = array();
    $options['emails-credits'] = str_replace($chars, "", $_POST['emails-credits']);
    SendPress_Option::set($options);
  }

  // function for remove especific elements from seenpress
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
    // XXX ajuda e pro não saem do overview
    add_submenu_page('sp-overview', __('Overview','sendpress'), __('Overview','sendpress'), $role, 'sp-overview', array($this,'render_view_jaiminho'));
    $main = add_submenu_page('sp-overview', __('Emails','sendpress'), __('Emails','sendpress'), $role, 'sp-emails', array($this,'render_view_jaiminho'));
    add_submenu_page('sp-overview', __('Reports','sendpress'), __('Reports','sendpress'), $role, 'sp-reports', array($this,'render_view_jaiminho'));
    add_submenu_page('sp-overview', __('Subscribers','sendpress'), __('Subscribers','sendpress'), $role, 'sp-subscribers', array($this,'render_view_jaiminho'));
    add_submenu_page('sp-overview', __('Queue','sendpress'), __('Queue','sendpress')  . " " . $queue, $role, 'sp-queue', array($this,'render_view_jaiminho'));
    add_submenu_page('sp-overview', __('Settings','sendpress'), __('Settings','sendpress'), $role, 'sp-settings', array($this,'render_view_jaiminho'));
    // além da aba teriamos que colocar a opção no menu
    //add_submenu_page('sp-overview', __('Settings','sendpress'), __('Settings','sendpress'), $role, 'sp-settings', array($this,'render_view_jaiminho'));

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
    //echo "About to render: $view_class, $this->_page";
    // se o nome da variavel é SendPress_View_Settings_Account troque por Jaiminho_View_Settings_Account
    var_dump($view_class);

    if($view_class == SendPress_View_Settings_Account)
      $view_class = "Jaiminho_View_Settings_Account";

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


}

global $Jaiminho;

$Jaiminho = new Jaiminho();
