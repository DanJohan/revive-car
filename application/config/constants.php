<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// Twilio credentials
define('TWILIO_SID','ACe60f8f7e7f6b5c76f244ed687d7e555f');
define('TWILIO_TOKEN','3fd9ddd4b66dcd39a37a93eb1108ab4c');
define('TWILIO_NUMBER','+1 856 281 3441');


// smtp mail credentials

/*define('MAIL_HOST','smtp.mailtrap.io');
define('MAIL_USERNAME','c4f3f72a8e133a');
define('MAIL_PASSWORD','500f8fd814ede7');
define('MAIL_PORT',25);*/

/*define('MAIL_HOST','mail.globalcaresystems.com');
define('MAIL_USERNAME','revive@globalcaresystems.com');
define('MAIL_PASSWORD','D}B^F7x(2{fP');
define('MAIL_PORT',25);*/


define('MAIL_HOST','smtp.gmail.com');
define('MAIL_USERNAME','kumaranuj.smartserve@gmail.com');
define('MAIL_PASSWORD','aNuj@123');
define('MAIL_PORT',587);

define('ANDRIOD_PUSH_AUTH_KEY','AAAAstFVzas:APA91bEkb-hJQUHRsOKBp6JqiURWs4TuoRbfjdP7h9bwWRmsXob43cdoW4_Bx9fcfdqzpg28v-mnVxb4mbuHjg3fwM8Mq_d9wtd7vIXNOfnxeEUnagmhwe3VWiJyySfjifw5lBC_lLCneQ_i97GhFWhdYLquDQRGVA');

define('DRIVER_PUSH_AUTH_KEY','AAAAwahzcU4:APA91bHusVsulEzKDfg38nRswaKVeUYalqbQst09l3dva4NVD4h-T7cB5U2t6f_LTarV0XExET8DawRvJWuc9SQMSZ8mSLxRHhxjRqtLSu-YOClNsL0WEreY3kVIdABqTQirwdtJRtmvWUfrXlcvAl_wdLYDGa9YmA');

define('JWT_KEY','UY39E7IX3puWn+2z7uoEpY8WXzXl2D1v/96k4U7FFkyjM/D/nZKdkJPprfQpkzKQ6fT0btWqd5viMbXJcG2NKA==');
