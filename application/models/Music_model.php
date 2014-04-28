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
     * @param String $name Song name
     * @param String $file File name
     * @param String $control_code 5 letter control code for claiming the song
     * @param String $email E-mail of the first player
     * @param String $email2 E-mail of the second player
     * @param Boolean $private Is the song private?
     * @param String $picture Picture for the song
     * @param Array $tags Array of tags assigned to this song
     * @param Numeric $owner ID of the first player
     * @param Numeric $owner2 ID of the second player
     * @param String $description Description for the song
     * @return Numeric Returns insert id
     */
    public function add($name, $file, $control_code, $email, $email2 = NULL, $private = FALSE, $picture = NULL, $tags = NULL, $owner = NULL, $owner2 = NULL, $description = NULL)
    {
        if($tags != NULL)
        {
            //change the tags array to string
            $tags = serialize($tags);
        }
        
        $this->load->helper('date');
        $this->db->insert('music', array('owner' => $owner, 'owner2' => $owner2, 'email' => $email, 'email2' => $email2, 'name' => $name, 'description' => $description, 'picture' => $picture, 'date' => now(), 'file' => $file, 'tags' => $tags, 'private' => $private, 'control_code' => $control_code));
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
     * @param String $email2
     * @param Boolean $private
     * @return Numeric Number of affected rows (should be 1)
     */
    public function update($id, $name = NULL, $tags = NULL, $description = NULL, $owner = NULL, $owner2 = NULL, $email = NULL, $email2 = NULL, $private = NULL)
    {
        $song = $this->db->get_where('music', array('id' => $id))->row();
        
        if($name == NULL)
        {
            $name = $song->name;
        }
        
        if($description == NULL)
        {
            $description = $song->description;
        }
        
        if($owner == NULL)
        {
            $owner = $song->owner;
        }
        
        if($owner2 == NULL)
        {
            $owner2 = $song->owner2;
        }
        
        if($email == NULL)
        {
            $email = $song->email;
        }
        
        if($email2 == NULL)
        {
            $email2 = $song->email2;
        }
        
        if($private == NULL)
        {
            $private = $song->private;
        }
        
        $update = array('owner' => $owner, 'owner2' => $owner2, 'email' => $email, 'email2' => $email2, 'name' => $name, 'description' => $description, 'tags' => $tags, 'private' => $private);
        if($tags != NULL)
        {
            //change the tags array to string
            $update['tags'] = serialize($tags);
        }
        else
        {
            $tags = $song->tags;
        }
        
        $this->db->where('id', $id);
        $this->db->update('music', $update);
        return $this->db->affected_rows();
    }
    
    /**
     * Will look up songs by name
     * @param String $name Search for the song name
     * @param Array $tags Search by tags
     */
    public function find($name = NULL, $tags = NULL, $number = 10, $offset = 0)
    {
        if($name == NULL && $tags == NULL)
        {
            return NULL;
        }
        
        $this->db->order_by('date', 'DESC');
        $this->db->limit($number, $offset);
        
        if($name != NULL)
        {
            $this->db->like('name', $name);
        }
        
        if($tags != NULL)
        {
            foreach($tags as $tag)
            {
                $this->db->like('tags', $tag);
            }
        }
        
        $results = $this->db->get('music')->result();
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
    
    /**
     * Add one play to the given song
     * @param Numeric $id The song id
     */
    public function add_play($id)
    {
        $music = $this->db->get_where('music', array('id' => $id))->row();
        if($music == NULL)
        {
            return FALSE;
        }
        $music->plays = $music->plays + 1;
        $this->db->where('id', $id);
        $this->db->update('music', array('plays' => $music->plays));
        return $this->db->affected_rows();
    }
    
    /**
     * Checks if the control code is correct for the given song
     * @param Numeric $id Song id
     * @param Numeric $user_id The user id
     * @param String $code Control Code
     * @return Boolean
     */
    public function control_code_confirm($id, $user_id, $code)
    {
        $code = strtoupper($code);
        $result = $this->db->get_where('music', array ('id' => $id))->row();
        if($result->control_code == $code)
        {
            //assign the song to the user
            $this->db->where('id', $id);
            if($result->owner == NULL)
            {
                $this->db->update('music', array('owner' => $user_id));
            }
            elseif($result->owner != NULL && $result->owner2 == NULL)
            {
                $this->db->update('music', array('owner2' => $user_id));
            }
            else
            {
                //this should not happen
                return FALSE;
            }
            
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
}

/* End of file Music_model.php */
/* Location: ./application/models/Music_model.php */