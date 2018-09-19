<?php
/** set your paypal credential **/

/*$config['client_id'] = 'AYSq3RDGsmBLJE-otTkBtM-jBRd1TCQwFf9RGfwddNXWz0uFU9ztymylOhRS';
$config['secret'] = 'EGnHDxD_qRPdaLdZz8iCr8N7_MzF-YHPTkjs6NKYQvQSBngp4PTTVWkPZRbL';*/

$config['client_id'] = 'AUvPOPFRg002AdyvE-gbrELklxpyP-XDz2vsolVPdQ-aIp26fgkppiIc-O9ODzD1n29JUC4VpWbrmTVu';
$config['secret'] = 'ELhNYBFWOYiP_vtVHp8ibHtBjGiRRAODu6evmNWQPz3fQpmS2aGd34YiARLQLQ-Tjjk5z2NL8sMuuajc';
/**
 * SDK configuration
 */
/**
 * Available option 'sandbox' or 'live'
 */
$config['settings'] = array(

    'mode' => 'sandbox',
    /**
     * Specify the max request time in seconds
     */
    'http.ConnectionTimeOut' => 1000,
    /**
     * Whether want to log to a file
     */
    'log.LogEnabled' => true,
    /**
     * Specify the file that want to write on
     */
    'log.FileName' => 'application/logs/paypal.log',
    /**
     * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
     *
     * Logging is most verbose in the 'FINE' level and decreases as you
     * proceed towards ERROR
     */
    'log.LogLevel' => 'FINE'
);

$config['payu_merchant_key'] = 'rjQUPktU';
$config['payu_salt'] = 'e5iIg1jwi8';
$config['payu_base_url'] = "https://sandboxsecure.payu.in";
