<?php
/**
 * message board api
 *
 * @extends \Controller_Rest
 * @dependency \Auth
 * @return json
 */
namespace MessageBoard;
class Controller_Api extends \Controller_Api
{

	protected $format = 'json';

	public function action_index()
	{
		return $this->response(array(
		));
	}

	public function get_list()
	{
		try
		{
			$message = Selector::get_comments(\Input::get('type', null), \Input::get('author_id', null), \Input::get('page', 1));
		}
		catch(\Exception $e)
		{
			return $this->_common_exception_return($e);
		}
		return $this->response(array(
			'result' => true,
			'data' => $message,
		));
	}

	public function post_post()
	{
		try
		{
			$save_data = array(
				'user_id'   => \Auth::get('id', null),
				'type'      => \Input::post('type', null),
				'author_id' => \Input::post('author_id', null),
				'message'   => \Input::post('message', null),
			);
			$Model_MessageBoard = Model_MessageBoard::forge($save_data)->set_rules();
			if( ! $Model_MessageBoard->save())
			{
				throw new \Exception(\Format::forge($Model_MessageBoard->validation()->error_message())->to_json(), 400);
			}
			// call new data
			$return = Selector::get_comments($save_data['type'], $save_data['author_id']);
		}
		catch(\Exception $e)
		{
			return $this->_common_exception_return($e);
		}
		return $this->response(array(
			'result' => true,
			'data' => $return,
		));

	}

	public function post_edit()
	{
		try
		{
			$Model_MessageBoard = Model_MessageBoard::find_by_pk(\Input::post('id', null));
			if(empty($Model_MessageBoard))
			{
				throw new \Exception('No data', 404);
			}
			if(intval($Model_MessageBoard->user_id) != intval(\Auth::get('id')))
			{
				throw new \Exception('You can\'t edit this message.', 403);
			}
			$Model_MessageBoard->message = \Input::post('message');
			if( ! $Model_MessageBoard->save())
			{
				throw new \Exception($Model_MessageBoard->validation()->error_message(), 400);
			}
		}
		catch(\Exception $e)
		{
			return $this->_common_exception_return($e);
		}
		return $this->response(array(
			'result' => true,
		));
	}

	public function delete_remove()
	{
		try
		{
			$Model_MessageBoard = Model_MessageBoard::find_by_pk(\Input::delete('id', null));
			if(empty($Model_MessageBoard))
			{
				throw new \Exception('No data', 404);
			}
			if(intval($Model_MessageBoard->user_id) != intval(\Auth::get('id')))
			{
				throw new \Exception('You can\'t delete this message.', 403);
			}
			$Model_MessageBoard->delete();
		}
		catch(\Exception $e)
		{
			return $this->_common_exception_return($e);
		}
		return $this->response(array(
			'result' => true,
		));
	}

}
