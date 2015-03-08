<?php
/**
 * push queue from ajax
 *
 * @method post
 */
class Controller_Queue extends \Controller_Rest
{

	protected $format = 'json';

	public function post_index()
	{
		if(\Package::loaded('fuelphp-queue') && \Input::post('method') and \Input::post('args'))
		{
			$args = \Input::post('args');
			// if include ${author_id}, change to Auth::get('id')
			$auth_num = array_search('${author_id}', $args);
			if(\Package::loaded('auth') && $auth_num !== false)
			{
				$args[$auth_num] = \Auth::get('id');
			}
			$result = true;
			try
			{
				if( ! in_array(\Input::post('method'), \Config::get('queue.api_accessible_method')))
				{
					throw new \Exception('not allowed method.');
				}
				\Model_TaskQueue::save_queue(
					\Input::post('method'),
					$args,
					\Input::post('type', 0)
				);
			}
			catch(\Exception $e)
			{
				$result = false;
				$response->set_status(404);
			}
			return $this->response(compact($result));
		}
		else
		{
			throw new \HttpNotFoundException();
		}
	}

}
