<?php
/**
 * following system
 *
 * @extends \Controller_Rest
 * @dependency \Auth
 * @return json
 */
namespace UserFollow;
class Controller_UserFollow extends \Controller_Rest
{

	protected $format = 'json';

	public function post_index()
	{
		if(\Auth::get('id') === false or strlen(\Input::post('user_id')) === 0)
		{
			$this->response->status = 403;
			return $this->response(array(
				'result' => false,
			));
		}
		try
		{
			Model_UserFollow::follow(\Auth::get('id'), \Input::post('user_id'));
			return $this->response(array(
				'result' => true,
				'follower_user_id' => intval(\Auth::get('id')),
				'followed_user_id' => intval(\Input::post('user_id'))
			));
		}
		catch(\Exception $e)
		{
			$code = 500;
			if($e->getCode() >= 400 and $e->getCode() < 600)
			{
				$code = $e->getCode();
			}
			$this->response->status = $code;
			return $this->response(array(
				'result' => false,
				'reason' => $e->getMessage(),
			));
		}
	}

	public function post_remove()
	{
		if(\Auth::get('id') === false or strlen(\Input::post('user_id')) === 0)
		{
			$this->response->status = 403;
			return $this->response(array(
				'result' => false,
			));
		}
		try
		{
			Model_UserFollow::unfollow(\Auth::get('id'), \Input::post('user_id'));
			return $this->response(array(
				'result' => true,
				'remover_user_id' => intval(\Auth::get('id')),
				'removed_user_id' => intval(\Input::post('user_id'))
			));
		}
		catch(\Exception $e)
		{
			$code = 500;
			if($e->getCode() >= 400 and $e->getCode() < 600)
			{
				$code = $e->getCode();
			}
			$this->response->status = $code;
			return $this->response(array(
				'result' => false,
				'reason' => $e->getMessage(),
			));
		}
	}
}
