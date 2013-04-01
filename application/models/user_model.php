<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class user_model extends CI_Model {

    public $return_data;

    function __construct()
	{
		parent::__construct();
	}

    //Log a user in
    public function LogInUser($session_data){
        //Let see if we can add the user
        if(!$this->AddUser($session_data)){
          return false;
        }
        //Set the session for the user
        $this->session->set_userdata('userdata', $session_data);
        //return true
        return true;
    }

    public function AddUser($insert_array){
        //Lets check and see if we already have the user in the system
        $run_check_query = $this->db->query("SELECT * FROM users WHERE user_id = ".$this->db->escape($insert_array['user_id']).";");
        if($run_check_query->num_rows() > 0) return true;
        //We dont have the user so lets add them to the system
        $insert_user = $this->db->insert_string('users',$insert_array);
        if(!$this->db->query($insert_user)){
            log_message(
                        'error',
                        $this->db->_error_number()  . ':' .
                        $this->db->_error_message() . ':' .
                        $this->db->last_query()
                        );
            return false;
        }
     return true;
    }

}

/* End of file user_model.php */
/* Location: ./application/models/user_model.php */