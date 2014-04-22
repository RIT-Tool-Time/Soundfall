<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Music_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Get the music file info by id
     * @param Number $id
     * @return object
     */
    public function get($id)
    {
        $song = $this->db->get_where('music', array('id' => $id))->row();
        if($song->tags != NULL)
        {
            $song->tags = unserialize($song->tags);
        }
        return $song;
    }
    
    /**
     * Get certain number of the latest addition with the given offset
     * @param Number $number How many songs should be returned
     * @param Number $offset Offset (If we have 10 songs per page then second page should have offset of 10)
     * @return object
     */
    public function get_batch($number = 10, $offset = 0)
    {
        $this->db->order_by('date', 'DESC');
        $this->db->limit($number, $offset);
        $results = $this->db->get('music')->result();
        foreach($results AS $song)
        {
            if($song->tags != NULL)
            {
                $song->tags = unserialize($song->tags);
            }
        }
        return $results;
    }
    
    /**
     * Counts all songs in the DB
     * @return int
     */
    public function count_all()
    {
        return $this->db->count_all('music');
    }
    
    /**
     * Get songs by the given artist
     * @param Number $id Artist ID
     * @param Number $number How many should we get
     * @param Number $offset What is the offset
     * @return object
     */
    public function get_by_artist($id, $number = 10, $offset = 0)
    {
        $this->db->order_by('date', 'DESC');
        $this->db->limit($number, $offset);
        $this->db->where('owner', $id);
        $this->db->or_where('owner2', $id);
        return $this->db->get('music')->result();
    }
    
    /**
     * Count all songs by the given artist
     * @param Number $id
     * @return Number
     */
    public function count_by_artist($id)
    {
        $this->db->where('owner', $id);
        $this->db->or_where('owner2', $id);
        $this->db->from('music');
        return $this->db->count_all_results();
    }
    
    /**
     * Adds one download to the download count
     * @param Numeric $id Song id
     */
    public function download($id)
    {
        $current = $this->db->get_where('music', array('id' => $id))->row();
        
        $count = $current->downloads + 1;
        
        $this->db->where('id', $id);
        return $this->db->update('music', array('downloads' => $count));
    }
    
    /**
     * Add a new song to the library
     * @param String $name Description
     * @param String $file Description
     * @param String $email Description
     * @param Boolean $private Description
     * @param String $picture Description
     * @param Array $tags Description
     * @param Numeric $owner Description
     * @param Numeric $owner2 Description
     * @param String $description Description
     * @return object  Description
     */
    public function add($name, $file, $email, $private = FALSE, $picture = NULL, $tags = NULL, $owner = NULL, $owner2 = NULL, $description = NULL)
    {
        if($tags != NULL)
        {
            //change the tags array to string
            $tags = serialize($tags);
        }
        
        $this->load->helper('date');
        $this->db->insert('music', array('owner' => $owner, 'owner2' => $owner2, 'email' => $email, 'name' => $name, 'description' => $description, 'picture' => $picture, 'date' => now(), 'file' => $file, 'tags' => $tags, 'private' => $private));
        return $this->db->insert_id();
    }
    
    /**
     * Update song data
     * @param Numeric $id
     * @param String $name
     * @param Array $tags
     * @param String $description
     * @param Numeric $owner
     * @param Numeric $owner2
     * @param String $email
     * @param Boolean $private
     */
    public function update($id, $name = NULL, $tags = NULL, $description = NULL, $owner = NULL, $owner2 = NULL, $email = NULL, $private = NULL)
    {
        if($tags != NULL)
        {
            //change the tags array to string
            $update['tags'] = serialize($tags);
        }
        
        $this->db->where('id', $id);
        $this->db->update('music', $update);
    }
    
    /**
     * Will look up songs by name
     * @param String $name Search for the song name
     * @param String $tags Search by tags
     */
    public function find($name = NULL, $tags = NULL, $number = 10, $offset = 0)
    {
        if($name == NULL && $tags == NULL)
        {
            return NULL;
        }
        
        $this->db->order_by('date', 'DESC');
        $this->db->limit($number, $offset);
        
        if($title != NULL)
        {
            $this->db->like('name', $name);
        }
        
        if($tags != NULL)
        {
            $this->db->like('tags', $tags);
        }
        
        $results = $this->db->get('music')->result;
        if($results != NULL)
        {
            foreach($results AS $song)
            {
                if($song->tags != NULL)
                {
                    $song->tags = unserialize($song->tags);
                }
            }
            return $results;
        }
        else
        {
            return NULL;
        }
        
    }
}

/* End of file Music_model.php */
/* Location: ./application/models/Music_model.php */