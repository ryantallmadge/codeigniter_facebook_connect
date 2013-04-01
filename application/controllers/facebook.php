<?php
	class Facebook extends CI_Controller {

        public $facebook_session;//Will hold the facebook session vars
        public $facebook_loginURL; //Will hold the login URL for redirects
        public $facebook_user; //Will hold the facebook user data till the session takes over

		function __construct()
		{
			parent::__construct();
            //Load the facebook session - Needed for the two way communicate that happens
            $this->facebook_session  = $this->facebook_connect->getSession();
            $this->load->model('user_model');
            $this->load->library('facebook_connect');
		}

        //If someone comes to the index redirect them
		function index()
		{
            redirect(base_url());
		}

        //Some has asked to be loged in, lets do it
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

        //Log the user out of facebook session and gstify session
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