<?php
/**
 * following system
 *
 * @extends \Controller_Rest
 * @dependency \Auth
 * @return json
 */
namespace UserFollow;
class Controller_UserFollow extends \Controller_Api
{

	protected $format = 'json';

	public function post_index()
	{
		try
		{
			if(\Auth::get('id') === false or strlen(\Input::post('user_id')) === 0)
			{
				throw new \Exception("param error", 403);
			}
			Model_UserFollow::follow(\Auth::get('id'), \Input::post('user_id'));
			return $this->response(array(
				'result' => true,
				'follower_user_id' => intval(\Auth::get('id')),
				'followed_user_id' => intval(\Input::post('user_id'))
			));
		}
		catch(\Exception $e)
		{
			$this->_common_exception_return($e);
		}
	}

	public function post_remove()
	{
		try
		{
			if(\Auth::get('id') === false or strlen(\Input::post('user_id')) === 0)
			{
				throw new \Exception("param error", 403);
			}
			Model_UserFollow::unfollow(\Auth::get('id'), \Input::post('user_id'));
			return $this->response(array(
				'result' => true,
				'remover_user_id' => intval(\Auth::get('id')),
				'removed_user_id' => intval(\Input::post('user_id'))
			));
		}
		catch(\Exception $e)
		{
			$this->_common_exception_return($e);
		}
	}
}
