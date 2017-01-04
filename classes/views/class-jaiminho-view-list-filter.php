<?php

require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails.php' );

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

class Jaiminho_View_List_Filter extends Jaiminho_View_Emails {

	function html() {
		var_dump("Conseguimos!!!");
	}

}
