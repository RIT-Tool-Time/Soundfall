<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tags_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Gets all tags
     */
    public function get_all()
    {
        return $this->db->get('tags')->result;
    }
    
    /**
     * Gets a specific tag by id
     * @param Numeric $id
     */
    public function get($id)
    {
        return $this->db->get_where('tags', array('id', $id))->row();
    }
    
    /**
     * Update the given tag
     * @param Numeric $id
     * @param String $name
     */
    public function update($id, $name)
    {
        $this->db->where('id', $id)->update('tags', array('name' => $name));
        return $this->db->affected_rows();
    }
    
    /**
     * Adds a new tag
     * @param String $name
     */
    public function add($name)
    {
        $this->db->insert('tags', array('name' => $name));
        return $this->db->insert_id();
    }
    
    /**
     * Deletes a given tag
     * @param Numeric $id
     */
    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('music');
        return $this->db->affected_rows();
    }
}
/* End of file Tags_model.php */
/* Location: ./application/models/Tags_model.php */