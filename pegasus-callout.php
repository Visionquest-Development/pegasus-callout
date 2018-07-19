<?php
/*
Plugin Name: Pegasus Callout Plugin
Plugin URI:  https://developer.wordpress.org/plugins/the-basics/
Description: This allows you to create carousels on your website with just a shortcode.
Version:     1.0
Author:      Jim O'Brien
Author URI:  https://visionquestdevelopment.com/
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wporg
Domain Path: /languages
*/
	
	function pegasus_callout_menu_item() {
		add_menu_page("Callout", "Callout", "manage_options", "pegasus_callout_plugin_options", "pegasus_callout_plugin_settings_page", null, 99);
		
	}
	add_action("admin_menu", "pegasus_callout_menu_item");

	function pegasus_callout_plugin_settings_page() { ?>
	    <div class="wrap pegasus-wrap">
	    <h1>Callout Usage</h1>
		
		<p>Callout Usage 1: <pre>[callout button="yes" link="http://example.com" external="yes" color="white" link_text="Learn More" background="http://www.wpfreeware.com/themes/html/appstation/img/download_bg.png"] <?php echo htmlspecialchars('<p>Get your copy now!Suspendisse vitae bibendum mauris. Nunc iaculis nisl vitae laoreet elementum donec dignissim metus sit.</p'); ?>[/callout]</pre></p>
		<p>Callout Usage 2: <pre>[callout button="yes" link="http://example.com" color="black" external="yes" backgroundcolor="#dedede"] <?php echo htmlspecialchars('<h2>Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Donec sollicitudin molestie malesuada. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Donec sollicitudin molestie malesuada. Nulla porttitor accumsan tincidunt. Nulla porttitor accumsan tincidunt. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.</h2>'); ?>[/callout]</pre></p>
			
		<p style="color:red;">MAKE SURE YOU DO NOT HAVE ANY RETURNS OR <?php echo htmlspecialchars('<br>'); ?>'s IN YOUR SHORTCODES, OTHERWISE IT WILL NOT WORK CORRECTLY</p>
		
		
		</div>
	<?php
	}
	
	function pegasus_callout_plugin_styles() {
		
		wp_enqueue_style( 'callout-plugin-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/callout.css', array(), null, 'all' );
		//wp_enqueue_style( 'slippery-slider-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/slippery-slider.css', array(), null, 'all' );
		
	}
	add_action( 'wp_enqueue_scripts', 'pegasus_callout_plugin_styles' );
	
	/**
	* Proper way to enqueue JS 
	*/
	function pegasus_callout_plugin_js() {
		
		wp_enqueue_script( 'slippery-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/slippery.js', array( 'jquery' ), null, true );
		wp_enqueue_script( 'pegasus-callout-plugin-js', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'js/plugin.js', array( 'jquery' ), null, true );
		
	} //end function
	add_action( 'wp_enqueue_scripts', 'pegasus_callout_plugin_js' ); 

	
	/*~~~~~~~~~~~~~~~~~~~~
		CALLOUT
	~~~~~~~~~~~~~~~~~~~~~*/
	
	// [callout url="img-src"] text [/callout]
	function pegasus_callout_func( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'link' => '#',
			'link_text' => '',
			'button' => '',
			'external' => '',
			'color' => '',
			'background' => '',
			'backgroundcolor' => '',
		), $atts );
	
		$output = '';
		$color = "{$a['color']}";
		$background = "{$a['background']}";
		$bkg_color = "{$a['backgroundcolor']}";
		if($background) { $output .= "<div class='callout_container' style='color: {$a['color']}; background: url({$a['background']});'>"; }
		if($bkg_color) { $output .= "<div class='callout_container' style='color: {$a['color']}; background: {$a['backgroundcolor']};'>"; }
		
        $output .= "<div class=''>
                <div class=''>
                  <div class='callout'>";
                    
                    $output .= $content;
					//$output .= '<a href ="http://example.com" class="btn btn-default"> Link Text </a>';
					$button =  "{$a['button']}";
					$external =  "{$a['external']}";
					if($button === 'yes') { 
						$output .= '<a href ="http://example.com" class="btn btn-default" ';
						if($external === 'yes') { $output .= ' target="_blank" '; }
						$output .= '>';
						$link_text = "{$a['link_text']}";
						if($link_text) { $output .= $link_text; }else{ $output .= 'Read More'; }
						$output .= '</a>'; 
					}
					
                $output .= '</div>
                </div>
              </div>
            </div>';
		
		
		return $output; 
	}
	add_shortcode( 'callout', 'pegasus_callout_func' );
	
