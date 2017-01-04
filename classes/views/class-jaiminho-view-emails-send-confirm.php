<?php

require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails.php' );

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
    header('HTTP/1.0 403 Forbidden');
    die;
}

class Jaiminho_View_Emails_Send_Confirm extends Jaiminho_View_Emails {

    function html() {

        var_dump($_POST);

        global $post_ID, $post;

        $list ='';
        $emailID = SPNL()->validate->_int('emailID');
        if($emailID > 0){
            
            $post = get_post( $emailID );
            $post_ID = $post->ID;
        }

        ?>
        <form  method="POST" name="post" id="post" action="<?php echo esc_url( admin_url('admin.php') ); ?>">
<?php
$info = SendPress_Option::get('current_send_'.$post->ID );
$subject = SendPress_Option::get('current_send_subject_'.$post->ID ,true);
?>
<div id="styler-menu">
    <div style="float:right;" class="btn-group">
    <input type="hidden" name="action" value="sendemails">
<a class="btn btn-primary btn-large " id="confirm-send" href="#"><i class="icon-white  icon-thumbs-up"></i> <?php _e('Confirm Send','sendpress'); ?></a>
  </div>
</div>
<div id="sp-cancel-btn" style="float:right; ">
<a class="btn btn-default" href="<?php echo '?page='.SPNL()->validate->page(). '&view=send&emailID='. $emailID ; ?>"><?php _e('Cancel Send','sendpress'); ?></a>&nbsp;
</div>
<h2><?php _e('Confirm Send','sendpress'); ?></h2>
<br>

<input type="hidden" id="user-id" name="user_ID" value="<?php //echo $current_user->ID; ?>" />
<input type="hidden" id="post_ID" name="post_ID" value="<?php echo $post->ID; ?>" />
<div class="boxer">
<div class="boxer-inner">
<?php $this->panel_start('<span class="glyphicon glyphicon-inbox"></span> '. __('Subject','sendpress')); ?>
<input type="text" class="form-control" value="<?php echo stripslashes(esc_attr( htmlspecialchars( $subject ) )); ?>" disabled />
<?php $this->panel_end(); ?>
<div class="leftcol">
<?php $this->panel_start( '<span class="glyphicon glyphicon-calendar"></span> '. __('Date & Time','sendpress')); ?>
<?php if($info['send_at'] == '0000-00-00 00:00:00') {
    echo "Your email will start sending right away!";
} else {
    echo "Your email will start sending on " .date('Y/m/d',strtotime($info['send_at'])) . " at " .date('h:i A',strtotime($info['send_at']))  ;
}?>
<?php 
$this->panel_end(); 

$this->panel_start('<span class="glyphicon glyphicon-list"></span> '. __('Lists','sendpress'));
?>



<?php

if( !empty($info['listIDS']) ){
    foreach($info['listIDS'] as $list_id){
        $list = SendPress_Data::get_list_details( $list_id );
        echo $list->post_title. " <small>(".SendPress_Data::get_count_subscribers($list_id). ")</small><br>";      

    } 
} else {
    _e('No Lists Selected','sendpress');
    echo "<br>";
}


?>
<?php $this->panel_end(); ?>
<?php
$this->panel_start('<span class="glyphicon glyphicon-tag"></span> '. __('Mark as Test','sendpress'));
    $sel = '';
    if(get_post_meta($post_ID ,'istest',true) == true ){
        $sel = 'checked';
    }
    echo "<input $sel name='test_report' type='checkbox' id='test_report' value='1' disabled> Test<br>";
    echo "<small class='text-muted'>". __('This puts the report into the Test tab on the Reports screen','sendpress') .".</small>";

$this->panel_end();
?>

</div>
<div style="margin-left: 250px;">
<div class="widerightcol">
<?php
$link =  get_permalink( $post->ID ); 
$sep = strstr($link, '?') ? '&' : '?';
$link = $link.$sep.'inline=true';

$open_info = array(
    "id"=>$post->ID,

    "view"=>"email"
);
$code = SendPress_Data::encrypt( $open_info );

$url =  SendPress_Manager::public_url($code);

$sep = strstr($url, '?') ? '&' : '?';
$link = $url.$sep.'inline=true';
?>
<iframe src="<?php echo $link; ?>" width="100%" height="600px"></iframe>

<small><?php _e('Displaying a 404? Please try saving your permalinks','sendpress'); ?> <a href="<?php echo admin_url('options-permalink.php'); ?>"><?php _e('here','sendpress'); ?></a>.</small>
</div>
<?php wp_nonce_field($this->_nonce_value); ?><br><br>
</div>
</div>
<br class="clear" />
    </div>
    </form>
    <?php   
    } 

}
SendPress_Admin::add_cap('Emails_Send_Confirm','sendpress_email_send');
