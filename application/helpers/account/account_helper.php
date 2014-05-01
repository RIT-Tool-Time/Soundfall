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

/**
 * Gets the avatar file name for the given user
 * @param Numeric $user_id
 * @return String  File name
 */
function get_avatar($user_id)
{
    $CI =& get_instance();
    $CI->load->model('Account_details_model');
    $account = $CI->Account_model->get_by_id($user_id);
    return $accont->picture;
}