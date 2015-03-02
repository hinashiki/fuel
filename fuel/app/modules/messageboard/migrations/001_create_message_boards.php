<?php
/**
 * create all table for Oisyna
 *
 *
 */
namespace Fuel\Migrations;
class Create_message_boards
{
	function up()
	{
		// -------------------------
		// user_follows
		// -------------------------
		\DBUtil::create_table(
			'message_boards',
			array(
				'id' => array(
					'type' => 'int',
					'constraint' => 10,
					'unsigned' => true,
					'auto_increment' => true,
				),
				'type' => array(
					'type' => 'tinyint',
					'constraint' => 4,
					'unsigned' => true,
					'default' => 0,
					'comment' => 'board type if you have multi type board. default = 0',
				),
				'author_id' => array(
					'type' => 'int',
					'constraint' => 10,
					'unsigned' => true,
				),
				'user_id' => array(
					'type' => 'int',
					'constraint' => 10,
					'unsigned' => true,
				),
				'message' => array(
					'type' => 'text',
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
			'message_boards',
			array('type', 'author_id'),
			'idx_message_board_mul01'
		);
		\DBUtil::create_index(
			'message_boards',
			'user_id',
			'idx_message_board_user_id'
		);
	}

	function down()
	{
		\DBUtil::drop_table('message_boards');
	}
}
