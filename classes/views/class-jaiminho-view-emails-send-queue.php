<?php

require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails.php' );

// Prevent loading this file directly
if (!defined('SENDPRESS_VERSION')) {
    header('HTTP/1.0 403 Forbidden');
    die;
}

class Jaiminho_View_Emails_Send_Queue extends Jaiminho_View_Emails
{


    function html() {
        global $post_ID, $post;
        $list = '';
        $emailID = SPNL()->validate->_int('emailID');
        if ($emailID > 0) {

            $post = get_post($emailID);
            $post_ID = $post->ID;
        }

        update_post_meta($post->ID, '_send_last', 0);

        $info = get_post_meta($post->ID, '_send_data', true);
        $lists = get_post_meta($post->ID, '_send_lists', true);
        $subject = $post->post_title;

        $list = explode(",", $lists);

        if ( SPNL()->validate->_isset('finished') ) {
            $time = get_post_meta($post->ID, '_send_time', true);
            if ($time == '0000-00-00 00:00:00') {
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
                }

                SendPress_Admin::redirect('Queue');
            }
            else {
                SendPress_Admin::redirect('Reports');
            }
        }

        $subs = SendPress_Data::get_active_subscribers_count($list);

        update_post_meta($post->ID, '_send_last_count', $subs);
        update_post_meta($post->ID, '_sendpress_report', 'new');

        ?>
        <div id="taskbar" class="lists-dashboard rounded group">


</div><input type="hidden" id="post_ID" name="post_ID" value="<?php echo $post->ID; ?>" /><input type="hidden" id="reporttoqueue" name="reporttoqueue" value="<?php echo $lists; ?>" />
<div class='well' id="confirm-queue-add">
    <h2><strong><?php
        //_e('Adding Subscribers to Queue', 'sendpress');
          _e('Enviando Mensagens', 'sendpress');  ?></strong></h2><br>
   <!-- <p>email:  <?php
        echo stripslashes(esc_attr(htmlspecialchars($subject))); ?></p>-->
    <div class="progress progress-striped active">
        <div class="progress-bar sp-queueit" style="width: 0%;"></div>
    </div>
    <span id="queue-total">Este procedimento leva bastante tempo.</span>
    <!--span id="queue-total">0</span> of <span id="list-total"><?php
        echo $subs; ?></span-->
</div>
        <?php
    }
}
SendPress_Admin::add_cap('Emails_Send_Queue', 'sendpress_email_send');
