<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Sql 
{
	
	function __construct()
	{
		$this->db = array();
	}

	public function create($table, $arg){
		$db = array();
		$tbln = strtolower(PRE.$table);
		$num = count($arg);
		$i = 1;
		$cols = '';
		foreach ($arg as $key => $value) {
			if($i == 1) {
				$cols .= $key . ' '.$value;
			} else {
				$cols .= ', '.$key . ' '.$value;
			}
			$i++;
		}
		if(strpos($cols,'delete') !== false || strpos($cols,'drop') !== false) {
			$query = "";
		} else {
			$query = "CREATE TABLE IF NOT EXISTS $tbln($cols)";
		}
		
		$db['sql'] = $query;
		$db['name'] = $tbln;
		array_push($this->db,$db);
	}

	public function query($query){
		$query = str_replace(PRE, '', $query);
		$db = array();
		$tbln = strtolower($query);
		if(strpos($tbln,'delete') !== false || strpos($tbln,'drop') !== false) {
			$query = "";
			$db['sql'] = "";
			$db['name'] = "";
		} else if(strpos($tbln,'insert') !== false) {
			$tbln = preg_replace("/(^insert)|into|\(..*\)..*\\n/m","",$tbln);
			$tbln = trim(preg_replace('/\s+/', ' ', $tbln));
			$tbln = preg_replace("/\([^)]+\)/","",$tbln);
			$tbln = str_replace(array('values',' ',';'), '', $tbln);
			$tbln = trim($tbln);
			$tbln_pre = PRE.$tbln;
			$db['dbname'] = $tbln_pre;
			$db['insert'] = str_replace($tbln, $tbln_pre, strtolower($query));
		} else if(strpos( $tbln, 'alter') !== false) {
			$tbln = preg_replace("/(^alter)|\(..*\)..*\\n/m","",$tbln);
			$tbln = trim(preg_replace('/\s+/', ' ', $tbln));
			$tbln = trim($tbln);
			$tblnarr = explode(' ', $tbln);
			$tbln = trim($tblnarr[1]);
			$tbln_pre = PRE.$tbln;
			$db['dbname'] = $tbln_pre;
			$db['alter'] = str_replace($tbln, $tbln_pre, strtolower($query));
		} else if(strpos( $tbln, 'create') !== false){
			$tbln = preg_replace("/(^create)|table if not exists|\(..*\)..*\\n/m","",$tbln);
			$tbln = trim(preg_replace('/\s+/', ' ', $tbln));
			$tbln = preg_replace("/\([^)]+\)/","",$tbln);
			$tbln = trim($tbln);
			$tbln_pre = PRE.$tbln;
			$db['name'] = $tbln_pre;
			$db['sql'] = str_replace($tbln, $tbln_pre, strtolower($query));	
		}
		array_push($this->db,$db);
	}

	public function insert($table, $arg){
		$db = array();
		$table = strtolower(PRE.$table);
		$cols = '';
		$vals = '';
		$i = 1;
		foreach ($arg as $key => $value) {
			if($i == 1) {
				$cols .= $key;
				$vals .= "'".$value."'";
				$col1 = $key;
				$val1 = $value;
			} else {
				$cols .= ','.$key;
				$vals .= ",'".$value."'";
			}
		$i++;	
		}
		$db['dbname'] = $table;
		$db['where'] = $col1;
		$db['val'] = $val1;
		$cols = strtolower($cols);
		$vals = $vals;
		if(strpos($cols,'delete') !== false || strpos($cols,'drop') !== false || strpos($vals,'delete') !== false || strpos($vals,'drop') !== false) {
			$query = "";
		} else {
			$query = "insert into $table ($cols) values ($vals)";
		}
		$db['add'] = $query;
		array_push($this->db,$db);
	}

	public function alter($table, $arg){
		$db = array();
		$table = strtolower(PRE.$table);
		if(isset($arg['add'])){
			$col = str_replace(array('drop','delete',';'), '', strtolower($arg['add']['column']));
			$type = str_replace(array('drop','delete',';'), '', strtolower($arg['add']['type']));
			$query = "ALTER TABLE `$table` ADD `$col` $type";
		} else if(isset($arg['modify'])) {
			$col = str_replace(array('drop','delete',';'), '', strtolower($arg['modify']['column']));
			$type = str_replace(array('drop','delete',';'), '', strtolower($arg['modify']['type']));
			$query = "ALTER TABLE `$table` MODIFY column `$col` $type";

		} else if(isset($arg['relation'])) {
			$col = str_replace(array('drop','delete',';'), '', strtolower($arg['relation']['column']));
			$reltable = str_replace(array('drop','delete',';'), '', strtolower($arg['relation']['rel-table']));
			$reltable = strtolower(PRE.$reltable);
			$relcol = str_replace(array('drop','delete',';'), '', strtolower($arg['relation']['rel-column']));
			$query = "ALTER TABLE `$table` ADD FOREIGN KEY (`$col`) REFERENCES `$reltable` (`$relcol`) ON DELETE CASCADE ON UPDATE CASCADE";

		} else if(isset($arg['drop'])) {
			$col = str_replace(array('drop','delete',';'), '', strtolower($arg['drop']));
			$query = "ALTER TABLE `$table` DROP column `$col`";
		}
		$db['alterdb'] = $query;
		array_push($this->db,$db);
	}
}