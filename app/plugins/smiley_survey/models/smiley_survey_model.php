<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Smiley_survey_model extends Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_company_api($api) {
		$sql = "SELECT * FROM ".PRE."smiley_servey_companies WHERE company_key = :company_key";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':company_key' => $api));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_all_companies() {
		$sql = "SELECT id, company, address, telephone, place, company_key  FROM ".PRE."smiley_servey_companies";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_company_info($id) {
		$sql = "SELECT id, company, address, telephone, place, company_key  FROM ".PRE."smiley_servey_companies WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_user_company_relations() {
		$sql = "SELECT *  FROM ".PRE."smiley_servey_users";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_user_company_relation($user_id) {
		$sql = "SELECT *  FROM ".PRE."smiley_servey_users WHERE user_id = :user_id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':user_id' => $user_id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_all_emoticons() {
		$sql = "SELECT *  FROM ".PRE."smiley_servey_emoticons";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_terminals($companies = NULL) {
		if($companies == NULL) {
			$sql = "SELECT *  FROM ".PRE."smiley_servey_terminals";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
		} else {
			$sql = "SELECT *  FROM ".PRE."smiley_servey_terminals WHERE company_id = :company_id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':company_id' => $companies));
		}
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_all_questions($terminal = NULL) {
		if($terminal == NULL) {
			$sql = "SELECT *  FROM ".PRE."smiley_servey_questions";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute();
		} else {
			$sql = "SELECT *  FROM ".PRE."smiley_servey_questions WHERE terminal_id = :terminal_id ";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':terminal_id' => $terminal));
		}
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_question($id) {
		$sql = "SELECT *  FROM ".PRE."smiley_servey_questions WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}

	public function get_terminal_info($id) {
		$sql = "SELECT * FROM ".PRE."smiley_servey_terminals WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row;
	}
	// use $arr['terminal'] or $arr['company']
	public function get_terminals_from_company($arr) {
		if(isset($arr['terminal'])) {
			$sql = "SELECT company_id FROM ".PRE."smiley_servey_terminals WHERE id = :id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':id' => $arr['terminal']));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$rows = $this->get_terminals_from_company(array('company'=>$row['company_id']));
		} else if(isset($arr['company'])) {
			$sql = "SELECT * FROM ".PRE."smiley_servey_terminals WHERE company_id = :company_id";
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute(array(':company_id' => $arr['company']));
			$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		return $rows;
	}

	public function get_company_from_terminal_id($id) {
		$sql = "SELECT company_id FROM ".PRE."smiley_servey_terminals WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if(isset($row['company_id'])) {
			return $row['company_id'];
		}
	}

	public function get_answers_info($id) {
		$sql = "SELECT *  FROM ".PRE."smiley_servey_answers WHERE question_id = :question_id ORDER BY list_order";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':question_id' => $id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_feedback_info($id) {
		$sql = "SELECT *  FROM ".PRE."smiley_servey_feedbacks WHERE answer_id = :answer_id ORDER BY list_order";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':answer_id' => $id));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_icon($id) {
		$sql = "SELECT image_svg  FROM ".PRE."smiley_servey_emoticons WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['image_svg'];
	}
}