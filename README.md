# wp-admin-notification [![Build Status](https://scrutinizer-ci.com/g/askupasoftware/wp-admin-notification/badges/build.png?b=master)](https://scrutinizer-ci.com/g/askupasoftware/wp-admin-notification/build-status/master) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/askupasoftware/wp-admin-notification/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/askupasoftware/wp-admin-notification/?branch=master) [![License](https://img.shields.io/badge/license-GPL--3.0%2B-red.svg)](https://raw.githubusercontent.com/askupasoftware/wp-admin-notification/master/LICENSE)
**wp-admin-notification** lets you add static/dismissible notifications to the WordPress administrastion. Dismissible notifictions are permanently dismissed and will not show when the page reloads. For an in-depth tutorial, see [Adding Static/Dismissible Admin Notifications to WordPress](https://blog.askupasoftware.com/adding-staticdismissible-admin-notifications-wordpress/)

![wp-admin-notification - ](https://askupasoftware.com/wp-content/uploads/2014/01/wp-admin-notifications.gif)

## Overview
**wp-admin-notification** lets you easily add notifications to the WordPress administrastion with different options to chose from. In WordPress 4.2 [dismissible notifications becamse supported](https://make.wordpress.org/core/2015/04/23/spinners-and-dismissible-admin-notices-in-4-2/). However, a dismissed notification becomes visible again when the user refreshes the page or navigates away. **wp-admin-notification** handles that by storing an option in the database once a notification is dismissed.  
**wp-admin-notification** is lightweight and trace free - it will only initiate if there is at least one registered notification, and will only store a database option if a user dismisses a notification. `wp_reset_admin_notification()` will remove the option from the database if there are no more dismissed notifications.

## Installation

### Via Composer

If you are using the command line:  
```
$ composer require askupa-software/wp-admin-notification:dev-master
```

Or simply add the following to your `composer.json` file:
```javascript
"require": {
     "askupa-software/wp-admin-notification": "dev-master"
 }
```
And run the command 
```
$ composer install
```

This will install the package in the directory `vendors/askupa-software/wp-admin-notification`.

### Manually

[Download the package](https://github.com/askupasoftware/wp-admin-notification/archive/master.zip) from github and include `bootstrap.php` in your project:

```php
require_once 'path/to/wp-admin-notification/bootstrap.php';
```

## Usage

### wp_admin_notification
*Register a notification to be printed in the administration.*
```php
wp_admin_notification( $handle, $html, $type = 'success', $dismissible = false, $class = '', $network = false )
```
This function is used to register a notification for a given handle. The handle is used as the notification's ID. If the notification is dismissible, the handle is used to permanently dismiss the notification. When a dismissible notification is dismissed, the `wp_dismissed_notices` option is updated with the handle added to it.

**Parameters**  
* `$handle` (*String*) The notification's ID. Also used to permanently dismiss a dismissible notification. If a given handle has previously been registered, a PHP notice will be triggered.
* `$html` (*String*)  The text/HTML content of the notification.
* `$type` (*String*)  The notification's type. One of `error`, `notice`, `info`, `success`.
* `$dismissible` (*Boolean*)  Whether to add a "dismiss" button to allow the user to permanently dismiss the notification.
* `$class` (*String*)  An additional CSS class to be added to the notification for styling purposes.
* `$network` (*Boolean*)  Whether to show this notification in the network administration as well. Uses the [network_admin_notices](https://codex.wordpress.org/Plugin_API/Action_Reference/network_admin_notices) hook internally.

### wp_reset_admin_notification
*Reset a dismissible notification.*
```php
wp_reset_admin_notification( $handle )
```
This function can be used to make a previously dismissed notification visible again. It does that by removing the given `$handle` from the list of dismissed notifications stored in the option `wp_dismissed_notices`. If the list of dismissed notification is empty, the option will be removed from the database.

**Parameters**  
* `$handle` (*String*)  The handle of the notification to be reset.
