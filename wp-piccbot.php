<?php 
/**
  Plugin Name: WP PiccBOT ENGINE (includes WP-Ban V1.69)
  Plugin URI: https://wordpress.org/plugins/wp-file-manager
  Description: Stop BOTS before they stop you + Ban users by IP, IP Range, host name, user agent and referer url from visiting your WordPress's blog. It will display a custom ban message when the banned IP, IP range, host name, user agent or referer url tries to visit you blog. You can also exclude certain IPs from being banned. There will be statistics recordered on how many times they attemp to visit your blog. It allows wildcard matching too.*(from https://lesterchan.net)
  Author: Aro Micheal, Lester 'GaMerZ' Chan
  Version: 1.0
  Author URI: https://aro-micheal.piccmaq.com.ng/?ref=piccbot
  License: GPLv2
  Text Domain: wp-piccbot
 **/
if (!session_id()) {
    session_start();
}
if (!defined('WP_PICCBOT_DIRNAME')) {
    define('WP_PICCBOT_DIRNAME', plugin_basename(dirname(__FILE__)));
}
define('WP_PICCBOT_PATH', plugin_dir_path(__FILE__));
define("PICCBOT_SESS_CONSTANT", "retkl2");
require_once(ABSPATH.'wp-admin/includes/user.php');


add_action("wp_ajax_nopriv_piccbots", "piccbot_do_robot_control");
add_action("wp_ajax_piccbots", "piccbot_do_robot_control");
add_action("groups_group_after_save", "piccbot_do_group_control");
add_action("bp_activity_after_save", "piccbot_do_activity_control");
add_filter( 'registration_errors', 'piccbot_registration_errors', 99, 3 );

function piccbot_do_activity_control($activity_obj){
	$content = $activity_obj->content;
	$id = $activity_obj->id;
	if(piccbot_check_activity_content_for_bots_keyword($content) && apply_filters("piccbot_can_delete_activity", true, $id)){
		BP_Activity_Activity::delete( array(
			'id' => $id
		) );
	}
}
function piccbot_do_group_control($group_obj){
	$content = $group_obj->description;
	$id = $group_obj->id;
	if(piccbot_check_group_content_for_bots_keyword($content) && apply_filters("piccbot_can_delete_group", true, $id)){
		$group = new BP_Groups_Group($id);
		$group->delete();
	}
}

function piccbot_do_robot_control(){
	global $bp;
	global $wpdb;

	$users_to_delete = [];
	$groups_to_delete = [];
	$activities_to_delete = [];

	//last verification date
	$date_end = "2020-03-30";

	/*DELETE GROUPS*/
	$query ="SELECT * FROM {$bp->groups->table_name} WHERE date_created > '$date_end'";
	if(isset($_SESSION[PICCBOT_SESS_CONSTANT."piccbot-last-checked-group-id"])){
		$query = $query." AND id > ".intval($_SESSION[PICCBOT_SESS_CONSTANT."piccbot-last-checked-group-id"]);
	}
	$activities_s = $wpdb->get_results( $query);
	foreach ($activities_s as $key => $activity) {
		$id  = $activity->id;
		$content=$activity->description;
		if(piccbot_check_group_content_for_bots_keyword($content)){
			$groups_to_delete[] = $id;
			$users_to_delete[] = $activity->creator_id;
		}
		$_SESSION[PICCBOT_SESS_CONSTANT."piccbot-last-checked-group-id"] = $id;
	}

	$query = "SELECT * FROM {$bp->activity->table_name} WHERE date_recorded > '$date_end'";
	if(isset($_SESSION[PICCBOT_SESS_CONSTANT."piccbot-last-checked-activity-id"])){
		$query = $query." AND id > ".intval($_SESSION[PICCBOT_SESS_CONSTANT."piccbot-last-checked-activity-id"]);
	}
	/*DELETE ACTIVITIES*/
	$activities_s = $wpdb->get_results( $query);
	foreach ($activities_s as $key => $activity) {
		$id  = $activity->id;
		$content=$activity->content;
		if(piccbot_check_activity_content_for_bots_keyword($content)){
			$activities_to_delete[] = $id;
			$users_to_delete[] = $activity->user_id;
		}
		$_SESSION[PICCBOT_SESS_CONSTANT."piccbot-last-checked-activity-id"] = $id;
	}

	/*DELETE USING USERS EMAIL*/
	$query = "SELECT * FROM {$wpdb->users} WHERE user_registered > '$date_end'";
	if(isset($_SESSION[PICCBOT_SESS_CONSTANT."piccbot-last-checked-user-id"])){
		$query = $query." AND ID > ".intval($_SESSION[PICCBOT_SESS_CONSTANT."piccbot-last-checked-user-id"]);
	}
	$users_s = $wpdb->get_results($query);
	foreach ($users_s as $key => $user_s) {
		$email_is_accepted = false;
		$id  = $user_s->ID;
		$email = strtolower($user_s->user_email);
		$email_is_accepted = piccbot_email_is_accepted_format($email);

		if(!$email_is_accepted){
			$users_to_delete[] = $id;
		}
		$_SESSION[PICCBOT_SESS_CONSTANT."piccbot-last-checked-user-id"] = $id;
	}

	if(count($activities_to_delete)> 0){
		foreach ($activities_to_delete as $key => $activity_to_delete) {
			if(!apply_filters("piccbot_can_delete_activity", true, $activity_to_delete)){
				continue;
			}				
			BP_Activity_Activity::delete( array(
				'id' => $activity_to_delete
			) );
		}
	}

	// delete groups
	foreach ($groups_to_delete as $key => $group_to_delete) {	
		if(!apply_filters("piccbot_can_delete_group", true, $group_to_delete)){
			continue;
		}
		$group = new BP_Groups_Group($group_to_delete);
		$group->delete();
	}

	// delete user
	if(count($users_to_delete)> 0){
		foreach ($users_to_delete as $key => $user_to_delete) {
			piccbot_disable_bot_user($user_to_delete);
		}
	}
}

function piccbot_disable_bot_user($user_to_delete){
	global $wpdb;
	$user_to_delete = intval($user_to_delete);
	if(!$user_to_delete || !apply_filters("piccbot_can_delete_user", true, $user_to_delete)){
		return false;
	}
	BP_Activity_Activity::delete( array(
		'user_id' => $user_to_delete
	) );
	//get all groups where user is admin
	$admin_group_ids = BP_Groups_Member::get_is_admin_of( $user_to_delete );
	$admin_groups = $admin_group_ids['groups'];	
    foreach( $admin_groups as $group_e ) {	
		if(!apply_filters("piccbot_can_delete_group", true, $group_e->id)){
			continue;
		}
		$group = new BP_Groups_Group($group_e->id);
		$group->delete();
    }
	// Attempt to delete comments.
	BP_Activity_Activity::delete( array(
		'type'    => 'activity_comment',
		'user_id' => $user_to_delete
	) );
	//ban Ip address
	$ip_table = $wpdb->prefix.FAULH_TABLE_NAME;
	$user = get_user_by( 'ID', $user_to_delete );
	if(!$user){
		return false;
	}
	$username = ($user)->user_login;
	$banned_ips = get_option('banned_ips', "");
    $query = "SELECT ip_address FROM $ip_table WHERE username='$username' LIMIT 1";
    $ip_results = $wpdb->get_results($query);

    if($ip_results){
	    foreach ($ip_results as $key => $result) {
	    	if(!$result->ip_address)continue;
	    	$deleted_users_ip = trim($result->ip_address);
	    	if(strstr($banned_ips, $deleted_users_ip) == false){
		    	$banned_ips = $banned_ips."\n".$deleted_users_ip;
	    	}
	    }
    }
	update_option("banned_ips", $banned_ips);

	//delete user
	// wp_delete_user($user_to_delete);
	update_user_meta($user_to_delete, "wdc-user-is-disabled", "spam");
	return true;
}

function piccbot_registration_errors( $errors, $sanitized_user_login, $user_email ) {
	if(!piccbot_email_is_accepted_format($user_email)){
		$errors->add( 'invalid_email', __( 'ERROR: Invalid E-mail', "whitedot-child"));	
	}
	return $errors;
}

function piccbot_email_is_accepted_format($email){
	$popular_emails = ['aim.com','alice.it','aliceadsl.fr','aol.com','arcor.de','att.net','bellsouth.net','bigpond.com','bigpond.net.au','bluewin.ch','blueyonder.co.uk','bol.com.br','centurytel.net','charter.net','chello.nl','club-internet.fr','comcast.net','cox.net','earthlink.net','facebook.com','free.fr','freenet.de','frontiernet.net','gmail.com','gmx.de','gmx.net','googlemail.com','hetnet.nl','home.nl','hotmail.co.uk','hotmail.com','hotmail.de','hotmail.es','hotmail.fr','hotmail.it','ig.com.br','juno.com','laposte.net','libero.it','live.ca','live.co.uk','live.com','live.com.au','live.fr','live.it','live.nl','mac.com','mail.com','mail.ru','me.com','msn.com','neuf.fr','ntlworld.com','optonline.net','optusnet.com.au','orange.fr','outlook.com','piccmaq.com.ng','planet.nl','qq.com','rambler.ru','rediffmail.com','rocketmail.com','sbcglobal.net','sfr.fr','shaw.ca','sky.com','skynet.be','sympatico.ca','t-online.de','telenet.be','terra.com.br','tin.it','tiscali.co.uk','tiscali.it','uol.com.br','verizon.net','virgilio.it','voila.fr','wanadoo.fr','web.de','windstream.net','yahoo.ca','yahoo.co.id','yahoo.co.in','yahoo.co.jp','yahoo.co.uk','yahoo.com','yahoo.com.ar','yahoo.com.au','yahoo.com.br','yahoo.com.mx','yahoo.com.sg','yahoo.de','yahoo.es','yahoo.fr','yahoo.in','yahoo.it','yandex.ru','ymail.com','zonnet.nl'];
	$popular_emails = apply_filters("piccbot_popular_emails_domains", $popular_emails);

	$response = false;
	if(!$email){
		return false;
	}
	$email_ending_arr = explode("@", $email);

	if(count($email_ending_arr) == 2){
		$response = (in_array($email_ending_arr[1], $popular_emails) || strstr($email_ending_arr[1], "piccmaq") != false);
	}
	return apply_filters("piccbot_email_is_accepted_format", $response, $email);
}

function piccbot_bot_keywords(){
	return ["visit", "homepage", "surf", "web blog", "wigs", "web-site", "web blog", "blog post", "webpage", "blog", "wig", "website", "site", "page", "cock", "ring", "penis", "web", "sex", "vibrator", "adult toys"];
}

function piccbot_check_activity_content_for_bots_keyword($content){
	$response = false;
	$content = strtolower($content);

	$key_words = piccbot_bot_keywords();
	$key_words = apply_filters("piccbot_bot_keywords", $key_words);

	if(strstr($content, "href=") != FALSE){
		foreach ($key_words as $key => $key_word) {
			$response = true;
			if(strstr(strtolower($content), $key_word) != false){
				$response = true;
				break;
			}
		}
	}
	return apply_filters("piccbot_check_activity_content_for_bots_keyword", $response, $content);
}

function piccbot_check_group_content_for_bots_keyword($content){
	$response = false;
	$content = strtolower($content);

	$key_words = piccbot_bot_keywords();
	$key_words = apply_filters("piccbot_bot_keywords", $key_words);

	$response = strlen($content)> 200;

	if(strstr($content, "href=") != FALSE && !$response){
		$response = true;
		foreach ($key_words as $key => $key_word) {
			if(strstr(strtolower($content), $key_word) != false){
				$response = true;
				break;
			}
		}
	}
	return apply_filters("piccbot_check_group_content_for_bots_keyword", $response, $content);
}

include WP_PICCBOT_PATH."/wp-ban/wp-ban.php";
include WP_PICCBOT_PATH."/coming-soon.php";
?>