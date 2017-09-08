=== User Wallet Credit System ===
Contributors: justingreerbbi
Donate link: http://justin-greer.com/#donate
Tags: woocommerce, wallet, woocommerce credits, user wallet
Requires at least: 4.8
Tested up to: 4.8
Stable tag: 3.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gives users the ability to load a virtual wallet balance using WooCommerce checkout.

== Description ==

User Wallet Credit System is the first and original plugin for WooCommerce that provides each user of your WordPress website with their very own personal
wallet. Users can load their wallet with virtual money paid for using real money. The plugin provides a way to purchase items from your store while using their virtual money.
Store managers can also adjust user amount easily in the backend of WordPress.

**Starting with version 3.0, you will be able to adjust a users wallet by clicking on Users. You will now see the option to "Edit Wallet" under each user.**

**Features**:

* Easy to install
* Load wallet using credit products which then can be used for later purchases.
* Ties into WooCommerce settings for currency formatting (simple).
* Manually adjust user wallet balances if need be from the admin area.
* Make purchases using the wallet balance.

**How To Use**:

*	Go to "Add Product" in WooCommerce and give the bundle a name.
* Ensure the product type is "Simple Product", "Virtual" check box is checked, and "Credit" is checked as the products category. Under the inventory tab check "Enable this to only allow one of this item to be bought in a single order"
*	Save the product. Once saved you will see an input label "Credit Amount". Enter the credit amount for the product. (If the product's retail price is 10.00 then the credit amount should be 10.00). 
* Save the product again.

The plugin is setup not to list the credit bundles (products) in the store with other products. It is recommended that when you are offering users the ability to purchase products, that they do not have anything else in their cart.

**Shortcodes**:

Show Current User Wallet Balance:

`
[uw_balance display_username="true" separator=":" username_type="display_name"]
`

* display_username = (true|false) - Show username next to balance
* separator = (:|-) The character separating the username and wallet balance.
* username_type = (display_name|first_name|last_name|full_name)


Display a table containing the bundles (credit product) and "Buy Now" buttons:

`
[uw_product_table]
`

**Things to Note**:

* The plugins uses user meta fields to keep track of wallet balances. (_uw_balance).. Beware if you plan to 				change this. You could wipe everyones wallet balances out.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `user-wallet` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Refer to plugin description in regards to setting up how the plugins works

== Frequently Asked Questions ==

= Can User Wallet be used to make purchases? =

Yes. If you enabled the Virtual Wallet Payment Gateway (which is included in the plugin).

= Can the Wallet balance and Credit card Payment Methods be used together to make a purchase? =

No. Use Wallet can not be used with any other payment method at the same time during checkout.

= Is there Multisite Support =
Yes. The users funds will follow them accessed all network sites.

== Screenshots ==

1. Simple Wallet Display
2. List Bundles
3. Pay with Virtual Wallet

== Changelog ==

== 3.0.1 ==
* Fixed the required issue with a file that does not exist.

== 3.0 ==
* Restructure admin management flow for better performance.
* Security Update.
* Minor code refactoring

== 2.0 ==
* Tested with WP 4.8.
* Added: `wpuw_update_status` filter. Defaults to "completed" (WC status). Used to modify the checkout status when using WPUW.
* Removed default values from main class to auto complete.
* -- Added a widget to display user wallet for logged in users

= 1.3 =
* Tested with latest version of WC and WP.
* Fixed undefined error if debug was set to true in wp-config.php
* Typo Updates
* Changed occurrences of plugin to User Wallet instead of Virtual Wallet

= 1.2 =
* Fixed issue where all orders go into "Complete" status, even if the product was not a currency package or virtual wallet was used as a payment method.

= 1.1 =
* Fixed infinite credit bug reported by dvolkering
* Updated version and confirmed working on 4.1

= 1.0 =
* Initial Release