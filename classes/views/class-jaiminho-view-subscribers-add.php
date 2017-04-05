<?php

// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

class Jaiminho_View_Subscribers_Add extends Jaiminho_View_Subscribers {
	
	function html() { ?>
	<div id="taskbar" class="lists-dashboard rounded group"> 
	<h2><?php _e('Add Subscriber','sendpress'); ?></h2>
	</div>
<div class="boxer">
	<div class="boxer-inner">
	<!-- Forms are NOT created automatically, so you need to wrap the table in one to use features like bulk actions -->
	<form id="subscriber-create" method="post" action="<?php echo esc_url( admin_url('admin.php') ); ?>">
		<!-- For plugins, we also need to ensure that the form posts back to our current page -->
	    <input type="hidden" name="action" value="createsubscriber" />
	    <input type="hidden" name="listID" value="<?php echo SPNL()->validate->_int('listID'); ?>" />
	    <span class="sublabel"><?php _e('Email','sendpress') ?>:</span><input type="text" name="email" value="" class="regular-text sp-text" /><br>
	    <span class="sublabel"><?php _e('Salutation','sendpress'); ?>:</span><input type="text" name="salutation" value="" class="regular-text sp-text" /><br>
	    <span class="sublabel"><?php _e('Firstname','sendpress'); ?>:</span><input type="text" name="firstname" value="" class="regular-text sp-text" /><br>
	    <span class="sublabel"><?php _e('Lastname','sendpress'); ?>:</span><input type="text" name="lastname" value="" class="regular-text sp-text" /><br>
	    <span class="sublabel"><?php _e('Phone Number','sendpress'); ?>:</span><input type="text" name="phonenumber" value="" class="regular-text sp-text" /><br>
	    <span class="sublabel"><?php _e('Estado','jaiminho'); ?>:</span>
			<select name="state">
				<option value="">Selecione seu Estado</option>
				<option value='Acre'>Acre</option>
				<option value='Alagoas'>Alagoas</option>
				<option value='Amapá'>Amapá</option>
				<option value='Amazonas'>Amazonas</option>
				<option value='Bahia'>Bahia</option>
				<option value='Ceará'>Ceará</option>
				<option value='Distrito Federal'>Distrito Federal</option>
				<option value='Espírito Santo'>Espírito Santo</option>
				<option value='Goiás'>Goiás</option>
				<option value='Maranhão'>Maranhão</option>
				<option value='Mato Grosso'>Mato Grosso</option>
				<option value='Mato Grosso do Sul'>Mato Grosso do Sul</option>
				<option value='Minas Gerais'>Minas Gerais</option>
				<option value='Pará'>Pará</option>
				<option value='Paraíba'>Paraíba</option>
				<option value='Paraná'>Paraná</option>
				<option value='Pernambuco'>Pernambuco</option>
				<option value='Piauí'>Piauí</option>
				<option value='Rio de Janeiro'>Rio de Janeiro</option>
				<option value='Rio Grande do Norte'>Rio Grande do Norte</option>
				<option value='Rio Grande do Sul'>Rio Grande do Sul</option>
				<option value='Rondônia'>Rondônia</option>
				<option value='Roraima'>Roraima</option>
				<option value='Santa Catarina'>Santa Catarina</option>
				<option value='São Paulo'>São Paulo</option>
				<option value='Sergipe'>Sergipe</option>
				<option value='Tocantins'>Tocantins</option>
			</select>
	    <br>
	    <span class="sublabel"><?php _e('Cidade','jaiminho'); ?>:</span><input type="text" name="city" value="" class="regular-text sp-text" /><br>
	    <span class="sublabel"><?php _e('Genêro','sendpress'); ?>:</span>
	      <select name="genre">
			<option value='masculino'>Masculino</option>
			<option value='feminino'>Feminino</option>
          </select><br>
        <span class="sublabel"><?php _e('categoria','sendpress'); ?>:</span>
	      <select name="category">
			<option value='education'>Educação</option>
			<option value='health'>Saúde</option>
			<option value='culture'>Cultura</option>
			<option value='human_rights'>Direitos Humanos</option>
          </select><br>
	    <span class="sublabel"><?php _e('Status','sendpress'); ?>:</span><select name="status">
	    			<?php 
	    				$results =  SendPress_Data::get_statuses();
	    				foreach($results as $status){
	    					$selected = '';
	    					if($status->status == 'Active'){
	    						$selected = 'selected';
	    					}
	    					echo "<option value='$status->statusid' $selected>$status->status</option>";

	    				}


	    			?>

	    		</select>
	    		<br>
	  <button type="submit" class="btn btn-primary"><?php _e('Submit','sendpress'); ?></button>
	   <?php SendPress_Data::nonce_field(); ?>

	</form>
	</div>
</div>
	
	<h2><?php _e('Add Subscribers','sendpress'); ?></h2>
<div class="boxer">
	<div class="boxer-inner">	

		<div class="subscribers-create-container">

			<form id="subscribers-create" method="post" action="<?php echo esc_url( admin_url('admin.php') ); ?>">
					<!-- For plugins, we also need to ensure that the form posts back to our current page -->
				    <input type="hidden" name="action" value="createsubscribers" />
 				    <?php var_dump(SPNL()->validate->_int( 'listID' )); ?> 
				    <input type="hidden" name="listID" value="<?php echo SPNL()->validate->_int( 'listID' ); ?>" />
				   	<textarea name="csv-add"></textarea>
				   	<button type="submit" class="btn btn-primary"><?php _e('Submit','sendpress'); ?></button>
				   	<?php SendPress_Data::nonce_field(); ?>
			</form>

			<div style="width: 25%; padding: 15px;" class="rounded box float-right">
				<?php _e('Emails shoud be written in separate lines. A line could also include a name, which is separated from the email by a comma','sendpress'); ?>.<br><br>
				<strong><?php _e('Correct formats','sendpress'); ?>:</strong><br>
				joao@redelivre.org.br<br>
				joao@redelivre.org.br, João<br>
				joao@redelivre.org.br, João, Mehl<br>
			</div>
		</div>
</div>
</div>
<?php
	
	}

}
