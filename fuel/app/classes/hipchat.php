<?php
/**
 * hipchat access class
 *
 * @dependency
 *  https://github.com/hipchat/hipchat-php
 */
class HipChat
{
	/**
	 * instances
	 */
	protected static $_instance = null;
	protected $_hc = null;

	public static function instance()
	{
		if(static::$_instance === null)
		{
			return static::forge();
		}
		return static::$_instance;
	}

	public static function forge()
	{
		static::$_instance = new static();
		return static::$_instance;
	}

	public function __construct()
	{
		\Config::load('hipchat', true);
		$this->_hc = new \HipChat\HipChat(\Config::get('hipchat.token'));
	}

	/**
	 *
	 * @param mixed $str array or string
	 * @param boolean $notify
	 * @return boolean
	 */
	public function send_message($str, $notify = true)
	{
		if(is_array($str))
		{
			$str = implode("\r\n", $str);
		}
		return $this->_hc->message_room(
			\Config::get('hipchat.room_id'),
			\Config::get('hipchat.from'),
			$str,
			(boolean) $notify,
			\HipChat\HipChat::COLOR_YELLOW,
			\HipChat\HipChat::FORMAT_TEXT
		);
	}

	/**
	 *
	 * @param mixed $str array or string as html
	 * @param boolean $notify
	 * @return boolean
	 */
	public function send_html($str, $notify = true)
	{
		if(is_array($str))
		{
			$str = implode("<br />", $str);
		}
		return $this->_hc->message_room(
			\Config::get('hipchat.room_id'),
			\Config::get('hipchat.from'),
			$str,
			(boolean) $notify,
			\HipChat\HipChat::COLOR_YELLOW,
			\HipChat\HipChat::FORMAT_HTML
		);
	}
}
