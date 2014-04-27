<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Gets the username from the user id
 * @param Numeric $user_id
 * @return String  Username
 */
function get_username($user_id)
{
    $CI =& get_instance();
    $CI->load->model('Account_details_model');
    $account = $CI->Account_model->get_by_id($user_id);
    return $account->username;
}