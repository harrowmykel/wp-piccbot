<?php 

// Review Request
add_action( 'admin_footer_text', 'pcbtt_csp4_admin_footer' );

function pcbtt_csp4_admin_footer( $text ) {
	
  global $current_screen;
//   $review = get_option( 'pcbtt_csp4_review' );
//   if ( isset( $review['dismissed'] ) &&  $review['dismissed']){
//   	return $text;
//   }


  if ( !empty( $current_screen->id ) && strpos( $current_screen->id, 'pcbtt_csp4' ) !== false ) {

    $url  = 'https://wordpress.org/support/plugin/picc-bot/reviews/?filter=5#new-post';
    $text = sprintf( __( 'Please rate <strong>PiccOrg</strong> <a href="%s" target="_blank">&#9733;&#9733;&#9733;&#9733;&#9733;</a> on <a href="%s" target="_blank">WordPress.org</a> to help us spread the word. Thank you from the PiccOrg team!', 'picc-bot' ), $url, $url );
  }
  return $text;
}

if(!empty($_GET['page']) && $_GET['page'] == 'pcbtt_csp4'){
//add_action( 'admin_notices', 'pcbtt_csp4_review' );
}
function pcbtt_csp4_review() {

	// Verify that we can do a check for reviews.

	$review = get_option( 'pcbtt_csp4_review' );
	$time	= time();
	$load	= false;
	$settings = pcbtt_csp4_get_settings();
	

	if ( ! $review ) {
		$review = array(
			'time' 		=> $time,
			'dismissed' => false
		);
		$load = true;
	} else {
		// Check if it has been dismissed or not.
		//if ( (isset( $review['dismissed'] ) && ! $review['dismissed']) && (isset( $review['time'] ) && (($review['time'] + DAY_IN_SECONDS) <= $time) && $settings['status'] > 0) ) {
			if ( (isset( $review['dismissed'] ) && ! $review['dismissed']) ) {
			$load = true;
		}
	}


	// If we cannot load, return early.
	if ( ! $load ) {
		return;
	}

	// Update the review option now.
	update_option( 'pcbtt_csp4_review', $review );

	$current_user = wp_get_current_user();
	$fname = '';
	if(!empty($current_user->user_firstname)){
		$fname = $current_user->user_firstname;
	}

	$page_type = 'Coming Soon Page';
	if(!empty($settings['status']) && $settings['status'] == 2){
		$page_type = 'Maintenance Mode Page';
	}


	// We have a candidate! Output a review message.
	?>
	<div class="notice notice-info is-dismissible pbtt-csp4-review-notice">
		<p><?php printf(__( 'Hey %s, <br><br>I just want to say "Thank you" using this free plugin. If you have any questions  post it to our <a href="https://wordpress.org/support/plugin/picc-bot">support forums</a>.<br><br>Also check out the &#8594; <a href="%s" target="blank" rel="noopener noreferrer">special upgrade offer</a> we have going on right now for the Pro Verison.<br><br>Hope you have a great %s! Cheers', 'picc-bot' ),ucfirst($fname),pcbtt_csp4_admin_upgrade_link( 'special-offer' ), date('l') ); ?></p>
		<p><strong><?php _e( '--<br> John Turner<br><a href="'.pcbtt_csp4_admin_upgrade_link( 'special-offer' ).'" target="blank" rel="noopener noreferrer">PiccOrg.com</a>', 'picc-bot' ); ?></strong></p>
		<p>
			<!-- <a href="https://wordpress.org/support/plugin/picc-bot/reviews/?filter=5#new-post" class="pbtt-csp4-dismiss-review-notice pbtt-csp4-review-out" target="_blank" rel="noopener"><?php _e( 'Ok, you deserve it', 'picc-bot' ); ?></a><br> -->
			<a href="#" class="pbtt-csp4-dismiss-review-notice" target="_blank" rel="noopener"><?php _e( 'Dismiss Notice', 'picc-bot' ); ?></a><br>
			<!-- <a href="#" class="pbtt-csp4-dismiss-review-notice" target="_blank" rel="noopener"><?php _e( 'I already did', 'picc-bot' ); ?></a><br> -->
		</p>
	</div>
	<script type="text/javascript">
		jQuery(document).ready( function($) {
			$(document).on('click', '.pbtt-csp4-dismiss-review-notice, .pbtt-csp4-review-notice .notice-dismiss', function( event ) {
				if ( ! $(this).hasClass('pbtt-csp4-review-out') ) {
					event.preventDefault();
				}

				$.post( ajaxurl, {
					action: 'pcbtt_csp4_dismiss_review'
				});

				$('.pbtt-csp4-review-notice').remove();
			});
		});
	</script>
	<?php
}

add_action( 'wp_ajax_pcbtt_csp4_dismiss_review', 'pcbtt_csp4_dismiss_review' );
function pcbtt_csp4_dismiss_review() {

	$review = get_option( 'pcbtt_csp4_review' );
	if ( ! $review ) {
		$review = array();
	}

	$review['time'] 	 = time();
	$review['dismissed'] = true;

	update_option( 'pcbtt_csp4_review', $review );
	die;
}