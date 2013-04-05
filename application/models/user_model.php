<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
Copyright (C) 2011 by Ryan Tallmadge

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

/**
 * Defines the users interaction with the database.
 */

class user_model extends CI_Model {

	//Hold any data to be returned to the controler
    public $return_data;

	//Start the class by including the parent class
    function __construct()
	{
		parent::__construct();
	}
	
	
	/**
	 * Logs the users into the website by starting a session
	 *
	 * @param array $session_data all parameters that are needed to be logged into the website
	 * @return bool
	 */
 
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

	/**
	 * Create a user account into the database
	 *
	 * @param array $insert_array list of vars to be put into the database
	 * @return bool
	 */	
    public function AddUser($insert_array){
        //Lets check and see if we already have the user in the system
        $run_check_query = $this->db->query("SELECT * FROM users WHERE user_id = ".$this->db->escape($insert_array['user_id']).";");
        if($run_check_query->num_rows() > 0) return true;
        //We dont have the user so lets add them to the system
        $insert_user = $this->db->insert_string('users',$insert_array);
		//If there is an error log it
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