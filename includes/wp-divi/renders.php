<?php

if ( ! function_exists( 'et_builder_include_general_categories_option' ) ) :
function et_builder_include_general_categories_option( $args = array() ) {
	$defaults = apply_filters( 'et_builder_include_categories_defaults', array (
		'use_terms' => true,
		'term_name' => array('public_agent_state', 'category', 'public_agent_job', 'public_agent_party', 'public_agent_genre', 'public_agent_commission'),
	) );

	$args = wp_parse_args( $args, $defaults );

	$output = "\t" . "<% var et_pb_include_categories_temp = typeof et_pb_include_categories !== 'undefined' ? et_pb_include_categories.split( ',' ) : []; %>" . "\n";

	if ( $args['use_terms'] ) {
		$cats_array = get_terms( $args['term_name'] );
	} else {
		$cats_array = get_categories( apply_filters( 'et_builder_get_categories_args', 'hide_empty=0' ) );
	}

	if ( empty( $cats_array ) ) {
		$output = '<p>' . esc_html__( "You currently don't have any public agent assigned to a category.", 'et_builder' ) . '</p>';
	}

	foreach ( $cats_array as $category ) {
		$contains = sprintf(
			'<%%= _.contains( et_pb_include_categories_temp, "%1$s" ) ? checked="checked" : "" %%>',
			esc_html( $category->term_id )
		);
  if ( $category->taxonomy == 'public_agent_commission' ) {
    //separados pois não deve ser impresso apenas comissão sem suplente e titular
    if ( $category->name == 'titular' || $category->name == 'suplente' ) {
      $output .= sprintf(
        '%4$s<label><input type="checkbox" name="et_pb_include_categories" value="%1$s"%3$s> %2$s</label><br/>',
        esc_attr( $category->term_id ),
        esc_html( get_category_parents( $category->term_id, false, ' &raquo; ' ) ),
        $contains,
        "\n\t\t\t\t\t"
      );
    }
  }else{
    $output .= sprintf(
      '%4$s<label><input type="checkbox" name="et_pb_include_categories" value="%1$s"%3$s> %2$s</label><br/>',
      esc_attr( $category->term_id ),
      esc_html( $category->name ),
      $contains,
      "\n\t\t\t\t\t"
    );
  }
		
	}

	$output = '<div id="et_pb_include_categories">' . $output . '</div>';

	return apply_filters( 'et_builder_include_categories_option_html', $output );
}
endif;

if ( ! function_exists( 'et_divi_get_public_agent' ) ) :
function et_divi_get_public_agent( $args = array() ) {
	$default_args = array(
		'post_type' => 'public_agent',
	);
	$args = wp_parse_args( $args, $default_args );
	return new WP_Query( $args );
}
endif;

add_action( 'wp_enqueue_scripts', 'wp_divi_jaiminho_script' );

function wp_divi_jaiminho_script() {
  wp_register_style( 'divi-jaiminho',  plugin_dir_url( __FILE__ ).'ET_Builder_Module_Make_Pressure/frontend/css/ET_Builder_Module_Make_Pressure.css' );
  wp_enqueue_style( 'divi-jaiminho' );
}

