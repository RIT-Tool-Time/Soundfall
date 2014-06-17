<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Rel_role_permissions
 *
 * Model for the Rel_role_permissions table.
 * Managing what permissions a role has.
 *
 * @package A3M
 * @subpackage Models
 */
class Rel_role_permission_model extends CI_Model
{

  /**
   * Get all role permissions
   *
   * @access public
   * @return object all account permissions
   */
  function get()
  {
    return $this->db->get($this->db->dbprefix . 'a3m_rel_role_permission')->result();
  }

  /**
   * Get permission details by role id
   *
   * @access public
   * @param int $role_id
   * @return object account details object
   */
  function get_by_role_id($role_id)
  {
    $this->db->select($this->db->dbprefix . 'a3m_acl_permission.*');
    $this->db->from($this->db->dbprefix . 'a3m_rel_role_permission');
    $this->db->join($this->db->dbprefix . 'a3m_acl_permission',$this->db->dbprefix . 'a3m_rel_role_permission.permission_id = '. $this->db->dbprefix . 'a3m_acl_permission.id');
    $this->db->where($this->db->dbprefix . "a3m_rel_role_permission.role_id = $role_id AND ".$this->db->dbprefix . "a3m_acl_permission.suspendedon IS NULL");

    return $this->db->get()->result();

    return $this->db->get()->result();
  }



  /**
   * Get role details by permission id
   *
   * @access public
   * @param int $permission_id
   * @return object account details object
   */
  function get_by_permission_id($permission_id)
  {
    $this->db->select($this->db->dbprefix . 'a3m_acl_role.*');
    $this->db->from($this->db->dbprefix . 'a3m_rel_role_permission');
    $this->db->join($this->db->dbprefix . 'a3m_acl_role', $this->db->dbprefix . 'a3m_rel_role_permission.role_id = '.$this->db->dbprefix . 'a3m_acl_role.id');
    $this->db->where($this->db->dbprefix . "a3m_rel_role_permission.permission_id = $permission_id AND ".$this->db->dbprefix . "a3m_acl_role.suspendedon IS NULL");

    return $this->db->get()->result();
  }

  /**
   * Check if role already has this permission assigned
   *
   * @access public
   * @param int $account_id
   * @param int $permission_id
   * @return object account details object
   */
  function exists($role_id, $permission_id)
  {
    $this->db->from($this->db->dbprefix . 'a3m_rel_role_permission');
    $this->db->where('role_id', $role_id);
    $this->db->where('permission_id', $permission_id);

    return ( $this->db->count_all_results() > 0 );
  }

  // --------------------------------------------------------------------
  
  /**
   * Create a new account permission
   *
   * @access public
   * @param int $role_id
   * @param int $permission_id
   * @return void
   */
  function update($role_id, $permission_id)
  {
    // Insert
    if (!$this->exists($role_id, $permission_id))
    {
      $this->db->insert($this->db->dbprefix . 'a3m_rel_role_permission', array('role_id' => $role_id, 'permission_id' => $permission_id));
    }
  }


  /**
   * Batch update role permissions.
   *
   * @access public
   * @param int $role_id
   * @param array $permission_ids
   * @return void
   */
  function update_batch($role_id, $permission_ids)
  {
    // Blank array, then no insert for you
    if( count($permission_ids) > 0)
    {
      // Create a new batch
      $batch = array();
      foreach($permission_ids as $permission_id)
      {
        $batch[] = array(
          'role_id' => $role_id,
          'permission_id' => $permission_id
          );
      }

      // Insert all the new roles
      $this->db->insert_batch($this->db->dbprefix . 'a3m_rel_role_permission', $batch);
    }
  }

  /**
   * Delete all current permissions and replace with array of permissions passed in.
   *
   * @access public
   * @param int $role_id
   * @param array $permission_ids
   * @return void
   */
  function delete_update_batch($role_id, $permission_ids)
  {
    // Delete all current roles
    $this->delete_by_role($role_id);

    // Batch update the account roles
    $this->update_batch($role_id, $permission_ids);
  }

  /**
   * Delete single instance by account/permission
   *
   * @access public
   * @param int $role_id
   * @param int $permission_id
   * @return void
   */
  function delete($role_id, $permission_id)
  {
    $this->db->delete($this->db->dbprefix . 'a3m_rel_role_permission', array('role_id' => $role_id, 'permission_id' => $permission_id));
  }


  /**
   * Delete all by role id
   *
   * @access public
   * @param int $role_id
   * @return void
   */
  function delete_by_role($role_id)
  {
    $this->db->delete($this->db->dbprefix . 'a3m_rel_role_permission', array('role_id' => $role_id));
  }


  /**
   * Delete all by permissions id
   *
   * @access public
   * @param int $permission_id
   * @return void
   */
  function delete_by_permission($permission_id)
  {
    $this->db->delete($this->db->dbprefix . 'a3m_rel_role_permission', array('permission_id' => $permission_id));
  }
}

/* End of file Rel_role_permission_model.php */
/* Location: ./application/models/account/Rel_role_permission_model.php */