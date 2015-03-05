<?php
/**
 * for appliation api
 *
 */
class Controller_Api extends \Controller_Rest
{
	protected $format = 'json';
	protected $_return_data = array(
		'result' => true,
		'reason' => null,
		'data'   => array(),
	);

	/**
	 * @overwrap
	 */
	public function before()
	{
		parent::before();
		// set Cache-Control : no-cache to header in POST
		// @see http://dev.classmethod.jp/smartphone/ios6-safari-post-jquery/
		if( ! empty(\Input::post()))
		{
			$this->response->set_header('Cache-Control', 'no-cache');
		}
		// set Access-Control-Allow-Origin
		// @see https://developer.mozilla.org/ja/docs/HTTP_access_control
		$this->response->set_header('Access-Control-Allow-Origin', \Uri::base());
	}
	/**
	 * @overwrap
	 */
	public function after($response)
	{
		// overwrap to $this->_return_data if $response is empty
		if(empty($response))
		{
			$response = $this->response($this->_return_data);
		}
		return parent::after($response);
	}
	/**
	 * @overwrap
	 */
	public function router($resource, $arguments)
	{
		try
		{
			return parent::router($resource, $arguments);
		} catch(\Exception $e)
		{
			$this->_common_exception_return($e);
		}
	}

	protected function _common_exception_return(\Exception $e)
	{
		$code = 500;
		if($e->getCode() >= 400 and $e->getCode() < 600)
		{
			$code = $e->getCode();
		}
		if(\DB::in_transaction())
		{
			\DB::rollback_transaction();
		}
		$this->response->status = $code;
		$this->_return_data['result'] = false;
		$this->_return_data['reason'] = $e->getMessage();
	}
}
