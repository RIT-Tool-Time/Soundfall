<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Account_providers_model
 *
 * Model for the Social Network providers connections.
 *
 * @package A3M
 * @subpackage Models
 */
class Account_providers_model extends CI_Model
{
    /**
     * Gets all of user's connection
     * @param int $user_id
     * @return array
     */
    public function get_by_user_id($user_id)
    {
        $this->db->order_by('provider', 'ACS');
        return $this->db->get_where($this->db->dbprefix . 'a3m_providers', array('user_id' => $user_id))->result();
    }
    
    // --------------------------------------------------------------------
    
    /*
     * Gets record by provider uid
     * @param string $provider Provider's name
     * @param string $id ID for the user used by the provider
     * @return object Record object
     */
    public function get_by_provider_uid($provider, $id)
    {
        return $this->db->get_where($this->db->dbprefix . 'a3m_providers', array('provider' => $provider, 'provider_uid' => $id))->row();
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Insert a new record into DB
     * @param int $user_id User id
     * @param string $provider Provider's name
     * @param string $provider_uid User's id from the provider
     * @param string $email User's e-mail provided by the provider
     * @param string $display_name Display/Nickaname from the provider
     * @param string $first_name
     * @param string $last_name
     * @param string $profile_url Link to user's profile with the provider
     * @param string $website_url
     * @param string $photo_url
     * @return int Insert id
     */
    public function insert($user_id, $provider, $provider_uid, $email, $display_name, $first_name, $last_name, $profile_url, $website_url, $photo_url)
    {
        $this->load->helper('date');
        $this->db->insert($this->db->dbprefix . 'a3m_providers', array('user_id' => $user_id, 'provider' => $provider, 'provider_uid' => $provider_uid, 'email' => $email, 'display_name' => $display_name, 'first_name' => $first_name, 'last_name' => $last_name, 'profile_url' => $profile_url, 'website_url' => $website_url, 'photo_url' => $photo_url, 'created_at' => mdate('%Y-%m-%d %H:%i:%s', now()) ));
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Delete given record from table
     * @param int $user_id
     * @param string $provider Provider name
     * @param string $uid Provider uid
     */
    public function delete($user_id, $provider, $uid)
    {
        $this->db->where(array('user_id' => $user_id, 'provider' => $provider, 'provider_uid' => $uid));
        $this->db->delete($this->db->dbprefix . 'a3m_providers');
    }
}
/* End of file Account_providers_model.php */
/* Location: ./application/model/account/Account_providers_model.php */