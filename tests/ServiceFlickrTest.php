<?php

/**
 * PHPUnit tests for the Service_Flickr class
 *
 * @package	Service Providers (OAuth)
 * @author	Dave Widmer (dwidmer@bgsu.edu)
 */
class ServiceFlickrTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @var	Service_Flickr
	 */
	public $f;

	public function setUp()
	{
		$this->f = new Service_Flickr("RandomAPIKey", "RandomAPISecret");
	}

	/**
	 * Test for the api and secret on creation
	 */
	public function test_api_values()
	{
		$this->assertSame("RandomAPIKey", $this->f->getKey());
		$this->assertSame("RandomAPISecret", $this->f->getSecret());
	}

	/**
	 * Tests the get/set of the token
	 */
	public function test_token()
	{
		$this->assertNull($this->f->getToken());
		$this->f->setToken("RandomString");
		$this->assertSame("RandomString", $this->f->getToken());
	}

	/**
	 * Test the get/set of the token secret
	 */
	public function test_token_secret()
	{
		$this->assertNull($this->f->getTokenSecret());
		$this->f->setTokenSecret("RandomString");
		$this->assertSame("RandomString", $this->f->getTokenSecret());
	}

	/**
	 * Test the get/set of the verifier
	 */
	public function test_verifier()
	{
		$this->assertNull($this->f->getVerifier());
		$this->f->setVerifier("RandomString");
		$this->assertSame("RandomString", $this->f->getVerifier());
	}

	/**
	 * Checks to see if the session variables are being set correctly
	 */
	public function test_session_access()
	{
		$_SERVER["flickr_token"] = "RandomString";
		$this->assertSame("RandomString", $this->f->getToken());

		$_SERVER["flickr_token_secret"] = "RandomString";
		$this->assertSame("RandomString", $this->f->getTokenSecret());

		$_SERVER["flickr_verifier"] = "RandomString";
		$this->assertSame("RandomString", $this->f->getVerifier());
	}

}
