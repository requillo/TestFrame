<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_all_pages($status = NULL){
		if($status == 'publish') {
			$sql = "SELECT id,title,slug,content,parent,level,created,updated,created_user,updated_user,status FROM ".PRE."pages WHERE type = 'page' AND status = 1 ORDER BY id DESC";
		} else if($status == 'draft') {
			$sql = "SELECT id,title,slug,content,parent,level,created,updated,created_user,updated_user,status FROM ".PRE."pages WHERE type = 'page' AND status = 2 ORDER BY id DESC";
		} else if($status == 'trash') {
			$sql = "SELECT id,title,slug,content,parent,level,created,updated,created_user,updated_user,status FROM ".PRE."pages WHERE type = 'page' AND status = 0 ORDER BY id DESC";
		} else {
			$sql = "SELECT id,title,slug,content,parent,level,created,updated,created_user,updated_user,status FROM ".PRE."pages ORDER BY id DESC";
		}
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$row = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_page($id){
		$sql = "SELECT * FROM ".PRE."pages WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function check_slug($slug){
		$sql = "SELECT slug FROM ".PRE."pages WHERE slug = :slug AND type = 'page'";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':slug' => $slug));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(empty($row)) {
			return true;
		} else {
			return false;
		}
	}

	public function the_slug($slug, $original = NULL){
		$check = $this->check_slug($slug);
		if($original != NULL && $slug == $original) {
			$res = $slug;
		} else if($check == true) {
			$res = $slug;
		} else {
			if(strpos($slug, '-pagecopy-') !== false) {
				$slgarr = explode('-', $slug);
				$cn = end($slgarr);
				$cnn = (int)$cn+1;
				$search = '-pagecopy-'.$cn;
				$replace = '-pagecopy-'.$cnn;
				$slug = str_replace($search, $replace, $slug);
				$res = $this->the_slug($slug,$original);
			} else {
				$slug = $slug .'-pagecopy-1';
				$res = $this->the_slug($slug,$original);
			}
		}
		return $res;
	}
}