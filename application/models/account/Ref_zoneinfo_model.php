<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Ref_zoneinfo
 *
 * Model for the Ref_zoneinfo table.
 * Refferencing timezone information.
 *
 * @package A3M
 * @subpackage Models
 */
class Ref_zoneinfo_model extends CI_Model
{

	/**
	 * Get by zoneinfo
	 *
	 * @access public
	 * @param string $zoneinfo
	 * @return object
	 */
	function get_by_zoneinfo($zoneinfo)
	{
		$this->db->where('zoneinfo', $zoneinfo);
		$query = $this->db->get($this->db->dbprefix . 'ref_zoneinfo');
		if ($query->num_rows()) return $query->row();
	}

	// --------------------------------------------------------------------

	/**
	 * Get by country
	 *
	 * @access public
	 * @param string $country
	 * @return object
	 */
	function get_by_country($country)
	{
		$this->db->where('country', $country);
		$query = $this->db->get($this->db->dbprefix . 'ref_zoneinfo');
		if ($query->num_rows()) return $query->result();
	}

	// --------------------------------------------------------------------

	/**
	 * Get all ref zoneinfo
	 *
	 * @access public
	 * @return object
	 */
	function get_all()
	{
		$this->db->order_by('zoneinfo', 'asc');
		return $this->db->get($this->db->dbprefix . 'ref_zoneinfo')->result();
	}

}
/* End of file Ref_zoneinfo_model.php */
/* Location: ./application/models/account/Ref_zoneinfo_model.php */