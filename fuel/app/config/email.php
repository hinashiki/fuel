<?php
/**
 * email config extends
 *
 */
return array(
	'defaults' => array(
		'useragent'	=> 'Fuel Application',
		'driver'		=> 'sendmailwrapper', //sendmail拡張
		'is_html'		=> null,
		'charset'		=> 'ISO-2022-JP',
		'encode_headers' => true,
		'encoding'		=> '7bit',
		'priority'		=> \Email::P_NORMAL,
		'from'		=> array(
			'email'		=> 'no-reply@mail.yourdomain.com',
			'name'		=> 'www.yourdomain.com(送信専用)',
		),
		'return_path'   => 'bounce@mail.yourdomain.com',
		'validate'	=> true,
		'auto_attach' => true,
		'generate_alt' => true,
		'force_mixed'   => false,
		'wordwrap'	=> 76,
		'sendmail_path' => '/usr/sbin/sendmail',
		'smtp'	=> array(
			'host'		=> 'mail.yourdomain.com',
			'port'		=> 25,
			'username'	=> '',
			'password'	=> '',
			'timeout'	=> 5,
		),
		'newline'	=> "\n",
		'attach_paths' => array(
			'',
			DOCROOT,
		),
	),
	'default_setup' => 'default',
	'setups' => array(
		'default' => array(),
	),
	'debug' => array(
		'email' => 'debug@mail.yourdomain.com',
	),
);
