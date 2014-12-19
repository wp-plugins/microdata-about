<?php
/**
 * Plugin Name: Microdata About
 * Plugin URI: http://antsanchez.com/blog/wp-plugin-microdata
 * Description: Serves Microdata
 * Version: 1.1
 * Author: Antonio Sanchez
 * Author URI: http://antsanchez.com
 * Text Domain: microdata-about
 * Domain Path: microdata-about
 * License: GPL2 v2.0
 */

/* Plugin Domain */
load_plugin_textdomain('microdata-about', false, plugins_url('microdata-about') . '/languages' );

/* Array for the foreach loop, just to spare some code */
function microdata_array(){
	return array("Company", "Logo", "Name", "Nickname", "Title", "Role", "Affiliation", "Street", "Locality", "Region", "Postal-Code", "Country", "Email", "Phone", "Fax", "URL");
}

/* Creates an array with the structure for the update_option() function */
function microdata_array_structure(){
	return array("Company" => null,
			"Logo" => null,
			"Name" => null,
			"Nickname" => null,
			"Title" => null,
			"Role" => null,
			"Affiliation" => null,
			"Street" => null,
			"Locality" => null,
			"Region" => null,
			"Postal-Code" => null,
			"Country" => null,
			"Email" => null,
			"Phone" => null,
			"Fax" => null,
			"URL" => null);
}

/* About & Microformats */
add_action('admin_menu', 'microdata_menu');
function microdata_menu() {
	add_plugins_page( 'Microdata About', 'Microdata About', 'edit_theme_options', 'customize-bc-microdata', 'my_plugin_microdata' );
    wp_enqueue_style( 'estilo', plugins_url('microdata-about') .'/css/estilo.css');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload',  plugins_url('microdata-about') .'/js/my-javascript.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
	wp_enqueue_style('thickbox');
}

/* About Form */
function my_plugin_microdata(){

    if ( !current_user_can( 'manage_options' ) )  {

		wp_die( 'You do not have sufficient permissions to access this page.' );

    }else if(isset($_POST["enviar"])){
		
		$microdata_array_fields = microdata_array();
		$microdata_array_saved = microdata_array_structure();
		foreach($microdata_array_fields as $valor){
			if(!empty($_POST[$valor])){
				$microdata_array_saved[$valor] = $_POST[$valor];
				echo "Updated $valor : " . $microdata_array_saved[$valor] . "<br>";
			}
		}
		update_option("microdata_data_saved", $microdata_array_saved);

    }else{
		echo '<div class="wrap">';
		echo '<h2>' . __('Microdata About', 'microdata-about') . '</h2>';
		echo '<p>' .__('More info about the Microdata on: <a href="https://support.google.com/webmasters/answer/176035" target="_blank">About Microdata, Google</a>', 'microdata-about') . '</p>';
		echo '<form method="post" id="microdata">';
	
		$microdata_array_fields = microdata_array();
		$microdata_array_saved = get_option("microdata_data_saved");
		
		echo '<div id="col1">';
		$i = 0;
		foreach($microdata_array_fields as $valor){
			
			if($i == 7){
				echo '</div><div id="col2">';
			}
			
			if(isset($microdata_array_saved[$valor])){
				$value = "value='$microdata_array_saved[$valor]'";
			}else{
				$value = "";
			}

			if($valor == "URL"){
				$type = "type='url'";
			}else if($valor == "Email"){
				$type = "type='email'";
			}else{
				$type = "type='text'";
			}

			echo "<label for='$valor'>$valor</label>";
			echo "<input $type name='$valor' id='$valor' $value /><br>";

			if($valor == "Logo"){
				echo '<input id="Logo_button" type="button" value="Upload Image" /><br>';
			}

			$i++;

		}
		echo '</div>';

		echo '<div class="limpiartodo"><input type="submit" id="enviar" name="enviar" /></div>';
	    echo '</div>';		
    }
}

/* Serves Microdata */
function microdata_address($atts){
	
	wp_enqueue_style( 'estilo', plugins_url('microdata-about') .'/css/estilo.css');

	$microdata_array_saved = get_option("microdata_data_saved");

	$opcion = $atts['a'];

	if($opcion == "person"){
		$argumento = '<div itemscope itemtype="http://data-vocabulary.org/Person" class="mcdata">';
		$argumento = $argumento . '<div class="mcname"><div class="mcname-content">';
		if($microdata_array_saved["Name"]){
			$argumento = $argumento . '<span itemprop="name">' . $microdata_array_saved["Name"] . '</span>';
		}
		if($microdata_array_saved["Nickname"]){
			$argumento = $argumento . '&nbsp;<span itemprop="nickname">(' . $microdata_array_saved["Nickname"] . ')</span>';
		}
		$argumento = $argumento . '</div></div>'; /* END .mcname */
		if($microdata_array_saved["Logo"]){
			$argumento = $argumento . '<div class="mcphoto"><img src="' . $microdata_array_saved["Logo"] . '" itemprop="photo"></div>';
		}
		$argumento = $argumento . '<div class="mcperson">';
		if($microdata_array_saved["Title"]){
			$argumento = $argumento . '<span itemprop="title">' . $microdata_array_saved["Title"] . '</span><br>';
		}
		if($microdata_array_saved["Role"]){
			$argumento = $argumento . '<span itemprop="role">' . $microdata_array_saved["Role"] . '</span><br>';
		}
		if($microdata_array_saved["Affiliation"]){
			$argumento = $argumento . '<span itemprop="Affiliation">' . $affiliation . '</span>';
		}
		$argumento = $argumento . '</div>'; /* END .mcperson */
	}else{
		$argumento = '<div itemscope itemtype="http://schema.org/Organization" class="mcdata">';
		$argumento = $argumento . '<div class="mcname"><div class="mcname-content">';
		if($microdata_array_saved["Company"]){
			$argumento = $argumento . '<span itemprop="name">' . $microdata_array_saved["Company"] . '</span>';
		}
		$argumento = $argumento . '</div></div>'; /* 1: END .mcnamecontent; 2: END .mcname */
		if($microdata_array_saved["Logo"]){
			$argumento = $argumento . '<div class="mcphoto"><img src="' . $microdata_array_saved["Logo"] . '" itemprop="logo"></div>';
		}
	}
	
	$argumento = $argumento . '<div class="mcaddress">';
	if($microdata_array_saved["Street"] or $microdata_array_saved["Locality"] or $microdata_array_saved["Postal-Code"] or $microdata_array_saved["Region"]){
	    $argumento = $argumento . '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">';
	    if($microdata_array_saved["Street"]){
		$argumento = $argumento . '<span itemprop="streetAddress">' . $microdata_array_saved["Street"] . '</span><br>';
	    }
	    if($microdata_array_saved["Locality"]){
		$argumento = $argumento . '<span itemprop="addressLocality">' . $microdata_array_saved["Locality"] . '</span>&nbsp;';
	    }
	    if($microdata_array_saved["Region"]){
		$argumento = $argumento . '(<span itemprop="addressRegion">' . $microdata_array_saved["Region"] . '</span>)<br> ';
	    }
	    if($microdata_array_saved["Postal-Code"]){
		$argumento = $argumento . ' <span itemprop="postalCode">' . $microdata_array_saved["Postal-Code"] . '</span>&nbsp;';
	    }
	    if($microdata_array_saved["Country"]){
		$argumento = $argumento . '<span itemprop="addresCountry">' . $microdata_array_saved["Country"] . '</span><br>';
	    }
	    $argumento = $argumento . '</div>';
	}
	$argumento = $argumento . "</div>"; /* End .mcaddress */
	
	$argumento = $argumento . '<div class="mccontact">';
	if($microdata_array_saved["Phone"]){
	    $argumento = $argumento . '<div>Tel: <span itemprop="telephone">' . $microdata_array_saved["Phone"] . '</span></div>';
	}
	
	if($microdata_array_saved["Fax"]){
	    $argumento = $argumento . '<div>Fax: <span itemprop="fax">' . $microdata_array_saved["Fax"] . '</span></div>';
	}

	if($microdata_array_saved["URL"]){
	    $argumento = $argumento . '<div><a href="' . $microdata_array_saved["URL"] . '" itemprop="url">' . $microdata_array_saved["URL"] . '</a></div>';
	}

	if($microdata_array_saved["Email"]){
		$argumento = $argumento . '<div><a href="mailto:' . $microdata_array_saved["Email"] . '" itemprop="email">' . $microdata_array_saved["Email"] . '</a></div>';
	}
	
	$argumento = $argumento . "</div></div>"; /* 1: End Address; 2: End Person OR Organization */
	
	return $argumento;
}
add_shortcode( 'mcaddress', 'microdata_address' );

/* Add Widget */
class MDaddress extends WP_Widget {
    /** constructor */
    function MDaddress() {
        parent::WP_Widget(false, $name = 'Microdata About');	
    }

    /** @see WP_Widget::widget */
    function widget($args, $instance) {
		$person = isset( $instance['person'] ) ? $instance['person'] : false;
		if ( $person ){
			$ladireccion = microdata_address(array('a' => "person"));
		}else{
			$ladireccion = microdata_address(array('a' => "company"));
		}
		echo $ladireccion;
    }

    /** @see WP_Widget::update */
    function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['person'] = strip_tags($new_instance['person']);
		return $instance;
    }

    /** @see WP_Widget::form */
    function form($instance) {
		$person = isset( $instance['person'] ) ? (bool) $instance['person'] : false;
        echo "<p>" . __('Do not forget to fill up the formular in the Plugins Options', 'microdata-about') . "</p>";
		echo '<p><input class="checkbox" type="checkbox"';
		checked( $person );
		echo ' id="';
		echo $this->get_field_id( 'person' );
		echo '" name="';
		echo $this->get_field_name( 'person' );
		echo '" />';
		echo '<label for=">';
		echo $this->get_field_id( 'person' );
		echo '">';
		echo __( 'Show Person Microdata?' , 'microdata-about');
		echo '</label></p>';
    }

} // clase MDaddress
// registrar el widget MDaddress
add_action('widgets_init', create_function('', 'return register_widget("MDaddress");'))

?>