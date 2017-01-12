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

        <style>
            .multiselect_city {
                width: 200px;
            }
            .selectBox_city {
                position: relative;
            }
            .selectBox_city select {
                width: 100%;
                font-weight: bold;
            }
            .overSelect_city {
                position: absolute;
                left: 0; right: 0; top: 0; bottom: 0;
            }
            #checkboxes_city {
                display: none;
                border: 1px #dadada solid;
            }
            #checkboxes_city label {
                display: block;
            }
            #checkboxes_city label:hover {
                background-color: #1e90ff;
            }
            .button-next{
            	float:right;
            }
        </style>

        <script>
            var expanded = false;
            function showCheckboxes_city() {
                var checkboxes_city = document.getElementById("checkboxes_city");
                if (!expanded) {
                    checkboxes_city.style.display = "block";
                    expanded = true;
                } else {
                    checkboxes_city.style.display = "none";
                    expanded = false;
                }
            }
        </script>

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

        <a class="btn btn-primary button-next" href="<?php echo esc_url( admin_url('admin.php') ); ?>?page=sp-emails&view=send&emailID=<?php echo $_GET['emailID']; ?>" ><?php _e('Pular este Passo'); ?></a> 

		<h1>Crie uma Lista nova com utilizando meta info dos Assinantes:</h1>

		<form metho="get" action="<?php echo esc_url( admin_url('admin.php') ); ?>">
		    <input type="hidden" name="action" value="createlist">
		    <input type="hidden" name="emailID" value="<?php echo $_GET['emailID']; ?>">
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
			<div class="multiselect">
                <div class="selectBox" onclick="showCheckboxes()">
                    <select>
                        <option>Selecione os Estados</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div id="checkboxes">
                <?php
                foreach ($this->get_keys('state') as $state) {
                	echo "<label><input type='checkbox' name='states[]' value='$state->meta_value'>$state->meta_value</label>";
                }
                ?>
                </div>
            </div>
            <div class="multiselect_city">
                <div class="selectBox_city" onclick="showCheckboxes_city()">
                    <select>
                        <option>Selecione as Cidades</option>
                    </select>
                    <div class="overSelect_city"></div>
                </div>
                <div id="checkboxes_city">
                <?php
                foreach ($this->get_keys('city') as $state) {
                	echo "<label><input type='checkbox' name='cities[]' value='$state->meta_value'>$state->meta_value</label>";
                }
                ?>
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
                <?php
                foreach ($this->get_keys('genre') as $state) {
                	echo "<label><input type='checkbox' name='genres[]' value='$state->meta_value'>$state->meta_value</label>";
                }
                ?>
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
                <?php
                foreach ($this->get_keys('category') as $state) {
                	echo "<label><input type='checkbox' name='categories[]' value='$state->meta_value'>$state->meta_value</label>";
                }
                ?>
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

	function get_keys($meta_key){
		global $wpdb;
		$meta_table = SendPress_Data::subscriber_meta_table();
		$query = "select distinct meta_value ";
		$query .= $wpdb->prepare( " from $meta_table where meta_key = %s", $meta_key );
		return $wpdb->get_results($query);
	}


}

class SendPress_View_Emails_List_Filter extends SendPress_View_Emails {

	function html() {}

}