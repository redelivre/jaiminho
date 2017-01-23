<?php


// Prevent loading this file directly
if ( !defined( 'SENDPRESS_VERSION' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	die;
}


class Jaiminho_View_Settings_Account extends SendPress_View_Settings {

	function account_setup(){

		$options =  array();
		if(isset($_POST['fromname'])){
			$fromname= $_POST['fromname'];
		}

		// From email and name
		// If we don't have a name from the input headers
		if ( !isset( $fromname ) || $fromname == '' ){
			$fromname = get_bloginfo('name');
		}

		if(isset($_POST['fromemail'])){
			$fromemail= $_POST['fromemail'];
		}


		if ( !isset( $fromemail )  || $fromemail == '') {
			// Get the site domain and get rid of www.
			$sitename = strtolower( $_SERVER['SERVER_NAME'] );
			if ( substr( $sitename, 0, 4 ) == 'www.' ) {
				$sitename = substr( $sitename, 4 );
			}

			$fromemail = 'wordpress@' . $sitename;
		}


		SendPress_Option::set('fromemail', $fromemail );
		SendPress_Option::set('fromname', $fromname );


		$options['sendmethod'] = $_POST['sendpress-sender'];
		// Provides: Hll Wrld f PHP
		$chars = array(".", ",", " ", ":", ";", "$", "%", "*", "-", "=");
		$options['emails-per-day'] =  str_replace($chars,"",$_POST['emails-per-day']);
		$options['emails-per-hour'] = str_replace($chars,"",$_POST['emails-per-hour']);
		$options['email-charset'] = $_POST['email-charset'];
		$options['email-encoding'] = $_POST['email-encoding'];
		$options['testemail'] = $_POST['testemail'];
		$options['phpmailer_error'] = '';
		$options['last_test_debug'] = '';
		SendPress_Option::set( $options );

		global  $sendpress_sender_factory;

		$senders = $sendpress_sender_factory->get_all_senders();

		foreach ( $senders as $key => $sender ) {
			$sender->save();
		}
	   // }

		if( isset($_POST['test'])){
			SendPress_Manager::send_test();
		}

		//SendPress_Admin::redirect('Settings_Account');


	}

	function send_test_email(){
		//$this->security_check();
		$options = array();

		$options['testemail'] = $_POST['testemail'];

		SendPress_Option::set($options);
		SendPress_Manager::send_test();
		// SendPress_Admin::redirect('Settings_Account');
	   // $this->send_test();
	   // $this->redirect();
	}


	function html( ) {
		global  $sendpress_sender_factory;
		$senders = $sendpress_sender_factory->get_all_senders();
		ksort($senders);
		$method = SendPress_Option::get( 'sendmethod' );
		$fe = __('From Email','sendpress');
		$fn = __('From Name','sendpress');
		?>
<!--
<div style="float:right;" >
  <a href="" class="btn btn-large btn-default" ><i class="icon-remove"></i> <?php _e( 'Cancel', 'sendpress' ); ?></a> <a href="#" id="save-update" class="btn btn-primary btn-large"><i class="icon-white icon-ok"></i> <?php _e( 'Save', 'sendpress' ); ?></a>
</div>
-->
<form method="post" id="post">
	<br class="clear">
	<br class="clear">
	<div class="sp-row">
		<div class="sp-50 sp-first">
			<?php $this->panel_start( '<span class="glyphicon glyphicon-user"></span> '. __('Sending Email','sendpress') ); ?>
			<div class="form-group">
				<label for="fromname"><?php _e('From Name','sendpress'); ?></label>
				<input name="fromname" tabindex=1 type="text" id="fromname" value="<?php echo SendPress_Option::get('fromname'); ?>" class="form-control">
			</div>
			<div class="form-group">
				<label for="fromemail"><?php _e('From Email','sendpress'); ?></label>
				<input name="fromemail" tabindex=2 type="text" id="fromemail" value="<?php echo SendPress_Option::get('fromemail'); ?>" class="form-control">
			</div>

			<div class="form-group">
                <label for="bounceemail"><?php _e('Email de Retorno','jaiminho'); ?></label>
                <input name="bounceemail" tabindex=3 type="text" id="bounceemail" value="<?php echo SendPress_Option::get('bounce_email'); ?>" class="form-control">
      </div>
			<div class="form-group">
								<label for="bounceemail_password"><?php _e('Senha Email de Retorno','jaiminho'); ?></label>
								<input name="bounceemail_password" tabindex=3 type="password" id="bounceemail_password" value="<?php echo get_option('bounce_email_password'); ?>" class="form-control">
			</div>
			<div class="form-group">
								<label for="bounceemail_imap"><?php _e('Endereço do Servidor IMAP de Retorno','jaiminho'); ?></label>
								<input name="bounceemail_imap" tabindex=3 type="text" id="bounceemail_imap" value="<?php echo get_option('bounce_email_imap'); ?>" class="form-control">
			</div>

			<div class="form-group">
								<label for="bounceemail_port"><?php _e('Porta de Leitura do Servidor IMAP de Retorno','jaiminho'); ?></label>
								<input name="bounceemail_port" tabindex=3 type="text" id="bounceemail_port" value="<?php echo get_option('bounce_email_port'); ?>" class="form-control">
			</div>

			<?php $this->panel_end(); ?>
		</div >
		<div class="sp-50">
			<?php $this->panel_start( '<span class="glyphicon glyphicon-inbox"></span> '. __('Test Email','sendpress') ); ?>

			<div class="form-group">
				<label for="testemail"><?php _e('Where to send Test Email','sendpress'); ?></label>
				<input name="testemail" type="text" id="test-email-main" value="<?php echo SendPress_Option::get( 'testemail' ); ?>" class="form-control"/>
			</div>
			<div class="sp-row">
				<div class="sp-50 sp-first">
					<button class="btn btn-primary btn-block" value="test" name="test" type="submit"><?php _e( 'Send Test!', 'sendpress' ); ?></button>
				</div>
				<div class="sp-50">
					<button class="btn btn-danger btn-block" data-toggle="modal" data-target="#debugModal" type="button"><?php _e( 'Debug Info', 'sendpress' ); ?></button>
				</div>
			</div>
			<div class="sp-row">
				<br>
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
									<?php _e('Click to View Last Error','sendpress'); ?>
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse">
							<div class="panel-body">

								<?php

								$logs = SPNL()->log->get_connected_logs( array( 'posts_per_page' => 1, 'log_type'=>'sending' ) );
								if(!empty($logs)){
									foreach ($logs as $log) {
										echo "<strong>". $log->post_date ."</strong>  ". $log->post_title;
										echo "<br>". $log->post_content;
									}
								}


								?>
							</div>
						</div>
					</div>
				</div>

			</div>
			<?php $this->panel_end(); ?>
		</div>
	</div>

	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?php _e('Sending Account Setup','sendpress'); ?></h3>
		</div>
		<div class="panel-body">

			<input type="hidden" name="action" value="account-setup" />
			<?php

$new =array();
foreach ( $senders as $key => $sender ) {
	array_push($new, array($key,$sender->label() ));
}
echo '<strong>Delivery Method: </strong>';
 $this->select('sendpress-sender',$method, $new );
			?><br><br>
			<?php if( count($senders) < 3 ){
				$c= 0;
				foreach ( $senders as $key => $sender ) {
					$class ='';
					if ( $c >= 1 ) { $class = "margin-left: 4%"; }
					echo "<div style=' float:left; width: 48%; $class' id='$key'>";
					?>
					<!-- XXXX -->
					<p>&nbsp;<!--<input name="sendpress-sender" type="radio"  <?php if ( $method == $key || strpos(strtolower($key) , $method) > 0 ) { ?>checked="checked"<?php } ?> id="website" value="<?php echo $key; ?>" /> <?php _e('Send Emails via','sendpress'); ?> -->
						<?php
						echo $sender->label();
						echo "</p><div class='well'>";
						echo $sender->settings();
						echo "</div></div>";
						$c++;
					}



				} else { ?>
				<div class="tabbable tabs-left">
					<ul class="nav nav-tabs">
						<?php
						foreach ( $senders as $key => $sender ) {
							$class ='';
							if ( $method == $key || strpos(strtolower($key) , $method) > 0 ) { $class = "class='active'"; }
							echo "<li $class><a href='#$key' data-toggle='tab'>";
							if ( $method == $key || strpos(strtolower($key) , $method) > 0 ) { echo '<span class="glyphicon glyphicon-ok-sign"></span> '; }
							echo $sender->label();
							echo "</a></li>";
						}
						?>
					</ul>
					<div class="tab-content" style="display:block;">
						<?php
						foreach ( $senders as $key => $sender ) {
							$class ='';
							if ( $method == $key || strpos(strtolower($key) , $method) > 0 ) { $class = "active"; }
							echo "<div class='tab-pane $class' id='$key'>";
							?>
							<!-- XXXX -->
							<!--<p>&nbsp;<input name="sendpress-sender" type="radio"  <?php if($key==='SendPress_Sender_Website' && is_multisite()) {echo 'style="display:none"'; } ?> <?php if ( $method == $key || strpos(strtolower($key) , $method) > 0 ) { ?>checked="checked"<?php } ?> id="website" value="<?php echo $key; ?>" /> <?php _e('Activate','sendpress'); ?>-->
								<?php
								//echo $sender->label();
								echo "</p><div class='well'>";
								echo $sender->settings();
								echo "</div></div>";
							}
							?>

						</div>
					</div>


					<p > <span class="glyphicon glyphicon-ok-sign"></span> = <?php _e('Currently Active','sendpress'); ?></p>
					<?php } ?>

				</div>
			</div>


<?php

        if (isset($_POST['credits_super_admin']) and $_POST['credits_super_admin'] != '') {
    			SendPress_Option::set( 'wpcron-per-call' , $_POST['credits_super_admin'] );
    			SendPress_Option::set( 'emails-per-day' , $_POST['credits_super_admin'] );
					update_option( 'emails-credits', $_POST['credits_super_admin'] );

        }
        if (isset($_POST['credits_per_hour_super_admin']) and $_POST['credits_per_hour_super_admin'] != '') {
    			SendPress_Option::set( 'emails-per-hour' , $_POST['credits_per_hour_super_admin'] );
        }
 ?>
			<br class="clear">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><?php _e('Advanced Sending Options','sendpress'); ?></h3>
				</div>
				<div class="panel-body">
					<div class="boxer form-box">
						<div style="float:left; position: relative">
							<?php if(is_super_admin()){ ?>
							<h2>Configuração de créditos super-admin</h2>
			                <p>
			                <?= __("Insira uma quantidade de créditos para este projeto:", "sendpress"); ?>
			                </p>
			                <p>
			                <input type="text" placeholder="eg. 5000" name="credits_super_admin" value="<?= SendPress_Option::get('emails-per-day'); ?>"/>
			                </p>
			                <p>
			                <?= __("Defina a quantidade de créditos por hora:", "sendpress"); ?>
			                </p>
			                <p>
			                <input type="text" placeholder="eg. 1000" name="credits_per_hour_super_admin" value="<?= SendPress_Option::get('emails-per-hour'); ?>" />
			                </p>
			                <p>
			                <button class="btn btn-primary" type="submit" >
			                  <?= __("Adicionar Créditos", "sendpress") ?>
			                  <span class="glyphicon glyphicon-send"></span>
			                </button>
			                </p>


			                <?php } ?>
						</div>
						<div style="<?php echo is_super_admin()?"position: relative; float: right; width: 45%;": "float:left"; ?>
							<h2><?php _e('Email Sending Limits','sendpress'); ?>

							</h2>

							<?php
							$emails_per_day = SendPress_Option::get('emails-per-day');

							$emails_per_hour =  SendPress_Option::get('emails-per-hour');
							$credits         = SendPress_Option::get('emails-credits');

							$emails_so_far = SendPress_Data::emails_sent_in_queue("day");

							$offset = get_option( 'gmt_offset' ) * 60 * 60;

						  $local_timestamp = wp_next_scheduled('sendpress_cron_action') + $offset;

							sprintf(__('You have sent <strong>%s</strong> emails so far today and you have <strong>%s</strong> credits remaining.', 'sendpress'), $emails_so_far, $credits);
							?>
							<br><br>


						<input type="hidden" />
						<input type="text" size="6" name="emails-per-day" value="<?php echo $emails_per_day; ?>" />
						<?php _e('Emails Per Day','sendpress'); ?>
						<br><br>

						<input type="text" size="6" name="emails-per-hour" value="<?php echo $emails_per_hour; ?>" />
						<?php _e('Emails Per Hour','sendpress'); ?>
						<br><br>

						<h2><?php _e('Email Encoding','sendpress'); ?></h2>
						<?php
						$charset = SendPress_Option::get('email-charset','UTF-8');
						?>Charset:
						<select name="email-charset" id="">

						<?php
						$charsete = SendPress_Data::get_charset_types();
						foreach ( $charsete as $type) {
							$select="";
							if($type == $charset){
								$select = " selected ";
							}
							echo "<option $select value=$type>$type</option>";

						}
						?>
</select><br>
<?php _e('Squares or weird characters displaying in your emails select the charset for your language','sendpress'); ?>.
<br><br>
<?php _e('Encoding','sendpress'); ?>: <select name="email-encoding" id="">
<?php
$charset = SendPress_Option::get('email-encoding','8bit');
$charsete = SendPress_Data::get_encoding_types();
foreach ( $charsete as $type) {
	$select="";
	if($type == $charset){
		$select = " selected ";
	}
	echo "<option $select value=$type>$type</option>";

}
?>
</select>

<br class="clear">
</div>
</div>
</div>
</div>


<?php
//Page Nonce
//wp_nonce_field(  basename(__FILE__) ,'_spnonce' );
wp_nonce_field( $this->_nonce_value );
?>
<input type="submit" class="btn btn-primary" value="Save"/> <a href="" class="btn btn-default"><i class="icon-remove"></i> <?php _e('Cancel','sendpress'); ?></a>
</form>
<form method="post" id="post-test" class="form-inline">
	<input type="hidden" name="action" value="send-test-email" />
	<input name="testemail" type="hidden" id="test-email-form" value="<?php echo SendPress_Option::get( 'testemail' ); ?>" class="form-control"/>

	<br class="clear">




	<?php
//Page Nonce
//wp_nonce_field(  basename(__FILE__) ,'_spnonce' );
//SendPress General Nonce
	wp_nonce_field( $this->_nonce_value );
	?>
</form>
<?php
$error=  SendPress_Option::get( 'phpmailer_error' );
$hide = 'hide';
if ( !empty( $error ) && isset($_POST['testemail'])) {
	$hide = '';
	$phpmailer_error = '<pre>'.$error.'</pre>';
	?>
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$('#debugModal').modal('show');
		});
	</script>

	<?php
}


?>


<div class="modal fade" id="debugModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3><?php _e( 'SMTP Debug Info', 'sendpress' ); ?></h3>
			</div>
			<div class="modal-body">
				<?php
				if ( !empty( $phpmailer_error ) ) {
					$server  = "smtp.sendgrid.net";
					$port   = "25";
					$port2   = "465";
					$port3   = "587";
					$timeout = "1";

					if ( $server and $port and $timeout ) {
						$port25 =  @fsockopen( "$server", $port, $errno, $errstr, $timeout );
						$port465 =  @fsockopen( "$server", $port2, $errno, $errstr, $timeout );
						$port587 =  @fsockopen( "$server", $port3, $errno, $errstr, $timeout );
					}
					if ( !$port25 ) {
						echo '<div class="alert alert-error">';
						_e( 'Port 25 seems to be blocked.', 'sendpress' );
						echo '</div>';

					}
					if ( !$port465 ) {
						echo '<div class="alert alert-error">';
						_e( 'Port 465 seems to be blocked. Gmail may have trouble', 'sendpress' );
						echo '</div>';

					}
					if ( !$port587 ) {
						echo '<div class="alert alert-error">';
						_e( 'Port 587 seems to be blocked.', 'sendpress' );
						echo '</div>';

					}

					echo $phpmailer_error;
				} ?>

				<pre>
					<?php

					$whoops = SendPress_Option::get( 'last_test_debug' );
					if ( empty( $whoops ) ) {
						_e( 'No Debug info saved.', 'sendpress' );
					} else {
						echo $whoops;
					}
					?>
				</pre>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal"><?php _e( 'Close', 'sendpress' ); ?></a>
			</div>
		</div>
	</div></div>
	<?php
}

}
