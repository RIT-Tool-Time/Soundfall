<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->library(array('form_validation', 'email'));
    }
    
    public function Index()
    {
        $data['page'] = "about";
        $data['content'] = $this->load->view('email_test', isset($data) ? $data : NULL, TRUE);
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('email', 'email', 'trim|valid_email|xss_clean');
        if($this->form_validation->run())
        {
            $email = $this->input->post('email', TRUE);
            $this->email->from('cascade@rit.edu', 'Cascade');
            $this->email->to($email);
            $this->email->subject('test e-mail from tooltime.cias.rit.edu');
            $this->email->message('Yay! It works!');
            if(!$this->email->send())
            {
                $data['content'] = $this->email->print_debugger();
            }
        }
        $this->load->view('template', $data);
    }
    
    public function resend($id = NULL)
    {
        $this->load->model('Music_model');
        $this->load->language('music');
        if($id != NULL)
        {
            $song = $this->Music_model->get($id);
            //email setup
            $this->email->from('cascade@rit.edu', 'Cascade');
            $this->email->to($song->email);
            if($song->email2 != NULL)
            {
                $this->email->cc($song->email2);
            }
            $this->email->subject(lang('music_add_email_subject'));
            $this->email->message(sprintf(lang('music_add_email_text'), base_url('song/'.$song->id.'/'.$song->file), $song->control_code));
            
            if(!$this->email->send())
            {
                $data['page'] = "about";
                $data['content'] = $this->email->print_debugger();
                $this->load->view('template', $data);
                die();
            }
            else
            {
                echo "Song: " . $song->id . " Send succesfully!<br />";
            }
        }
        else
        {
            $total = $this->Music_model->count_all();
            
            for($i = 1; $i < $total; $i++)
            {
                $song = $this->Music_model->get($i);
                //email setup
                $this->email->from('Stegalldesign@outlook.com', 'Cascade');
                $this->email->to($song->email);
                if($song->email2 != NULL)
                {
                    $this->email->cc($song->email2);
                }
                $this->email->subject(lang('music_add_email_subject'));
                $this->email->message(sprintf(lang('music_add_email_text'), base_url('song/'.$song->id.'/'.$song->file), $song->control_code));
                if(!$this->email->send())
                {
                    $data['page'] = "about";
                    $data['content'] = $this->email->print_debugger();
                    $this->load->view('template', $data);
                    die();
                }
                else
                {
                    echo "Song: " . $song->id . " Send succesfully!<br />";
                }
                sleep(30);
            }
        }
    }
}