<?php
// Twilio credentials
define('TWILIO_SID', getenv('TWILIO_SID'));
define('TWILIO_TOKEN', getenv('TWILIO_TOKEN'));
define('TWILIO_NUMBER', getenv('TWILIO_NUMBER'));


define('MAIL_HOST', getenv('MAIL_HOST'));
define('MAIL_USERNAME', getenv('MAIL_USERNAME'));
define('MAIL_PASSWORD',getenv('MAIL_PASSWORD'));
define('MAIL_PORT',getenv('MAIL_PORT'));

define('ANDRIOD_PUSH_AUTH_KEY',getenv('ANDRIOD_PUSH_AUTH_KEY'));

define('DRIVER_PUSH_AUTH_KEY',getenv('DRIVER_PUSH_AUTH_KEY'));

define('JWT_KEY',getenv('JWT_KEY'));

define('PUSHER_APP_ID',getenv('PUSHER_APP_ID'));
define('PUSHER_KEY',getenv('PUSHER_KEY'));
define('PUSHER_SECRET',getenv('PUSHER_SECRET'));
define('PUSHER_CLUSTER',getenv('PUSHER_CLUSTER'));

?>
