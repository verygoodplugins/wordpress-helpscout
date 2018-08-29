=== WordPress Dynamic Data for HelpScout ===
Contributors: verygoodplugins
Tags: helpscout,support,help scout
Requires at least: 3.8
Tested up to: 4.9.6
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WordPress Dynamic Data for HelpScout. Shows WordPress user information right from your HelpScout interface.

== Description ==

WordPress Dynamic Data for HelpScout is a WordPress plugin that will show WordPress user information right from your HelpScout dashboard.

The content that is displayed can be edited by modifying the /views/output.php file, or by using the wp_helpscout_html_output filter.

**How to install and configure**

Have a look at the [installation instructions](https://github.com/verygoodplugins/wordpress-helpscout/).

> Please note that this plugin requires PHP 5.3 or higher.

**More information**

- Developers; follow or contribute to the [plugin on GitHub](https://github.com/verygoodplugins/wordpress-helpscout/)

== Installation ==

To get this up an running, you'll need to configure a few things in WordPress and HelpScout.

= WordPress =

1. Upload the contents of **wordpress-helpscout.zip** to your plugins directory, which usually is `/wp-content/plugins/`.
1. Activate the **WordPress Dynamic Data for HelpScout** plugin
1. Set the **HELPSCOUT_SECRET_KEY** constant in your `/wp-config.php` file. This should be a random string of 40 characters.


_Example_
`
define( 'HELPSCOUT_SECRET_KEY', 'your-random-string' );
`

= HelpScout =

1. Go to the [HelpScout custom app interface](https://secure.helpscout.net/apps/custom/).
1. Enter the following settings.

**App Name:** WordPress User<br />
**Content Type:** Dynamic Content<br />
**Callback URL:** https://your-site.com/wp-helpscout/api _(I recommend using HTTPS)_ <br />
**Secret Key:** The value of your **HELPSCOUT_SECRET_KEY** constant.

== Frequently Asked Questions ==

= HelpScout just shows "Invalid Signature" =

Make sure the "Secret Key" setting for your HelpScout application matches the value of your `HELPSCOUT_SECRET_KEY` constant. This key is used to authorize requests coming from HelpScout.

== Changelog ==

= 1.0 =
Initial release.


