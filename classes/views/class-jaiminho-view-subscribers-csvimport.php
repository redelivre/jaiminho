<?php

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

class Jaiminho_View_Subscribers_Csvimport extends Jaiminho_View_Subscribers {
	
  function html() { ?>
  <?php 
  if( SendPress_Option::get('import_error', false) == true ) { ?>
	<div class="alert alert-danger">
  <?php _e('We had a problem saving your upload','sendpress'); ?>.
  </div>
  <?php } ?>
  <div id="taskbar" class="lists-dashboard rounded group"> 
	<h2><?php _e('Import CSV to ','sendpress'); ?><?php echo get_the_title(SPNL()->validate->_int( 'listID' )); ?></h2>
	</div>
        <div class="boxer">
	<div class="boxer-inner">
	<form method="post" action="<?php echo esc_url( admin_url('admin.php') ); ?>" enctype="multipart/form-data" >
            <input type="hidden" name="action" value="import">
	    <input type="hidden" name="listID" value="<?php echo SPNL()->validate->_int( 'listID' ); ?>" />
          <input type="file" name="uploadfiles" id="uploadfiles" size="35" class="uploadfiles" />
          <button class="button-primary" type="submit" name="uploadfile" id="uploadfile_btn"  >Upload</button>
          <?php 
          SendPress_Option::set('import_error', false);
          SendPress_Data::nonce_field(); ?>
	</form>
</div>
</div>
<?php
	
	}

}
