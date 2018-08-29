WordPress Dynamic Data for HelpScout
=============

WordPress Dynamic Data for HelpScout is a WordPress plugin that will show WordPress user information right from your HelpScout dashboard.

The content that is displayed can be edited by modifying the `/views/output.php` file, or by using the `wp_helpscout_html_output` filter.

See [this blog post](https://verygoodplugins.com/fun/wordpress-dynamic-data-for-helpscout/) for a screenshot.


### Installation

To get this up an running, you'll need to configure a few things in WordPress and HelpScout.

#### WordPress

1. Upload the contents of **wordpress-helpscout.zip** to your plugins directory, which usually is `/wp-content/plugins/`.
1. Activate the **WordPress Dynamic Data for HelpScout** plugin
1. Set the **HELPSCOUT_SECRET_KEY** constant in your `/wp-config.php` file. This should be a random string of 40 characters.


_Example_

`
define( 'HELPSCOUT_SECRET_KEY', 'your-random-string' );
`

#### HelpScout

1. Go to the [HelpScout custom app interface](https://secure.helpscout.net/apps/custom/).
1. Enter the following settings.

**App Name:** WordPress User<br />
**Content Type:** Dynamic Content<br />
**Callback URL:** https://your-site.com/wp-helpscout/api _(I recommend using HTTPS)_ <br />
**Secret Key:** The value of your **HELPSCOUT_SECRET_KEY** constant.