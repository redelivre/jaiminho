<?php

require_once( ABSPATH . '/wp-content/plugins/jaiminho/classes/views/class-jaiminho-view-emails.php' );
require_once( ABSPATH . '/wp-content/plugins/sendpress/classes/views/class-sendpress-view-emails.php' );
// Prevent loading this file directly
if ( !defined('SENDPRESS_VERSION') ) {
	header('HTTP/1.0 403 Forbidden');
	die;
}

class Jaiminho_View_Emails_List_Filter extends Jaiminho_View_Emails {

	function html() {
		//var_dump("Conseguimos!!!");

		?>
       <style>
            .multiselect {
                width: 200px;
            }
            .selectBox {
                position: relative;
            }
            .selectBox select {
                width: 100%;
                font-weight: bold;
            }
            .overSelect {
                position: absolute;
                left: 0; right: 0; top: 0; bottom: 0;
            }
            #checkboxes {
                display: none;
                border: 1px #dadada solid;
            }
            #checkboxes label {
                display: block;
            }
            #checkboxes label:hover {
                background-color: #1e90ff;
            }
        </style>

        <script>
            var expanded = false;
            function showCheckboxes() {
                var checkboxes = document.getElementById("checkboxes");
                if (!expanded) {
                    checkboxes.style.display = "block";
                    expanded = true;
                } else {
                    checkboxes.style.display = "none";
                    expanded = false;
                }
            }
        </script>


        <style>
            .multiselect_genre {
                width: 200px;
            }
            .selectBox_genre {
                position: relative;
            }
            .selectBox_genre select {
                width: 100%;
                font-weight: bold;
            }
            .overSelect_genre {
                position: absolute;
                left: 0; right: 0; top: 0; bottom: 0;
            }
            #checkboxes_genre {
                display: none;
                border: 1px #dadada solid;
            }
            #checkboxes_genre label {
                display: block;
            }
            #checkboxes_genre label:hover {
                background-color: #1e90ff;
            }
        </style>

        <script>
            var expanded = false;
            function showCheckboxes_genre() {
                var checkboxes_genre = document.getElementById("checkboxes_genre");
                if (!expanded) {
                    checkboxes_genre.style.display = "block";
                    expanded = true;
                } else {
                    checkboxes_genre.style.display = "none";
                    expanded = false;
                }
            }
        </script>


        <style>
            .multiselect_category {
                width: 200px;
            }
            .selectBox_category {
                position: relative;
            }
            .selectBox_category select {
                width: 100%;
                font-weight: bold;
            }
            .overSelect_category {
                position: absolute;
                left: 0; right: 0; top: 0; bottom: 0;
            }
            #checkboxes_category {
                display: none;
                border: 1px #dadada solid;
            }
            #checkboxes_category label {
                display: block;
            }
            #checkboxes_category label:hover {
                background-color: #1e90ff;
            }
        </style>

        <script>
            var expanded = false;
            function showCheckboxes_category() {
                var checkboxes_category = document.getElementById("checkboxes_category");
                if (!expanded) {
                    checkboxes_category.style.display = "block";
                    expanded = true;
                } else {
                    checkboxes_category.style.display = "none";
                    expanded = false;
                }
            }
        </script>

		<h1>Crie uma Lista nova com utilizando meta info dos Assinantes:</h1>
		<form metho="post" action="">
			<label>Primeiro Selecione as listas que você quer utilizar:</label>
			<p>
			<?php

	        $post_args = array( 'post_type' => 'sendpress_list','numberposts'     => -1,
	                'offset'          => 0,
	                'orderby'         => 'post_title',
	                'order'           => 'DESC', );
			$current_lists = get_posts( $post_args );
	        foreach($current_lists as $list){

	             $t = '';
	             $tlist = '';
	                if( get_post_meta($list->ID,'_test_list',true) == 1 ){ 
	                   $t = '  <span class="label label-info">Test List</span>';
	                   $tlist = ' test-list-add';
	                } 
	            echo "<input name='listIDS[]' type='checkbox' id='listIDS' class='sp-send-lists ". $tlist ."' value=" . $list->ID. "> ".$list->post_title . " <small>(".SendPress_Data::get_count_subscribers($list->ID). ")</small>$t<br>";
	        }
	        ?>
	        </p>
	        <label>Agora selecione quais os filtros que você gostaria de realizar:</label>
	        <p>
			<input type="hidden" name="action" value="xxx">

			<div class="multiselect">
                <div class="selectBox" onclick="showCheckboxes()">
                    <select>
                        <option>Selecione os Estados</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div id="checkboxes">
                    <label><input type='checkbox' value='Acre'>Acre</label>
                    <label><input type='checkbox' value='Alagoas'>Alagoas</label>
                    <label><input type='checkbox' value='Amapá'>Amapá</label>
                    <label><input type='checkbox' value='Amazonas'>Amazonas</label>
                    <label><input type='checkbox' value='Bahia'>Bahia</label>
                    <label><input type='checkbox' value='Ceará'>Ceará</label>
                    <label><input type='checkbox' value='Distrito Federal'>Distrito Federal</label>
                    <label><input type='checkbox' value='Espírito Santo'>Espírito Santo</label>
                    <label><input type='checkbox' value='Goiás'>Goiás</label>
                    <label><input type='checkbox' value='Maranhão'>Maranhão</label>
                    <label><input type='checkbox' value='Mato Grosso'>Mato Grosso</label>
                    <label><input type='checkbox' value='Mato Grosso do Sul'>Mato Grosso do Sul</label>
                    <label><input type='checkbox' value='Minas Gerais'>Minas Gerais</label>
                    <label><input type='checkbox' value='Pará'>Pará</label>
                    <label><input type='checkbox' value='Paraíba'>Paraíba</label>
                    <label><input type='checkbox' value='Paraná'>Paraná</label>
                    <label><input type='checkbox' value='Pernambuco'>Pernambuco</label>
                    <label><input type='checkbox' value='Piauí'>Piauí</label>
                    <label><input type='checkbox' value='Rio de Janeiro'>Rio de Janeiro</label>
                    <label><input type='checkbox' value='Rio Grande do Norte'>Rio Grande do Norte</label>
                    <label><input type='checkbox' value='Rio Grande do Sul'>Rio Grande do Sul</label>
                    <label><input type='checkbox' value='Rondônia'>Rondônia</label>
                    <label><input type='checkbox' value='Roraima'>Roraima</label>
                    <label><input type='checkbox' value='Santa Catarina'>Santa Catarina</label>
                    <label><input type='checkbox' value='São Paulo'>São Paulo</label>
                    <label><input type='checkbox' value='Sergipe'>Sergipe</label>
                    <label><input type='checkbox' value='Tocantins'>Tocantins</label>
                </div>
            </div>

            <div class="multiselect_genre">
                <div class="selectBox_genre" onclick="showCheckboxes_genre()">
                    <select>
                        <option>Selecione os generos</option>
                    </select>
                    <div class="overSelect_genre"></div>
                </div>
                <div id="checkboxes_genre">
                    <label><input type='checkbox' value='feminino'>Feminino</label>
                    <label><input type='checkbox' value='masculino'>masculino</label>
                </div>
            </div>

            <div class="multiselect_category">
                <div class="selectBox_category" onclick="showCheckboxes_category()">
                    <select>
                        <option>Selecione as categorias</option>
                    </select>
                    <div class="overSelect_category"></div>
                </div>
                <div id="checkboxes_category">
                    <label><input type='checkbox' value='education'>Educação</label>
                    <label><input type='checkbox'value='health'>Saúde</label>
                    <label><input type='checkbox' value='culture'>Cultura</label>
                    <label><input type='checkbox' value='human_rights'>Direitos Humanos</label>
                </div>
            </div>
            </p>
            <button type="send" class="btn btn-primary">Gerar nova lista!</button>
		</form>

		<?php
	}

	function get_subscribers_ids($meta_key, $meta_value, $listID){
		global $wpdb;
		$meta_table = SendPress_Data::subscriber_meta_table();
		$query = 'select subscriberID,listID from ' . $meta_table . ' where meta_key=' . $meta_key . ' and meta_value=' . $meta_value . ' and listID=' . $listID;
		return $wpdb->get_results($query); 
	}

}

class SendPress_View_Emails_List_Filter extends SendPress_View_Emails {

	function html() {}

}