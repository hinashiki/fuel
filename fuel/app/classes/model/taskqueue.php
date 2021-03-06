<?php
/**
 * Queue wrapper
 */
class Model_TaskQueue extends \Queue\Model_TaskQueue
{

	/**
	 * @override
	 */
	protected static $_observers = array(
		'Orm\\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => true,
			'property' => 'created_at',
		),
		'Orm\\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => true,
			'property' => 'updated_at',
		),
	);

	/**
	 * @override
	 */
	public static function notify($msg)
	{
		\HipChat::forge()->send_message($msg);
	}
}
