<?php
/**
 * user_follows
 *
 * @extends \Model_Crud
 */
namespace UserFollow;
class Model_UserFollow extends \Model_Crud
{
	protected static $_table_name = 'user_follows';
	protected static $_created_at = 'created_at';
	protected static $_updated_at = 'updated_at';
	protected static $_mysql_timestamp = true;
	protected static $_properties = array(
		'id',
		'follower_id',
		'followed_id',
	);
	protected static $_mass_whitelist = array(
		'follower_id',
		'followed_id',
	);

	/**
	 * follow user (insert)
	 *
	 * @param int $action_user_id
	 *        int $follow_user_id
	 */
	public static function follow($action_user_id, $follow_user_id)
	{
		// duplicate check
		if(Selector::is_follower($action_user_id, $follow_user_id))
		{
			throw new \Exception('Already following.', 409);
		}
		$save_data = array(
			'follower_id' => $action_user_id,
			'followed_id' => $follow_user_id,
		);
		self::forge($save_data)->save();
	}

	/**
	 * unfollow user (delete)
	 *
	 * @param int $action_user_id
	 *        int $remove_user_id
	 */
	public static function unfollow($action_user_id, $remove_user_id)
	{
		$follow_data = self::find(array(
			'where' => array(
				'follower_id' => $action_user_id,
				'followed_id' => $remove_user_id,
			),
		));
		// exist check
		if(empty($follow_data))
		{
			throw new \Exception('Follow data not found.', 404);
		}
		// only first data.
		$follow_data[0]->delete();
	}

}
