<?php

require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails.php' );

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

/**
* Jaiminho_View_Emails_Tempdelete
*
* @uses     Jaiminho_View_Emails
*
* @package  Jaiminho
* @since 1.1
*
*/

class Jaiminho_View_Emails_Tempdelete extends Jaiminho_View_Emails {

	function html() {

		?>
		<?php
		$template = get_post($_GET['templateID']);

	?>

		<h2><?php _e('You are about to delete template','sendpress'); ?>: <?php echo $template->post_title; ?></h2>
		<br>
				<a class="btn btn-danger" href="<?php echo SendPress_Admin::link('Emails_Temp',array('templateID'=>$_GET['templateID'] , 'action'=>'delete' )); ?>"><?php _e('Delete Template','sendpress'); ?></a>

				<a class="btn btn-default" href="<?php echo SendPress_Admin::link('Emails_Temp'); ?>"><?php _e('Cancel','sendpress'); ?></a>

		<?php //wp_editor($post->post_content,'textversion'); ?>

		 <?php wp_nonce_field($this->_nonce_value); ?><br><br>
		 </form>

		<?php
	}

}
