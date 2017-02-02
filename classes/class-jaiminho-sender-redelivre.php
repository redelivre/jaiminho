<?php 


// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') )
{
	header('HTTP/1.0 403 Forbidden');
	die;
}

if(!class_exists('Jaiminho_Sender_RedeLivre'))
{

class Jaiminho_Sender_RedeLivre extends SendPress_Sender
{
	function label()
        {
	  return __('RedeLivre','jaiminho');
	}

	function save()
        {
          $options =  array();
	  $options['redelivreuser'] = $_POST['redelivreuser'];
          $options['redelivrepass'] = $_POST['redelivrepass'];
          $options['redelivreserver'] = $_POST['redelivreserver'];
          $options['redelivreport'] = $_POST['redelivreport'];
          $options['redelivretls'] = isset($_POST['redelivretls']) ? $_POST['redelivretls'] : '' ;
          SendPress_Option::set( $options );
	}

	function settings(){ ?>
	 <p><?php _e( 'Insira abaixo a configuração pessoal da rede livre ou uma configuração para outro serviço, que inclui usuário, senha, servidor  smtp (ex.: smtp.redelivre.org) e  porta (ex.: 25, 486, 587)', 'jaminho' ); ?>.</p>
  <?php _e( 'Username' , 'sendpress'); ?>
  <p><input name="redelivreuser" type="text" value="<?php echo SendPress_Option::get( 'redelivreuser' ); ?>" style="width:100%;" /></p>
  <?php _e( 'Password' , 'sendpress'); ?>
  <p><input name="redelivrepass" type="password" value="<?php echo SendPress_Option::get( 'redelivrepass' ); ?>" style="width:100%;" /></p>
  <?php _e( 'Servidor' , 'jaiminho'); ?>
  <p><input name="redelivreserver" type="text" value="<?php echo SendPress_Option::get( 'redelivreserver' ); ?>" style="width:100%;" /></p>
  <?php _e( 'Porta' , 'jaiminho'); ?>
  <p><input name="redelivreport" type="text" value="<?php echo SendPress_Option::get( 'redelivreport' ); ?>" style="width:100%;" /></p>
  <p><input name="redelivretls" type="checkbox" value="true"
              <?php echo SendPress_Option::get( 'redelivretls' ) == true ? 'checked' : ''; ?> >
              <?php _e( 'Habilitar criptografia TLS' , 'jaiminho' ); ?>
      </input></p>
	<?php

	}


	function send_email($to, $subject, $html, $text, $istest = false ,$sid , $list_id, $report_id ){

		$phpmailer = new SendPress_PHPMailer;
		/*
		 * Make sure the mailer thingy is clean before we start,  should not
		 * be necessary, but who knows what others are doing to our mailer
		 */
		// If we don't have a charset from the input headers


		$phpmailer->ClearAddresses();
		$phpmailer->ClearAllRecipients();
		$phpmailer->ClearAttachments();
		$phpmailer->ClearBCCs();
		$phpmailer->ClearCCs();
		$phpmailer->ClearCustomHeaders();
		$phpmailer->ClearReplyTos();
		//return $email;

		$charset = SendPress_Option::get('email-charset','UTF-8');
		$encoding = SendPress_Option::get('email-encoding','8bit');

		$phpmailer->CharSet = $charset;
		$phpmailer->Encoding = $encoding;


		if($charset != 'UTF-8'){
             $html = $this->change($html,'UTF-8',$charset);
             $text = $this->change($text,'UTF-8',$charset);
             $subject = $this->change($subject,'UTF-8',$charset);

		}

		/**
		* We'll let php init mess with the message body and headers.  But then
		* we stomp all over it.  Sorry, my plug-inis more important than yours :)
		*/
		do_action_ref_array( 'phpmailer_init', array( &$phpmailer ) );

        $from_email = SendPress_Option::get('fromemail');
		$phpmailer->From = $from_email;
		$phpmailer->FromName = SendPress_Option::get('fromname');
		//$phpmailer->Sender = 'bounce@sendpress.us';
		//$phpmailer->Sender = SendPress_Option::get('fromemail');
		$sending_method  = SendPress_Option::get('sendmethod');


        //$subject = str_replace(array('â€™','â€œ','â€�','â€“'),array("'",'"','"','-'),$subject);
        //$html = str_replace(chr(194),chr(32),$html);
		//$text = str_replace(chr(194),chr(32),$text);


		$phpmailer->AddAddress( trim( $to ) );
		$phpmailer->AltBody= $text;
		$phpmailer->Subject = $subject;
		$phpmailer->MsgHTML( $html );
		$content_type = 'text/html';
		$phpmailer->ContentType = $content_type;
		// Set whether it's plaintext, depending on $content_type
		//if ( 'text/html' == $content_type )
		$phpmailer->IsHTML( true );

		$rpath = SendPress_Option::get('bounce_email');
		if( $rpath != false ){
                          $phpmailer->ReturnPath = $rpath;
			  $phpmailer->AddReplyTo($rpath, SendPress_Option::get('fromname'));

		}

		$phpmailer->Mailer = 'smtp';
		// We are sending SMTP mail
		$phpmailer->IsSMTP();
		// Set the other options
		$phpmailer->Host = SendPress_Option::get('redelivreserver');
                if ( SendPress_Option::get('redelivretls') )
                {
		  $phpmailer->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for GMail
                }
		$phpmailer->Port = SendPress_Option::get('redelivreport');
		// If we're using smtp auth, set the username & password

		//only auth if needed
		$redelivreuser = trim(SendPress_Option::get('redelivreuser'));
		$redelivrepass = trim(SendPress_Option::get('redelivrepass'));
		if( ! empty($redelivreuser) && ! empty($redelivrepass) )
		{
			$phpmailer->SMTPAuth = true;  // authentication enabled
			$phpmailer->Username = $redelivreuser;
			$phpmailer->Password = $redelivrepass;
		}


		$hdr = new SendPress_SendGrid_SMTP_API();
		$hdr->addFilterSetting('dkim', 'domain', SendPress_Manager::get_domain_from_email($from_email) );
		$phpmailer->AddCustomHeader(sprintf( 'X-SMTPAPI: %s', $hdr->asJSON() ) );
		$phpmailer->AddCustomHeader('X-SP-METHOD: Rede Livre');
		$phpmailer->AddCustomHeader('X-SP-LIST: ' . $list_id );
		$phpmailer->AddCustomHeader('X-SP-REPORT: ' . $report_id );
		$phpmailer->AddCustomHeader('X-SP-SUBSCRIBER: '. $sid );
		$phpmailer->AddCustomHeader('List-Unsubscribe: <mailto:'.$from_email.'>');

		// Set SMTPDebug to 2 will collect dialogue between us and the mail server
		if($istest == true){
			$phpmailer->SMTPDebug = 2;
			// Start output buffering to grab smtp output
			ob_start();
		}


		// Send!
		$result = true; // start with true, meaning no error
		$result = @$phpmailer->Send();

		//$phpmailer->SMTPClose();
		if($istest == true){
			// Grab the smtp debugging output
			$smtp_debug = ob_get_clean();
			SendPress_Option::set('phpmailer_error', $phpmailer->ErrorInfo);
			SendPress_Option::set('last_test_debug', $smtp_debug);

		}

                if ( $result == true ) SendPress_Option::set('phpmailer_error', __('Nenhum erro encontrado' , 'jaiminho' ) );
		if (  $result != true ){
			$log_message = 'RedeLivre <br>';
			$log_message .= $to . "<br>";

			if( $istest == true  ){
				$log_message .= "<br><br>";
				$log_message .= $smtp_debug;
			}
			//$phpmailer->ErrorInfo
			SPNL()->log->add(  $phpmailer->ErrorInfo , $log_message , 0 , 'sending' );
		}

		if (  $result != true && $istest == true  ) {
			$hostmsg = 'host: '.($phpmailer->Host).'  port: '.($phpmailer->Port).'  secure: '.($phpmailer->SMTPSecure) .'  auth: '.($phpmailer->SMTPAuth).'  user: '.($phpmailer->Username)."  pass: *******\n";
		    $msg = '';
			$msg .= __('The result was: ','sendpress').$result."\n";
		    $msg .= __('The mailer error info: ','sendpress').$phpmailer->ErrorInfo."\n";
		    $msg .= $hostmsg;
		    $msg .= __("The SMTP debugging output is shown below:\n","sendpress");
		    $msg .= $smtp_debug."\n";
		}



		return $result;

	}



}


}
