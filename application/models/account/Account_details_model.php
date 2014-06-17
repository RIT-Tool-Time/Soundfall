<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Account_details_model
 *
 * Model to retrieve and update more detailed information about user.
 *
 * @package A3M
 * @subpackage Models
 */
class Account_details_model extends CI_Model
{

	/**
	 * Get details for all account
	 *
	 * @access public
	 * @return object details for all accounts
	 */
	function get()
	{
		return $this->db->get($this->db->dbprefix . 'a3m_account_details')->result();
	}

	/**
	 * Get account details by account_id
	 *
	 * @access public
	 * @param string $account_id
	 * @return object account details object
	 */
	function get_by_account_id($account_id)
	{
		return $this->db->get_where($this->db->dbprefix . 'a3m_account_details', array('account_id' => $account_id))->row();
	}

	// --------------------------------------------------------------------

	/**
	 * Update account details
	 *
	 * @access public
	 * @param int   $account_id
	 * @param array $attributes
	 * @return void
	 */
	function update($account_id, $attributes = array())
	{
		if (isset($attributes['firstname'])) if (strlen($attributes['firstname']) > 80) $attributes['firstname'] = substr($attributes['firstname'], 0, 80);
		if (isset($attributes['lastname'])) if (strlen($attributes['lastname']) > 80) $attributes['lastname'] = substr($attributes['lastname'], 0, 80);
		if (isset($attributes['dateofbirth']))
		{
			$this->load->helper('date');
			$attributes['dateofbirth'] = mdate('%Y-%m-%d', strtotime($attributes['dateofbirth']));
		}
		if (isset($attributes['gender']))
		{
			switch (strtolower($attributes['gender']))
			{
				case 'f':
				case 'female':
					$attributes['gender'] = 'f';
					break;
				case 'm':
				case 'male':
					$attributes['gender'] = 'm';
					break;
			}
		}
		// Check that it's a recognized country (see http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2)
		if (isset($attributes['country']))
		{
			$this->load->model('account/ref_country_model');
			$country = $this->ref_country_model->get($attributes['country']);
			$country ? $attributes['country'] = $country->alpha2 : NULL;
		}
		// Check that it's a recognized language (see http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes)
		if (isset($attributes['language']))
		{
			$language = preg_split('/[_-]/', $attributes['language']);
			// Check for valid language
			if (isset($language[0]))
			{
				$this->load->model('account/ref_language_model');
				$language = $this->ref_language_model->get($language[0]);
				$language ? $attributes['language'] = $language->one : NULL;
			}
		}
		// Check that it's a recognized timezone (tz database, see http://en.wikipedia.org/wiki/Zoneinfo)
		if (isset($attributes['timezone']))
		{
			$this->load->model('account/ref_zoneinfo_model');
			$timezone = $this->ref_zoneinfo_model->get_by_zoneinfo($attributes['timezone']);
			$timezone ? $attributes['timezone'] = $timezone->zoneinfo : NULL;

			// Try to guess country based on timezone
			if ( ! isset($attributes['country']))
			{
				$attributes['country'] = $timezone->country;
			}
		}
		// Try to guess timezone based on country
		elseif (isset($attributes['country']))
		{
			$this->load->model('account/ref_zoneinfo_model');
			$result = $this->ref_zoneinfo_model->get_by_country($attributes['country']);
			if (isset($result[0])) $attributes['timezone'] = $result[0]->zoneinfo;
		}

		// Update
		if ($this->get_by_account_id($account_id))
		{
			$this->db->where('account_id', $account_id);
			$this->db->update($this->db->dbprefix . 'a3m_account_details', $attributes);
		}
		// Insert
		else
		{
			$attributes['account_id'] = $account_id;
			$this->db->insert($this->db->dbprefix . 'a3m_account_details', $attributes);
		}
	}

}
/* End of file Account_details_model.php */
/* Location: ./application/models/account/Account_details_model.php */