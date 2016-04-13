<?php
namespace MessageBoard;
class Selector
{
	/**
	 * get comments
	 *
	 * @param int $type
	 *        int $author_id
	 *        int $page
	 *
	 * @return array
	 */
	public static function get_comments($type, $author_id, $page = 1)
	{
		\Config::load('messageboard::messageboard', 'messageboard');
		\Config::load('messageboard', 'messageboard', false, true);
		$limit = \Config::get('messageboard.limit', 100);
		$select = array(
			'users.*',
		);
		// 値の重複を避けるために無理矢理prefixを指定
		$mboard_columns = array(
			'id',
			'type',
			'author_id',
			'user_id',
			'message',
			'created_at',
			'updated_at',
			'timestamp',
		);
		foreach($mboard_columns as $column)
		{
			$select[] = array('message_boards.'.$column, 'message_boards__'.$column);
		}
		$offset = ($page - 1) * $limit;
		$query = \DB::select_array($select);
		$query->from('message_boards')
			->join('users', 'INNER')
			->on('users.id', '=', 'message_boards.user_id')
			->where('message_boards.type', $type)
			->where('message_boards.author_id', $author_id)
			->order_by('message_boards.id', 'DESC')
			->limit($limit)
			->offset($offset);
		foreach(\Config::get('messageboard.add_where', array()) as $where)
		{
			// TODO: 複雑なDB処理が必要な場合はまた別途改修します
			$query->where($where);
		}
		return $query->execute()->as_array();
	}

	public static function get_comment_count($type, $author_id)
	{
		\Config::load('messageboard::messageboard', 'messageboard');
		\Config::load('messageboard', 'messageboard', false, true);
		$query = \DB::select(\DB::expr('COUNT(*) as cnt'));
		$query->from('message_boards')
			->join('users', 'INNER')
			->on('users.id', '=', 'message_boards.user_id')
			->where('message_boards.type', $type)
			->where('message_boards.author_id', $author_id);
		foreach(\Config::get('messageboard.add_where', array()) as $where)
		{
			// TODO: 複雑なDB処理が必要な場合はまた別途改修します
			$query->where($where);
		}
		$result = $query->execute()->as_array();
		return $result[0]['cnt'];
	}
}
