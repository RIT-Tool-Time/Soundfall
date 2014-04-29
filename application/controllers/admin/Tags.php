<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Tags Controller
 */
class Tags extends CI_Controller {

  /**
   * Constructor
   */
  function __construct()
  {
    parent::__construct();
    $this->load->model('Tags_model');
    $this->load->language('tags');
  }
  
  /**
   * Overview, addition and editing of tags
   */
  public function Index()
  {
    // Enable SSL?
    maintain_ssl($this->config->item("ssl_enabled"));
    
    if(!$this->authentication->is_signed_in())
    {
        redirect('account/sign_in/?continue='.urlencode(base_url().'admin/tags'));
    }
    else
    {
        $data['account'] = $this->Account_model->get_by_id($this->session->userdata('account_id'));
    }
    
    if(!$this->authorization->is_permitted('manage_tags'))
    {
        redirect('account/profile'); 
    }
    
    //get the tags
    $data['tags'] = $this->Tags_model->get();
    
  }
  
  public function create()
  {
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    $this->form_validation->set_rules('tag_name', 'lang:tags_name', 'trim|required|alpha_dash|min_length[2]|max_length[24]|is_unique[tags.name]');
    if($this->form_validation->run())
    {
        $name = $this->input->post('tag_name', TRUE);
        if($this->Tags_model->add($name))
        {
            $data['message'] = 'add_success';
        }
        else
        {
            $data['message'] = 'fail';
        }
    }
    
    $this->Index();
  }
  
  public function update()
  {
    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
    $this->form_validation->set_rules('tag_id', 'id', 'trim|numeric');
    $this->form_validation->set_rules('tag_name', 'lang:tags_name', 'trim|required|alpha_dash|min_length[2]|max_length[24]|is_unique[tags.name]');
    if($this->form_validation->run())
    {
        $id = $this->input->post('tag_id', TRUE);
        $name = $this->input->post('tag_name', TRUE);
        if($this->Tags_model->update($id, $name) == 1)
        {
            $data['message'] = 'update_success';
        }
        else
        {
            $data['message'] = 'fail';
        }
    }
    
    $this->Index();
  }
}