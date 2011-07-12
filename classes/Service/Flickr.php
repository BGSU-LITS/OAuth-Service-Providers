<?php

/**
 * Service information for Flickr
 *
 * @package	Service Providers (OAuth)
 * @author	Dave Widmer (dwidmer@bgsu.edu)
 */
class Service_Flickr extends Service_Base
{
	public $request_url = "http://www.flickr.com/services/oauth/request_token";
	public $auth_url = "http://www.flickr.com/services/oauth/authorize";
	public $access_url = "http://www.flickr.com/services/oauth/access_token";
	public $endpoint = "http://api.flickr.com/services/rest/";
	public $prefix = "flickr";
}
