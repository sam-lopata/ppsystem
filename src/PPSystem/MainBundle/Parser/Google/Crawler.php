<?php
namespace PPSystem\MainBundle\Parser\Google;

//use Symfony\Component\BrowserKit\Client;
//use Symfony\Component\BrowserKit\History;
//use Symfony\Component\BrowserKit\CookieJar;
//use Symfony\Component\BrowserKit\Request;
//use Symfony\Component\BrowserKit\Response;

class Crawler 
{
//	protected $nextResponse = null;
//	protected $nextScript = null;
//
//	public function setNextResponse(Response $response)
//	{
//		$this->nextResponse = $response;
//	}
//
//	public function setNextScript($script)
//	{
//		$this->nextScript = $script;
//	}
//
//	protected function doRequest($request)
//	{
//		if (null === $this->nextResponse)
//		{
//			return new Response();
//		}
//		else
//		{
//			$response = $this->nextResponse;
//			$this->nextResponse = null;
//
//			return $response;
//		}
//	}
//
//	protected function getScript($request)
//	{
//		$r = new \ReflectionClass('Symfony\Components\BrowserKit\Response');
//		$path = $r->getFileName();
//
//		return <<<EOF
//<?php
//
//require_once('$path');
//
//echo serialize($this->nextScript);
//EOF;
//	}
	
}