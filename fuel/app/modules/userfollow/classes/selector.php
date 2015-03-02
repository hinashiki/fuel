<?php
namespace UserFollow;
class Selector
{
	private static $__limit = 0;

	/**
	 * init
	 *
	 * @return void
	 */
	private static function __init()
	{
		\Config::load('userfollow::userfollow', 'userfollow');
		self::$__limit = \Config::get('userfollow.limit', 100);
	}

	/**
	 *
	 * @param int $your_user_id
	 *        mixed $target_user_id int or array
	 * @return mixed boolean | array
	 */
	public static function is_follower($your_user_id, $target_user_id)
	{
		$query = \DB::select('id', 'followed_id')
			->from('user_follows')
			->where('follower_id', $your_user_id);
		if(is_array($target_user_id))
		{
			$query->where('followed_id', 'IN', $target_user_id);
			$result = $query->execute()->as_array();
			$return = array_flip($target_user_id);
			foreach($return as $k => &$v)
			{
				$v = false;
			}
			foreach($result as $r)
			{
				if(isset($return[$r['followed_id']]))
				{
					$return[$r['followed_id']] = true;
				}
			}
			return $return;
		}
		else
		{
			$query->where('followed_id', $target_user_id);
			$result = $query->execute();
			return (count($result) > 0);
		}
	}

	/**
	 *
	 * @param int $your_user_id
	 *        mixed $target_user_id int or array
	 * @return mixed boolean | array
	 */
	public static function is_followed($your_user_id, $target_user_id)
	{
		$query = \DB::select('id', 'follower_id')
			->from('user_follows')
			->where('followed_id', $your_user_id);
		if(is_array($target_user_id))
		{
			$query->where('follower_id', 'IN', $target_user_id);
			$result = $query->execute()->as_array();
			$return = array_flip($target_user_id);
			foreach($return as $k => &$v)
			{
				$v = false;
			}
			foreach($result as $r)
			{
				if(isset($return[$r['follower_id']]))
				{
					$return[$r['follower_id']] = true;
				}
			}
			return $return;
		}
		else
		{
			$query->where('follower_id', $target_user_id);
			$result = $query->execute();
			return (count($result) > 0);
		}
	}

	/**
	 * $user_idがフォローしているユーザIDの取得
	 *
	 * @return array
	 */
	public static function get_followers($user_id, $page = 1)
	{
		self::__init();
		$result = \DB::select('followed_id')
			->from('user_follows')
			->where('follower_id', $user_id)
			->limit(self::$__limit)
			->offset(($page -1) * self::$__limit)
			->execute()->as_array();
		return \Arr::pluck($result, 'followed_id');
	}

	/**
	 * $user_idがフォローしているユーザの取得（count）
	 *
	 * @return int
	 */
	public static function get_followers_count($user_id)
	{
		$result = \DB::select(\DB::expr('COUNT(id) as cnt'))
			->from('user_follows')
			->where('follower_id', $user_id)
			->execute()->as_array();
		return $result[0]['cnt'];
	}

	/**
	 * $user_idがフォローされているユーザIDの取得
	 *
	 * @return array
	 */
	public static function get_followeds($user_id, $page = 1)
	{
		self::__init();
		$result = \DB::select('follower_id')
			->from('user_follows')
			->where('followed_id', $user_id)
			->limit(self::$__limit)
			->offset(($page -1) * self::$__limit)
			->execute()->as_array();
		return \Arr::pluck($result, 'follower_id');
	}

	/**
	 * $user_idがフォローされているユーザの取得（count）
	 *
	 * @return int
	 */
	public static function get_followeds_count($user_id)
	{
		$result = \DB::select(\DB::expr('COUNT(id) as cnt'))
			->from('user_follows')
			->where('followed_id', $user_id)
			->execute()->as_array();
		return $result[0]['cnt'];
	}

}
