<?php

class ET_Builder_Module_Jaiminho_Signup extends ET_Builder_Module {
	function init() {
		$this->name = esc_html__( 'Jaiminho Email Optin', 'et_builder' );
		$this->slug = 'et_pb_jaiminho_signup';

		$this->whitelisted_fields = array(
			'provider',
			'jaiminho_list',
			'title',
			'button_text',
			'use_background_color',
			'background_color',
			'background_layout',
			'text_orientation',
			'content_new',
			'admin_label',
			'module_id',
			'module_class',
			'form_field_background_color',
			'form_field_text_color',
			'focus_background_color',
			'focus_text_color',
			'use_focus_border_color',
			'focus_border_color',
		);

		$this->fields_defaults = array(
			'provider'               => array( 'mailchimp' ),
			'button_text'            => array( esc_html__( 'Subscribe', 'et_builder' ) ),
			'use_background_color'   => array( 'on' ),
			'background_color'       => array( et_builder_accent_color(), 'add_default_setting' ),
			'background_layout'      => array( 'dark' ),
			'text_orientation'       => array( 'left' ),
			'use_focus_border_color' => array( 'off' ),
		);

		$this->main_css_element = '%%order_class%%.et_pb_subscribe';
		$this->advanced_options = array(
			'fonts' => array(
				'header' => array(
					'label'    => esc_html__( 'Header', 'et_builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} h2",
						'important' => 'all',
					),
				),
				'body'   => array(
					'label'    => esc_html__( 'Body', 'et_builder' ),
					'css'      => array(
						'line_height' => "{$this->main_css_element} p",
					),
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
				),
			),
		);
		$this->custom_css_options = array(
			'newsletter_description' => array(
				'label'    => esc_html__( 'Newsletter Description', 'et_builder' ),
				'selector' => '.et_pb_newsletter_description',
			),
			'newsletter_form' => array(
				'label'    => esc_html__( 'Newsletter Form', 'et_builder' ),
				'selector' => '.et_pb_newsletter_form',
			),
			'newsletter_fields' => array(
				'label'    => esc_html__( 'Newsletter Fields', 'et_builder' ),
				'selector' => '.et_pb_newsletter_form input',
			),
			'newsletter_button' => array(
				'label'    => esc_html__( 'Newsletter Button', 'et_builder' ),
				'selector' => '.et_pb_newsletter_button',
			),
		);
	}
}
	function get_fields() {
		$et_pb_jaiminho_lists_options = array( 'none' => esc_html__( 'Select the list', 'et_builder' ) );

		//$et_pb_jaiminho_lists = et_pb_get_jaiminho_lists();
		//$et_pb_jaiminho_lists = array(  'teste' => 'Teste' ,  'lobo' => 'Lobo'  );

		//if ( $et_pb_jaiminho_lists ) {
		//	foreach ( $et_pb_jaiminho_lists as $et_pb_jaiminho_list_key => $et_pb_jaiminho_list_name ) {
		//		$et_pb_jaiminho_lists_options[ $et_pb_jaiminho_list_key ] = $et_pb_jaiminho_list_name;
		//	}
		//}

		$fields = array(
			'provider' => array(
				'label'           => esc_html__( 'Service Provider', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'Jaiminho'  => esc_html__( 'Jaiminho', 'et_builder' ),
				),
				'affects' => array(
					'#et_pb_jaiminho_list',
				),
				'description'       => esc_html__( 'Here you can choose a service provider.', 'et_builder' ),
			),
			'jaiminho_list' => array(
				'label'           => esc_html__( 'Jaiminho lists', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => $et_pb_jaiminho_lists_options,
				'description'     => sprintf(
					esc_html__( 'Here you can choose MailChimp list to add customers to. If you don\'t see any lists here, you need to make sure MailChimp API key is set in %1$s and you have at least one list on a MailChimp account. If you added new list, but it doesn\'t appear here, activate \'Regenerate MailChimp Lists\' option in %1$s.%2$s', 'et_builder' ),
						et_is_builder_plugin_active() ? esc_html__( 'Divi Plugin Options', 'et_builder' ) : esc_html__( 'ePanel', 'et_builder' ),
						! et_is_builder_plugin_active() ? esc_html__( 'Don\'t forget to disable it once the list has been regenerated.', 'et_builder' ) : ''
					),
				'depends_show_if' => 'jaiminho',
			),
			'button_text' => array(
				'label'             => esc_html__( 'Button Text', 'et_builder' ),
				'type'              => 'text',
				'option_category'   => 'basic_option',
				'description'       => esc_html__( 'Here you can change the text used for the signup button.', 'et_builder' ),
			),
			'use_background_color' => array(
				'label'             => esc_html__( 'Use Background Color', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'configuration',
				'options'           => array(
					'on'  => esc_html__( 'Yes', 'et_builder' ),
					'off' => esc_html__( 'No', 'et_builder' ),
				),
				'affects'           => array(
					'#et_pb_background_color',
				),
				'description'       => esc_html__( 'Here you can choose whether background color setting below should be used or not.', 'et_builder' ),
			),
			'background_color' => array(
				'label'             => esc_html__( 'Background Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'description'       => esc_html__( 'Define a custom background color for your module, or leave blank to use the default color.', 'et_builder' ),
				'depends_default'   => true,
			),
			'background_layout' => array(
				'label'           => esc_html__( 'Text Color', 'et_builder' ),
				'type'            => 'select',
				'option_category' => 'configuration',
				'options'         => array(
					'dark'  => esc_html__( 'Light', 'et_builder' ),
					'light' => esc_html__( 'Dark', 'et_builder' ),
				),
				'description' => esc_html__( 'Here you can choose whether your text should be light or dark. If you are working with a dark background, then your text should be light. If your background is light, then your text should be set to dark.', 'et_builder' ),
			),
			'text_orientation' => array(
				'label'             => esc_html__( 'Text Orientation', 'et_builder' ),
				'type'              => 'select',
				'option_category'   => 'layout',
				'options'           => et_builder_get_text_orientation_options(),
				'description'       => esc_html__( 'Here you can adjust the alignment of your text.', 'et_builder' ),
			),
			'content_new' => array(
				'label'             => esc_html__( 'Content', 'et_builder' ),
				'type'              => 'tiny_mce',
				'option_category'   => 'basic_option',
				'description'       => esc_html__( 'Input the main text content for your module here.', 'et_builder' ),
			),
			'form_field_background_color' => array(
				'label'             => esc_html__( 'Form Field Background Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'form_field_text_color' => array(
				'label'             => esc_html__( 'Form Field Text Color', 'et_builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'focus_background_color' => array(
				'label'             => esc_html__( 'Focus Background Color', 'et_builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'focus_text_color' => array(
				'label'             => esc_html__( 'Focus Text Color', 'et_builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'use_focus_border_color' => array(
				'label'           => esc_html__( 'Use Focus Border Color', 'et_builder' ),
				'type'            => 'yes_no_button',
				'option_category' => 'color_option',
				'options'         => array(
					'off' => esc_html__( 'No', 'et_builder' ),
					'on'  => esc_html__( 'Yes', 'et_builder' ),
				),
				'affects'     => array(
					'#et_pb_focus_border_color',
				),
				'tab_slug' => 'advanced',
			),
			'focus_border_color' => array(
				'label'             => esc_html__( 'Focus Border Color', 'et_builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'depends_default'   => true,
				'tab_slug'          => 'advanced',
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
		);
		return $fields;
	}
	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id                   = $this->shortcode_atts['module_id'];
		$module_class                = $this->shortcode_atts['module_class'];
		$title                       = $this->shortcode_atts['title'];
		$button_text                 = $this->shortcode_atts['button_text'];
		$background_color            = $this->shortcode_atts['background_color'];
		$mailchimp_list              = $this->shortcode_atts['mailchimp_list'];
		$aweber_list                 = $this->shortcode_atts['aweber_list'];
		$text_orientation            = $this->shortcode_atts['text_orientation'];
		$use_background_color        = $this->shortcode_atts['use_background_color'];
		$provider                    = $this->shortcode_atts['provider'];
		$feedburner_uri              = $this->shortcode_atts['feedburner_uri'];
		$background_layout           = $this->shortcode_atts['background_layout'];
		$form_field_background_color = $this->shortcode_atts['form_field_background_color'];
		$form_field_text_color       = $this->shortcode_atts['form_field_text_color'];
		$focus_background_color      = $this->shortcode_atts['focus_background_color'];
		$focus_text_color            = $this->shortcode_atts['focus_text_color'];
		$use_focus_border_color      = $this->shortcode_atts['use_focus_border_color'];
		$focus_border_color          = $this->shortcode_atts['focus_border_color'];
		$button_custom               = $this->shortcode_atts['custom_button'];
		$custom_icon                 = $this->shortcode_atts['button_icon'];

		$module_class = ET_Builder_Element::add_module_order_class( $module_class, $function_name );

		if ( '' !== $focus_background_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_newsletter_form p input.input:focus',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $focus_background_color )
				),
			) );
		}

		if ( '' !== $focus_text_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_newsletter_form p input.input:focus',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $focus_text_color )
				),
			) );
		}

		if ( 'off' !== $use_focus_border_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .et_pb_newsletter_form p input.input:focus',
				'declaration' => sprintf(
					'border: 1px solid %1$s !important;',
					esc_html( $focus_border_color )
				),
			) );
		}

		if ( '' !== $form_field_background_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% input[type="text"], %%order_class%% textarea',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $form_field_background_color )
				),
			) );
		}

		if ( '' !== $form_field_text_color ) {
			ET_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% input[type="text"], %%order_class%% textarea',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $form_field_text_color )
				),
			) );
		}

		if ( is_rtl() && 'left' === $text_orientation ) {
			$text_orientation = 'right';
		}

		$class = " et_pb_module et_pb_bg_layout_{$background_layout} et_pb_text_align_{$text_orientation}";

		$form = '';

		$firstname     = esc_html__( 'First Name', 'et_builder' );
		$lastname      = esc_html__( 'Last Name', 'et_builder' );
		$email_address = esc_html__( 'Email Address', 'et_builder' );

		switch ( $provider ) {
			case 'mailchimp' :
				if ( ! in_array( $mailchimp_list, array( '', 'none' ) ) ) {
					$form = sprintf( '
						<div class="et_pb_newsletter_form">
							<div class="et_pb_newsletter_result"></div>
							<p>
								<label class="et_pb_contact_form_label" for="et_pb_signup_firstname" style="display: none;">%3$s</label>
								<input id="et_pb_signup_firstname" class="input" type="text" value="%4$s" name="et_pb_signup_firstname">
							</p>
							<p>
								<label class="et_pb_contact_form_label" for="et_pb_signup_lastname" style="display: none;">%5$s</label>
								<input id="et_pb_signup_lastname" class="input" type="text" value="%6$s" name="et_pb_signup_lastname">
							</p>
							<p>
								<label class="et_pb_contact_form_label" for="et_pb_signup_email" style="display: none;">%7$s</label>
								<input id="et_pb_signup_email" class="input" type="text" value="%8$s" name="et_pb_signup_email">
							</p>
							<p><a class="et_pb_newsletter_button et_pb_button%10$s" href="#"%9$s><span class="et_subscribe_loader"></span><span class="et_pb_newsletter_button_text">%1$s</span></a></p>
							<input type="hidden" value="%2$s" name="et_pb_signup_list_id" />
						</div>',
						esc_html( $button_text ),
						( ! in_array( $mailchimp_list, array( '', 'none' ) ) ? esc_attr( $mailchimp_list ) : '' ),
						esc_html( $firstname ),
						esc_attr( $firstname ),
						esc_html( $lastname ),
						esc_attr( $lastname ),
						esc_html( $email_address ),
						esc_attr( $email_address ),
						'' !== $custom_icon && 'on' === $button_custom ? sprintf(
							' data-icon="%1$s"',
							esc_attr( et_pb_process_font_icon( $custom_icon ) )
						) : '',
						'' !== $custom_icon && 'on' === $button_custom ? ' et_pb_custom_button_icon' : ''
					);
				}

				break;
			case 'feedburner':
				$form = sprintf( '
					<div class="et_pb_newsletter_form et_pb_feedburner_form">
						<form action="http://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open(\'http://feedburner.google.com/fb/a/mailverify?uri=%4$s\', \'popupwindow\', \'scrollbars=yes,width=550,height=520\'); return true">
						<p>
							<label class="et_pb_contact_form_label" for="email" style="display: none;">%2$s</label>
							<input id="email" class="input" type="text" value="%3$s" name="email">
						</p>
						<p><button class="et_pb_newsletter_button et_pb_button%7$s" type="submit"%6$s>%1$s</button></p>
						<input type="hidden" value="%4$s" name="uri" />
						<input type="hidden" name="loc" value="%5$s" />
						</form>
					</div>',
					esc_html( $button_text ),
					esc_html( $email_address ),
					esc_attr( $email_address ),
					esc_attr( $feedburner_uri ),
					esc_attr( get_locale() ),
					'' !== $custom_icon && 'on' === $button_custom ? sprintf(
							' data-icon="%1$s"',
							esc_attr( et_pb_process_font_icon( $custom_icon ) )
					) : '',
					'' !== $custom_icon && 'on' === $button_custom ? ' et_pb_custom_button_icon' : ''
				);

				break;
			case 'aweber' :
				$firstname = esc_html__( 'Name', 'et_builder' );

				if ( ! in_array( $aweber_list, array( '', 'none' ) ) ) {
					$form = sprintf( '
						<div class="et_pb_newsletter_form" data-service="aweber">
							<div class="et_pb_newsletter_result"></div>
							<p>
								<label class="et_pb_contact_form_label" for="et_pb_signup_firstname" style="display: none;">%3$s</label>
								<input id="et_pb_signup_firstname" class="input" type="text" value="%4$s" name="et_pb_signup_firstname">
							</p>
							<p>
								<label class="et_pb_contact_form_label" for="et_pb_signup_email" style="display: none;">%5$s</label>
								<input id="et_pb_signup_email" class="input" type="text" value="%6$s" name="et_pb_signup_email">
							</p>
							<p><a class="et_pb_newsletter_button et_pb_button%8$s" href="#"%7$s><span class="et_subscribe_loader"></span><span class="et_pb_newsletter_button_text">%1$s</span></a></p>
							<input type="hidden" value="%2$s" name="et_pb_signup_list_id" />
						</div>',
						esc_html( $button_text ),
						( ! in_array( $aweber_list, array( '', 'none' ) ) ? esc_attr( $aweber_list ) : '' ),
						esc_html( $firstname ),
						esc_attr( $firstname ),
						esc_html( $email_address ),
						esc_attr( $email_address ),
						'' !== $custom_icon && 'on' === $button_custom ? sprintf(
							' data-icon="%1$s"',
							esc_attr( et_pb_process_font_icon( $custom_icon ) )
						) : '',
						'' !== $custom_icon && 'on' === $button_custom ? ' et_pb_custom_button_icon' : ''
					);
				}

				break;
		}

		$output = sprintf(
			'<div%6$s class="et_pb_newsletter et_pb_subscribe clearfix%4$s%7$s%8$s"%5$s>
				<div class="et_pb_newsletter_description">
					%1$s
					%2$s
				</div>
				%3$s
			</div>',
			( '' !== $title ? '<h2>' . esc_html( $title ) . '</h2>' : '' ),
			$this->shortcode_content,
			$form,
			esc_attr( $class ),
			( 'on' === $use_background_color
				? sprintf( ' style="background-color: %1$s;"', esc_attr( $background_color ) )
				: ''
			),
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' ),
			( 'on' !== $use_background_color ? ' et_pb_no_bg' : '' )
		);

		return $output;
	}
new ET_Builder_Module_Jaiminho_Signup;
