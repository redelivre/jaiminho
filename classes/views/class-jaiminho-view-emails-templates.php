<?php

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails.php' );

class Jaiminho_View_Emails_Templates extends Jaiminho_View_Emails{
	public function prerender($sp = false)
        {
		wp_enqueue_script( 'dashboard' );
		/*
		sp_add_help_widget( 'help_support', 'Support Information', array(&$this,'help_support'));
		sp_add_help_widget( 'help_knowledge', 'Recent Knowledge Base Articles', array(&$this,'help_knowledge'),'side' );
		sp_add_help_widget( 'help_debug', 'Debug Information', array(&$this,'help_debug'), 'side');
		
		sp_add_help_widget( 'help_blog', 'Recent Blog Posts', array(&$this,'help_blog'),'normal',  array(&$this,'help_blog_control') );
		sp_add_help_widget( 'help_shortcodes', 'Shortcode Cheat Sheet', array(&$this,'help_shortcodes') ,'normal');
		sp_add_help_widget( 'help_editemail', 'Customizing Emails', array(&$this,'help_editemail') ,'normal');
		*/
	}

	public function my_acf_admin_notice() {
		?>
			<div class="notice error my-acf-notice is-dismissible" >
			<p><?php _e( 'ACF is not necessary for this plugin, but it will make your experience better, install it now!', 'my-text-domain' ); ?></p>
			</div>
			<?php
	}

	public function html($sp){
        // XXX removendo a parte de update para aprimorar depois
	//	if(isset($_GET['templateID'])){
	//		$templateID = SPNL()->validate->int($_GET['templateID']);
	//		$post = get_post( $templateID );
	//		$post_ID = $post->ID;
	//		$post_id = wp_update_post(
	//				array(
        //                                        'ID'                    =>      $post_ID,
	//					'post_title'            =>      $_POST['post_title'],
	//					'post_content'          =>      $_POST['content_area_one_edit']
	//				     )
	//				);
	//		update_post_meta( $post_id, '_guid',  'cd8ab467-e236-49d3-bd6c-e84db055ae9a');
	//		update_post_meta( $post_id, '_footer_page', $_POST["footer_content_edit"] );
	//		update_post_meta( $post_id, '_header_content', $_POST["header_content_edit"] );
	//		update_post_meta( $post_id, '_header_padding', 'pad-header' );
	//	}
		if(isset($_POST['post_title'])){
			$post_id = wp_insert_post(
					array(
						'post_name'             =>      sanitize_title($_POST['post_title']),
						'post_title'            =>      $_POST['post_title'],
						'post_content'          =>      $_POST['content_area_one_edit'],
						'post_status'           =>      'sp-standard',
						'post_type'             =>      'sp_template',
					     )
					);
			update_post_meta( $post_id, '_guid',  'cd8ab467-e236-49d3-bd6c-e84db055ae9a');
			update_post_meta( $post_id, '_footer_page', $_POST["footer_content_edit"] );
			update_post_meta( $post_id, '_header_content', $_POST["header_content_edit"] );
			update_post_meta( $post_id, '_header_padding', 'pad-header' );
                        //SendPress_Admin::link('Emails_Social');
			SendPress_Admin::redirect('emails&view=temp');
		}
	  ?>
     <form method="post" id="post" role="form">
        <input type="hidden" name="action" id="action" value="save" />
       <div  >
       <div style="float:right;" class="btn-toolbar">
            <div id="sp-cancel-btn" class="btn-group">
     		<a href="<?php echo SendPress_Admin::link('Emails_Temp'); ?>" id="cancel-update" class="btn btn-default"><?php echo __('Cancel','sendpress'); ?></a>&nbsp;
            </div>
             <!--a class="btn btn-primary" href="<?php echo get_site_url().'/wp-admin/admin.php?page=sp-emails&view=temp'; ?>"><i class="icon-white icon-ok"></i> <?php echo __('Back','sendpress'); ?></a-->
             <button class="btn btn-primary " type="submit" value="save" name="submit"><i class="icon-white icon-ok"></i> <?php echo __('Save','sendpress'); ?></button>
        </div>
	

</div>
        <h2><?php _e('Create Template','jaiminho'); ?></h2>
        <br>
        <div class="sp-row">
<div class="sp-75 sp-first">
<!-- Nav tabs -->
<?php $enable_edits = true;?>
<ul class="nav nav-tabs">
  <li class="active"><a href="#content-area-one-tab" data-toggle="tab"><?php _e('Main Content','sendpress'); ?></a></li>
  <?php if($enable_edits){
  	?>
  	<li><a href="#header-content" data-toggle="tab"><?php _e('Header','sendpress'); ?></a></li>
  	<li><a href="#footer-content" data-toggle="tab"><?php _e('Footer','sendpress'); ?></a></li>
  	<?php
  }

  ?>
</ul>

<div class="tab-content" style="display:block;">
  <div class="tab-pane in active" id="content-area-one-tab">
  <?php wp_editor( isset( $post ) ? $post->post_content : '' , 'content_area_one_edit', array(
	'dfw' => true,
	'drag_drop_upload' => true,
	'tabfocus_elements' => 'insert-media-button-1,save-post',
	'editor_height' => 360,
	'tinymce' => array(
		'resize' => false,
		'wp_autoresize_on' => ( ! empty( $_wp_autoresize_on ) && get_user_setting( 'editor_expand', 'on' ) === 'on' ),
		'add_unload_trigger' => false,
	),
) ); ?><?php //wp_editor($post->post_content,'content_area_one_edit'); ?></div>

	<?php 
	if($enable_edits){
		?>
		<div class="tab-pane" id="header-content">
			<?php wp_editor( SendPress_Tag_Header_Content::content() , 'header_content_edit', array(
		'dfw' => true,
		'drag_drop_upload' => true,
		'tabfocus_elements' => 'insert-media-button-1,save-post',
		'editor_height' => 360,
		'tinymce' => array(
			'resize' => false,
			'wp_autoresize_on' => ( ! empty( $_wp_autoresize_on ) && get_user_setting( 'editor_expand', 'on' ) === 'on' ),
			'add_unload_trigger' => false,
		),
		) ); ?>

		</div>
		<div class="tab-pane" id="footer-content">
			<?php wp_editor(  SendPress_Tag_Footer_Page::content() , 'footer_content_edit', array(
		'dfw' => true,
		'drag_drop_upload' => true,
		'tabfocus_elements' => 'insert-media-button-1,save-post',
		'editor_height' => 360,
		'tinymce' => array(
			'resize' => false,
			'wp_autoresize_on' => ( ! empty( $_wp_autoresize_on ) && get_user_setting( 'editor_expand', 'on' ) === 'on' ),
			'add_unload_trigger' => false,
		),
		) ); ?>

		</div>
		<?php
	}
	?>
   <!--
  <div class="tab-pane fade" id="messages"><?php wp_editor($post->post_content,'content-3'); ?></div>
  <div class="tab-pane fade" id="settings"><?php wp_editor($post->post_content,'content-4'); ?></div>
  -->
</div>

</div>
<div class="sp-25">
<br><br>

	<?php $this->panel_start( __('Template Name','jaiminho') ); ?>
          <input type="text" name="post_title" value="<?php echo isset ( $post ) ? $post->post_title : '' ;?>"/>
	<?php $this->panel_end(  ); ?>
</div>
</div>


<div class="modal fade bs-modal-lg" id="sendpress-helper" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
	<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<ul class="nav nav-tabs" id="myTab">
			<li class="active tabs-first"><a href="#posts"><?php _e('Single Post','sendpress'); ?></a></li>
		  	<li ><a href="#merge"><?php _e('Personalize','sendpress'); ?></a></li>
		 
		  	<!--
		  <li><a href="#messages">Messages</a></li>
		  <li><a href="#settings">Settings</a></li>
			-->
		</ul>
	</div>
	<div class="modal-body">

 
<div class="tab-content">
	 <div class="tab-pane active" id="posts">

  	<div id="search-header"><?php _e('Search Posts','sendpress'); ?>: <input type="text" name="q" id="sp-single-query"></div>
  	<div  id="sp-post-preview" class="well">
  		<?php _e('No Post Selected','sendpress'); ?>
  	</div>

  	<p><?php _e('Header HTML','sendpress'); ?>:&nbsp;
	  	<label class="radio">
		  <input type="radio" name="headerOptions" id="optionsRadios1" value="h1" >
		  H1
		</label>
		<label class="radio">
		  <input type="radio" name="headerOptions" id="optionsRadios2" value="h2">
		  H2
		</label>
		<label class="radio">
		  <input type="radio" name="headerOptions" id="optionsRadios2" value="h3" checked>
		  H3
		</label>
		<label class="radio">
		  <input type="radio" name="headerOptions" id="optionsRadios2" value="h4">
		  H4
		</label>
		<label class="radio">
		  <input type="radio" name="headerOptions" id="optionsRadios2" value="h5">
		  H5
		</label>
		<label class="radio">
		  <input type="radio" name="headerOptions" id="optionsRadios2" value="h6">
		  H6
		</label>
	</p>
	<p><?php _e('Header Link','sendpress'); ?>:&nbsp;
	  	<label class="radio">
		  <input type="radio" name="headerlinkOptions" id="optionsRadios2" value="link" checked>
		  <?php _e('Link Header to Post','sendpress'); ?>
		</label>
		<label class="radio">
		  <input type="radio" name="headerlinkOptions" id="optionsRadios2" value="nolink">
		  <?php _e('Don\'t Link Header to Post','sendpress'); ?>
		</label>
	</p>
  	<p><?php _e('Post Content','sendpress'); ?>:&nbsp;
	  	<label class="radio">
		  <input type="radio" name="optionsRadios" id="optionsRadios1" value="excerpt" checked>
		  <?php _e('Excerpt','sendpress'); ?>
		</label>
		<label class="radio">
		  <input type="radio" name="optionsRadios" id="optionsRadios2" value="full">
		  <?php _e('Full Post','sendpress'); ?>
		</label>
	</p>
  	<button class="btn btn-mini btn-success sp-insert-code" id="sp-post-preview-insert" data-code=""><?php _e('Insert','sendpress'); ?></button>
  </div>
 	<div class="tab-pane " id="merge">
 		<h3><?php _e('Subscriber specific content','sendpress'); ?></h3>
  		<table class="table table-condensed table-striped">
  			
  <thead>
    <tr>
      <th><?php _e('Description','sendpress'); ?></th>
      <th><?php _e('Code','sendpress'); ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
    	<td><?php _e('First Name','sendpress'); ?></td>
      	<td>*|FNAME|*</td>
      	<td class="text-right"><button class="btn btn-xs btn-success sp-insert-code" data-code="*|FNAME|*"><?php _e('Insert','sendpress'); ?></button></td>
    </tr>
    <tr>
    	<td><?php _e('Last Name','sendpress'); ?></td>
      	<td>*|LNAME|*</td>
      	<td class="text-right"><button class="btn btn-xs btn-success sp-insert-code" data-code="*|LNAME|*"><?php _e('Insert','sendpress'); ?></button></td>
    </tr>
    <tr>
    	<td><?php _e('Email','sendpress'); ?></td>
      	<td>*|EMAIL|*</td>
      	<td class="text-right"><button class="btn btn-xs btn-success sp-insert-code"  data-code="*|EMAIL|*"><?php _e('Insert','sendpress'); ?></button></td>
    </tr>

  </tbody>
</table>
	<h3><?php _e('Site specific content','sendpress'); ?></h3>
  		<table class="table table-condensed table-striped">
  			
  <thead>
    <tr>
      <th><?php _e('Description','sendpress'); ?></th>
      <th><?php _e('Code','sendpress'); ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
    	<td><?php _e('Website URL','sendpress'); ?></td>
      	<td>*|SITE:URL|*</td>
      	<td class="text-right"><button class="btn btn-xs btn-success sp-insert-code" data-code="*|SITE:URL|*"><?php _e('Insert','sendpress'); ?></button></td>
    </tr>
    <tr>
    	<td><?php _e('Website Title','sendpress'); ?></td>
      	<td>*|SITE:TITLE|*</td>
      	<td class="text-right"><button class="btn btn-xs btn-success sp-insert-code" data-code="*|SITE:TITLE|*"><?php _e('Insert','sendpress'); ?></button></td>
    </tr>
    <tr>
    	<td><?php _e('Website Description','sendpress'); ?></td>
      	<td>*|SITE:DECRIPTION|*</td>
      	<td class="text-right"><button class="btn btn-xs btn-success sp-insert-code"  data-code="*|SITE:DESCRIPTION|*"><?php _e('Insert','sendpress'); ?></button></td>
    </tr>
    
  </tbody>
</table>
<h3><?php _e('Date and Time','sendpress'); ?></h3>
  		<table class="table table-condensed table-striped">
  			
  <thead>
    <tr>
      <th><?php _e('Description','sendpress'); ?></th>
      <th><?php _e('Code','sendpress'); ?></th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
    	<td><?php _e('Current Date','sendpress'); ?><br><small><?php _e('Format based on WordPress settings','sendpress'); ?>.</small></td>
      	<td>*|DATE|*</td>
      	<td class="text-right"><button class="btn btn-xs btn-success sp-insert-code" data-code="*|DATE|*"><?php _e('Insert','sendpress'); ?></button></td>
    </tr>
     <tr>
    	<td><?php _e('Current Time','sendpress'); ?><br><small>5:16 pm</small></td>
      	<td>*|DATE:g:i a|*</td>
      	<td class="text-right"><button class="btn btn-xs btn-success sp-insert-code" data-code="*|DATE:g:i a|*"><?php _e('Insert','sendpress'); ?></button></td>
    </tr>
    <tr>
    	<td><?php _e('Custom Date','sendpress'); ?><br><small>March 10, 2001, 5:16 pm</small></td>
      	<td>*|DATE:F j, Y, g:i a|*</td>
      	<td class="text-right"><button class="btn btn-xs btn-success sp-insert-code" data-code="*|DATE:F j, Y, g:i a|*"><?php _e('Insert','sendpress'); ?></button></td>
    </tr>
  
    
  </tbody>
</table>

  </div>
 
  <div class="tab-pane" id="messages">...</div>
  <div class="tab-pane" id="settings">...</div>
</div>
		
	</div>
	<div class="modal-footer">
	 	<a href="#" class="btn btn-primary" data-dismiss="modal"><?php _e('Close','sendpress'); ?></a>
	</div>
</div>
</div>
	<?php SendPress_Data::nonce_field(); ?>
        </form>
<?php

	}
}
// Add Access Controll!
//SendPress_Admin::add_cap('Emails_Templates','sendpress_email');
//SendPress_View_Overview::cap('sendpress_access');

