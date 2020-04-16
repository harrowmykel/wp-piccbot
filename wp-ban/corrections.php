<?php 
// FILE  /wp-ban/ban-options.php

// Line 197
$banned_options = get_option( 'banned_options' );
/** get_otion() returns false if the option does not exist already, so do check*/
if(!$banned_options){
	$banned_options = [];
	$banned_options['reverse_proxy'] = "";
}




// LINE 30
$banned_message             = ! empty( $_POST['banned_template_message'] )  ? trim( $_POST['banned_template_message'] ) : '';
/*add div container, if user forgets*/
if(!empty($banned_message) && strstr($banned_message, 'id="wp-ban-container"') == FALSE && strstr($banned_message, 'id="wp-ban-container"') == FALSE){
    $banned_message = '<div id="wp-ban-container">'.$banned_message.'</div>';
}





 ?>