<?php
/**
 * add columns to users
 *
 */
namespace Fuel\Migrations;
class Add_users_deleted_column
{
	function up()
	{

		if(!\DBUtil::field_exists('users', array('deleted')))
		{
			\DBUtil::add_fields(
				'users',
				array(
					'deleted' => array(
						'type' => 'tinyint',
						'default' => 0,
					),
				)
			);
		}

	}

	function down()
	{
		if(\DBUtil::field_exists('users', array('deleted')))
		{
			\DBUtil::drop_fields('users', array('deleted'));
		}
	}
}
