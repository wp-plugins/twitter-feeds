=== Plugin Name ===
Contributors: viaviwebtech
Donate link:
Tags: twitter feeds, twitter, feeds, social,social media
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Twitter feeds that outputs your latest tweets in HTML into any post, page or sidebar widget. Customizable,Colorful and easy to configure!

== Description ==

Twitter feeds plugin provides facility to display twitter tweets on your website using Twitter 1.1 API with authentication.

= Features =
  * Embed timelines using only username or Hashtags/keywords.
  * Using Twitter 1.1 API with authentication.
  * Easy setting and configuration.
  * No JavaScript embedded.
  * Admin side display tweets in Dashboard.
  * Multiple times you can use Twitter widget & shortcode.
  * Different color Options.

= Author =
Developed by [Viaviweb](http://viaviweb.com)
 
== Installation ==

To use this plugin, please follow the steps given below:

1) Register at https://dev.twitter.com/apps/new and create a new app.

2) After registering, fill in App name, e.g. "domain name App", description, e.g "My Twitter App", and write the address of your website. Check "I agree" next to their terms of service and click "create your Twitter application".

3) After this, your app will be created. Click "Create my access token" and you should see at the bottom "Access token" and "Access token secret". Refresh the page if you don't see them.

4) Copy "Consumer Key", "Consumer Secret", "Access Token" and "Access Token Secret" to admin panel, Menu ->'Settings' -> 'Twitter Feeds Settings'.

= Follow below steps to install plugin: =

Download plugin and place 'AI-Twitter-Feeds' folder to the '/wp-content/plugins/' directory or Install plugin directly from your wordpress admin, Menu-> Plugins -> Add New, and search for 'Twitter-Feeds'zip and Install.

Activate the plugin through the WordPress admin panel,'Plugins' menu -> Installed Plugins -> find the 'Twitter Feeds' -> Activate.

Set Options for Twitter feeds from the admin panel menu link,'Settings ->Twitter Feeds Settings'.

Place PHP code '< ? php do_shortcode("[TwitterFeeds twitter_username='Your Twitter Name(Without the "@" symbol)' numberoftweets='Number Of Tweets' tweet_title='Your Title']"); ? >' to display twitter feeds in your page template.

Place shortcode '[TwitterFeeds twitter_username='Your Twitter Name(Without the "@" symbol)' numberoftweets='Number Of Tweets' tweet_title='Your Title']' to display twitter feeds in your post(s).

Use the widget to place it in your sidebar or other areas!


== Frequently Asked Questions ==

= Q. Do i have to create any kind of application on twitter ? =
A. You must be create twitter app.
 
== Screenshots ==
 
1. Settings Screen from WordPress Admin.
2. Widget Setting example in admin.
3. Widget view on front side.

== Changelog ==

= 1.0 =
Initial version released

== Upgrade Notice ==
Nothing here




