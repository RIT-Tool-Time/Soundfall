<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Gets the username from the user id
 * @param Numeric $user_id
 * @return String  Username
 */
function get_username($user_id)
{
    $CI =& get_instance();
    $account = $CI->Account_model->get_by_id($user_id);
    return $account->username;
}

/**
 * Gets the avatar file name for the given user
 * @param Numeric $user_id
 * @param Numeric $height
 * @param Numeric $width
 * @return String  File name
 */
function get_avatar($user_id, $height, $width)
{
    $CI =& get_instance();
    $CI->load->model('account/Account_details_model');
    $account = $CI->Account_details_model->get_by_account_id($user_id);
    $picture = $account->picture;
    
    //@todo clean this later
    $nocache = (isset($param['nocache'])) ? $param['nocache'] : FALSE; // TRUE = disable caching, add time string to image url
    $check = (isset($param['check'])) ? $param['check'] : FALSE;
    
    if (isset($picture) && strlen(trim($picture)) > 0)
    {
        $remote = stristr($picture, 'http'); // do a check here to see if image is from twitter / facebook / remote URL

        if ( ! $remote)
        {
            if ($nocache)
            {
                $picture = $picture.'?t='.md5(time());
            } // only if $nocache is TRUE
            $path = site_url(RES_DIR.'/user/profile/'.$picture); //.		-- disabled time attachment, no need to break cache
        }
        else
        {

                $path = $picture;
                
                // request proper cropped size from facebook for this photo
                if (stripos($path, 'graph.facebook.com'))
                {
                    $path .= '?width='.$width.'&amp;height='.$height; // this appends size requirements to facebook image
                }
                
                // request bigger photo from twitter
                if (stripos($path, 'twimg.com'))
                {
                    if ($height > 75)
                    {
                        $path = str_replace('_normal', '_bigger', $path); // this forces _bigger 73x73 sized image (over default 48x48), no custom crop offered
                    }
                    if ($height < 25)
                    {
                        $path = str_replace('_normal', '_mini', $path); // this forces _mini 24x24 sized image (over default 48x48), no custom crop offered
                    }
                }
        }
        
        if ($check && ! $remote)
        {
                if ( ! fileExists($path))
                {
                        $title = "Photo not found! ";
                        $path = site_url(RES_DIR.'/img/default-person.png');
                }
        }
    }
    else
    {
        $path = site_url(RES_DIR.'/img/default-person.png');
    }
    return $path;
}