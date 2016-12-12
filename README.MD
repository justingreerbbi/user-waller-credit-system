# User Wallet Credit System

* Contributors: justingreerbbi
* Donate link: http://justin-greer.com/#donate
* Tags: woocommerce, wallet, woocommerce credits, user wallet
* Requires at least: 4.0
* Tested up to: 4.1
* Stable tag: 1.2
* License: GPLv2 or later
* License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gives users the ability to load their virtual wallet balance using WooCommerce checkout.

## Description

User Wallet Credit System for Woocommerce provides each user of your WordPress website with their very own personal wallet. Users can load and there wallet with virtual money paid for using real money. The plugin provides a way to purchase items from your store while using their virtual money.

The plugin is still in its infant age and developers are welcome to extend.

## Features

*   Load wallet using credit products which then can be used for later purchases.
*   Ties into WooCommerce settings for currency formatting (simple).
*   Manually adjust user wallet balances if need be from the admin area.
*   Make purchases using the wallet balance.

## How To Use

*	Go to "Add Product" in Woocommerce and give the bundle a name.
*   Ensure the product type is "Simple Product", "Virtual" check box is checked, and "Credit" is checked as the products category. ⋅⋅⋅Under the inventory tab check "Enable this to only allow one of this item to be bought in a single order"
*	Save the product. Once saved you will see an input label "Credit Amount". Enter the credit amount for the product. (If the product's retail price is 10.00 then the credit amount should be 10.00). 
* Save the product again.

The plugin is setup not to list the credit bundles (products) in the store with other products. It is recommended that when you are offering users the ability to purchase products, that they do not have anything else in their cart.

## Shortcodes

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

## Things to Note

The plugins uses user meta fields to keep track of wallet balances. (_uw_balance).. Beware if you plan to change this. You could wipe everyones wallet balances out.


## Installation

This section describes how to install the plugin and get it working.

1. Upload `user-wallet` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Refer to plugin description in regards to setting up how the plugins works

## Frequently Asked Questions

<dl>
    <dt>Can User Wallet be used to make purchases?</dt>
    <dd>Yes. If you enabled the Virtual Wallet Payment Gateway (which is included in the plugin).</dd>
    <dt>Can the Wallet balance and Credit card Payment Methods be used together to make a purchase?</dt>
    <dd>No. Use Wallet can not be used with any other payment method at the same time during checkout.</dd>
</dl> 

## Screenshots
1. Simple Wallet Display:![alt text](/docs/images/1-user-wallet.jpg?raw=true "Simple Wallet Display")
2. List Bundles
3. Pay with Virtual Wallet:![alt text](/docs/images/1-user-wallet.jpg?raw=true "Pay with Virtual Wallet")

## Changelog

### 1.2
* Fixed issue where all orders go into "Complete" status, even if the product was not a currency package or virtual wallet was used as a payment method.

### 1.1
* Fixed infinite credit bug reported by dvolkering
* Updated version and confirmed working on 4.1

### 1.0
* Initial Release.
