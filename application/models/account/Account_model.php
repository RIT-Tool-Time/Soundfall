<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Account_model
 *
 * Model for basic interaction with user accounts.
 *
 * @package A3M
 * @subpackage Models
 */
class Account_model extends CI_Model
{
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}
	
	/**
	 * Get all accounts
	 *
	 * @access public
	 * @return object all accounts
	 */
	function get()
	{
		return $this->db->get($this->db->dbprefix . 'a3m_account')->result();
	}

	/**
	 * Get account by id
	 *
	 * @access public
	 * @param string $account_id
	 * @return object account object
	 */
	function get_by_id($account_id)
	{
		return $this->db->get_where($this->db->dbprefix . 'a3m_account', array('id' => $account_id))->row();
	}

	// --------------------------------------------------------------------

	/**
	 * Get account by username
	 *
	 * @access public
	 * @param string $username
	 * @return object account object
	 */
	function get_by_username($username)
	{
		return $this->db->get_where($this->db->dbprefix . 'a3m_account', array('username' => $username))->row();
	}

	// --------------------------------------------------------------------

	/**
	 * Get account by email
	 *
	 * @access public
	 * @param string $email
	 * @return object account object
	 */
	function get_by_email($email)
	{
		return $this->db->get_where($this->db->dbprefix . 'a3m_account', array('email' => $email))->row();
	}

	// --------------------------------------------------------------------

	/**
	 * Get account by username or email
	 *
	 * @access public
	 * @param string $username_email
	 * @return object account object
	 */
	function get_by_username_email($username_email)
	{
		return $this->db->where('username', $username_email)->or_where('email', $username_email)->get($this->db->dbprefix . 'a3m_account')->row();
	}

	// --------------------------------------------------------------------

	/**
	 * Create an account
	 *
	 * @access public
	 * @param string $username
	 * @param string $email
-	 * @param string $password Password in plain. Will be hashed before inserted into DB
	 * @return int insert id
	 */
	function create($username, $email = NULL, $password = NULL)
	{
		// Create password hash using phpass
		if ($password !== NULL)
		{
			$this->load->helper('account/phpass');
			$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
			$hashed_password = $hasher->HashPassword($password);
		}

		$this->load->helper('date');
		$this->db->insert($this->db->dbprefix . 'a3m_account', array('username' => $username, 'email' => $email, 'password' => isset($hashed_password) ? $hashed_password : NULL, 'createdon' => mdate('%Y-%m-%d %H:%i:%s', now())));

		return $this->db->insert_id();
	}

	// --------------------------------------------------------------------

	/**
	 * Change account username
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $new_username
	 * @return void
	 */
	function update_username($account_id, $new_username)
	{
		$this->db->update($this->db->dbprefix . 'a3m_account', array('username' => $new_username), array('id' => $account_id));
	}

	// --------------------------------------------------------------------

	/**
	 * Change account email
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $new_email
	 * @return void
	 */
	function update_email($account_id, $new_email)
	{
		$this->db->update($this->db->dbprefix . 'a3m_account', array('email' => $new_email), array('id' => $account_id));
	}

	// --------------------------------------------------------------------

	/**
	 * Change account password
	 *
	 * @access public
	 * @param int $account_id
	 * @param int $password_new
	 * @return void
	 */
	function update_password($account_id, $password_new)
	{
		$this->load->helper('account/phpass');
		$hasher = new PasswordHash(PHPASS_HASH_STRENGTH, PHPASS_HASH_PORTABLE);
		$new_hashed_password = $hasher->HashPassword($password_new);

		$this->db->update($this->db->dbprefix . 'a3m_account', array('password' => $new_hashed_password), array('id' => $account_id));
	}

	// --------------------------------------------------------------------

	/**
	 * Update account last signed in dateime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function update_last_signed_in_datetime($account_id)
	{
		$this->load->helper('date');

		$this->db->update($this->db->dbprefix . 'a3m_account', array('lastsignedinon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('id' => $account_id));
	}

	// --------------------------------------------------------------------

	/**
	 * Update password reset sent datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return int password reset time
	 */
	function update_reset_sent_datetime($account_id)
	{
		$this->load->helper('date');

		$resetsenton = mdate('%Y-%m-%d %H:%i:%s', now());

		$this->db->update($this->db->dbprefix . 'a3m_account', array('resetsenton' => $resetsenton), array('id' => $account_id));

		return strtotime($resetsenton);
	}

	/**
	 * Remove password reset datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function remove_reset_sent_datetime($account_id)
	{
		$this->db->update($this->db->dbprefix . 'a3m_account', array('resetsenton' => NULL), array('id' => $account_id));
	}

	// --------------------------------------------------------------------

	/**
	 * Update account deleted datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function update_deleted_datetime($account_id)
	{
		$this->load->helper('date');

		$this->db->update($this->db->dbprefix . 'a3m_account', array('deletedon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('id' => $account_id));
	}

	/**
	 * Remove account deleted datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function remove_deleted_datetime($account_id)
	{
		$this->db->update($this->db->dbprefix . 'a3m_account', array('deletedon' => NULL), array('id' => $account_id));
	}

	// --------------------------------------------------------------------

	/**
	 * Update account suspended datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function update_suspended_datetime($account_id)
	{
		$this->load->helper('date');

		$this->db->update($this->db->dbprefix . 'a3m_account', array('suspendedon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('id' => $account_id));
	}
	
	// --------------------------------------------------------------------

	/**
	 * Remove account suspended datetime
	 *
	 * @access public
	 * @param int $account_id
	 * @return void
	 */
	function remove_suspended_datetime($account_id)
	{
		$this->db->update($this->db->dbprefix . 'a3m_account', array('suspendedon' => NULL), array('id' => $account_id));
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Verify user
	 * 
	 * @access public
	 * @param int $account_id
	 * @return boolean
	 */
	function verify($account_id)
	{
		$this->load->helper('date');
		
		$this->db->update('a3m_account', array('verifiedon' => mdate('%Y-%m-%d %H:%i:%s', now())), array('id' => $account_id));
		
		if($this->db->affected_rows() === 1)
		{
			return TRUE;
		}
		
		return FALSE;
	}
	
	// --------------------------------------------------------------------
	
	/**
	 * Changes the force reset parameter in the DB
	 * @param int $account_id
	 * @param boolean $action Set TRUE to force user to reset password on next login or FALSE when the reset has been performed
	 * @return boolean
	 */
	public function force_reset_password($account_id, $action)
	{
		$this->db->update($this->db->dbprefix . 'a3m_account', array('forceresetpass' => $action), array('id' => $account_id));
		
		if($this->db->affected_rows() === 1)
		{
			return TRUE;
		}
		
		return FALSE;
	}
}
/* End of file Account_model.php */
/* Location: ./application/models/account/Account_model.php */