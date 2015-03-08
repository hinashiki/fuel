<?php
/**
 * Queue wrapper
 */
class Model_TaskQueue extends \Queue\Model_TaskQueue
{
	/**
	 * @override
	 */
	public static function notify($msg)
	{
		\HipChat::forge()->send_message($msg);
	}
}
