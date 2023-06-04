<?php 

// Exit if accessed directly.
if ( !defined( 'ABSPATH' ) ) {
	exit; 
}

/**
 * WPBSvgIcon
 *
 * @package wpb-svg-icon
 */

if ( !class_exists( 'WPBSvgIcon' ) ) {

	class WPBSvgIcon extends WPBakeryShortCode {

		function __construct() {
			// add_action( 'init', array( $this, 'create_shortcode' ), 999 );
			add_action( 'vc_before_init', array( $this, 'create_shortcode' ) );
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_shortcode( 'wpb_svg_icon', array( $this, 'render_shortcode' ) );
		}

		public function create_shortcode() {
			// stop all if WPB not enable
	        if ( !defined( 'WPB_VC_VERSION' ) ) {
	            return;
	        }

	        vc_map( array(
	        	'name' => esc_html__( 'SVG Icon', 'wpb-svg-icon' ),
	        	'base' => 'wpb_svg_icon',
	        	'icon' => plugins_url( 'assets/images/plugin-icon.svg', dirname(__FILE__) ), // Simply pass url to your icon here
	        	'description' => esc_html__( 'Use svg icon inline directly!', 'wpb-svg-icon' ),
	        	'category' => esc_html__( 'Content', 'wpb-svg-icon' ),
	        	'params' => array(
	        		array(
	        			'type' 			=> 'textfield',
	        			'heading' 		=> esc_html__( 'Label', 'wpb-svg-icon' ),
	        			'param_name' 	=> 'label',
	        			'value' 		=> '',
	        			'description' 	=> esc_html__( 'add a useful information for screen reader', 'wpb-svg-icon' ),
	        			'admin_label'	=> true,
	        		),

	        		array(
	        			'type' 			=> 'dropdown',
	        			'heading' 		=> esc_html__( 'Variant', 'wpb-svg-icon' ),
	        			'param_name' 	=> 'variant',
	        			'value' 		=> array(
	        				'Simple' => 'simple',
	        				'Filled' => 'filled'
	        			)
	        		),

	                array(
	                    'type'			=> 'colorpicker',
	                    'heading'		=> esc_html__( 'Icon Color', 'wpb-svg-icon' ),
	                    'param_name'	=> 'icon_color',
	                    'value'			=> '#000000',
	                ),

	                array(
	                    'type'			=> 'colorpicker',
	                    'heading'		=> esc_html__( 'Icon Background', 'wpb-svg-icon' ),
	                    'param_name'	=> 'icon_background',
	                    'value'			=> '#ffffff',
	                    'dependency' 	=> array(
	                        'element' => 'variant',
	                        'value' => array( 'filled' )
	                    ),
	                ),

	                array(
	                    'type'			=> 'dropdown',
	                    'heading'		=> esc_html__( 'Icon border radius', 'wpb-svg-icon' ),
	                    'param_name'	=> 'icon_radius',
	                    'value' 		=> array(
	        				'Rounded' => 'rounded',
	        				'Square' => 'square',
	        				'Square Rounded' => 'square_rounded'
	        			),
	                    'dependency' 	=> array(
	                        'element' => 'variant',
	                        'value' => array( 'filled' ),
	                        'not_empty'	=> false
	                    ),
	                ),

	                array(
	                    'type' 			=> 'vc_link',
	                    'param_name' 	=> 'icon_link',
	                    'heading' 		=> esc_html__( 'Icon Link', 'wpb-svg-icon' ),
	                ),

	                array(
	                    'type'			=> 'textfield',
	                    'heading'		=> esc_html__( 'Icon Size', 'wpb-svg-icon' ),
	                    'param_name'	=> 'icon_size',
	                    'value'			=> '',
	                    'description'	=> sprintf( esc_html__( 'set the icon size including %sCSS unit length%s. E.g: 16px, 1rem, etc', 'wpb-svg-icon' ), '<a href="https://developer.mozilla.org/en-US/docs/Web/CSS/length" target="_blank">', '</a>' ),
	                ),

	        		// array(
	        		// 	'type' 			=> 'dropdown',
	        		// 	'heading' 		=> esc_html__( 'Icon Source', 'wpb-svg-icon' ),
	        		// 	'param_name' 	=> 'icon_source',
	        		// 	'value' 		=> array(
	        		// 		'Media' => 'media',
	        		// 		'Custom Code' => 'code'
	        		// 	),
	        		// 	'group'         => esc_html__('Source', 'wpb-svg-icon' )
	        		// ),

	        		array(
	        			'type'			=> 'textarea_raw_html',
	        			'heading'		=> esc_html__( 'Svg Code', 'wpb-svg-icon' ),
	        			'param_name'	=> 'icon_code',
	        			'value'			=> '',
	        			'group'         => esc_html__( 'Source', 'wpb-svg-icon' ),
	        			// 'dependency' 	=> array(
	                    //     'element' => 'icon_source',
	                    //     'value' => array( 'code' ),
	                    // ),
	        		),

	        		array(
	                    'type' 			=> 'textfield',
	                    'param_name' 	=> 'custom_class',
	                    'heading' 		=> esc_html__( 'Extra class name', 'wpb-svg-icon' ),
	                    'description' 	=> esc_html__( 'add a class name and refer to it in custom CSS', 'wpb-svg-icon' ),
	                ),
	        	)
	        ) );
		}

		public function render_shortcode( $atts, $content, $tag ) {
			$args = array(
	            'label'				=> 'icon',
	            'variant'			=> 'simple',
	            'icon_color'		=> '#000000',
	            'icon_background'	=> '#ffffff',
	            'icon_radius'		=> 'rounded',
	            'icon_size'			=> '16px',
	            'icon_link'			=> '',
	            // 'icon_source'	=> 'code',
	            'icon_code'			=> '',
	            'custom_class'		=> ''
	        );

	        $atts = ( shortcode_atts( $args, $atts ) );

	        $label = $atts[ 'label' ];
	        $variant = $atts[ 'variant' ];
	        $icon_color = $atts[ 'icon_color' ];
	        $icon_background = $atts[ 'icon_background' ];
	        $icon_radius = $atts[ 'icon_radius' ];
	        $icon_size = $atts[ 'icon_size' ];
	        $icon_code = $atts[ 'icon_code' ];
	        $custom_class = $atts[ 'custom_class' ];

	        $icon_code = rawurldecode( base64_decode( wp_strip_all_tags( $icon_code ) ) );
			$icon_code = wpb_js_remove_wpautop( apply_filters( 'vc_raw_html_module_content', $icon_code ) );

			$icon_link = vc_build_link( $atts[ 'icon_link' ] );
			$icon_link_url = esc_url( $icon_link[ 'url' ] );
			$icon_link_target = $icon_link[ 'target' ];
			$icon_link_rel = $icon_link[ 'rel' ];

			// icon class state
			$icon_classes = array();
			$icon_classes[] = 'wpb-svgi';
			if ( $variant == 'filled' ) {
				$icon_classes[] = 'wpb-svgi--filled';

				if ( $icon_radius == 'rounded' ) {
					$icon_classes[] = 'wpb-svgi--rounded';
				}
				if ( $icon_radius == 'square_rounded' ) {
					$icon_classes[] = 'wpb-svgi--square-rounded';
				}
			}
			if ( !empty( $custom_class ) ) {
				$icon_classes[] = esc_attr( $custom_class );
			}

			// icon css variables
			$icon_styles = array();
			$icon_styles[] = '--icon-size:'. esc_attr( $icon_size ) .';';
			$icon_styles[] = '--icon-color:'. esc_attr( $icon_color ) .';';
			if ( $variant == 'filled' ) {
				$icon_styles[] = '--icon-bg-color:'. esc_attr( $icon_background ) .';';
			}

			$icon_wrapper_tag = !empty( $icon_link_url ) ? 'a' : 'span';
			$icon_attrs = array();
			$icon_attrs[] = 'class="'. implode( ' ', $icon_classes) .'"';
			$icon_attrs[] = 'aria-label="'. $label .'"';
			if ( !empty( $icon_link_url ) ) {
				$icon_attrs[] = 'href="'. $icon_link_url .'"';

				if ( !empty( $icon_link_target ) ) {
					$icon_attrs[] = 'target="'. $icon_link_target .'"';
				}

				if ( !empty( $icon_link_rel ) ) {
					$icon_attrs[] = 'rel="'. $icon_link_rel .'"';
				}
			}
			$icon_attrs[] = 'style="'. implode( ' ', $icon_styles) .'"';

	        $output = '';
	        $output .= '<'. $icon_wrapper_tag .' '. implode( '', $icon_attrs ) .'>' . $icon_code . '</'. $icon_wrapper_tag .'>';

	        return $output;
		}

		public function enqueue_scripts() {
	        global $post;

	        if ( has_shortcode( $post->post_content, 'wpb_svg_icon' ) ) {
	            wp_enqueue_style( 'wpb-svgi-front-style', plugins_url('assets/css/wpb-svg-icon.min.css', dirname(__FILE__)), array(), WPB_SVGI_VERSION );
	        }
	    }

	}

	new WPBSvgIcon();

}
