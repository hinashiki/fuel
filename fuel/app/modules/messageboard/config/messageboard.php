<?php
/**
 * for message_boards module setting
 *
 */
return array(
	// select count default
	'limit' => 20,
	// select add conditions
	'add_where' => array(
		array('users.deleted' => \Schema::DELETED_NO),
	),
	// default valid rule for insert | update
	'valid_rule' => array(
		'message' => 'required|max_length[1024]',
	),
);
