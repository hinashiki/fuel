<?php
/**
 * extends testcase class
 * @see https://gist.github.com/kenjis/1354574
 */
class TestCase extends Fuel\Core\TestCase
{
	protected $_tables = array(
		// table_name => yaml_file_name
	);

	protected function setUp()
	{
		// for controller common
		$_SERVER['HTTP_USER_AGENT'] = 'FuelPHP_Test';
		$_SERVER['SERVER_PORT'] = 443;
		if(Fuel::$env !== 'jenkins')
		{
			Fuel::$env = Fuel::TEST;
		}
		if( ! empty($this->_tables))
		{
			$this->_dbfixt($this->_tables);
		}
	}

	/**
	 * auto load fixture
	 *
	 * @params mixed $tables
	 */
	protected function _dbfixt($tables)
	{
		// support $this->_dbfixt('table1', 'table2', ...) format
		$tables = is_string($tables) ? func_get_args() : $tables;
		foreach($tables as $table => $yaml)
		{
			// read yaml file
			$tested_class = preg_replace('/^Test_/', '', get_class($this));
			$in_fixt_path = str_replace('_', '/', strtolower($tested_class));
			$file_name = $yaml.'_fixt.yml';
			$file = APPPATH.'tests/fixture/'.$in_fixt_path.'/'.$file_name;
			if( ! file_exists($file))
			{
				exit('No such file: '.$file.PHP_EOL);
			}
			$data = file_get_contents($file);
			$table = is_int($table) ? $yaml : $table;
			$fixt_name = $table . '_fixt';
			$this->$fixt_name = Format::forge($data, 'yaml')->to_array();

			// truncate table
			if(DBUtil::table_exists($table))
			{
				DBUtil::truncate_table($table);
			}
			else
			{
				exit('No such table: '.$table.PHP_EOL);
			}

			// insert data
			foreach($this->$fixt_name as $row)
			{
				list($insert_id, $rows_affected) = DB::insert($table)->set($row)->execute();
			}
			$ret = Log::info('Table Fixture '.$file_name.'->'.$fixt_name.' loaded', __METHOD__);
		}
	}

	protected function tearDown()
	{
		// reset used tables
		foreach($this->_tables as $table => $yaml)
		{
			// truncate table
			if(DBUtil::table_exists($table))
			{
				DBUtil::truncate_table($table);
			}
			else
			{
				exit('No such table: '.$table.PHP_EOL);
			}
		}
	}
}
