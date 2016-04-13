<?php
/**
 * user_follows
 *
 * @extends \Model_Crud
 */
namespace MessageBoard;
class Model_MessageBoard extends \Model_Crud
{
	protected static $_table_name = 'message_boards';
	protected static $_primary_key = 'id';
	protected static $_created_at = 'created_at';
	protected static $_updated_at = 'updated_at';
	protected static $_mysql_timestamp = true;
	protected static $_properties = array(
		'id',
		'type',
		'author_id',
		'user_id',
		'message',
	);
	protected static $_mass_whitelist = array(
		'type',
		'author_id',
		'user_id',
		'message',
	);
	protected static $_rules = array(
	);

	/**
	 * set save rule
	 *
	 * @params array $rules
	 * @return object $this
	 */
	public function set_rules($rules = array())
	{
		if(empty($rules))
		{
			\Config::load('messageboard::messageboard', 'messageboard');
			\Config::load('messageboard', 'messageboard', false, true);
			$rules = \Config::get('messageboard.valid_rule', array());
		}
		static::$_rules = $rules;
		return $this;
	}

}
