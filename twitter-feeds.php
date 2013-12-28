<?php
/*
Plugin Name:Twitter Feeds 
Plugin URI: http://viaviweb.com
Description:  Twitter feeds that outputs your latest tweets in HTML into any post, page or sidebar widget. Customizable,Colorful and easy to configure!
Version: 1.0.0
Author:  
Author URI: http://viaviweb.com
Wordpress version supported: 3.0 and above
License: GPL2
*/


add_action('plugins_loaded', 'tweets_feeds_init');

/* 

*Make Admin Menu Item

*/

add_action('admin_menu','twitter_feeds_setting');


/*Color*/
function stickysocialicon_script() {
	
	wp_enqueue_script( 'wp-color-picker' );
        // load the minified version of custom script
        wp_enqueue_script( 'stickysocialicon-color', plugins_url( 'js/color-script.min.js', __FILE__ ), array( 'jquery', 'wp-color-picker' ), '1.1', true );
        wp_enqueue_style( 'wp-color-picker' );
}
add_action('init', 'stickysocialicon_script');

/*

*Register Twitter Specific Options

*/

add_action('admin_init','twfeeds_init');

add_action('wp_dashboard_setup', 'add_dashboard_tweets_feed' );

 
# Load the language files

function tweets_feeds_init(){

	load_plugin_textdomain( '', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

}



/* 

*Setup Admin menu item 

*/

function twitter_feeds_setting(){

	add_menu_page('Twitter Feeds','Twitter Feeds','administrator','twitter-feeds-plugin','twitter_feed_option_page',plugins_url('/twitter-feeds/css/twitter_icon.png',1));

}



function add_dashboard_tweets_feed(){

	wp_add_dashboard_widget('twitter_feeds_dashboard_widget', 'Twitter Feeds', 'viavi_get_twitter_feeds');

}



/* 

*Register Twitter Specific Options 

*/

function twfeeds_init(){

	register_setting('twfeeds_options','wtfeeds_consumer_screen_name');//todo - add sanitization function ", 'functionName'"

	register_setting('twfeeds_options','wtfeeds_consumer_key');

	register_setting('twfeeds_options','wtfeeds_consumer_secret');

	register_setting('twfeeds_options','wtfeeds_access_token');

	register_setting('twfeeds_options','wtfeeds_access_token_secret');

	register_setting('twfeeds_options','wtfeeds_display_number_of_tweets');	
	
	register_setting('twfeeds_options','wtfeeds_display_color');	

} 



if( function_exists('register_uninstall_hook') )

	register_uninstall_hook(__FILE__,'twitterfeeds_uninstall');   



function twitterfeeds_uninstall(){

	delete_option('wtfeeds_consumer_screen_name'); 

	delete_option('wtfeeds_consumer_key');

	delete_option('wtfeeds_consumer_secret');

	delete_option('wtfeeds_access_token');

	delete_option('wtfeeds_access_token_secret');

	delete_option('wtfeeds_display_number_of_tweets');
	
	delete_option('wtfeeds_display_color');

}		



/* 

*Display the Options form for Twitter Feeds 

*/

function twitter_feed_option_page(){ ?>

	<div class="wrap">  

	<h2>

		<?php _e('Twitter Feeds Options','');?>

	</h2>
 
	<p>

		<?php _e('You can find these settings here: <a href="https://dev.twitter.com/apps" target="_blank">Twitter API</a>','');?>

	</p>
		<div style="width:60%;float:left;">
			<form action="options.php" method="post" id="options-form">

		<?php settings_fields('twfeeds_options'); ?>

		<table class="form-table">

			<tr class="even" valign="top">

				<th scope="row">

					<label for="wtfeeds_consumer_screen_name">

						<?php _e('Twitter Screen(User) Name or  Hashtags/keywords:','');?>

					</label>

				</th>

				<td>

					<input type="text" id="wtfeeds_consumer_screen_name" name="wtfeeds_consumer_screen_name" class="regular-text" value="<?php echo esc_attr(get_option('wtfeeds_consumer_screen_name')); ?>" />

					<p class="description">

						<?php _e('(Without the "@" / "#" symbol)','');?>

					</p>

				</td>

			</tr>

			<tr class="odd" valign="top">

				<th scope="row">

					<label for="wtfeeds_consumer_key">

						<?php _e('Consumer Key:','');?>

					</label>

				</th>

				<td>

					<input type="text" id="wtfeeds_consumer_key" name="wtfeeds_consumer_key" class="regular-text" value="<?php echo esc_attr(get_option('wtfeeds_consumer_key')); ?>" />

					<p></p>

				</td>

			</tr>

			<tr class="even" valign="top">

				<th scope="row">

					<label for="wtfeeds_consumer_secret">

						<?php _e('Consumer Secret:','');?>

					</label>

				</th>

				<td>

					<input type="text" id="wtfeeds_consumer_secret" name="wtfeeds_consumer_secret" class="regular-text" value="<?php echo esc_attr(get_option('wtfeeds_consumer_secret')); ?>" />

					<p></p>

				</td>

			</tr>

			<tr class="odd" valign="top">

				<th scope="row">

					<label for="wtfeeds_access_token">

						<?php _e('Access Token:','');?>

					</label>

				</th>

				<td>

					<input type="text" id="wtfeeds_access_token" name="wtfeeds_access_token" class="regular-text" value="<?php echo esc_attr(get_option('wtfeeds_access_token')); ?>" />

					<p></p>

				</td>

			</tr>

			<tr class="even" valign="top">

				<th scope="row">

					<label for="wtfeeds_access_token_secret">

						<?php _e('Access Token Secret:','');?>

					</label>

				</th>

				<td>

					<input type="text" id="wtfeeds_access_token_secret" name="wtfeeds_access_token_secret" class="regular-text" value="<?php echo esc_attr(get_option('wtfeeds_access_token_secret')); ?>" />

					<p></p>

				</td>

			</tr>

			<tr class="odd" valign="top">

				<th scope="row">

					<label for="wtfeeds_display_number_of_tweets">

						<?php _e('Number Of Tweets:','');?>

					</label>

				</th>

				<td>

					<input type="text" id="wtfeeds_display_number_of_tweets" name="wtfeeds_display_number_of_tweets" class="regular-text" value="<?php echo esc_attr(get_option('wtfeeds_display_number_of_tweets')); ?>" />

					<p></p>

				</td>

			</tr>		
            <tr class="odd" valign="top">

				<th scope="row">

					<label for="wtfeeds_display_color">

						<?php _e('Select Color:','');?>

					</label>

				</th>

				<td>
                
                	<input name="wtfeeds_display_color" id="link-color" type="text" value="<?php  echo esc_attr(get_option('wtfeeds_display_color'));?>" /> 
					 
					 
		

				</td>

			</tr>			

		</table>

			<p class="submit">

				<input type="submit" name="submit" class="button-primary" value="Save Settings" />

			</p>

	</form>
		</div>
        <div style="width:38%;float:right; background:#9F9;padding:1%;-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;">
        		<h3>

					<?php _e('How to use?','');?>

				</h3>
  
                <p>Place PHP code '< ? php do_shortcode("[TwitterFeeds twitter_username='Your Twitter Name(Without the "@" symbol)' numberoftweets='Number Of Tweets' tweet_title='Your Title']"); ? >' to display twitter feeds in your page template. </p>
                
                 <p>Place shortcode '[TwitterFeeds twitter_username='Your Twitter Name(Without the "@" symbol)' numberoftweets='Number Of Tweets' tweet_title='Your Title']' to display twitter feeds in your post(s).
                </p>
                <p>
                 <form method="post" action="https://www.paypal.com/cgi-bin/webscr" class="paypal-button" target="_blank" style="opacity: 1;"><input type="hidden" name="button" value="donate"><input type="hidden" name="business" value="viaviwebtech@gmail.com"><input type="hidden" name="item_name" value="Twitter feeds wordpress plugin"><input type="hidden" name="quantity" value=""><input type="hidden" name="amount" value=""><input type="hidden" name="currency_code" value=""><input type="hidden" name="shipping" value=""><input type="hidden" name="tax" value=""><input type="hidden" name="notify_url" value="http://viaviweb.com"><input type="hidden" name="cmd" value="_donations"><input type="hidden" name="bn" value="JavaScriptButton_donate"><input type="hidden" name="env" value="www"><input type="image" border="0" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" name="submit" alt="PayPal - The safer, easier way to pay online!"></form>
                </p>
                
        </div>
	</div>

<?php }

function twitter_feed_makeLink($tweet_feeds_con){

	$tweet_feeds_con = preg_replace('@(https?://([-\w\.]+[-\w])+(:\d+)?(/([\w/_\.#-]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $tweet_feeds_con);

	$tweet_feeds_con = preg_replace( '/@([a-zA-Z0-9]+)/', '<a href="https://twitter.com/\1" target="_blank">@\1</a>', $tweet_feeds_con ); 

	$tweet_feeds_con = preg_replace( '/#([a-zA-Z0-9-]+)/', '<a href="https://twitter.com/search?q=%23\1&src=hash" target="_blank">#\1</a>', $tweet_feeds_con ); 

	return $tweet_feeds_con;

}



// parse time in a twitter style

function viavi_getTime($tw_date){

	$tw_timediff = time() - strtotime($tw_date);

	if($tw_timediff < 60)		return $tw_timediff . 's';

	else if($tw_timediff < 3600)		return intval(date('i', $tw_timediff)) . 'm';

	else if($tw_timediff < 86400)		return round($tw_timediff/60/60) . 'h';

	else		return date_i18n('M d', strtotime($tw_date));

}	



function twitter_feeds_formatter($tw_date){

	$tw_epoch_timestamp = strtotime( $tw_date );

	$tw_twitter_time = human_time_diff($tw_epoch_timestamp, current_time('timestamp') ) . ' ago';

	return $tw_twitter_time;

}



require_once("twitteroauth/twitteroauth.php"); //Path to twitteroauth library



function getConnectionWithAccessToken($cons_key, $cons_secret, $oauth_token, $oauth_token_secret){

	$twitter_feeds_connection = new TwitterOAuth($cons_key, $cons_secret, $oauth_token, $oauth_token_secret);

	return $twitter_feeds_connection;

}



function get_connect($tw_consumerkey_gt, $tw_consumersecret_gt, $tw_accesstoken_gt, $tw_accesstokensecret_gt,$tw_twitteruser_gt,$twi_notweets_gt){

	//session_start();

	$twitter_feeds_connection = getConnectionWithAccessToken($tw_consumerkey_gt, $tw_consumersecret_gt, $tw_accesstoken_gt, $tw_accesstokensecret_gt);

	$tw_tweets_all = $twitter_feeds_connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$tw_twitteruser_gt."&count=".$twi_notweets_gt);

	return $tw_tweets_all;

}



/* Short code */

add_shortcode( 'TwitterFeeds' , 'viavi_get_twitter_feeds' );



function viavi_get_twitter_feeds($atts){

	extract( shortcode_atts( array(

				'twitter_username' => '',

				'numberoftweets' => '',

				'tweet_title' =>''

	), $atts));

	$tw_get_twitteruser=$twitter_username ? $twitter_username : get_option('wtfeeds_consumer_screen_name');

	$tw_get_notweets=$numberoftweets ? $numberoftweets : get_option('wtfeeds_display_number_of_tweets');

	$tw_get_tweetstitle=$tweet_title ? $tweet_title:'Latest Twetter Feeds';

	$tw_twitteruser = $tw_get_twitteruser;

	$tw_notweets = $tw_get_notweets;

	$tw_consumerkey = get_option('wtfeeds_consumer_key');

	$tw_consumersecret = get_option('wtfeeds_consumer_secret');

	$tw_accesstoken = get_option('wtfeeds_access_token');

	$tw_accesstokensecret = get_option('wtfeeds_access_token_secret');



	if($tw_twitteruser!='' && $tw_notweets !='' && $tw_consumerkey!='' && $tw_consumersecret!='' && $tw_accesstoken!='' && $tw_accesstokensecret!=''){

		$tw_tweets_feeds = get_connect($tw_consumerkey, $tw_consumersecret, $tw_accesstoken, $tw_accesstokensecret,$tw_twitteruser,$tw_notweets);

		

		wp_register_style('twitterfeeds', plugins_url('css/twitterfeeds.css', __FILE__));

		wp_enqueue_style('twitterfeeds');



		if(is_admin()){

			$screen = get_current_screen(); 

			if($screen->id == 'dashboard'){

				$tw_wid_title="";

				$tw_class="";

			}

			else{

				$tw_wid_title="<h3 class='widget-title'>".$tw_get_tweetstitle."</h3>";

				$tw_class="viavi_twitter_feeds widget";

			}

		}else{

			$tw_wid_title="<h3 class='widget-title'>".$tw_get_tweetstitle."</h3>";	

			$tw_class="viavi_twitter_feeds widget";

		}

		

		$twitter_feeds_output="<div class='".$tw_class."'>

		".$tw_wid_title."					

		<div class='viaviwidget-title'><span class='tweet_author_name'>".$tw_twitteruser."</span>&nbsp;<span class='tweet_author_heading'><a href='https://twitter.com/$tw_twitteruser' target='_blank'>@".$tw_twitteruser."</a></span></div>";

echo "<style type='text/css'>
 		.viavi_twitter_feeds a{color:".get_option('wtfeeds_display_color')."!important;}
 		</style>";
		
		for($i=0;$i<count($tw_tweets_feeds);$i++){



				$tw_img_html='<a href="https://twitter.com/'.$tw_twitteruser.'" target="_blank"><img src="'.$tw_tweets_feeds[$i]->user->profile_image_url_https.'" class="imgalign"/></a>';

		

				$twitter_username_html='<span class="tweet_author_name">

				<a href="https://twitter.com/'.$tw_twitteruser.'" target="_blank">'.$tw_tweets_feeds[$i]->user->name.'</a>

				</span>&nbsp;<span class="tweet_author"><a href="https://twitter.com/'.$tw_twitteruser.'" target="_blank">@'.$tw_twitteruser.'</a></span><br />';

				$tw_timestamp_html='<a href="https://twitter.com/'.$tw_tweets_feeds[$i]->user->screen_name.'/status/'.$tw_tweets_feeds[$i]->id_str.'" target="_blank">'.viavi_getTime($tw_tweets_feeds[$i]->created_at).'</a>';



			$tw_replay_html='<a target="_blank" href="https://twitter.com/intent/tweet?in_reply_to='.$tw_tweets_feeds[$i]->id_str.'">reply</a>';



			$tw_retweet_html='<a target="_blank" href="https://twitter.com/intent/retweet?tweet_id='.$tw_tweets_feeds[$i]->id_str.'">retweet</a>';



			$tw_favorite_html='<a target="_blank" href="https://twitter.com/intent/favorite?tweet_id='.$tw_tweets_feeds[$i]->id_str.'">favorite</a>';

			$tw_follow_html='<p class="thinkTwitFollow"><a href="https://twitter.com/'. $tw_twitteruser.'" class="twitter-follow-button" data-show-count="false" data-dnt="true">Follow @'.$username.'</a></p>';

			$tw_follow_html.='<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");twttr.widgets.load();</script>';

			
			 
			$twitter_feeds_output.='<div class="imgdisplay">'.$tw_img_html.'

			<div class="tweettxts">

			<div class="tweettext">'.$twitter_username_html.''.twitter_feed_makeLink($tw_tweets_feeds[$i]->text).'&nbsp

			</div> 

			<div class="tweetlink">

			'.$tw_timestamp_html.'

			'.$tw_replay_html.'

			'.$tw_retweet_html.'

			'.$tw_favorite_html.'

			<a href="https://twitter.com/'.$tw_twitteruser.'" target="_blank">'.twitter_feeds_formatter($tw_tweets_feeds[$i]->created_at).'</a>

			</div>

			</div>

			</div>';
			 
		}	
		 


		$twitter_feeds_output.=$tw_follow_html."</div>";
		
		//echo $twitter_feeds_output;

	}

	else{

		$twitter_feeds_output="<div id='viavi_twitter_feeds'>

		<h1>".$tw_get_tweetstitle."</h1>

		<div>Please Fill All Required Value

		</div>

		</div>";
	
		//echo $twitter_feeds_output;			

	}

	return $twitter_feeds_output;
	
}

/* 

*Twitter Feeds Widget 

* enables the ability to use a widget to place the tweet feed in the widget areas 

* of a theme.

*/

class VIAVI_Twitter_Widget extends WP_Widget{

/*

	* Register the widget for use in WordPress

*/ 

	public function VIAVI_Twitter_Widget(){

		$this->options = array(
			 
			array(

				'name'	=> 'twitter_feed_widget_title',	'label'	=> 'Widget title',

				'type'	=> 'text',	'default' => 'Latest Tweets', 'tooltip' => 'Title of the widget'),

			array(

				'name'	=> 'twitter_feed_widget_username',	'label'	=> 'Username (Without the "@" symbol)',

				'type'	=> 'text',	'default' => 'twitter', 'tooltip' => 'Twitter username for which you want to display tweets if widget type is set to Timeline'),

			array(

				'name'	=> 'twitter_feeds_widget_count',	'label'	=> 'Tweet number',

				'type'	=> 'text',	'default' => '5', 'tooltip' => 'Number of Tweets to display'),

		);



	/* Widget settings. */



		$widget_options = array(

			'classname' => 'twitter_feeds_widget',

			'description' => 'Twitter Feed Widget, Displays your latest Tweet',

		);



	/* Widget control settings. */



		$control_ops = array('width' => 250);

		parent::WP_Widget('twitter_feeds_widget','Twitter Feeds',$widget_options,$control_ops);

	}



	public function widget($args, $instance){

		$tw_get_widget_twitteruser=$instance['twitter_feed_widget_username'] ? $instance['twitter_feed_widget_username'] : get_option('wtfeeds_consumer_screen_name');

		$tw_get_widget_notweets=$instance['twitter_feeds_widget_count'] ? $instance['twitter_feeds_widget_count'] : get_option('wtfeeds_display_number_of_tweets');

		$title = ($instance['twitter_feed_widget_title']) ? $instance['twitter_feed_widget_title'] : 'Latest Twitter Feeds';

		$tw_wid_twitteruser = $tw_get_widget_twitteruser;

		$tw_wid_notweets = $tw_get_widget_notweets;

		extract($args, EXTR_SKIP);	

		$atts_arr=array('twitter_username' => $tw_get_widget_twitteruser,

			'numberoftweets' => $tw_get_widget_notweets,

			'tweet_title' =>$title);

		echo viavi_get_twitter_feeds($atts_arr);

	}



	function update($new_instance, $old_instance){                

		return $new_instance;

	}



	public function form($instance){

		if(empty($instance)){

			foreach($this->options as $val){

				if($val['type'] == 'separator'){

					continue;

				}

				$instance[$val['name']] = $val['default'];

			}

		}					



		if(!is_callable('curl_init')){

			echo __('Your PHP doesn\'t have cURL extension enabled. Please contact your host and ask them to enable it.');

			return;

		}



		foreach($this->options as $val){

			$title = '';

			if(!empty($val['tooltip'])){

				$title = ' title="' . $val['tooltip'] . '"';

			}

			if($val['type'] == 'separator'){

				echo $val['label'] . '<br/ >';

			}

			else if($val['type'] == 'text'){

				$label = '<label for="' . $this->get_field_id($val['name']) . '" ' . $title . '>' . $val['label'] . '</label>';

				$value = $val['default'];

				if(isset($instance[$val['name']]))

					$value = esc_attr($instance[$val['name']]);

				echo '<p>' . $label . '<br />';

				echo '<input class="widefat" id="' . $this->get_field_id($val['name']) . '" name="' . $this->get_field_name($val['name']) . '" type="text" value="' . $value . '" ' . $title . '/></p>';



			}

		}

		echo "<a href='".admin_url()."options-general.php?page=twitter-feeds-plugin'>More Settings</a>";

	}

}
 

/*

* Register the VIAVI_Twitter_Widget widget

*/



function twitter_feeds_widget_init(){

	register_widget('VIAVI_Twitter_Widget');

}

add_action('widgets_init', 'twitter_feeds_widget_init');