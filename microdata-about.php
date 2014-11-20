<?php
/**
 * Plugin Name: Microdata About
 * Plugin URI: http://antsanchez.com/blog/wp-plugin-microdata
 * Description: Serves Microdata
 * Version: 1.0.1
 * Author: Antonio Sanchez
 * Author URI: http://antsanchez.com
 * Text Domain: microdata-about
 * Domain Path: microdata-about
 * License: A short license name. Example: GPL2
 */

/* Plugin Domain */
load_plugin_textdomain('microdata-about', false, plugins_url('microdata-about') . '/languages' );

/* About & Microformats */
add_action('admin_menu', 'microdata_menu');
function microdata_menu() {
	add_plugins_page( 'Microdata About', 'Microdata About', 'edit_theme_options', 'customize-bc-microdata', 'my_plugin_microdata' );
    wp_enqueue_style( 'estilo', plugins_url('microdata-about') .'/css/estilo.css');
	wp_enqueue_script('media-upload');
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
	echo __('Updated:', 'Blackcolors') . '<br>';
	if($company = $_POST["namecompany"]){
	    update_option("mccompany", $company);
	    echo "<br>" . __('Name (Company): ', 'microdata-about') . $company;
	}
	if($logo = $_POST["upload_image"]){
	    update_option("mclogo", $logo);
	    echo "<br>" . __('Logo (URL): ', 'microdata-about') . $logo;
	}
	if($nombre = $_POST["name"]){
	    update_option("mcname", $nombre);
	    echo "<br>" . __('Name (Person): ', 'microdata-about') . $nombre;
	}
	if($nickname = $_POST["nickname"]){
	    update_option("mcnickname", $nickname);
	    echo "<br>" . __('Nickname: ', 'microdata-about') . $nickname;
	}
	if($title = $_POST["title"]){
	    update_option("mctitle", $title);
	    echo "<br>" . __('Title (Person): ', 'microdata-about') . $title;
	}
	if($role = $_POST["role"]){
	    update_option("mcrole", $role);
	    echo "<br>" . __('Role (Person): ', 'microdata-about') . $role;
	}
	if($affiliation = $_POST["affiliation"]){
	    update_option("mcaffiliation", $affiliation);
	    echo "<br>" . __('Affiliation (Person): ', 'microdata-about') . $affiliation;
	}
	if($street = $_POST["street"]){
	    update_option("mcstreet", $street);
	    echo "<br>" . __('Street: ', 'microdata-about') . $street;
	}
	if($locality = $_POST["locality"]){
	    update_option("mclocality", $locality);
	    echo "<br>" . __('Locality: ', 'microdata-about') . $locality;
	}
	if($region = $_POST["region"]){
	    update_option("mcregion", $region);
	    echo "<br>" . __('Region: ', 'microdata-about') . $region;
	}
	if($postalcode = $_POST["postal-code"]){
	    update_option("mcpostalcode", $postalcode);
	    echo "<br>" . __('Postal Code: ', 'microdata-about') . $postalcode;
	}
	if($country = $_POST["country-name"]){
	    update_option("mccountry", $country);
	    echo "<br>" . __('Country Name: ', 'microdata-about') . $country;
	}
	if($phone = $_POST["phone"]){
	    update_option("mcphone", $phone);
	    echo "<br>" . __('Phone: ', 'microdata-about') . $phone;
	}
	if($url = $_POST["url"]){
	    update_option("mcurl", $url);
	    echo "<br>" . __('WEB URL: ', 'microdata-about') . $url;
	}
	if($fax = $_POST["fax"]){
	    update_option("mcfax", $url);
	    echo "<br>" . __('FAX: ', 'microdata-about') . $fax;
	}
	if($email = $_POST["email"]){
	    update_option("mcemail", $email);
	    echo "<br>" . __('Email: ', 'microdata-about') . $email;
	}
    }else{
		$name = get_option("mcname");
		$logo = get_option("mclogo");
		$nickname = get_option("mcnickname");
		$title = get_option("mctitle");
		$role = get_option("mcrole");
		$affiliation = get_option("mcaffiliation");
		$photo = get_option("mcphoto");
		$company = get_option("mccompany");
		$street = get_option("mcstreet");
		$locality = get_option("mclocality");
		$region = get_option("mcregion");
		$postalcode = get_option("mcpostalcode");
		$country = get_option("mccountry");
		$phone = get_option("mcphone");
		$url = get_option("mcurl");
		$fax = get_option("fax");
		$email = get_option("email");

	echo '<h2>' . __('Microdata About', 'microdata-about') . '</h2>';
	echo '<p>' .__('More info about the Microdata on: <a href="https://support.google.com/webmasters/answer/176035" target="_blank">About Microdata, Google</a>', 'microdata-about') . '</p>';
	echo '<form method="post" id="microdata">
	<div id="col1"><h3>' . __('For Companies:', 'microdata-about') . '</h3>
	    <label for="namecompany">' . __('Name (Company): ', 'microdata-about') . '</label><br>
	    <input type="text" name="namecompany" maxlenght="60" id="namecompany" autocomplete="namecompany" value="' . $company . '" /><br>
		<h3>' . __('For Persons:', 'microdata-about') . '</h3>
		<label for="name">' . __('Name (Person): ', 'microdata-about') . '</label><br>
	    <input type="text" name="name" maxlenght="60" id="name" autocomplete="name" value="' . $name . '" /><br>
		<label for="nickname">' . __('Nickame: ', 'microdata-about') . '</label><br>
	    <input type="text" name="nickname" maxlenght="60" id="nickname" autocomplete="nickname" value="' . $nickname . '" /><br>
		<label for="title">' . __('Title: ', 'microdata-about') . '</label><br>
	    <input type="text" name="title" maxlenght="60" id="title" autocomplete="title" value="' . $title . '" /><br>
		<label for="role">' . __('Role: ', 'microdata-about') . '</label><br>
	    <input type="text" name="role" maxlenght="60" id="role" autocomplete="role" value="' . $role . '" /><br>
		<label for="affiliation">' . __('Affiliation: ', 'microdata-about') . '</label><br>
	    <input type="text" name="affiliation" maxlenght="60" id="affiliation" autocomplete="affiliation" value="' . $affiliation . '" /><br>
		<h3>' . __('Logo or Profile Image:', 'microdata-about') . '</h3>
		<label for="upload_image">' . __('Image URL: *Recomended: 300x300 px', 'microdata-about') . '</label><br>
	    <input id="upload_image" type="text" size="36" name="upload_image" id="upload_image" /><br>
		<input id="upload_image_button" type="button" value="Upload Image" />
		</div><div id="col2"><h3>' . __('Address:', 'microdata-about') . '</h3>
		<label for="street">' . __('Street: ', 'microdata-about') . '</label><br>
	    <input type="text" name="street" maxlenght="60" id="street" autocomplete="street" value="' . $street . '" /><br>
	    <label for="locality">' . __('Locality: ', 'microdata-about') . '</label><br>
	    <input type="text" name="locality" maxlenght="60" id="locality" autocomplete="locality" value="' . $locality . '" /><br>
	    <label for="region">' . __('Region: ', 'microdata-about') . '</label><br>
	    <input type="text" name="region" maxlenght="60" id="region" autocomplete="region" value="' . $region . '"/><br>
	    <label for="postal-code">' . __('Postal Code: ', 'microdata-about') . '</label><br>
	    <input type="text" name="postal-code" maxlenght="12" id="postal-code" autocomplete="postal-code" value="' . $postalcode . '" /><br>
	    <label for="country-name">' . __('Country Name: ', 'microdata-about') . '</label><br>
	    <input type="text" name="country-name" maxlenght="12" id="country-name" autocomplete="country-name" value="' . $country . '" /><br>
	    <label for="Phone">' . __('Phone: ', 'microdata-about') . '</label><br>
	    <input type="text" name="phone" maxlenght="25" id="phone" autocomplete="phone" value="' . $phone . '" /><br>
	    <label for="Fax">' . __('Fax: ', 'microdata-about') . '</label><br>
	    <input type="text" name="fax" maxlenght="25" id="fax" autocomplete="fax" value="' . $fax . '" /><br>
	    <label for="URL">' . __('WEB URL: ', 'microdata-about') . '</label><br>
	    <input type="url" name="url" maxlenght="60" id="url" autocomplete="url" value="' . $url . '" /><br>
	    <label for="Email">' . __('Email: ', 'microdata-about') . '</label><br>
	    <input type="email" name="email" maxlenght="60" id="email" autocomplete="email" value="' . $email . '" /><br></div>
	    <div class="limpiartodo"><input type="submit" id="enviar" name="enviar" /></div>';
    }
}

/* Serves Microdata */
function microdata_address($atts){
	wp_enqueue_style( 'estilo', plugins_url('microdata-about') .'/css/estilo.css');

	$name = get_option("mcname");
	$logo = get_option("mclogo");
	$nickname = get_option("mcnickname");
	$title = get_option("mctitle");
	$role = get_option("mcrole");
	$affiliation = get_option("mcaffiliation");
	$photo = get_option("mcphoto");
	$company = get_option("mccompany");
	$street = get_option("mcstreet");
	$locality = get_option("mclocality");
	$region = get_option("mcregion");
	$postalcode = get_option("mcpostalcode");
	$country = get_option("mccountry");
	$phone = get_option("mcphone");
	$url = get_option("mcurl");
	$fax = get_option("fax");
	$email = get_option("email");

	$opcion = $atts['a'];

	if($opcion == "person"){
		$argumento = '<div itemscope itemtype="http://data-vocabulary.org/Person" class="mcdata">';
		$argumento = $argumento . '<div class="mcname"><div class="mcname-content">';
		if($name){
			$argumento = $argumento . '<span itemprop="name">' . $name . '</span>';
		}
		if($nickname){
			$argumento = $argumento . '&nbsp;<span itemprop="nickname">(' . $nickname . ')</span>';
		}
		$argumento = $argumento . '</div></div>'; /* END .mcname */
		if($logo){
			$argumento = $argumento . '<img src="' . $logo . '" itemprop="photo" class="mcphoto">';
		}
		$argumento = $argumento . '<div class="mcperson">';
		if($title){
			$argumento = $argumento . '<span itemprop="title">' . $title . '</span><br>';
		}
		if($role){
			$argumento = $argumento . '<span itemprop="role">' . $role . '</span><br>';
		}
		if($affiliation){
			$argumento = $argumento . '<span itemprop="affiliation">' . $affiliation . '</span>';
		}
		$argumento = $argumento . '</div>'; /* END .mcperson */
	}else{
		$argumento = '<div itemscope itemtype="http://schema.org/Organization" class="mcdata">';
		$argumento = $argumento . '<div class="mcname"><div class="mcname-content">';
		if($company){
			$argumento = $argumento . '<span itemprop="name">' . $company . '</span>';
		}
		$argumento = $argumento . '</div></div>'; /* 1: END .mcnamecontent; 2: END .mcname */
		if($logo){
			$argumento = $argumento . '<img src="' . $logo . '" itemprop="logo" class="mcphoto">';
		}
	}
	
	$argumento = $argumento . '<div class="mcaddress">';
	if($street or $locality or $postalcode or $region){
	    $argumento = $argumento . '<div itemprop="address" itemscope itemtype="http://schema.org/PostalAddress"">';
	    if($street){
		$argumento = $argumento . '<span itemprop="streetAddress">' . $street . '</span><br>';
	    }
	    if($locality){
		$argumento = $argumento . '<span itemprop="addressLocality">' . $locality . '</span>&nbsp;';
	    }
	    if($region){
		$argumento = $argumento . '(<span itemprop="addressRegion">' . $region . '</span>)<br> ';
	    }
	    if($postalcode){
		$argumento = $argumento . ' <span itemprop="postalCode">' . $postalcode . '</span>&nbsp;';
	    }
	    if($country){
		$argumento = $argumento . '<span itemprop="addresCountry">' . $country . '</span><br>';
	    }
	    $argumento = $argumento . '</div>';
	}
	$argumento = $argumento . "</div>"; /* End .mcaddress */
	
	$argumento = $argumento . '<div class="mccontact">';
	if($phone){
	    $argumento = $argumento . '<div>Tel: <span itemprop="telephone">' . $phone . '</span></div>';
	}
	
	if($fax){
	    $argumento = $argumento . '<div>Fax: <span itemprop="fax">' . $fax . '</span></div>';
	}

	if($url){
	    $argumento = $argumento . '<div><a href="' . $url . '" itemprop="url">' . $url . '</a></div>';
	}

	if($email){
		$argumento = $argumento . '<div><a href="mailto:' . $email . '" itemprop="email">' . $email . '</a></div>';
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