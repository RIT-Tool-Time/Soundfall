<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Global
|--------------------------------------------------------------------------
*/
$config['ssl_enabled'] 		= FALSE;
$config['sign_up_enabled'] 	= TRUE;
/*
|--------------------------------------------------------------------------
| Sign In
|--------------------------------------------------------------------------
*/
$config['sign_in_recaptcha_enabled'] 	= FALSE;
$config['sign_in_recaptcha_offset'] 	= 3;

/*
|--------------------------------------------------------------------------
| Sign Up
|--------------------------------------------------------------------------
*/
$config['sign_up_recaptcha_enabled'] 	= FALSE;
$config['sign_up_auto_sign_in'] 	= TRUE;
$config['sign_up_default_user_group']   = 2;
$config['sign_up_username_min_length']  = 2;
$config['sign_up_username_max_length']  = 24;
$config['sign_up_password_min_length']  = 6;

/*
|--------------------------------------------------------------------------
| Sign Out
|--------------------------------------------------------------------------
*/
$config['sign_out_view_enabled'] 		= TRUE;

/*
|--------------------------------------------------------------------------
| Forgot Password
|--------------------------------------------------------------------------
*/
$config['forgot_password_recaptcha_enabled'] 	= TRUE;

/*
|--------------------------------------------------------------------------
| Third Party Auth
| Adding more services:
| http://hybridauth.sourceforge.net/userguide.html
|--------------------------------------------------------------------------
*/
$config['openid_what_is_url'] = 'http://openidexplained.com/';
$config['third_party_auth'] = array(
// set on "base_url" the relative url that point to HybridAuth Endpoint
'base_url' => '/account/connect_end/',

"providers" => array (
        // openid providers
        "OpenID" => array (
                "enabled" => TRUE
        ),

        "Yahoo" => array (
                "enabled" => FALSE,
                "keys"    => array ( "key" => "", "secret" => "" ),
        ),

        "AOL"  => array (
                "enabled" => TRUE
        ),

        "Google" => array (
                "enabled" => FALSE,
                "keys"    => array ( "id" => "", "secret" => "" ),
        ),

        "Facebook" => array (
                "enabled" => FALSE,
                "keys"    => array ( "id" => "", "secret" => "" ),
        ),

        "Twitter" => array (
                "enabled" => FALSE,
                "keys"    => array ( "key" => "", "secret" => "" )
        ),

        // windows live
        "Live" => array (
                "enabled" => FALSE,
                "keys"    => array ( "id" => "", "secret" => "" )
        ),

        "LinkedIn" => array (
                "enabled" => FALSE,
                "keys"    => array ( "key" => "", "secret" => "" )
        ),

        "Foursquare" => array (
                "enabled" => FALSE,
                "keys"    => array ( "id" => "", "secret" => "" )
        ),
),

// if you want to enable logging, set 'debug_mode' to true  then provide a writable file by the web server on "debug_file"
"debug_mode" => (ENVIRONMENT == 'development'),

"debug_file" => APPPATH.'/logs/hybridauth.log',
);

/*
|--------------------------------------------------------------------------
| Password Reset
|--------------------------------------------------------------------------
|
|	password_reset_expiration		Reset password form will be valid for 30 mins (default)
|	password_reset_secret 			Reset password token salt. See https://www.grc.com/passwords.htm
|									* IMPORTANT * Do not reuse the password reset salt else where!
|	password_reset_email 			Reset password sender email
*/
$config['password_reset_expiration'] 	= 1800;
$config['password_reset_secret'] 	= '';
$config['password_reset_email'] 	= 'no-reply@a3m.net';


/*
|--------------------------------------------------------------------------
| Confrimation E-mail for registration
|--------------------------------------------------------------------------
|       
|	account_email_validate               Will send out confirmation email for account email validation
|       account_email_validation_required    Requires that the e-mail is validated before user can login
|       account_email_confirm_sender        
|       
*/
$config['account_email_validate']           = TRUE;
$config['account_email_validation_required']= TRUE;
$config['account_email_confirm_sender']     = 'no-reply@a3m.net';

/* End of file account.php */
/* Location: ./application/account/config/account.php */
