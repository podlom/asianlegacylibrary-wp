<?php 
/**
 * Shortcodes
 *
 * @package all_wp_theme
 */

// REMOVE EMPTY P TAG IN SHORTCODES
function shortcode_empty_paragraph_fix( $content ) {
    $array = array(
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']'
    );
    return strtr( $content, $array );
}
add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );


// BUTTON
function button_shortcode( $atts, $content = null ) {
	$btn = shortcode_atts( array(
		'class' => 'green'
	), $atts );
    $output = '<span class="button-outer btn-color-outer-' . esc_attr( $btn['class'] ) . '">' . $content . '</span>';
	return $output;
}
add_shortcode('button', 'button_shortcode');


// SUBPAGES
function subpagesSection() {
	ob_start();
	get_template_part( 'partials/section','subpages' );
	$output .= ob_get_clean();
return $output;
}
add_shortcode('subpages', 'subpagesSection');


/* PEOPLE - OLD
function peopleSection() {
	ob_start();
	get_template_part( 'partials/section','people' );
	$output .= ob_get_clean();
return $output;
}
add_shortcode('people', 'peopleSection');*/

// PEOPLE - categories
function peopleItems( $atts ) {
	extract( shortcode_atts( array (
		 'type' => ''
	), $atts ) );

	$people_query= null;
	$args = array(
		'post_type'      => 'people',
		'post_status'    => 'publish',
		'orderby'        => 'date',
		'order'          => 'DESC',
		'tax_query' => array(
			array(
				'taxonomy' => 'peoplecats',
				'terms' => $type,
				'field' => 'slug',
				'operator' => 'IN'
			)
		),
	);

	$people_query = new WP_Query( $args );
	$output = '';
	if ( $people_query->have_posts() ) {
		 $output .= '<div class="people-outer ' . $type . '">';
			  $output .= '<div class="people-grid">';
		 while ( $people_query->have_posts() ) : $people_query->the_post();
			  ob_start();
			  get_template_part( 'partials/item-people' );
			  $output .= ob_get_clean();
		 endwhile;
		$output .= '</div>';
		$output .= '</div>';
		if (has_term('headquarters', 'peoplecats')) {
		ob_start();
		get_template_part( 'partials/people-popups' );
		$output .= ob_get_clean();
		}
	}
	return $output;
}
add_shortcode('people', 'peopleItems');


// PARTNERS
function partnersSection() {
	ob_start();
	get_template_part( 'partials/section','partners' );
	$output .= ob_get_clean();
return $output;
}
add_shortcode('partners', 'partnersSection');


// STORIES
function storiesSection() {
	ob_start();
	get_template_part( 'partials/section','stories' );
	$output .= ob_get_clean();
return $output;
}
add_shortcode('stories', 'storiesSection');