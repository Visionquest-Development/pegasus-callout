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

	function callout_check_main_theme_name() {
		$current_theme_slug = get_option('stylesheet'); // Slug of the current theme (child theme if used)
		$parent_theme_slug = get_option('template');    // Slug of the parent theme (if a child theme is used)

		//error_log( "current theme slug: " . $current_theme_slug );
		//error_log( "parent theme slug: " . $parent_theme_slug );

		if ( $current_theme_slug == 'pegasus' ) {
			return 'Pegasus';
		} elseif ( $current_theme_slug == 'pegasus-child' ) {
			return 'Pegasus Child';
		} else {
			return 'Not Pegasus';
		}
	}

	function pegasus_callout_menu_item() {
		if ( callout_check_main_theme_name() == 'Pegasus' || callout_check_main_theme_name() == 'Pegasus Child' ) {
			//do nothing
		} else {
			//echo 'This is NOT the Pegasus theme';
			add_menu_page(
				"Callout", // Page title
				"Callout", // Menu title
				"manage_options", // Capability
				"pegasus_callout_plugin_options", // Menu slug
				"pegasus_callout_plugin_settings_page", // Callback function
				null, // Icon
				81 // Position in menu
			);
		}
	}
	add_action("admin_menu", "pegasus_callout_menu_item");

	function pegasus_callout_admin_table_css() {
		if ( callout_check_main_theme_name() == 'Pegasus' || callout_check_main_theme_name() == 'Pegasus Child' ) {
			//do nothing
		} else {
			//wp_register_style('callout-admin-table-css', trailingslashit(plugin_dir_url(__FILE__)) . 'css/pegasus-callout-admin-table.css', array(), null, 'all');
			ob_start();
			?>
				pre {
					background-color: #f9f9f9;
					border: 1px solid #aaa;
					page-break-inside: avoid;
					font-family: monospace;
					font-size: 15px;
					line-height: 1.6;
					margin-bottom: 1.6em;
					max-width: 100%;
					overflow: auto;
					padding: 1em 1.5em;
					display: block;
					word-wrap: break-word;
				}
				input[type="text"].code {
					width: 100%;
				}
				table.pegasus-table {
					width: 100%;
					border-collapse: collapse;
					border-color: #777 !important;
				}
				table.pegasus-table th {
					background-color: #f1f1f1;
					text-align: left;
				}
				table.pegasus-table th,
				table.pegasus-table td {
					border: 1px solid #ddd;
					padding: 8px;
				}
				table.pegasus-table tr:nth-child(even) {
					background-color: #f2f2f2;
				}
				table.pegasus-table thead tr { background-color: #282828; }
				table.pegasus-table thead tr td { padding: 10px; }
				table.pegasus-table thead tr td strong { color: white; }
				table.pegasus-table tbody tr:nth-child(0) { background-color: #cccccc; }
				table.pegasus-table tbody tr td { padding: 10px; }
				table.pegasus-table code { color: #d63384; }

			<?php
			// Get the buffered content
			$inline_css = ob_get_clean();

			wp_register_style('callout-admin-table-css', false);
			wp_enqueue_style('callout-admin-table-css');

			wp_add_inline_style('callout-admin-table-css', $inline_css);
		}
	}

	add_action('admin_enqueue_scripts', 'pegasus_callout_admin_table_css');

	function pegasus_callout_plugin_settings_page() { ?>

		<div class="wrap pegasus-wrap">
			<h1>Callout Usage</h1>
<!--
			<p>Callout Usage 1: <pre>[callout button="yes" link="http://example.com" external="yes" color="white" link_text="Learn More" background="http://www.wpfreeware.com/themes/html/appstation/img/download_bg.png"] <?php echo htmlspecialchars('<p>Get your copy now!Suspendisse vitae bibendum mauris. Nunc iaculis nisl vitae laoreet elementum donec dignissim metus sit.</p'); ?>[/callout]</pre></p>
			<p>Callout Usage 2: <pre>[callout button="yes" link="http://example.com" color="black" external="yes" backgroundcolor="#dedede"] <?php //echo htmlspecialchars('<h2>Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Donec sollicitudin molestie malesuada. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Donec sollicitudin molestie malesuada. Nulla porttitor accumsan tincidunt. Nulla porttitor accumsan tincidunt. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.</h2>'); ?>[/callout]</pre></p>
	-->
			<div>
				<h3>Callout Usage 1:</h3>
				<pre >[callout button="yes" link="http://example.com" external="yes" color="white" link_text="Learn More" background="http://www.wpfreeware.com/themes/html/appstation/img/download_bg.png"] <?php echo htmlspecialchars('<p>Get your copy now! Suspendisse vitae bibendum mauris. Nunc iaculis nisl vitae laoreet elementum donec dignissim metus sit.</p>'); ?>[/callout]</pre>

				<input
					type="text"
					readonly
					value="<?php echo esc_html('[callout button="yes" link="http://example.com" external="yes" color="white" link_text="Learn More" background="http://www.wpfreeware.com/themes/html/appstation/img/download_bg.png"]<p>Get your copy now! Suspendisse vitae bibendum mauris. Nunc iaculis nisl vitae laoreet elementum donec dignissim metus sit.</p>[/callout]'); ?>"
					class="regular-text code"
					id="my-shortcode"
					onClick="this.select();"
				>
			</div>

			<div>
				<h3>Callout Usage 2:</h3>

				<pre >[callout button="yes" link="http://example.com" color="black" external="yes" backgroundcolor="#dedede"] <?php echo htmlspecialchars('<h2>Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Donec sollicitudin molestie malesuada. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Donec sollicitudin molestie malesuada. Nulla porttitor accumsan tincidunt. Nulla porttitor accumsan tincidunt. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.</h2>'); ?>[/callout]</pre>

				<input
					type="text"
					readonly
					value="<?php echo esc_html('[callout button="yes" link="http://example.com" color="black" external="yes" backgroundcolor="#dedede"]<h2>Vivamus magna justo, lacinia eget consectetur sed, convallis at tellus. Donec sollicitudin molestie malesuada. Curabitur arcu erat, accumsan id imperdiet et, porttitor at sem. Donec sollicitudin molestie malesuada. Nulla porttitor accumsan tincidunt. Nulla porttitor accumsan tincidunt. Praesent sapien massa, convallis a pellentesque nec, egestas non nisi.</h2>[/callout]'); ?>"
					class="regular-text code"
					id="my-shortcode"
					onClick="this.select();"
				>
			</div>

			<p style="color:red;">MAKE SURE YOU DO NOT HAVE ANY RETURNS OR <?php echo htmlspecialchars('<br>'); ?>'s IN YOUR SHORTCODES, OTHERWISE IT WILL NOT WORK CORRECTLY</p>

			<div>
				<?php echo pegasus_callout_settings_table(); ?>
			</div>
		</div>
	<?php
	}

	function pegasus_callout_settings_table() {

		//$data = json_decode('', true);
		$data = json_decode( file_get_contents( plugin_dir_path( __FILE__ ) . 'settings.json' ), true );
		// echo '<pre>';
		// var_dump( plugin_dir_path( __FILE__ ) . 'settings.json' );
		// echo '</pre>';
		// echo '<pre>';
		// var_dump( file_get_contents( plugin_dir_path( __FILE__ ) . 'settings.json' ) );
		// echo '</pre>';
		// echo '<pre>';
		// var_dump($data);
		// echo '</pre>';

		if (json_last_error() !== JSON_ERROR_NONE) {
			return '<p style="color: red;">Error: Invalid JSON provided.</p>';
		}

		// Start building the HTML
		$html = '<table border="0" cellpadding="1" class="table pegasus-table" align="left">
		<thead>
		<tr style="background-color: #282828;">
		<td <span><strong>Name</strong></span></td>
		<td <span><strong>Attribute</strong></span></td>
		<td <span><strong>Options</strong></span></td>
		<td <span><strong>Description</strong></span></td>
		<td <span><strong>Example</strong></span></td>
		</tr>
		</thead>
		<tbody>';

		// Iterate over the data to populate rows
		if (!empty($data['rows'])) {
			foreach ($data['rows'] as $section) {
				// Add section header
				$html .= '<tr >';
				$html .= '<td colspan="5">';
				$html .= '<span>';
				$html .= '<strong>' . htmlspecialchars($section['section_name']) . '</strong>';
				$html .= '</span>';
				$html .= '</td>';
				$html .= '</tr>';

				// Add rows in the section
				foreach ($section['rows'] as $row) {
					$html .= '<tr>
						<td >' . htmlspecialchars($row['name']) . '</td>
						<td >' . htmlspecialchars($row['attribute']) . '</td>
						<td >' . nl2br(htmlspecialchars($row['options'])) . '</td>
						<td >' . nl2br(htmlspecialchars($row['description'])) . '</td>
						<td ><code>' . htmlspecialchars($row['example']) . '</code></td>
					</tr>';
				}
			}
		}

		$html .= '</tbody></table>';

		// Return the generated HTML
		return $html;
	}

	function pegasus_callout_plugin_styles() {

		wp_register_style( 'callout-plugin-css', trailingslashit( plugin_dir_url( __FILE__ ) ) . 'css/callout.css', array(), null, 'all' );

	}
	add_action( 'wp_enqueue_scripts', 'pegasus_callout_plugin_styles' );


	/*~~~~~~~~~~~~~~~~~~~~
		CALLOUT
	~~~~~~~~~~~~~~~~~~~~~*/

	// [callout url="img-src"] text [/callout]
	function pegasus_callout_func( $atts, $content = null ) {
		$a = shortcode_atts( array(
			'background' => '',
			'backgroundcolor' => '',
			'button' => '',
			'color' => '',
			'external' => '',
			'link' => '#',
			'link_text' => '',
		), $atts );

		$output = '';
		$background = "{$a['background']}";
		$bkg_color = "{$a['backgroundcolor']}";
		$button =  "{$a['button']}";
		$color = "{$a['color']}";
		$external =  "{$a['external']}";
		$link = "{$a['link']}";
		$link_text = "{$a['link_text']}";

		if($background) {
			$output .= "<div class='callout_container' style='color: {$a['color']}; background: url({$background});'>";
		}
		if($bkg_color) {
			$output .= "<div class='callout_container' style='color: {$a['color']}; background: {$bkg_color};'>";
		}

        $output .= "<div class=''>
                <div class=''>
                  <div class='callout'>";

                    $output .= $content;
					//$output .= '<a href ="http://example.com" class="                    btn btn-default"> Link Text </a>';

					if($button === 'yes') {
						$output .= '<a href ="' . $link . '" class="btn btn-default" ';
						if($external === 'yes') {
							$output .= ' target="_blank" ';
						}
						$output .= '>';

						if($link_text) {
							$output .= $link_text;
						}else{
							$output .= 'Read More';
						}
						$output .= '</a>';
					}

                $output .= '</div>
                </div>
              </div>
            </div>';

		wp_enqueue_style( 'callout-plugin-css' );

		return $output;
	}
	add_shortcode( 'callout', 'pegasus_callout_func' );

