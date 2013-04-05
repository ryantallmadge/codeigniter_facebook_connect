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
	 * Class Facebook - Used to control the interaction with the facebook API
	 */

	class Facebook extends CI_Controller {

        public $facebook_session;//Will hold the facebook session vars
        public $facebook_loginURL; //Will hold the login URL for redirects
        public $facebook_user; //Will hold the facebook user data till the session takes over

		/**
		 * Start the Facebook class
		 * Include the library's and sessions needed to run the methods in the class
		 */	
		function __construct()
		{
			//Load the parent class data
			parent::__construct();
            //Load the facebook session - Needed for the two way communicate that happens
            $this->facebook_session  = $this->facebook_connect->getSession();
            //Load the user model to store and retrive data from the users database
			$this->load->model('user_model');
			//Load the Facebook API library to communicate with facebook
            $this->load->library('facebook_connect');
		}

		/**
		 * Redirects user if they reach the index by mistake
		 *
		 */ 
		function index()
		{
            redirect(base_url());
		}

		/**
		 * User has asked to by logged in, lets process the request
		 */
		function login()
		{
            //check and see if we have a facebook session
            if(!$this->facebook_session){
                //There's no active session, let's generate one
                //We are getting email for login and creation
                $this->facebook_loginURL = $this->facebook_connect->getLoginUrl(array('req_perms' => 'email,user_birthday,status_update,publish_stream,user_photos,user_videos'));
                //Send the user to the location for them to auth the facebook rules
                redirect($this->facebook_loginURL);
                return true;
            }else{
                //We have a facebook session, lets put the user together
                $this->facebook_userid = $this->facebook_connect->getUser();
                //Get all the public/private info for the user
                $this->facebook_user['userdata'] = $this->facebook_connect->api('/me');
                //set the data for the model
                $session_array = array(
                                       'user_fullname'     => $this->facebook_user['userdata']['name'],
                                       'user_image'        => 'https://graph.facebook.com/'.$this->facebook_user['userdata']['id'].'/picture',
                                       'user_displayname'  => $this->facebook_user['userdata']['username'],
                                       'user_id'           => $this->facebook_user['userdata']['id'],
                                       'user_login_type'   => 'facebook',
                                       'user_date'             => time(),
                                       );
                //Run the model
                $this->user_model->LogInUser($session_array);
                //redirect the user
                redirect(base_url("facebook"));
                return true;
            }
		}

		/**
		 * User has asked to by logged out, kill all sessions
		 */
		function logout()
		{
            if(!$this->facebook_session){
                $this->session->sess_destroy();
                redirect(base_url("facebook"));
            }else{
                $this->session->sess_destroy();
                redirect($this->facebook_connect->getLogoutUrl());
            }
		}
	}