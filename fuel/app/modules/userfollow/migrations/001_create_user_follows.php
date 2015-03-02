<?php
/**
 * create all table for Oisyna
 *
 *
 */
namespace Fuel\Migrations;
class Create_user_follows
{
	function up()
	{
		// -------------------------
		// user_follows
		// -------------------------
		\DBUtil::create_table(
			'user_follows',
			array(
				'id' => array(
					'type' => 'int',
					'constraint' => 10,
					'unsigned' => true,
					'auto_increment' => true,
				),
				'follower_id' => array(
					'type' => 'int',
					'constraint' => 10,
					'unsigned' => true,
					'comment' => 'フォローした側のユーザID',
				),
				'followed_id' => array(
					'type' => 'int',
					'constraint' => 10,
					'unsigned' => true,
					'comment' => 'フォローされた側のユーザID',
				),
				'created_at' => array(
					'type' => 'datetime',
					'null' => true,
				),
				'updated_at' => array(
					'type' => 'datetime',
					'null' => true,
				),
				'timestamp' => array(
					'type' => 'timestamp',
					'default' => \DB::expr('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
				),
			),
			array('id'),
			true,
			'InnoDB',
			'utf8'
		);
		\DBUtil::create_index(
			'user_follows',
			'followed_id',
			'idx_user_follows_followed_id'
		);
		\DBUtil::create_index(
			'user_follows',
			'follower_id',
			'idx_user_follows_follower_id'
		);
		\DBUtil::create_index(
			'user_follows',
			array('follower_id', 'followed_id'),
			'idx_user_follows_mul01',
			'unique'
		);
	}

	function down()
	{
		\DBUtil::drop_table('user_follows');
	}
}
