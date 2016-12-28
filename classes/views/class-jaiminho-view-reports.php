<?php

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

class Jaiminho_View_Reports extends SendPress_View{
	
	function admin_init(){
		add_action('load-sendpress_page_sp-reports',array($this,'screen_options'));
                //add_action( 'admin_post_nopriv_export', array($this,'export_report') );
                //add_action( 'admin_action_export', array($this,'export_report') );
	}


//        function export_report(){
//                  $args = array(
//                      'post_type' => 'sp_report' ,
//                      'post_status' => array('publish','draft'),
//                      'posts_per_page' => -1,
//                      'fields' => 'ids',
//                      'meta_query' => array(
//                         array(
//                             'key' => '_report_type',
//                             'compare' => 'not exists',
//                  
//                          ),
//                      ),
//                  );
//
//                  $query = new WP_Query( $args );
//                  if($query->have_posts()){
//                      while($query->have_posts()){
//                          $query->the_post();
//                      $item = get_post();
//                          $stat_type = get_post_meta($item->ID, '_stat_type', true);
//                  
//                  
//                          $rec = get_post_meta($item->ID, '_send_count', true) + get_post_meta($item->ID, '_send_last_count', true)  . '';
//                          $sentold = get_post_meta($item->ID, '_sent_total', true);
//                  
//                          $queue = 0;
//                          $sent = get_post_meta($item->ID, '_send_total', true);
//                          $inqueue = get_post_meta($item->ID, '_in_queue', true);
//                          if($inqueue !== 'none'){
//                              $queue = SendPress_Data::emails_in_queue($item->ID);
//                              $sentindb =  SendPress_Data::emails_sent_in_queue_for_report($item->ID);
//                              if($sentindb > $sent){
//                                  update_post_meta($item->ID, '_send_total', $sentindb);
//                                  $sent = $sentindb;
//                              }
//                              if($queue == 0){
//                                 update_post_meta($item->ID, '_in_queue', 'none');
//                              }
//                          } 
//                  
//                      
//                              $display = '';
//                          $info = get_post_meta($item->ID, '_send_data', true);
//                          if(!empty($info['listIDS']) ){
//                              foreach($info['listIDS'] as $list_id){
//                              
//                              $list = get_post( $list_id );
//                              if($list &&  $list->post_type == 'sendpress_list'){
//                                  $display .= $list->post_title.'<br>';      
//                              }
//                  
//                              } 
//                          } else {
//                              
//                              $lists = get_post_meta($item->ID,'_send_lists', true);
//                              $list = explode(",",$lists );
//                              foreach($list as $list_id){
//                              
//                              $list = get_post( $list_id );
//                              if($list &&  $list->post_type == 'sendpress_list'){
//                                  $display .= $list->post_title.'<br>';      
//                              }
//                  
//                              } 
//                  
//                          }
//                  
//                      
//                      $opens = SPNL()->load("Subscribers_Tracker")->get_opens( $item->ID  );
//                          $opens_total = SPNL()->load("Subscribers_Tracker")->get_opens_total( $item->ID  );
//                          $opens =  $opens == 0 ? '-' : $opens;
//                          $opens_total =  $opens_total == 0 ? '-' : $opens_total;
//                      
//                      $clicks = SPNL()->load("Subscribers_Url")->clicks_email_id( $item->ID  );
//                          $clicks_total = SPNL()->load("Subscribers_Url")->clicks_total_email_id( $item->ID  );
//                          $clicks =  $clicks == 0 ? '-' : $clicks;
//                          $clicks_total =  $clicks_total == 0 ? '-' : $clicks_total;
//                  
//                  
//                          $unsubscribers = SPNL()->load("Subscribers_Tracker")->get_unsubs( $item->ID  );
//                          $unsubscribert =  $unsubscribers == 0 ? '-' : $clicks;
//                  
//                          $date = get_post_meta($item->ID, "send_date", true);
//
//                          //$string = "Destinatários: ". $rec ."<br>";
//                          //$string .= "Enviados: ". $sent ."<br>";
//                          //$string .= "Na Fila: ". $queue ."<br>";
//                  
//                          //echo $string;
//                          //echo "Lista: " . $display;
//                          //echo  "Unique: " . $opens ."<br>Total: ". $opens_total . "<br>";
//                          //echo  "Inscritos via URL Unique: " . $clicks . "<br> Inscritos via URL Total: " . $clicks_total . "<br>" ;
//                          //echo  "Desinscritos: " . $clicks . "<br>";
//                      
//                          //if(!empty( $date ) ){
//                          //    echo "Data de envio: " . date_i18n(get_option('date_format') ,strtotime($date) );
//                          //}else{
//                          //echo 'sem data';
//                          //}
//                          $date_final = !empty( $date )? date_i18n(get_option('date_format') ,strtotime($date) ) : 'sem data';
//                  header("Content-type:text/octect-stream");
//                  header("Content-Disposition:attachment;filename=sendpress.csv");
//                  print "Titulo,Destinatarios,Enviados,Na Fila,Lista,Unique,Total,Inscritos via URL Unique,Inscritos via URL Total,Desinscritos,Data \n";
//                  print  get_the_title() . "," .$rec .",". $sent .",". $queue ."," . $display . ',' . $opens .",". $opens_total . "," . $clicks . "," . $clicks_total . "," . $clicks . "" . $date_final."\n";
//                    }
//                  }
//        }

	function screen_options(){

		$screen = get_current_screen();
	 	
		$args = array(
			'label' => __('Reports per page', 'sendpress'),
			'default' => 10,
			'option' => 'sendpress_reports_per_page'
		);
		add_screen_option( 'per_page', $args );
	}



 function sub_menu(){
 		?>
		<div class="navbar navbar-default" >
			<div class="navbar-header">
			  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
       <span class="sr-only"><?php _e('Toggle navigation','sendpress'); ?></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>

    </button>
    <a class="navbar-brand" href="#"><?php _e('Reports','sendpress'); ?></a>
	</div>
		 <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		<ul class="nav navbar-nav">
					<li <?php if(!SPNL()->validate->_isset('view') ){ ?>class="active"<?php } ?> >
				    	<a href="<?php echo SendPress_Admin::link('Reports'); ?>"><?php _e('Newsletters','sendpress'); ?></a>
				  	</li>
				  	<li <?php if(SPNL()->validate->_string('view') === 'tests'){ ?>class="active"<?php } ?> >
				    	<a href="<?php echo SendPress_Admin::link('Reports_Tests'); ?>"><?php _e('Tests','sendpress'); ?></a>
				  	</li>
				  	
				</ul>

				
			</div>
		</div>
		
		<?php

		do_action('sendpress-reports-sub-menu');
		
	}	

	function html(){
		 SendPress_Tracking::event('Reports Tab');
		//Create an instance of our package class...
		$sp_reports_table = new SendPress_Reports_Table();
		//Fetch, prepare, sort, and filter our data...
		$sp_reports_table->prepare_items();
		?>
		<br>
		<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
		<form id="email-filter" method="get">
			<!-- For plugins, we also need to ensure that the form posts back to our current page -->
		    <input type="hidden" name="page" value="<?php echo SPNL()->validate->page(); ?>" />
		    <!-- Now we can render the completed list table -->
		    <?php $sp_reports_table->display(); ?>
		    <?php wp_nonce_field( $this->_nonce_value ); ?>
		</form>
		<h3><?php _e('Information','sendpress'); ?></h3>
		<div class='well'>
		<span class="label label-success"><?php _e('Unique','sendpress');?></span> <?php _e('The total number of different recipients that have clicked on a link or opened an email.','sendpress');?><br><br>

		<span class="label label-info"><?php _e('Total','sendpress');?></span> <?php _e('The total number of clicks or opens that have happened. Regardless of who clicked or opened the email.','sendpress');?>
		</div>
                <form action="<?php echo esc_url( admin_url('admin.php') ); ?>" method="POST">
                <input type="hidden" name="action" value="export">
                <input type="submit" value="Exportar">
                </form>
		<?php
	}
}
SendPress_Admin::add_cap('Reports','sendpress_reports');
