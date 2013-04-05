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

       //Facebook AppID
	define('facebook_app_id','xxxxxxx');
      //Facebook API Secret
	define('facebook_api_secret','xxxxxxx');
     //Define all the information you want to get from the user
	define('facebook_default_scope','user_about_me,user_location,user_status,email,publish_actions,offline_access,read_friendlists'); // E.G 'read_stream,birthday,users_events,rsvp_event'
       //Graph URL
	define('facebook_api_url','https://graph.facebook.com/'); // Just in case it changes.