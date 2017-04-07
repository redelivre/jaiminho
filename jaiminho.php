<?php
/*
   Plugin Name: Jaiminho Newsletters
   Version: 2.1
   Plugin URI: https://jaiminho.redelivre.org.br
   Description: Plugin que atualiza o Seedpress em tempo de execução com algumas personalizações para a Rede Livre.
   Author: RedeLivre
   Author URI: https://redelivre.org.br
   Developer: https://github.com/cabelotaina
   Developer: https://github.com/jacsonp

   Text Domain: jaiminho
   Domain Path: /languages/
 */

define( 'JAIMINHO_URL', plugin_dir_url( __FILE__ ) );
define( 'JAIMINHO_VERSION', 0.0 );
define( 'JAIMINHO_PATH', plugin_dir_path( __FILE__ ) );
define( 'SPNL_DISABLE_SENDING_DELIVERY',false);
define( 'SPNL_DISABLE_SENDING_GMAIL',false);
define( 'SPNL_DISABLE_SENDING_WP_MAIL',false);


// sendpress classes
require_once( ABSPATH . '/wp-content/plugins/sendpress/sendpress.php' );
require_once( ABSPATH . '/wp-content/plugins/sendpress/classes/class-sendpress-option.php' );

// divi classes
require_once __DIR__ . DIRECTORY_SEPARATOR . 'includes' . DIRECTORY_SEPARATOR . 'wp-divi'. DIRECTORY_SEPARATOR .'modules.php';

// jaiminho classes
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-send.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/plugins/mce-table-buttons/mce_table_buttons.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/class-jaiminho-signup-shortcode-old.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-overview.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-queue-all.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-queue.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-settings.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-queue-errors.php' );
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
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-settings-account.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-reports.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-subscribers.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-subscribers-csvimport.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-subscribers-add.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails-list-filter.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/class-jaiminho-sender-redelivre.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/class-jaiminho-sender-network.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/class-jaiminho-sender-gmail.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/class-tgm-plugin-activation.php' );
require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/class-jaiminho-widget-signup.php' );

class Jaiminho extends SendPress
{
	protected $plugin_name;
	protected $sendpress_name;

	public function __construct()
	{
		add_action('init', array( $this , 'Init' ) );
    add_action('widgets_init', create_function( '' , 'return register_widget("Jaiminho_Widget_Signup");'));
    //spl_autoload_register( array( 'Jaiminho', 'autoload' ) );
    Jaiminho_Signup_Shortcode::init();
	}

	public function Init()
	{
		$sendpress_name = __( 'SendPress', 'sendpress' );
		add_action( 'init' , array( $this , 'jaiminho_check_rewrite' ) );
		add_action( 'init' , array( $this , 'run_script' ) );
		sendpress_register_sender( 'Jaiminho_Sender_RedeLivre' );
		sendpress_register_sender( 'Jaiminho_Sender_Gmail' );
		remove_action( 'in_admin_footer',array(SendPress_View::get_instance(),'footer'),10);
		wp_register_script('jaiminho_disable', JAIMINHO_URL .'js/disable.js' ,'',JAIMINHO_VERSION);
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
      add_action( 'wpmu_new_blog', array( $this , 'jaiminho_set_settings_for_new_site' ) );
		}
		add_action( 'tgmpa_register', array( $this , 'jaiminho_register_required_plugins' ) );
		remove_action( 'init' , array( SPNL() , 'toplevel_page_sp-overview' ) );
		add_action( 'sendpress_notices', array( $this, 'jaiminho_notices' ) );
    add_action( 'init', array( $this, 'frame_it_up' ), 20 );
		add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_script') );
    add_action( 'admin_action_export', array($this,'export_report') );
    add_action( 'admin_action_exportsenderrors', array($this,'exportsenderrors') );
    add_action( 'admin_action_send_message', array($this,'send_message') );
    add_action( 'admin_action_export_all_lists', array($this,'export_all_lists') );
		add_action( 'admin_action_remove_hard_bounces', array($this,'remove_hard_bounces') );
    add_action( 'admin_action_import', array($this,'save_import') );
    add_filter( 'mce_buttons_2', array($this,'mce_buttons') );
    add_action( 'admin_action_addsubscriber', array($this,'addsubscriber') );
    add_action( 'admin_action_createsubscriber', array($this,'create_subscriber') );
    add_action( 'admin_action_createsubscribers', array($this,'create_subscribers') );
    add_action( 'admin_action_sendemails', array($this,'send_emails') );
    add_action( 'admin_action_saveemail', array($this,'save_email') );
    add_action( 'admin_action_createlist', array($this,'create_list') );
		add_action( 'admin_action_gethtml', array($this,'get_link_html_callback') );
		add_action( 'admin_init', array($this,'my_tinymce_button') );
		add_action( 'wp_ajax_get_link_html', array($this,'get_link_html_callback') );
		add_action( 'wp_ajax_nopriv_get_link_html', array($this,'get_link_html_callback' ));

		// docs to understand this see: https://codex.wordpress.org/Plugin_API/Admin_Screen_Reference
    add_action( "admin_head-toplevel_page_sp-emails", array($this,'my_admin_head') );

	}

  public function remove_hard_bounces(){
		$email = SendPress_Option::get("bounce_email");
		$password = get_option("bounce_email_password");
		$server = get_option("bounce_email_server");
		$port = get_option("bounce_email_port");


		require_once("includes/php-bounce-handler/bounce_driver.class.php");
		$bouncehandler = new Bouncehandler();

		/* connect to gmail */
		//$hostname = '{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX';
		$hostname = '{'.$server.':'.$port.'/imap/ssl/novalidate-cert}INBOX';
		$username = $email;
		$password = $password;

		$inbox = imap_open($hostname,$username,$password) or die('Cannot connect to Gmail: ' . imap_last_error());

		$emails = imap_search($inbox,'UNANSWERED');

		if($emails) {

			rsort($emails);
			set_time_limit(0);

			foreach( $emails as $email ) {

				$overview = imap_fetch_overview($inbox,$email,0);

		    $bounce = imap_fetchheader($inbox, $email).imap_body($inbox, $email);

		    $multiArray = $bouncehandler->get_the_facts($bounce);
				//var_dump($multiArray);
				if($multiArray != array()){
					if($multiArray[0]["recipient"] == "failed"){
						$subscriberID = SendPress_Data::get_subscriber_by_email($multiArray[0]["recipient"]);
						SendPress_Data::delete_subscriber($subscriberID);
					}
				}
			}
		}

		/* close the connection */
		imap_close($inbox);
			SendPress_Admin::redirect( 'Subscribers' );
	}
	/**
	 * Localize Script
	 */
	function my_admin_head() {
	    $plugin_url = plugins_url( '/', __FILE__ );
	    ?>
	<!-- TinyMCE Shortcode Plugin -->
	<script type='text/javascript'>

	var my_plugin = {
	    'url': '<?php echo admin_url('admin.php'); ?>',
	};
	</script>
	<!-- TinyMCE Shortcode Plugin -->
	    <?php
	}

	function get_link_html_callback(){
		if($_GET["url"] != ""){
			$url = $_GET["url"];
			if(filter_var($url, FILTER_VALIDATE_URL)){
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
				$content_old = curl_exec($ch);
				curl_close($ch);
				$content_old = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $content_old);
				$content = wp_kses($content_old,
				array(
					'head' => array(
						'meta' => array(),
						'title' => array(),
					),
			    'a' => array(
			        'href' => array(
							),
			        'title' => array(),
							'style' => array(),
			    ),
			    'br' => array(),
			    'em' => array(),
					'p' => array(
						'stylle' => array(),
					),
					'img' => array(
						'src' => array(),
						'style' => array(),
					),
			    'strong' => array(),
					'center' => array(),
					'table' => array(
						'tr' => array(
							'style' => array()
						),
						'td' => array(
							'style' => array()
						),
						'style' => array(),
					),
					'div' => array(
						'style' => array(),
					),
					'style' => array(
						'type' => array(
							'text/css'
						),
					),
				), array("http","https","ftp", "irc", "mailto"));
				echo $content;
			}
		}
		die();
	}
	function my_tinymce_button() {
	     if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
	          add_filter( 'mce_buttons', array($this,'my_register_tinymce_button') );
	          add_filter( 'mce_external_plugins', array($this,'my_add_tinymce_button') );
	     }
	}

	function my_register_tinymce_button( $buttons ) {
	     array_push( $buttons, "button_addlink" );
	     return $buttons;
	}

	function my_add_tinymce_button( $plugin_array ) {
	     $plugin_array['my_button_script'] = plugins_url( '/mybuttons.js', __FILE__ ) ;
	     return $plugin_array;
	}

  function create_list(){
    $vars = $_GET;
    if(count($vars) == 4){
      SendPress_Admin::redirect('Emails_Send', array('emailID'=> SPNL()->validate->_int('emailID') ) );
    }

    global $wpdb;
    $meta_table = SendPress_Data::subscriber_meta_table();
    $query = "select distinct subscriberID from $meta_table where";

    $name = "";
    if (isset($vars["states"])) {
      foreach ($vars["states"] as $state) {
        $name .= "_" . $state;
        $query .= $wpdb->prepare( " meta_value=%s or ", $state);
      }
    }

    if (isset($vars['cities'])) {
      foreach ($vars["cities"] as $city) {
        $name .= "_" . $city;
        $query .= $wpdb->prepare( " meta_value=%s or ", $city);
      }
    }

    if (isset($vars['genres'])) {
      foreach ($vars["genres"] as $genre) {
        $name .= "_" . $genre;
        $query .= $wpdb->prepare( " meta_value=%s or ", $genre);
      }
    }

    if (isset($vars['categories'])) {
      $last_value = end(array_values($vars["categories"]));
      foreach ($vars["categories"] as $category) {
        $name .= "_" . $category;
      }
    }

    $public = 0;

    $query = substr($query, 0, -3);

    $list = SendPress_Data::create_list( array('name'=> $name, 'public'=>$public ) );

    $subscribers = $wpdb->get_results($query);

    //addsubscriber

    foreach ($subscribers as $key => $subscriber) {
      $subscriber = $subscriber->subscriberID;
      $list_values['listID'] = $list;
      $list_values['subscriberID'] = $subscriber;
      $list_values['status'] = 2;
      $list_values['updated'] = date('Y-m-d H:i:s');

      $table = SendPress_Data::list_subcribers_table();
      $result = $wpdb->insert($table,$list_values);
    }

    SendPress_Admin::redirect('Emails_Send', array('emailID'=> SPNL()->validate->_int('emailID') ) );
  }

  function send_emails(){
      $saveid = SPNL()->validate->_int('post_ID');
      update_post_meta( $saveid, 'send_date', date('Y-m-d H:i:s') );
      $email_post = get_post( $saveid );
      $subject = SendPress_Option::get('current_send_subject_'. $saveid);
      $info = SendPress_Option::get('current_send_'.$saveid);
      $slug = SendPress_Data::random_code();
      $new_id = SendPress_Posts::copy($email_post, $subject, $slug, SPNL()->_report_post_type );
      SendPress_Posts::copy_meta_info($new_id, $saveid);
      $lists = implode(',', $info['listIDS']);

      update_post_meta($new_id,'_send_time',  $info['send_at'] );
      update_post_meta($new_id,'_send_lists', $lists );
      update_post_meta($new_id,'_stat_type', 'new' );
      $count = 0;
      if(get_post_meta($saveid ,'istest',true) == true ){
          update_post_meta($new_id,'_report_type', 'test' );
      }
      update_post_meta($new_id ,'_sendpress_subject', $subject );
      if(isset($info['testemails']) && $info['testemails'] != false ){
          foreach($info['testemails'] as $email){

                   $go = array(
                      'from_name' => 'Josh',
                      'from_email' => 'joshlyford@gmail.com',
                      'to_email' => $email['email'],
                      'emailID'=> $new_id,
                      'subscriberID'=> 0,
                      'subject' => $subject,
                      'listID' => 0
                      );

                  SPNL()->add_email_to_queue($go);
                  $count++;
          }
      }
      update_post_meta($new_id,'_send_count', $count );

      SendPress_Admin::redirect('Emails_Send_Queue',array('emailID'=> $new_id));

  }

  function save_email(){

    $post_id =  SPNL()->validate->_int('post_ID');
    if($post_id > 0){

      $html = SPNL()->validate->_html('content_area_one_edit');
      $post_update = array(
        'ID'           => $post_id,
            'post_content' => $html
        );

      update_post_meta( $post_id, '_sendpress_template', SPNL()->validate->_int('template') );
      update_post_meta( $post_id, '_sendpress_subject', sanitize_text_field(SPNL()->validate->_string('post_subject' )) );
      if( SPNL()->validate->_isset('header_content_edit')){
        update_post_meta( $post_id, '_header_content', SPNL()->validate->_html('header_content_edit') );
      }
      if( SPNL()->validate->_isset('footer_content_edit')){
        update_post_meta( $post_id, '_footer_content', SPNL()->validate->_html('footer_content_edit') );
      }

      remove_filter('content_save_pre', 'wp_filter_post_kses');
      remove_filter('content_filtered_save_pre', 'wp_filter_post_kses');
      wp_update_post( $post_update );
      add_filter('content_save_pre', 'wp_filter_post_kses');
      add_filter('content_filtered_save_pre', 'wp_filter_post_kses');

    }

        if( SPNL()->validate->_string('submit') == 'save-next'){
          SendPress_Admin::redirect('Emails_List_Filter', array('emailID'=> SPNL()->validate->_int('post_ID') ) );
        } else if (SPNL()->validate->_string('submit') == 'send-test'){
            $email = new stdClass;
            $email->emailID  = SPNL()->validate->_int('post_ID');
            $email->subscriberID = 0;
            $email->listID = 0;
            $email->to_email = SPNL()->validate->_email('test-email');
            $d =SendPress_Manager::send_test_email( $email );
            //print_r($d);
            SendPress_Admin::redirect('Emails_Edit', array('emailID'=>SPNL()->validate->_int('emailID') ));
        } else {
            SendPress_Admin::redirect('Emails_Edit', array('emailID'=>SPNL()->validate->_int('emailID') ));
        }

  }
  function create_subscriber(){
    $email = SPNL()->validate->_email('email');
    $fname = SPNL()->validate->_string('firstname');
    $lname = SPNL()->validate->_string('lastname');
    $phonenumber = SPNL()->validate->_string('phonenumber');
    $salutation = SPNL()->validate->_string('salutation');
    $listID = SPNL()->validate->_int('listID');
    $status = SPNL()->validate->_string('status');
    $subscriber_id = "";

    if( is_email($email) ){
        $result = SendPress_Data::add_subscriber( array('firstname'=> $fname ,'email'=> $email,'lastname'=>$lname, 'phonenumber'=>$phonenumber, 'salutation'=>$salutation) );
        SendPress_Data::update_subscriber_status($listID, $result, $status ,false);
        $subscriber_id = $result;
    }

    $state = SPNL()->validate->_string('state');
    $city = SPNL()->validate->_string('city');
    $genre = SPNL()->validate->_string('genre');
    $category = SPNL()->validate->_string('category');

    SendPress_Data::update_subscriber_meta($subscriber_id,'state',$state, $listID);
    SendPress_Data::update_subscriber_meta($subscriber_id,'city',$city, $listID);
    SendPress_Data::update_subscriber_meta($subscriber_id,'genre',$genre, $listID);
    SendPress_Data::update_subscriber_meta($subscriber_id,'category',$category, $listID);

    SendPress_Admin::redirect( 'Subscribers_Subscribers' , array( 'listID' => $listID ) );

  }

	function create_subscribers(){
	//$this->security_check();
	$csvadd = "email,firstname,lastname\n" . trim( SPNL()->validate->_string('csv-add') );
	$listID = SPNL()->validate->_int('listID');
	if($listID > 0 ){
	$newsubscribers = SendPress_Data::subscriber_csv_post_to_array( $csvadd );

	foreach( $newsubscribers as $subscriberx){
			if( is_email( trim( $subscriberx['email'] ) ) ){

			$result = SendPress_Data::add_subscriber( array('firstname'=> trim($subscriberx['firstname']) ,'email'=> trim($subscriberx['email']),'lastname'=> trim($subscriberx['lastname']) ) );
			SendPress_Data::update_subscriber_status($listID, $result, 2, false);
			}
	}

	}
	SendPress_Admin::redirect( 'Subscribers_Subscribers' , array( 'listID' => $listID ) );
}

  function addsubscriber(){
    if (isset($_POST)) {
      $values = array();
      $values['email'] = $_POST['email'] ? $_POST['email']:"";
      $values['firstname'] = $_POST['firstname'] ? $_POST['firstname']:"";
      $values['lastname'] = $_POST['lastname'] ? $_POST['lastname']:"";
      $values['phonenumber'] = $_POST['phonenumber'] ? $_POST['phonenumber']:"";
      $user = SendPress_Data::add_subscriber($values);

      $list_values = array();
      $listID = $_POST['list'] ? $_POST['list']:"";
      $list_values['listID'] = $listID;
      $list_values['subscriberID'] = $user;
      $list_values['status'] = 2;
      $list_values['updated'] = date('Y-m-d H:i:s');

      $table = SendPress_Data::list_subcribers_table();
      global $wpdb;
      $result = $wpdb->insert($table,$list_values);

      if (!$result) {
        $id = $wpdb->get_var( 'select * from wp_sendpress_list_subscribers where listID = '.$list_values['listID'].' and subscriberID = '.$list_values['subscriberID']);
        $wpdb->update($table,$list_values, array('id' => $id));
      }

      $link = isset($_POST['link'])?$_POST['link']:"";
      if (isset($link)) {
        wp_redirect($link."?result=1");
      }
    }
  }

  function send_message(){
    $result = wp_mail( get_option('admin_email'), "Créditos no blog ".get_bloginfo(), 'O blog ' . network_site_url( '/' ) . ' - ' . get_bloginfo() . " necessita de mais créditos.");
    SendPress_Admin::redirect('Queue', array('result' => $result));
  }

	function save_import(){

    $uploadfiles = $_FILES['uploadfiles'];

	  if (is_array($uploadfiles)) {
      if ( $uploadfiles['error'] == 0 ) {

        $filetmp = $uploadfiles['tmp_name'];

        $filename = $uploadfiles['name'];

        $filetype = wp_check_filetype( $filename, array('csv' => 'text/csv') );

        $filetitle = preg_replace('/\.[^.]+$/', '', basename( $filename ) );
        $filename = $filetitle . '.' . $filetype['ext'];

        $upload_dir = wp_upload_dir();
        if( $filetype['ext'] != 'csv' || $filetype['type'] != 'text/csv'){
          SendPress_Admin::redirect('Subscribers_Csvimport',array('listID'=> SPNL()->validate->_int( 'listID' )));
        }

        // $i = 0;
        // while ( file_exists( $upload_dir['path'] .'/' . $filename ) ) {
        //   $filename = $filetitle . '_' . $i . '.' . $filetype['ext'];
				// 	var_dump($filename);
        //   $i++;
        // }

        $filedest = $upload_dir['path'] . '/' . $filename;

        $filedest = str_replace('\\','/', $filedest);
        if ( !is_writeable( $upload_dir['path'] ) ) {
          SendPress_Option::set('import_error', true);
        }

        if ( !@move_uploaded_file($filetmp, $filedest) ){
          SendPress_Option::set('import_error', true);
        }
        update_post_meta(SPNL()->validate->_int( 'listID' ),'csv_import',$filedest);
        //if( SendPress_Option::get('import_error', false) == 1 ){
		      SendPress_Admin::redirect('Subscribers_Csvprep',array('listID'=> SPNL()->validate->_int( 'listID' )));
        //}
      }
    }
	}

  function mce_buttons( $buttons ) {
    array_unshift( $buttons, 'fontselect' );
    array_unshift( $buttons, 'fontsizeselect' );
    return $buttons;
  }

  function export_all_lists(){
    $query = SendPress_Data::get_lists();
    header("Content-type:text/octect-stream");
    header("Content-Disposition:attachment;filename=sendpress.csv");
    echo "email, firstname, lastname, status, phone, list \n";
    while($query->have_posts()){
        $query->the_post();
        $item = get_post();
        $subscribers = SendPress_Data::export_subscirbers($item->ID);
        foreach($subscribers as $sb){
          echo $sb->email . "," .
               $sb->firstname . "," .
               $sb->lastname . "," .
               $sb->status . "," .
               $sb->phonenumber . "," .
               $item->post_title . "\n";
        }
    }
  }

  public function exportsenderrors()
  {
    header("Content-type:text/octect-stream");
    header("Content-Disposition:attachment;filename=sendpress_errors.csv");
    echo "Email,Tipo de Erro \n";
    $errors =  SPNL()->log->get_logs(0,'sending');
    foreach ($errors as $error) {
      $error_description = $error->post_title;
      $email = strip_tags ( $error->post_content );
      $error_email = explode ( " " , $email )[count($email)];
      echo $error_email.",".$error_description."\n";
    }
  }

  function export_report(){
    $args = array(
        'post_type' => 'sp_report' ,
        'post_status' => array('publish','draft'),
        'posts_per_page' => -1,
        'fields' => 'ids',
        'meta_query' => array(
           array(
               'key' => '_report_type',
               'compare' => 'not exists',

            ),
        ),
    );

    $query = new WP_Query( $args );

    if($query->have_posts()){

        header("Content-type:text/octect-stream");
        header("Content-Disposition:attachment;filename=sendpress.csv");
        print "Titulo,Destinatarios,Enviados,Na Fila,Lista,Unique,Total,Inscritos via URL Unique,Inscritos via URL Total,Desinscritos,Data \n";

        while($query->have_posts()){
            $query->the_post();
            $item = get_post();
            $stat_type = get_post_meta($item->ID, '_stat_type', true);


            $rec = get_post_meta($item->ID, '_send_count', true) + get_post_meta($item->ID, '_send_last_count', true)  . '';
            $sentold = get_post_meta($item->ID, '_sent_total', true);

            $queue = 0;
            $sent = get_post_meta($item->ID, '_send_total', true);
            $inqueue = get_post_meta($item->ID, '_in_queue', true);
            if($inqueue !== 'none'){
                $queue = SendPress_Data::emails_in_queue($item->ID);
                $sentindb =  SendPress_Data::emails_sent_in_queue_for_report($item->ID);
                if($sentindb > $sent){
                    update_post_meta($item->ID, '_send_total', $sentindb);
                    $sent = $sentindb;
                }
                if($queue == 0){
                   update_post_meta($item->ID, '_in_queue', 'none');
                }
            }


                $display = '';
            $info = get_post_meta($item->ID, '_send_data', true);
            if(!empty($info['listIDS']) ){
                foreach($info['listIDS'] as $list_id){

                $list = get_post( $list_id );
                if($list &&  $list->post_type == 'sendpress_list'){
                    $display .= $list->post_title.'<br>';
                }

                }
            } else {

                $lists = get_post_meta($item->ID,'_send_lists', true);
                $list = explode(",",$lists );
                foreach($list as $list_id){

                $list = get_post( $list_id );
                if($list &&  $list->post_type == 'sendpress_list'){
                    $display .= $list->post_title.'<br>';
                }

                }

            }


            $opens = SPNL()->load("Subscribers_Tracker")->get_opens( $item->ID  );
            $opens_total = SPNL()->load("Subscribers_Tracker")->get_opens_total( $item->ID  );
            $opens =  $opens == 0 ? '-' : $opens;
            $opens_total =  $opens_total == 0 ? '-' : $opens_total;

            $clicks = SPNL()->load("Subscribers_Url")->clicks_email_id( $item->ID  );
            $clicks_total = SPNL()->load("Subscribers_Url")->clicks_total_email_id( $item->ID  );
            $clicks =  $clicks == 0 ? '-' : $clicks;
            $clicks_total =  $clicks_total == 0 ? '-' : $clicks_total;


            $unsubscribers = SPNL()->load("Subscribers_Tracker")->get_unsubs( $item->ID  );
            $unsubscribert =  $unsubscribers == 0 ? '-' : $clicks;

            $date = get_post_meta($item->ID, "send_date", true);

            $date_final = !empty( $date )? date_i18n(get_option('date_format') ,strtotime($date) ) : 'sem data';
            print  get_the_title() . "," .$rec .",". $sent .",". $queue ."," . strip_tags($display) . "," . $opens .",". $opens_total . "," . $clicks . "," . $clicks_total . "," . $clicks . "," . $date_final."\n";
        }
    }
  }

  function frame_it_up( $init_array ){
    global $allowedtags, $allowedposttags;
    $allowedposttags['iframe'] = $allowedtags['iframe'] = array(
      'name' => true,
      'id' => true,
      'class' => true,
      'style' => true,
      'src' => true,
      'width' => true,
      'height' => true,
      'allowtransparency' => true,
      'frameborder' => true,
    );
  }


	function jaiminho_notices() {

		$registered = strtotime(get_blog_details()->registered);
		$now = new DateTime();
		$now = strtotime($now->format('Y-m-d H:i:s'));
		$secs = $now - $registered;
		$days = $secs / 86400;

		if (!get_option('emails-credits') && $days > 100 &&  SendPress_Option::get( 'sendmethod' ) === 'Jaiminho_Sender_NetWork'  )
		{
			echo '<div class="notice notice-info is-dismissible"><p>';
			echo "<strong>";
			_e( 'Olá!', 'sendpress' );
			echo "</strong>&nbsp;";
			printf( __( '  Seus créditos acabaram, entre em contato para pedir mais créditos', 'jaiminho' ));
			echo '</p></div>';
		}

		if (get_option('emails-credits') == "5000" && $days <10 )
		{
			echo '<div class="notice notice-success is-dismissible"><p>';
			echo "<strong>";
			_e( 'Olá!', 'sendpress' );
			echo "</strong>&nbsp;";
			printf( __( '  Bem vindo a plataforma, nós colocamos 5000 créditos, ou seja você pode enviar 5k emails a partir de agora, se precisar de mais entre em contato com a gente', 'jaiminho' ));
			echo '</p></div>';
		}


	}

  function jaiminho_set_settings_for_new_site($blog_id){
    switch_to_blog( $blog_id );

    activate_plugin('sendpress/sendpress.php');
    //activate_plugin('jaiminho/jaiminho.php');
    SendPress_Option::set( 'wpcron-per-call' , 5000 );
    SendPress_Option::set( 'emails-per-day' , 5000);
    SendPress_Option::set( 'emails-per-hour' , 2500 );

    switch_to_blog( 1 );
    $args = array (
                   'networkuser'     => get_option('networkuser'),
                   'networkpass'     => get_option('networkpass'),
                   'networkserver'   => get_option('networkserver'),
                   'networkport'     => get_option('networkport'),
                   'bounce_email'    => get_option('bounce_email'),
                   'sendmethod'      => 'Jaiminho_Sender_NetWork',
                 );
    switch_to_blog( $blog_id );
    foreach( $args as $key => $value )
    {
      $method = SendPress_Option::set($key,$value);
    }
		$jaiminho = new Jaiminho();
    $jaiminho->jaiminho_define_opt_in_email();
    $jaiminho->create_templates();

    restore_current_blog();
  }

	public static function jaiminho_define_opt_in_email(){

		$optin = SendPress_Data::get_template_id_by_slug('double-optin');
		$my_post = array(
				'ID'           => $optin,
				'post_title' => "Por favor responda para entrar na lista de emails da *|SITE:TITLE|*",
				'post_content' => "Olá!

				Falta pouco para podermos enviar para você e-mail do site *|SITE:TITLE|*, mas antes disto precisamos que você confirme que você realmente quer receber nossas informações.

				Se você quer receber informações do *|SITE:TITLE|* no seu e-mail, você só precisa clicar no linque abaixo. Muito obrigado!
				———————————————————————————————————
				CONFIRME UTILIZANDO O LINQUE ABAIXO:

				*|SP:CONFIRMLINK|*

				Clique no linque acima para nos dar permissão de te enviar
				informações. É rápido e fácil! Se você não conseguir clicar,
				copie e cole o linque o seu navegador.
				———————————————————————————————————

				Se você não quiser receber e-mails, simplesmente ignore esta mensagem."
		);

		wp_update_post($my_post);
	}

	public function jaiminho_register_required_plugins(){
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
				'has_notices'  => false,                    // Show admin notices or not.
				'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,                   // Automatically activate plugins after installation or not.
				'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}

	public function jaiminho_check_rewrite(){
		global $wp_rewrite;

		$rules = $wp_rewrite->extra_rules_top;
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
				$wp_rewrite->flush_rules();
			}
		}
	}

	public function jaiminho_network_settings(){
    $basename = 'jaiminho-network-settings';
		add_menu_page( __('Jaiminho','jaiminho'), __('Jaiminho','jaiminho'), 'manage_network_options', $basename, array( $this , 'jaiminho_settings_network_html' ), JAIMINHO_URL . 'img/jaiminho-bg-16.png' );

		add_submenu_page(
				$basename,
				__('Configurar Contas','jaiminho'),
				__('Configurar Contas','jaiminho'),
				'manage_network_options',
				$basename,
				array( $this , 'jaiminho_settings_network_html' )
		);

		add_submenu_page(
				$basename,
				__('Configurar Créditos','jaiminho'),
				__('Configurar Créditos','jaiminho'),
				'manage_network_options',
				'jaiminho-network-credits-settings',
				array( $this , 'jaiminho_settings_network_html_credits' )
		);

		add_submenu_page(
				$basename,
				__('Configurar Limite de Envio','jaiminho'),
				__('Configurar Limite de Envio','jaiminho'),
				'manage_network_options',
				'jaiminho-emails-limits-settings',
				array( $this , 'jaiminho_emails_limits_html' )
		);

		add_submenu_page(
				$basename,
				__('Corrigir tabelas','jaiminho'),
				__('Corrigir tabelas','jaiminho'),
				'manage_network_options',
				'jaiminho-fix-tables--settings',
				array( $this , 'jaiminho_fix_tables_html' )
		);
	}

  public function jaiminho_fix_tables_html(){

	  global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    $collate = '';
    if ( $wpdb->has_cap( 'collation' ) ) {
        if( ! empty($wpdb->charset ) ){
              $collate .= "DEFAULT CHARACTER SET $wpdb->charset";
        }

        if( ! empty($wpdb->collate ) ){
             $collate .= " COLLATE $wpdb->collate";
        }

    }
    ?>
		<form method="post">
		  <input type="hidden" name="fix_tables" value="true" />
			<?php	submit_button(__( 'Corrigir Tabelas' , 'jaiminho' )); ?>
		</form>
    <?php

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
			//TODO: this function is deprecated for wp 4.6.0
		  $blogs = wp_get_sites( $args );
      // debug info
		  // echo '<pre>';
		  // var_dump($blogs);
		  // echo '</pre>';
		  foreach( $blogs as $blog ){
			  switch_to_blog( $blog['blog_id'] );
			  echo '<br>';
			  echo get_bloginfo( 'name' );
			  echo '<br>';

			  echo "<b>Database Tables</b>: <br>";

        // primera tabela

        $subscriber_events_table =  new SendPress_DB_Subscribers_Tracker();
			  $subscriber_events_table = $subscriber_events_table->table_name;
			  if($wpdb->get_var("show tables like '$subscriber_events_table'") != $subscriber_events_table) {
				  echo $subscriber_events_table . " Not Installed<br>";

				  if(isset($_POST['fix_tables'])){
            $command = " CREATE TABLE $subscriber_events_table (
            subscriberID int(11) unsigned NOT NULL,
            emailID int(11) unsigned NOT NULL,
            sent_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            opened_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
            status tinyint(4) NOT NULL DEFAULT '0',
            PRIMARY KEY  (subscriberID,emailID)
            )  $collate;\n";

            $return = dbDelta($command);

            echo $return["wp_sendpress_report_url"];
				  }
			  }
        else {
				  echo $subscriber_events_table . " OK<br>";
			  }

// XXX Terminar indentação do jaiminho

// segunda tabela
			$subscriber_events_table =  new SendPress_DB_Subscribers_Url();
			$subscriber_events_table = $subscriber_events_table->table_name;
			if($wpdb->get_var("show tables like '$subscriber_events_table'") != $subscriber_events_table) {
				echo $subscriber_events_table . " Not Installed<br>";

				if(isset($_POST['fix_tables']))
						{
$command = " CREATE TABLE $subscriber_events_table (
subscriberID int(11) unsigned NOT NULL,
emailID int(11) unsigned NOT NULL,
urlID int(11) unsigned NOT NULL,
clicked_at datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
click_count int(11) unsigned NOT NULL,
PRIMARY KEY  ( subscriberID , emailID , urlID )
)  $collate;\n";

$return = dbDelta($command);

echo $return["wp_sendpress_report_url"];
				}


			} else {
				echo $subscriber_events_table . " OK<br>";
			}
//terceira tabela
			$subscriber_events_table =  new SendPress_DB_Url();
			$subscriber_events_table = $subscriber_events_table->table_name;
			if($wpdb->get_var("show tables like '$subscriber_events_table'") != $subscriber_events_table) {
				echo $subscriber_events_table . " Not Installed<br>";

				if(isset($_POST['fix_tables']))
						{
$command = " CREATE TABLE $subscriber_events_table (urlID int(11) unsigned NOT NULL AUTO_INCREMENT, url text,hash varchar(255) DEFAULT NULL, PRIMARY KEY  (urlID), KEY hash (hash))  $collate;\n";
$return = dbDelta($command);

echo $return["wp_sendpress_report_url"];
				}

			} else {
				echo $subscriber_events_table . " OK<br>";
			}

// quarta tabela
			$report_url_table =  SendPress_DB_Tables::report_url_table();
			if($wpdb->get_var("show tables like '$report_url_table'") != $report_url_table) {
				echo $report_url_table . " Not Installed<br>";

				if(isset($_POST['fix_tables']))
						{
$command = " CREATE TABLE $report_url_table (
urlID int(11) unsigned NOT NULL AUTO_INCREMENT,
url varchar(2000) DEFAULT NULL,
reportID int(11) DEFAULT NULL,
PRIMARY KEY  (urlID),
KEY reportID (reportID),
KEY url (url(255))
) $collate;\n";

$return = dbDelta($command);

echo $return["wp_sendpress_report_url"];
				}
			} else {
				echo $report_url_table . " OK<br>";
			}
// quinta tabela
			$subscriber_status_table =  SendPress_DB_Tables::subscriber_status_table();
			if($wpdb->get_var("show tables like '$subscriber_status_table'") != $subscriber_status_table) {
				echo $subscriber_status_table . " Not Installed<br>";

				if(isset($_POST['fix_tables']))
						{
$command = " CREATE TABLE $subscriber_status_table (
statusid int(11) unsigned NOT NULL AUTO_INCREMENT,
status varchar(255) DEFAULT NULL,
PRIMARY KEY  (statusid)
) $collate;\n";

$return = dbDelta($command);

echo $return["wp_sendpress_report_url"];
				}
			} else {
				echo $subscriber_status_table . " OK<br>";
			}
// sexta tabela
			$subscriber_table = SendPress_DB_Tables::subscriber_table();
			if($wpdb->get_var("show tables like '$subscriber_table'") != $subscriber_table) {
				echo $subscriber_table . " Not Installed<br>";

				if(isset($_POST['fix_tables']))
						{
$command = " CREATE TABLE $subscriber_table (
subscriberID bigint(20) unsigned NOT NULL AUTO_INCREMENT,
email varchar(100) NOT NULL DEFAULT '',
join_date datetime  NOT NULL DEFAULT '0000-00-00 00:00:00',
status int(1) NOT NULL DEFAULT '1',
registered datetime  NOT NULL DEFAULT '0000-00-00 00:00:00',
registered_ip varchar(20) NOT NULL DEFAULT '',
identity_key varchar(60) NOT NULL DEFAULT '',
bounced int(1) NOT NULL DEFAULT '0',
firstname varchar(250) NOT NULL DEFAULT '',
lastname varchar(250) NOT NULL DEFAULT '',
wp_user_id bigint(20) DEFAULT NULL,
phonenumber varchar(12) DEFAULT NULL,
salutation varchar(40) DEFAULT NULL,
PRIMARY KEY  (subscriberID),
UNIQUE KEY email (email) ,
UNIQUE KEY identity_key (identity_key),
UNIQUE KEY wp_user_id (wp_user_id)
) $collate;\n";

$return = dbDelta($command);

echo $return["wp_sendpress_report_url"];
				}
			} else {
				echo $subscriber_table . " OK<br>";
			}
//setima tabela
			$subscriber_list_subscribers = SendPress_DB_Tables::list_subcribers_table();
			if($wpdb->get_var("show tables like '$subscriber_list_subscribers'") != $subscriber_list_subscribers) {
				echo $subscriber_list_subscribers . " Not Installed<br>";

				if(isset($_POST['fix_tables']))
						{
$command .= " CREATE TABLE $subscriber_list_subscribers (
id int(11) unsigned NOT NULL AUTO_INCREMENT,
listID int(11) DEFAULT NULL,
subscriberID int(11) DEFAULT NULL,
status int(1) DEFAULT NULL,
updated datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY  (id),
KEY listID (listID) ,
KEY subscriberID (subscriberID) ,
KEY status (status),
UNIQUE KEY listsub (subscriberID,listID)
) $collate;\n";

$return = dbDelta($command);

echo $return["wp_sendpress_report_url"];
				}
			} else {
				echo $subscriber_list_subscribers . " OK<br>";
			}
//oitava tabela
			$subscriber_queue = SendPress_DB_Tables::queue_table();
			if($wpdb->get_var("show tables like '$subscriber_queue'") != $subscriber_queue) {
				echo $subscriber_queue . " Not Installed<br>";

				if(isset($_POST['fix_tables']))
						{
$command .=" CREATE TABLE $subscriber_queue (
id int(11) NOT NULL AUTO_INCREMENT,
subscriberID int(11) DEFAULT NULL,
listID int(11) DEFAULT NULL,
from_name varchar(64) DEFAULT NULL,
from_email varchar(128) NOT NULL,
to_email varchar(128) NOT NULL,
subject varchar(255) NOT NULL,
messageID varchar(400) NOT NULL,
emailID int(11) NOT NULL,
max_attempts int(11) NOT NULL DEFAULT '3',
attempts int(11) NOT NULL DEFAULT '0',
success tinyint(1) NOT NULL DEFAULT '0',
date_published datetime  NOT NULL DEFAULT '0000-00-00 00:00:00',
inprocess int(1) DEFAULT '0',
last_attempt datetime  NOT NULL DEFAULT '0000-00-00 00:00:00',
date_sent datetime  NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY  (id),
KEY to_email (to_email),
KEY subscriberID (subscriberID),
KEY listID (listID),
KEY inprocess (inprocess),
KEY success (success),
KEY max_attempts (max_attempts),
KEY attempts (attempts),
KEY last_attempt (last_attempt),
KEY date_sent (date_sent),
KEY success_date (success,last_attempt,max_attempts,attempts,inprocess,date_sent)
) $collate;\n";

$return = dbDelta($command);

echo $return["wp_sendpress_report_url"];
				}
			} else {
				echo $subscriber_queue . " OK<br>";
			}
			echo "<br>";
			echo '<br>';
		}

		restore_current_blog();
	}
	public function jaiminho_emails_limits_html()
	{?>
	<!-- //show page -->
	  <h1><?php _e('Limite WP-Cron', 'jaiminho'); ?></h1>
	  <p><?php _e('Defininir o limite base de emails por ativação do wp-cron, insira o valor no campo abaixo e redefina este valor para todos os sites', 'jaiminho' ); ?></p>
	  <form method="post">
	    <p>
	      <label><?php _e('Limite' , 'jaiminho'); ?></label>:
	    </p>
	    <p>
	  	  <input type="text" size="6" name="limits" value="1000" />
	  	</p>
	    <?php submit_button(__( 'Enviar' , 'jaiminho' )); ?>
	  </form>
	  <?php
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
		foreach( $blogs as $blog )
		{
			switch_to_blog( $blog['blog_id'] );
			echo '<br>';
			echo get_bloginfo( 'name' );
			echo '<br>';
			if (isset($_POST['limits'])) SendPress_Option::set( 'wpcron-per-call' , $_POST['limits'] );
			echo SendPress_Option::get('wpcron-per-call');
			echo '<br>';
		}

		restore_current_blog();

	}

	public function jaiminho_settings_network_html_credits()
	{
		?>
		<h1><?php _e("Configurar créditos"); ?></h1>

		<p>
		<input id="filter" type="text">
		<label><?php _e( 'Filtro' , 'jaiminho' ); ?></label>
		<p>
		<?php
		// get blogs
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


		// receive post

		if (isset( $_POST["emails-credits"] ) )
		{
			if(isset($_POST['blogs']))
			{
				foreach( $_POST['blogs'] as $blog )
				{
					switch_to_blog( $blog );
					$this->jaiminho_settings_account_email($_POST["emails-credits"]);
					//SendPress_Option::set('emails-credits' , $_POST["emails-credits"] );
				}

			}
			else
			{
				foreach( $blogs as $blog )
				{
					switch_to_blog( $blog['blog_id'] );
					$this->jaiminho_settings_account_email($_POST["emails-credits"]);
					//SendPress_Option::set('emails-credits' , $_POST["emails-credits"] );
				}
			}
			restore_current_blog();

		}

		//show page
		$credits = SendPress_Option::get('emails-credits');
		?>
	    <form method="post">
			<select name="blogs[]" multiple >
			<?php
			foreach ($blogs as $blog)
			{
			  switch_to_blog(  $blog['blog_id'] );
			  echo '<option value="' . $blog['blog_id'] . '">' .get_bloginfo( 'name' ) . '</option>';
			}
		    restore_current_blog();
		    ?>
			</select>
			<p>
			<input type="text" name="emails-credits" value="<?php echo $credits; ?>" placeholder="<?php _e('Insira um valor, ex.: 5000', 'jaiminho' ); ?>" />
			<label><?php _e('Créditos Disponiveis', 'jaiminho'); ?></label>
			</p>
			<?php
			submit_button(__( 'Enviar' , 'jaiminho' )); ?>
		</form>
	<?php
	}

	public function jaiminho_settings_network_html()
	{
		if (isset( $_POST ) )
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

                        if (isset($_POST['networkuser'])) update_option('networkuser', $_POST['networkuser'] );
                        if (isset($_POST['networkpass'])) update_option('networkpass', $_POST['networkpass'] );
                        if (isset($_POST['networkserver'])) update_option('networkserver', $_POST['networkserver'] );
                        if (isset($_POST['networkport'])) update_option('networkport', $_POST['networkport'] );
                        if (isset($_POST['bounce_email'])) update_option('bounce_email', $_POST['bounce_email'] );

			$post = array (
					'networkuser'   => get_option('networkuser'),
					'networkpass'   => get_option('networkpass'),
					'networkserver' => get_option('networkserver'),
					'networkport'   => get_option('networkport'),
					'bounce_email'    => get_option('bounce_email'),
					'sendmethod'      => 'Jaiminho_Sender_NetWork',
				      );

			//create back up of options
			switch_to_blog( 1 );

			foreach($post as $key => $value )
				update_option( $key , $value);

			restore_current_blog();

			//add conf on selected blogs
			if(isset($_POST['blogs']))
			{
				foreach( $_POST['blogs'] as $blog )
				{
					foreach( $post as $key => $value )
					{
						switch_to_blog( $blog );
						$method = SendPress_Option::set($key,$value);
					}
				}

			}// add conf on all blogs
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

		global  $sendpress_sender_factory;
		$sender = $sendpress_sender_factory->get_sender('Jaiminho_Sender_NetWork');
		$method = SendPress_Option::get( 'sendmethod' );
		?>
		<h1><?= $sender->label(); ?></h1>
		<p><?php _e( 'Selecione os blogs que devem receber a configuração ou não selecione nenhum e todos os blogs serão configurados' , 'jaiminho' ); ?>.</p>

		<p><label><?php _e( 'Filtro' , 'jaiminho' ); ?></label></p>
		<p>
		<input id="filter" type="text">
		<p>

	    <form method="post" id="post" >

			<div class="panel panel-default">
			<div class="panel-body">

			<input type="hidden" name="action" value="account-setup" />
			<?php
		echo "</p><div class='well'>";
		?>
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

	function load_admin_script( $hook ){
	    wp_enqueue_script(
	        'wptuts53021_script', //unique handle
	        plugin_dir_url( __FILE__ ) . '/admin-scripts.js', //location
	        array('jquery')  //dependencies
	     );
	}

	public function myformatTinyMCE( $in )
	{

                $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src]';

                if ( isset( $in['extended_valid_elements'] ) ) {
                    $in['extended_valid_elements'] .= ',' . $ext;
                } else {
                    $in['extended_valid_elements'] = $ext;
                }


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
		add_menu_page( __('Jaiminho','jaiminho'), __('Jaiminho','jaiminho'), $role, 'sp-settings', array( $this , 'render_view_jaiminho' ), JAIMINHO_URL . 'img/jaiminho-bg-16.png' );
		// xxx: ainda não foi possivel descobrir onde esta o problema, simplesmente a página do overview repete o template - depois voltar de sp-settings para sp-overview
		// add_submenu_page('sp-settings', __('Overview','sendpress'), __('Overview','sendpress'), $role, 'sp-overview', array($this,'render_view_jaiminho'));

		$main = add_submenu_page('sp-settings', __('Settings','sendpress'), __('Settings','sendpress'), $role, 'sp-settings', array($this,'render_view_jaiminho'));
		add_submenu_page('sp-settings', __('Emails','sendpress'), __('Emails','sendpress'), $role, 'sp-emails', array($this,'render_view_jaiminho'));
		add_submenu_page('sp-settings', __('Reports','sendpress'), __('Reports','sendpress'), $role, 'sp-reports', array($this,'render_view_jaiminho'));
		add_submenu_page('sp-settings', __('Subscribers','sendpress'), __('Subscribers','sendpress'), $role, 'sp-subscribers', array($this,'render_view_jaiminho'));
		add_submenu_page('sp-settings', __('Queue','sendpress'), __('Queue','sendpress')  . " " . $queue, $role, 'sp-queue', array($this,'render_view_jaiminho'));
		//$main =
		//add_submenu_page('sp-settings', __('Settings','sendpress'), __('Settings','sendpress'), $role, 'sp-settings', array($this,'render_view_jaiminho'));

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
		elseif ( SendPress_Option::get( 'bounce_email' ) )
			$_bounce_email = SendPress_Option::get('bounce_email');
		else
		{
			// Get the site domain and get rid of www.
			$sitename = strtolower( $_SERVER['SERVER_NAME'] );
			if ( substr( $sitename, 0, 4 ) == 'www.' ) {
				$sitename = substr( $sitename, 4 );
			}
			$sets = array();
			$sets['value'] = array_merge(array($sets['value']), get_option('plataform_defined_settings', array()));
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

	public function bounce_password( $password , $server , $port ){
		if($password != "")
		  update_option("bounce_email_password",$password);
		if($server != "")
			update_option("bounce_email_server",$server);
		if($port != "")
			update_option("bounce_email_port",$port);
	}

	public function jaiminho_get_view_class($page, $current_view, $emails_credits, $bounce_email, $bounce_password, $bounce_server , $bounce_port )
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
			//case "SendPress_View_Emails_Send_Confirm":
				//return "Jaiminho_View_Emails_Send_Confirm";
			case "SendPress_View_Emails_Send_Queue":
				return "Jaiminho_View_Emails_Send_Queue";
			case "SendPress_View_Emails_Tempdelete":
				return "Jaiminho_View_Emails_Tempdelete";
			case "SendPress_View_Emails_Tempclone":
				return "Jaiminho_View_Emails_Tempclone";
			case "SendPress_View_Reports":
				return "Jaiminho_View_Reports";
			case "SendPress_View_Subscribers":
				return "Jaiminho_View_Subscribers";
      case "SendPress_View_Emails_List_Filter":
        return "Jaiminho_View_Emails_List_Filter";
			case "SendPress_View_Subscribers_Csvimport":
				return "Jaiminho_View_Subscribers_Csvimport";
      case "SendPress_View_Subscribers_Add":
        return "Jaiminho_View_Subscribers_Add";
      case "SendPress_View_Queue_Errors":
        return "Jaiminho_View_Queue_Errors";
			case "SendPress_View_Subscribers_Listcreate":
				wp_enqueue_script('jaiminho_disable');
				return $view_class;
			case "SendPress_View_Settings_Account":
				$this->jaiminho_settings_account_email( $emails_credits );
				$this->jaiminho_settings_account_bounce( $bounce_email );
				$this->bounce_password($bounce_password, $bounce_server , $bounce_port );
				return "Jaiminho_View_Settings_Account";
			default:
				return $view_class;
		}
	}

	public function render_view_jaiminho() {
		load_plugin_textdomain('sendpress', false, dirname(plugin_basename( __FILE__ )).'/languages');
		load_plugin_textdomain('jaiminho', false, dirname(plugin_basename( __FILE__ )).'/languages');
		$this->_page = SPNL()->validate->page( $_GET['page'] );
		$this->_current_view = isset( $_GET['view'] ) ? sanitize_text_field( $_GET['view'] ) : '';
		$emails_credits = isset (  $_POST['emails-credits'] ) ?  $_POST['emails-credits'] : SendPress_Option::get( 'emails-credits' );
		$bounce_email = isset (  $_POST['bounceemail'] ) ?  $_POST['bounceemail'] : null;
		$bounce_password = isset (  $_POST['bounceemail_password'] ) ?  $_POST['bounceemail_password'] : null;
		$bounce_server = isset (  $_POST['bounceemail_server'] ) ?  $_POST['bounceemail_server'] : null;
		$bounce_port = isset (  $_POST['bounceemail_port'] ) ?  $_POST['bounceemail_port'] : null;

		$view_class = $this->jaiminho_get_view_class( $this->_page , $this->_current_view ,  $emails_credits  , $bounce_email , $bounce_password , $bounce_server , $bounce_port );

    // debug
		//echo "About to render: $view_class, $this->_page";
		//echo " nova: ".$view_class;

		$view_class = NEW $view_class;

		$queue  = '<span id="queue-count-menu-tab">-</span>';

		// xxx: ainda não foi possivel descobrir onde esta o problema, simplesmente a página do overview repete o template - depois reativar a aba
		//$view_class->add_tab( __( 'Overview', 'sendpress' ), 'sp-overview', ( $this->_page === 'sp-overview' ) );

		//add tabs
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

register_activation_hook( __FILE__, array( 'Jaiminho' , 'jaiminho_define_opt_in_email' ) );
register_activation_hook( __FILE__, array( 'Jaiminho' , 'create_templates' ) );
register_activation_hook( __FILE__, array( 'Jaiminho' , 'jaiminho_define_redelivre_default_smtp' ) );
register_activation_hook( __FILE__, array( 'Jaiminho' , 'jaiminho_set_settings_for_new_site' ) );
register_deactivation_hook( __FILE__, array( 'Jaiminho' , 'remove_templates' ) );


/*
Plugin Name: WP-CLI Commands
Version: 1.0
Description: Extending WP-CLI with custom commands
Author: Konstantinos Kouratoras
Author URI: http://www.kouratoras.gr
*/

if( defined( 'WP_CLI' ) && WP_CLI ) {

        class Jaiminho_Commands {


								function sendemails ( $args, $assoc_args ){
									$blogs = wp_get_sites( $args );
								  foreach( $blogs as $blog ){
									  switch_to_blog( $blog['blog_id'] );
										$blog_name = get_bloginfo( 'name' );
										set_time_limit(0);
		                $control = 1;
		                while ($control != 0) {
		                    $response = SendPress_Manager::send_single_from_queue();
		                    if($response['sent'] == 0){
		                        $control = 0;
		                    }
		                    $all = (int) SendPress_Data::emails_in_queue();
		                    $stuck = (int) SendPress_Data::emails_stuck_in_queue();
		                    $control = $all - $stuck;
												WP_CLI::success( $control );
		                }

										if ($control == 0)
											WP_CLI::success( "$blog_name: Todos os emails foram enviados!" );
								  }
								  restore_current_blog();
								}
        }

        WP_CLI::add_command( 'jaiminho', 'Jaiminho_Commands' );
}

global $Jaiminho;

$Jaiminho = new Jaiminho();
