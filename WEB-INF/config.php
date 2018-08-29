<?php
// +----------------------------------------------------------------------+
// | Anuko Time Tracker
// +----------------------------------------------------------------------+
// | Copyright (c) Anuko International Ltd. (https://www.anuko.com)
// +----------------------------------------------------------------------+
// | LIBERAL FREEWARE LICENSE: This source code document may be used
// | by anyone for any purpose, and freely redistributed alone or in
// | combination with other software, provided that the license is obeyed.
// |
// | There are only two ways to violate the license:
// |
// | 1. To redistribute this code in source form, with the copyright
// |    notice or license removed or altered. (Distributing in compiled
// |    forms without embedded copyright notices is permitted).
// |
// | 2. To redistribute modified versions of this code in *any* form
// |    that bears insufficient indications that the modifications are
// |    not the work of the original author(s).
// |
// | This license applies to this document only, not any other software
// | that it may be combined with.
// |
// +----------------------------------------------------------------------+
// | Contributors:
// | https://www.anuko.com/time_tracker/credits.htm
// +----------------------------------------------------------------------+

// Set include path for PEAR and its modules, which we include in the distribution.
set_include_path(realpath(dirname(__FILE__).'/lib/pear') . PATH_SEPARATOR . get_include_path());


// Database connection parameters.
// CHANGE 3 PARAMETERS HERE!
// In this example: "root" is username, "no" is password, "dbname" is database name.

define('DSN', 'mysqli://root:@127.0.0.1/timetracker?charset=utf8');


// MULTITEAM_MODE option defines whether users can create their own top groups (organizations).
// When false, a Time Tracker server is managed by admin, who creates top groups (one or many).
// Available values are true or false.

define('MULTITEAM_MODE', true);


// Application name.

define('APP_NAME', 'timetracker');


// WEEKEND_START_DAY
// This option defines which days are highlighted with weekend color.
// 6 means Saturday. For Saudi Arabia, etc. set it to 4 for Thursday and Friday to be weekend days.

define('WEEKEND_START_DAY', 6);


// PHPSESSID_TTL
//
// Lifetime in seconds for tt_PHPSESSID cookie. Time to live is extended by this value
// with each visit to the site so that users don't have to re-login. 
// define('PHPSESSID_TTL', 86400);
//
// Note: see also PHP_SESSION_PATH below as you may have to use it together with
// PHPSESSID_TTL to avoid premature session expirations.


// PHP_SESSION_PATH
// Local file system path for PHP sessions. Use it to isolate session deletions
// (garbage collection interference) by other PHP scripts potentially running on the system.
// define('PHP_SESSION_PATH', '/tmp/timetracker'); // Directory must exist and be writable.


// Forum and help links from the main menu.

define('FORUM_LINK', 'https://www.anuko.com/forum/viewforum.php?f=4');
define('HELP_LINK', 'https://www.anuko.com/time_tracker/user_guide/index.htm');


// Default sender for mail.

define('SENDER', '"Anuko Time Tracker" <no-reply@timetracker.anuko.com>');


// MAIL_MODE - mail sending mode. Can be 'mail' or 'smtp'.
// 'mail' - sending through php mail() function.
// 'smtp' - sending directly through SMTP server.
// See https://www.anuko.com/time_tracker/install_guide/mail.htm

define('MAIL_MODE', 'smtp');
define('MAIL_SMTP_HOST', 'localhost'); // For gmail use 'ssl://smtp.gmail.com' instead of 'localhost' and port 465.
// define('MAIL_SMTP_PORT', '465');
// define('MAIL_SMTP_USER', 'yourname@yourdomain.com');
// define('MAIL_SMTP_PASSWORD', 'yourpassword');
// define('MAIL_SMTP_AUTH', true);
// define('MAIL_SMTP_DEBUG', true);


// CSS files. They are located in the root of Time Tracker installation.

define('DEFAULT_CSS', 'default.css');
define('BOOTSTRAP_CSS', 'bootstrap.min.css');
define('RTL_CSS', 'rtl.css'); // For right to left languages.
define('AD_CSS', 'ad.css');


// Default date format. Behaviour with not included formats is undefined. Possible values:
// '%Y-%m-%d'
// '%m/%d/%Y'
// '%d.%m.%Y'
// '%d.%m.%Y %a'
define('DATE_FORMAT_DEFAULT', '%Y-%m-%d');


// Default time format. Behaviour with not included formats is undefined. Possible values:
// '%H:%M'
// '%I:%M %p'
define('TIME_FORMAT_DEFAULT', '%H:%M');


// Default week start day.
// Possible values: 0 - 6. 0 means Sunday.
define('WEEK_START_DEFAULT', 0);


// Default language of the application.
// Possible values: en, fr, nl, etc. Empty string means the language is defined by user browser.
define('LANG_DEFAULT', '');


// Default currency symbol. Use €, £, a more specific dollar like US$, CAD, etc.
define('CURRENCY_DEFAULT', '$');


// EXPORT_DECIMAL_DURATION - defines whether time duration values are decimal in CSV and XML data exports (1.25 or 1,25 vs 1:15).

define('EXPORT_DECIMAL_DURATION', true);


// REPORT_FOOTER - defines whether to use a footer on reports.
define('REPORT_FOOTER', true);


// Authentication module (see WEB-INF/lib/auth/)
// Possible authentication methods:
//   db - internal database, logins and password hashes are stored in time tracker database.
//   ldap - authentication against an LDAP directory such as OpenLDAP or Windows Active Directory.

define('AUTH_MODULE', 'db');

// LDAP authentication examples.
// Go to https://www.anuko.com/time_tracker/install_guide/ldap_auth/index.htm for detailed configuration instructions.

// Configuration example for OpenLDAP server:
// define('AUTH_MODULE', 'ldap');
// $GLOBALS['AUTH_MODULE_PARAMS'] = array(
//  'server' => '',                    // OpenLDAP server address or name. For secure LDAP use ldaps://hostname:port here.
//  'type' => 'openldap',                       // Type of server. openldap type should also work with Sun Directory Server when member_of is empty.
////                                                 It may work with other (non Windows AD) LDAP servers. For Windows AD use the 'ad' type.
//  'base_dn' => 'ou=,dc=,dc=', // Base distinguished name in LDAP catalog.
//  'default_domain' => '',          // Default domain.
//  'member_of' => array());                    // List of groups, membership in which is required for user to be authenticated.


// Configuration example for Windows domains with Active Directory:
// define('AUTH_MODULE', 'ldap');
// $GLOBALS['AUTH_MODULE_PARAMS'] = array(
//  'server' => '',            // Domain controller IP address or name. For secure LDAP use ldaps://hostname:port here.
//  'type' => '',                     // Type of server.
//  'base_dn' => 'DC=,DC=',   // Base distinguished name in LDAP catalog.
//  'default_domain' => '',  // Default domain.
//  'member_of' => array());



// define('AUTH_DEBUG', 1); // Note: enabling AUTH_DEBUG breaks redirects as debug output is printed before setting redirect header. Do not enable on production systems.


// Height in pixels for the note input field in time.php. Defaults to 40.
// define('NOTE_INPUT_HEIGHT', 100);
