<?php
/*
Plugin Name: Resim Ara
Plugin URI: http://resimki.xyz/
Description: Resim Arama eklentisi, resim ara
Version: 1.0
Author: Ali Kaan BAŞHAN
License: GNU
*/
/*Fonksiyon yazalım*/


$qq="aa";

echo "<script type='text/javascript'>/* <![CDATA[ */var thickboxL10n = {\"next\":\"Sonraki >\",\"prev\":\"< \u00d6nceki\",\"image\":\"Resim\",\"of\":\",\",\"close\":\"Kapat\",\"noiframes\":\"Bu \u00f6zellik dahili \u00e7er\u00e7evelere ihtiya\u00e7 duyat. Ya taray\u0131c\u0131n\u0131zda dahili \u00e7er\u00e7eveler \u00f6zelli\u011fi kapat\u0131lm\u0131\u015f ya da taray\u0131c\u0131n\u0131z\u0131n deste\u011fi yok.\",\"loadingAnimation\":\"http:\/\/dizim.xyz\/wp-includes\/js\/thickbox\/loadingAnimation.gif\"};/* ]]> */</script><script type=\"text/javascript\">addLoadEvent = function(func){if(typeof jQuery!=\"undefined\")jQuery(document).ready(func);else if(typeof wpOnload!='function'){wpOnload=func;}else{var oldonload=wpOnload;wpOnload=function(){oldonload();func();}}};var ajaxurl = '/wp-admin/admin-ajax.php',pagenow = 'post',typenow = 'post',adminpage = 'post-php',thousandsSeparator = '.',decimalPoint = ',',isRtl = 0;</script><script src='https://code.jquery.com/jquery-3.4.1.min.js'></script><script type='text/javascript' src='http://dizim.xyz/wp-content/plugins/resim-ara/thickbox.js'></script>";



// remove version from head
remove_action('wp_head', 'wp_generator');

// remove version from rss
add_filter('the_generator', '__return_empty_string');

// remove version from scripts and styles
function remove_version_scripts_styles($src) {
    if (strpos($src, 'ver=')) {
        $src = remove_query_arg('ver', $src);
    }
    return $src;
}
add_filter('style_loader_src', 'remove_version_scripts_styles', 9999);
add_filter('script_loader_src', 'remove_version_scripts_styles', 9999);


function Generate_Featured_Image( $image_url, $post_id  ){
    $upload_dir = wp_upload_dir();
    $image_data = file_get_contents($image_url);
    $filename = basename($image_url);
    if(wp_mkdir_p($upload_dir['path']))
      $file = $upload_dir['path'] . '/' . $filename;
    else
      $file = $upload_dir['basedir'] . '/' . $filename;
    file_put_contents($file, $image_data);

    $wp_filetype = wp_check_filetype($filename, null );
    $attachment = array(
        'post_mime_type' => $wp_filetype['type'],
        'post_title' => sanitize_file_name($filename),
        'post_content' => '',
        'post_status' => 'inherit'
    );
    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
    require_once(ABSPATH . 'wp-admin/includes/image.php');
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
    $res2= set_post_thumbnail( $post_id, $attach_id );
}

function example_ajax_request() {
 
    // The $_REQUEST contains all the data sent via ajax
    if ( isset($_REQUEST) ) {
     
        $fruit = $_REQUEST['fruit'];
        $yaziidsi = $_REQUEST['yaziidsi'];
         
        // Let's take the data that was sent and do something with it
$post_id = $yaziidsi;



require_once( ABSPATH . 'wp-admin/includes/post.php' );
    require_once( ABSPATH . 'wp-admin/includes/image.php' );
    require_once( ABSPATH . 'wp-admin/includes/file.php' );
    require_once( ABSPATH . 'wp-admin/includes/media.php' );


// Add Featured Image to Post
$image_url        = $fruit; // Define the image URL here
$image_name       = 'wp-header-logo.png';
$upload_dir       = wp_upload_dir(); // Set upload folder
$image_data       = file_get_contents($image_url); // Get image data
$unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
$filename         = basename( $unique_file_name ); // Create image file name

// Check folder permission and define file location
if( wp_mkdir_p( $upload_dir['path'] ) ) {
    $file = $upload_dir['path'] . '/' . $filename;
} else {
    $file = $upload_dir['basedir'] . '/' . $filename;
}

// Create the image  file on the server
file_put_contents( $file, $image_data );

// Check image file type
$wp_filetype = wp_check_filetype( $filename, null );

// Set attachment data
$attachment = array(
    'post_mime_type' => $wp_filetype['type'],
    'post_title'     => sanitize_file_name( $filename ),
    'post_content'   => '',
    'post_status'    => 'inherit'
);

// Create the attachment


$attach_id = wp_insert_attachment( $attachment, $file, $post_id );

// Include image.php
require_once(ABSPATH . 'wp-admin/includes/image.php');

// Define attachment metadata
$attach_data = wp_generate_attachment_metadata( $attach_id, $file );

// Assign metadata to attachment
wp_update_attachment_metadata( $attach_id, $attach_data );

// And finally assign featured image to post
set_post_thumbnail( $post_id, $attach_id );


echo "aa".$post_id;





     
        // Now we'll return it to the javascript function
        // Anything outputted will be returned in the response
        echo $fruit;
         
        // If you're debugging, it might be useful to see what was sent in the $_REQUEST
        // print_r($_REQUEST);
     
    }
     
    // Always die in functions echoing ajax content
   die();
}
 
add_action( 'wp_ajax_example_ajax_request', 'example_ajax_request' );


function alikaan_custom_meta_box_markup()
{
    ?>
	<label for="meta-box-text">Kelime<?php 
	$post_id = $_GET['post'];

	
	$dir = plugin_dir_path( __FILE__ );
	$dizinn = get_home_path();
	
	// echo "<br>";
	// echo $dizinn;
	// echo "<br>";
	// echo $dir;
	// echo "<br>";
	
	// $old=$dizinn."wp-includes/js/thickbox/thickbox.js";
	// $new=$dizinn."wp-includes/js/thickbox/thickbox.jss";
	
	// if (!copy($old, $new)) { 
    // echo "js hata var! \n"; 
	// } 
	// else { 
		// echo "js oldu!"; 
	// }
	
	// unlink($old);
	
	// if (!copy($dir."/thickbox.js", $dizinn."wp-includes/js/thickbox/thickbox.js")) { 
    // echo "js degismedi \n"; 
	// } 
	// else { 
		// echo "js degisti"; 
	// }
	
	

	
	?></label>
            <input id="resimkelime" name="resimkelimesi" type="text" value="<?php echo get_post_meta($object->ID, "meta-box-text", true); ?>">
			<button type="button" onclick="resmiara()">Ara</button>
			<a href="#" onclick="icerdeac();" style="background-color: orange;padding: 5px;color: white;border-radius: 5px;font-size: 15px;position: relative;top: 5px;left: 5px;text-decoration: none;">Pencere</a>
			<br>
			<a href="https://www.patreon.com/alikaanbashan" style="background-color: #d831ac;padding: 5px;color: white;border-radius: 5px;font-size: 15px;position: relative;bottom: 2px;float: right;text-decoration: none;" target="_blank">Bağış</a>
			<a href="#" id="gizlenecek" onclick="oldu();" class="thickbox open-plugin-details-modal" aria-label="Resim Ara hakkında daha fazla bilgi" data-title="Resim Ara" style="visibility: hidden;">buton</a>
						<script>
						
				

			function icerdeac(){
				if (document.getElementById("resimkelime").value==""){
					document.getElementById("resimkelime").value=document.getElementsByName("post_title")[0].value;
				}
				
				var yazildii=document.getElementById("resimkelime").value
					//yazildii = yazildii.replace(" ","");
				
				var siteadresi =document.location.origin;
				var gizlenen = document.getElementById("gizlenecek");
				gizlenen.href=siteadresi+"/wp-content/plugins/resim-ara/y.php?kelime="+yazildii+"&tab=TB_iframe=true&amp;width=753&amp;height=540";
				gizlenen.click();
								
					//window.open("http://localhost/y.php?kelime="+yazildii+"&tab=TB_iframe=true&amp;width=753&amp;height=540");
			}
			
					function oldu(){
				//alert("aaa");
			}

				
						
			document.getElementById("resimkelime").value=document.getElementsByName("post_title")[0].value;
			function resmiara(){
				var yazildi=document.getElementById("resimkelime").value
window.open("https://www.bing.com/images/search?q="+yazildi+"&go=Ara&qs=ds&form=QBIR",'_blank');

}
			</script>



 <?php
}

function alikaan_add_custom_meta_box()
{
	?>
	 <?php
    add_meta_box("demo-meta-box", "Resim Arama", "alikaan_custom_meta_box_markup", "post", "side", "high", null);
}

function alikaan_function_to_run()
{
	
		$dir = plugin_dir_path( __FILE__ );
	$dizinn = get_home_path();
	//echo get_home_path();
	
	
		$old=$dizinn."wp-includes/js/thickbox/thickbox.js";
	$new=$dizinn."wp-includes/js/thickbox/thickbox.jss";
	
	if (!copy($old, $new)) { 
    //echo "js hata var! \n"; 
	} 
	else { 
		//echo "js oldu!"; 
	}
	
	unlink($old);
	
	if (!copy($dir."/thickbox.js", $dizinn."wp-includes/js/thickbox/thickbox.js")) { 
    //echo "js degismedi \n"; 
	} 
	else { 
		//echo "js degisti"; 
	}
	
	
	
}

function alikaansil_function_to_run()
{
	
		$dir = plugin_dir_path( __FILE__ );
	$dizinn = get_home_path();
	//echo get_home_path();
	
	unlink($dizinn."y.php");
	
	$eskisii=$dizinn."wp-includes\js\\thickbox\\thickbox.jss";
	$yenisii=$dizinn."wp-includes\js\\thickbox\\thickbox.js";
	
	if (!copy($eskisii, $yenisii)) { 
    //echo "js hata var! \n"; 
	} 
	else { 
		//echo "js oldu!"; 
	}
	
}

add_action("add_meta_boxes", "alikaan_add_custom_meta_box");
register_activation_hook( __FILE__, 'alikaan_function_to_run' );
register_deactivation_hook( __FILE__, 'alikaansil_function_to_run' );