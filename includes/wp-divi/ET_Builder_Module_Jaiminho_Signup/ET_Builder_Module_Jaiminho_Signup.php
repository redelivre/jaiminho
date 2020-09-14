<?php

class ET_Builder_Module_Jaiminho extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__( 'Jaiminho', 'et_builder' );
		$this->slug = 'et_pb_Jaiminho';

		$this->whitelisted_fields = array(
			'select_background_layout',
			'background_layout',
			'text_orientation',
			'content_new',
			'admin_label',
			'module_id',
			'module_class',
			'max_width',
			'max_width_tablet',
			'max_width_phone',
			'button_text',
		);

		$this->fields_defaults = array(
			'background_layout' => array( 'light' ),
			'background_color'  => array( et_builder_accent_color(), 'add_default_setting' ),
			'text_orientation'  => array( 'left' ),
			'button_text' => array( 'Assinar Newsletter' ),
		);

		$this->main_css_element = '%%order_class%%';
		$this->advanced_options = array(
			'fonts' => array(
				'text'   => array(
					'label'    => esc_html__( 'Text', 'et_builder' ),
					'css'      => array(
						'line_height' => "{$this->main_css_element} p",
					),
				),
			),
			'background' => array(
				'settings' => array(
					'color' => 'alpha',
				),
			),
			'border' => array(),
			'custom_margin_padding' => array(
				'css' => array(
					'important' => 'all',
				),
			),
			'button' => array(
				'button' => array(
					'label' => esc_html__( 'Button', 'et_builder' ),
					'css' => array(
						'main' => $this->main_css_element,
					),
				),
			),
		);
	}

	function get_fields() {

		$args = array(
			'numberposts'     => -1,
	    	'orderby'         => 'post_title',
	    	'order'           => 'DESC'
	    );

		//set the post type after filter so our function name always makes sense ;)
	    $args['post_type'] = 'sendpress_list';

		$query = new WP_Query( $args );
		$lists = array();
		while($query->have_posts()){
            $query->the_post();
            $item = get_post();
			$lists[$item->ID] = esc_html__( get_the_title() . " id: " . $item->ID, 'et_builder' );
		}
		wp_reset_postdata();

		$fields = array(
			'select_background_layout' => array(
				'label'             => esc_html__( 'Lista', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => $lists,
				'description'       => esc_html__( 'Selecione uma das listas em que será feito o cadastro do assinante.', 'et_builder' ),
			),
			'background_layout' => array(
				'label'             => esc_html__( 'Text Color', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'light' => esc_html__( 'Dark', 'et_builder' ),
					'dark'  => esc_html__( 'Light', 'et_builder' ),
				),
				'description'       => esc_html__( 'Here you can choose the value of your text. If you are working with a dark background, then your text should be set to light. If you are working with a light background, then your text should be dark.', 'et_builder' ),
			),
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'options'           => et_builder_get_text_orientation_options(),
				'description'       => esc_html__( 'This controls the how your text is aligned within the module.', 'et_builder' ),
			),
			'content_new' => array(
				'label'           => esc_html__( 'Content', 'et_builder' ),
				'type'            => 'tiny_mce',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Here you can create the content that will be used within the module.', 'et_builder' ),
			),
			'max_width' => array(
				'label'           => esc_html__( 'Max Width', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'layout',
				'mobile_options'  => true,
				'tab_slug'        => 'advanced',
				'validate_unit'   => true,
			),
			'max_width_tablet' => array(
				'type' => 'skip',
			),
			'max_width_phone' => array(
				'type' => 'skip',
			),
			'disabled_on' => array(
				'label'           => esc_html__( 'Disable on', 'et_builder' ),
				'type'            => 'multiple_checkboxes',
				'options'         => array(
					'phone'   => esc_html__( 'Phone', 'et_builder' ),
					'tablet'  => esc_html__( 'Tablet', 'et_builder' ),
					'desktop' => esc_html__( 'Desktop', 'et_builder' ),
				),
				'additional_att'  => 'disable_on',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'This will disable the module on selected devices', 'et_builder' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'et_builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'et_builder' ),
			),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'et_pb_custom_css_regular',
			),
			'button_text' => array(
				'label'           => esc_html__( 'Button Text', 'et_builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'Input your desired button text.', 'et_builder' ),
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$select_list          = $this->shortcode_atts['select_background_layout'];
		$module_id            = $this->shortcode_atts['module_id'];
		$module_class         = $this->shortcode_atts['module_class'];
		$background_layout    = $this->shortcode_atts['background_layout'];
		$text_orientation     = $this->shortcode_atts['text_orientation'];
		$max_width            = $this->shortcode_atts['max_width'];
		$max_width_tablet     = $this->shortcode_atts['max_width_tablet'];
		$max_width_phone      = $this->shortcode_atts['max_width_phone'];
		$button_text       = $this->shortcode_atts['button_text'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		$this->shortcode_content = et_builder_replace_code_content_entities( $this->shortcode_content );

		if ( '' !== $max_width_tablet || '' !== $max_width_phone || '' !== $max_width ) {
			$max_width_values = array(
				'desktop' => $max_width,
				'tablet'  => $max_width_tablet,
				'phone'   => $max_width_phone,
			);

			et_pb_generate_responsive_css( $max_width_values, '%%order_class%%', 'max-width', $function_name );
		}

		if ( is_rtl() && 'left' === $text_orientation ) {
			$text_orientation = 'right';
		}

		$class = " et_pb_module et_pb_bg_layout_{$background_layout} et_pb_text_align_{$text_orientation}";

		$output = sprintf(
			'<div%3$s class="et_pb_text%2$s%4$s">
				%1$s
			</div> <!-- .et_pb_text -->',
			$this->shortcode_content,
			esc_attr( $class ),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);


		if (isset($_GET) and isset($_GET['result'])) {
			if ($_GET['result'] == 1) {
				$output .= "<p>Assinante adicionado com sucesso</p><p>Algo esta errado?</p><p>Envie novamente as informações</p><br>";
			}
		}

		$output .= '<form method="post" action="' . esc_url( admin_url('admin.php') ) . '">';

		 	$output .= '<p>';
			$output .= '<input type="text" name="email" placeholder="Email">';
			$output .= '</p>';

			$output .= '<p>';
			$output .= '<input type="text" name="firstname" placeholder="Nome">';
			$output .= '</p>';

			$output .= '<p>';
			$output .= '<input type="text" name="lastname" placeholder="Sobrenome">';
			$output .= '</p>';

			$output .= '<p>';
			$output .= '<input type="text" name="phonenumber" placeholder="Telefone">';
			$output .= '</p>';

			$output .= '<input type="text" name="city" placeholder="'.__("Cidade", "jaiminho").'"value="" class="regular-text sp-text" /><br>';
	    $output .= '<span class="sublabel">' . __('Estado','sendpress') . ':</span><br>';
			$output .= '<select name="state">';
				$output .= '<option value="">Selecione seu Estado</option>';
				$output .= '<option value="Acre">Acre</option>';
				$output .= '<option value="Alagoas">Alagoas</option>';
				$output .= '<option value="Amapá">Amapá</option>';
				$output .= '<option value="Amazonas">Amazonas</option>';
				$output .= '<option value="Bahia">Bahia</option>';
				$output .= '<option value="Ceará">Ceará</option>';
				$output .= '<option value="Distrito Federal">Distrito Federal</option>';
				$output .= '<option value="Espírito Santo">Espírito Santo</option>';
				$output .= '<option value="Goiás">Goiás</option>';
				$output .= '<option value="Maranhão">Maranhão</option>';
				$output .= '<option value="Mato Grosso">Mato Grosso</option>';
				$output .= '<option value="Mato Grosso do Sul">Mato Grosso do Sul</option>';
				$output .= '<option value="Minas Gerais">Minas Gerais</option>';
				$output .= '<option value="Pará">Pará</option>';
				$output .= '<option value="Paraíba">Paraíba</option>';
				$output .= '<option value="Paraná">Paraná</option>';
				$output .= '<option value="Pernambuco">Pernambuco</option>';
				$output .= '<option value="Piauí">Piauí</option>';
				$output .= '<option value="Rio de Janeiro">Rio de Janeiro</option>';
				$output .= '<option value="Rio Grande do Norte">Rio Grande do Norte</option>';
				$output .= '<option value="Rio Grande do Sul">Rio Grande do Sul</option>';
				$output .= '<option value="Rondônia">Rondônia</option>';
				$output .= '<option value="Roraima">Roraima</option>';
				$output .= '<option value="Santa Catarina">Santa Catarina</option>';
				$output .= '<option value="São Paulo">São Paulo</option>';
				$output .= '<option value="Sergipe">Sergipe</option>';
				$output .= '<option value="Tocantins">Tocantins</option>';
			$output .= '</select>';

			$output .= '<br>';

	    $output .= '<span class="sublabel">' . __('Genêro','sendpress') . ':</span><br>';
	    $output .= '<select name="genre">';
				$output .= '<option value="masculino">Masculino</option>';
				$output .= '<option value="feminino">Feminino</option>';
      $output .= '</select><br>';

      $output .= '<span class="sublabel">' . __('Categoria','sendpress') .':</span><br>';
	    $output .= '<select name="category">';
				$output .= '<option value="education">Educação</option>';
				$output .= '<option value="health">Saúde</option>';
				$output .= '<option value="culture">Cultura</option>';
				$output .= '<option value="human_rights">Direitos Humanos</option>';
      $output .= '</select><br><br>';

			$output .= '<input type="hidden" name="action" value="addsubscriber">';
			$output .= '<input type="hidden" name="link" value="' . get_page_link()	 . '">';
			$output .=  '<input type="hidden" name="list" value="' . $select_list . '">';

	 		$output .= '<button class="et_pb_button" style="background-color:#545454; color: white ">' . ('' !== $button_text ? esc_html( $button_text ) : 'Assinar Newsletter') . '</button>';
	 		$output .= '</p>';
		$output .= '</form>';

		return $output;
	}
}
new ET_Builder_Module_Jaiminho;
