<?php
/**
 * Hybrid Authentication library
 * @package A3M
 * @subpackage Libraries
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'/third_party/Hybrid/Auth.php';

/**
 * Allows to use of Hybrid Authentication
 */
class Hybrid_auth_lib extends Hybrid_Auth
{
    /**
     * Object variables needed by this library
     * @var object
     */
    var $CI, $setup;
    
    /**
     * Constructor
     * @return object
     */
    function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->helper('url_helper');
        
        //get config for Hybrid Auth
        $this->setup = $this->CI->config->item('third_party_auth');
        
        $this->setup['base_url'] = site_url($this->setup['base_url']);
        
        parent::__construct($this->setup);
        //$this->ha = new Hybrid_Auth($this->setup);
        
        log_message('debug', 'Hybrid_Auth_Lib Class Initalized');
    }
    
    /**
     * Enabled providers
     * @param array $provider Providers set in the config file
     */
    function provider_enabled($provider)
    {
        return isset($this->setup['providers'][$provider]) && $this->setup['providers'][$provider]['enabled'];
    }
}
/* End of file Hybrid_auth_lib.php */
/* Location: ./application/libraries/Hybrid_auth_lib.php */