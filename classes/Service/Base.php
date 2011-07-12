<?php

/**
 * The Service class is the foundation for all OAuth Service Providers
 *
 * @package	Service Providers (OAuth)
 * @author	Dave Widmer (dwidmer@bgsu.edu)
 */
class Service_Base extends HTTP_OAuth_Consumer
{
	/**
	 * @var	string	The callback url for OAuth Authorization 
	 */
	public static $callback = "oob";

	/**
	 * @var	string	The url to get a request token
	 */
	public $request_url = "";

	/**
	 * @var	string	The url to authorize the user
	 */
	public $auth_url = "";

	/**
	 * @var	string	The url to change the request token for an access token
	 */
	public $access_url = "";

	/**
	 * @var	string	The endpoint url for the web service
	 */
	public $endpoint = "";

	/**
	 * @var	string	The verifier from the OAuth provider
	 */
	public $verifier = null;

	/**
	 * @var	string	The prefix
	 */
	public $prefix = "";

	/**
	 * @var	HTTP_OAuth_Consumer
	 */
	protected $consumer = null;

	/**
	 * Creates a new Service instance.
	 *
	 * @param	string	The API Key
	 * @param	string	The API Secret
	 * @param	string	The OAuth Token
	 * @param	string	The OAuth Token Secret
	 */
	public function __construct($key, $secret, $token = null, $tokenSecret = null)
	{
		if (session_id() === "")
		{
			session_start();
		}

		// Check to see if the sessions variables are set already
		if ($token === null)
		{
			$token = $this->getToken();
		}

		if ($tokenSecret === null)
		{
			$tokenSecret = $this->getTokenSecret();
		}

		parent::__construct($key, $secret, $token, $tokenSecret);
	}

	/**
	 * Runs a call to the service.
	 * If the user isn't authenticated, it will attempt to do that first.
	 *
	 * @param	string	The name of the service function to call
	 * @param	array	Any additional parameters to add
	 * @return	string	The response in raw format (json|xml|etc..)
	 */
	public function call($name, array $params = array())
	{
		if ( ! $this->consumer && ! $this->getConsumer())
		{
			$this->requestToken();
		}
		else
		{
			// Default to json w/o callback if nothing is specified
			if ( ! isset($params['format']))
			{
				$params['format'] = "json";
				$params['nojsoncallback'] = 1;
			}

			$params['method'] = $name;

			$r = $this->consumer->sendRequest($this->endpoint, $params);
			$r->getResponse()->getBody();
		}
	}

	/**
	 * Attempts to get the consumer that is logged in.
	 *
	 * @return	boolean	Has consumer been found?
	 */
	protected function getConsumer()
	{
		if ($this->verifier === null)
		{
			return false;
		}

		$this->consumer = new HTTP_OAuth_Consumer($this->key, $this->secret, $this->token, $this->tokenSecret);

		$this->consumer->getAccessToken($this->access_url, $this->verifier);
		$this->setToken($this->consumer->getToken());
		$this->setTokenSecret($this->consumer->getTokenSecret());
		return true;
	}

	/**
	 * Sends a request to the OAuth provider to get a request token.
	 * This function redirects to the authorize url.
	 */
	protected function requestToken()
	{
		$r = new HTTP_OAuth_Consumer($this->key, $this->secret);
		$r->getRequestToken($this->request_url, self::$callback);

		$this->setToken($r->getToken());
		$this->setTokenSecret($r->getTokenSecret());

		header('Location: '.$r->getAuthorizeUrl($this->auth_url));
	}

	/**
	 * Gets the token.
	 *
	 * @return	string	The token
	 */
	public function getToken()
	{
		if ($this->token === null)
		{
			if (isset($_SERVER["{$this->prefix}_token"]))
			{
				$this->token = $_SERVER["{$this->prefix}_token"];
			}
		}

		return $this->token;
	}

	/**
	 * Sets the token.
	 *
	 * @param	string	The token value
	 */
	public function setToken($value)
	{
		$_SERVER["{$this->prefix}_token"] = $value;
		parent::setToken($value);
	}

	/**
	 * Gets the token secret.
	 *
	 * @return	string	The token secret
	 */
	public function getTokenSecret()
	{
		if ($this->tokenSecret === null)
		{
			if (isset($_SERVER["{$this->prefix}_token_secret"]))
			{
				$this->tokenSecret = $_SERVER["{$this->prefix}_token_secret"];
			}
		}

		return $this->tokenSecret;
	}

	/**
	 * Sets the token secret.
	 *
	 * @param	string	The token secret value
	 */
	public function setTokenSecret($value)
	{
		$_SERVER["{$this->prefix}_token_secret"] = $value;
		parent::setTokenSecret($value);
	}

	/**
	 * Gets the oauth verifier
	 *
	 * @return	string	The verifier or null
	 */
	public function getVerifier()
	{
		if ($this->verifier === null)
		{
			if (isset($_SERVER["{$this->prefix}_verifier"]))
			{
				$this->verifier = $_SERVER["{$this->prefix}_verifier"];
			}
		}

		return $this->verifier;
	}

	/**
	 * Sets the oauth verifier.
	 *
	 * @param	string	The verifier value
	 */
	public function setVerifier($value)
	{
		$_SERVER["{$this->prefix}_verifier"] = $value;
		$this->verifier = $value;
	}

}
