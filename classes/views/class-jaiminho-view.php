<?php

require_once( ABSPATH . '/wp-content/plugins/sendpress/classes/views/class-sendpress-view.php' );

// Field classes
class Jaiminho_View extends SendPress_View 
{

  public function __construct() 
  {
    add_action('init', array( $this , 'Init' ) );
  }
  public function Init()
  {
    add_filter( 'in_admin_footer','__return_empty_string',11);
  }
}
