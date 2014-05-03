<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music_tags_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Summary
     * @param Numeric $song_id Song id
     * @return Array  Array list of the tags ids
     */
    public function get_by_song($song_id)
    {
        return $this->db->get_where('music_tags', array('music_id' => $song_id))->result();
    }
    
    /**
     * Adds tag to a given song
     * @param Numeric $song_id
     * @param Numeric $tag_id
     */
    public function add_to_song($song_id, $tag_id)
    {
        $this->db->insert('music_tags', array('music_id' => $song_id, 'tag_id' => $tag_id));
        return $this->db->affected_rows();
    }
    
    /**
     * @param Numeric $song_id
     * @param Numeric $tag_id
     */
    public function remove_tag_from_song($song_id, $tag_id)
    {
        $this->db->where('music_id', $song_id);
        $this->db->where('tag_id', $tag_id);
        $this->db->delete('music_tags');
        return $this->db->affected_rows();
    }
}
/* End of file Music_tags_model.php */
/* Location: ./application/models/Music_tags_model.php */