<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Form
{
	public $required = '';
	public function create($arr = NULL){
		$date = date_create();
		$date = date_timestamp_get($date);
		$nonce = sha1($date.rand(1,10000000));
		if(!isset($_SESSION['nonce'])) {
			$_SESSION['nonce'] = array();
		} else {
			if(count($_SESSION['nonce']) > 10) {
				array_shift($_SESSION['nonce']);
			}
		}
		array_push($_SESSION['nonce'],$nonce);
		$n_input = '<input name="data[nonce]" value="'.$nonce.'" type="hidden">';
		if(!is_array($arr) && $arr != NULL){
			$id = 'id="'.$arr.'" ';
			$method = 'method="post"';
			$action = '';
			$enctype = '';
			$class = '';
			$attr = '';
		} else {
			$class = $enctype = $id = $attr = '';
		if(isset($arr['method'])){
			$method = 'method="'.$arr['method'].'"';
		} else {
			$method = 'method="post" ';
		}
		if(isset($arr['action'])){
			$action = 'action="'.$arr['action'].'"';
		} else {
			$action = '';
		}
		if(isset($arr['file-upload']) && $arr['file-upload'] == true){
			$enctype = 'enctype="multipart/form-data"';
		}
		if(isset($arr['id'])){
			$id = 'id="'.$arr['id'].'"';
		}
		if(isset($arr['class'])){
			$class = 'class="'.$arr['class'].'"';
		}
		if(isset($arr['attribute'])){
			$attr = $arr['attribute'];
		}
		}
		echo "<form $id $action $method $class $enctype $attr >\n".$n_input."\n"; 
	}

	public function input($name,$arr = NULL){
		if(Message::$required != ''){
			$this->required = Message::$required;
		}
		$post_val = '';
		if(isset($_POST['data'][$name])) {
		$post_val = $_POST['data'][$name];	
		}
		$fra = explode(',', $this->required);
		if(in_array($name,$fra)) {
			$errorClass = 'form-error';	
		} else {
			$errorClass = '';
		}
		$labelClass = '';
		$wrapperClass = '';
		if(isset($arr['class'])) {
			$class = 'class="'.$arr['class'].' '.$errorClass.'"';
		} else {
			$class = 'class="form-control'.' '.$errorClass.'"';
		}
		if(isset($arr['type'])){
			$type = 'type="'.$arr['type'].'"';
			if($arr['type'] == 'file'){
				$labelClass = ' class="uploadlabel" ';
				$wrapperClass = ' uploadfilewrapper';
			}
		} else {
			$type = 'type="text"';
		}
		if(isset($arr['value'])){
			$value = 'value="' . $arr['value'].'"';		
		} else {
			$value = 'value="'.$post_val.'"';
		} 
		if(isset($arr['label'])) {
			$label = '<label '.$labelClass.' for="input-'.$name.'">'.$arr['label'].'</label> ';
		} else {
			$label = '';
		}
		if(isset($arr['placeholder'])){
			$placeholder = 'placeholder="'.$arr['placeholder'].'"';
		} else {
			$placeholder = '';
		}
		if(isset($arr['attribute'])){
			$attribute = $arr['attribute'];
		} else {
			$attribute = '';
		}
		if(isset($arr['label-pos'])){
			$pos = $arr['label-pos'];
		} else {
			$pos = 'before';
		}
		$inputname = 'name="data['.$name.']"';
		if($type == 'type="radio"' || $type == 'type="checkbox"'){
			if($type == 'type="radio"') {
				$labelcl = 'radio-cl';
			} else {
				$labelcl = 'check-cl';
			}
			if($label != '') {
				if(isset($arr['id'])) {
					$id = 'id="'.$arr['id'].'" ';
					$label = '<label for="'.$arr['id'].'" class="'.$labelcl.'">'.$arr['label'].'</label> ';
				} else {
					$id = 'id="radio-'.strtolower(str_replace(' ', '-', $arr['label'])).'" ';
					$label = '<label for="radio-'.strtolower(str_replace(' ', '-', $arr['label'])).'" class="'.$labelcl.'">'.$arr['label'].'</label> ';
				}
				
			} else {
				$id = 'id="input-'.$name.'" ';
			}
		} else {
			$id = 'id="input-'.$name.'" ';
		}

		if(isset($arr['no-wrap'])){
			$nowrap = $arr['no-wrap'];
		} else {
			$nowrap = false;
		}
		
		if($attribute == 'hidden'){
		echo "<input $type $inputname $class $id $value $placeholder $attribute>\n";
		} else {
		if($nowrap == false){
		echo '<div class="form-group '.$wrapperClass.'">' ."\n";
		}
		
		if($pos == 'before') {
		echo $label;
		echo "<input $type $inputname $class $id $value $placeholder $attribute>\n";
		} else {
		echo "<input $type $inputname $class $id $value $placeholder $attribute>\n";
		echo " " . $label;
		}
		if($nowrap == false){
		echo '</div>' . "\n";
		}

		}
		
	}

	public function close($send=NULL,$class=NULL){
		if(isset($class)){
			$btnclass = 'class="btn '.$class.'"';
		} else {
			$btnclass = 'class="btn btn-default"';
		}
		if(isset($send)) {
		echo "<button $btnclass>".$send."</button>\n";
		}
		echo "</form>\n";

	}

	public function submit($send=NULL,$class=NULL){
		if($send==NULL) {
			$send = __('Send');
		}
		if(isset($class)){
			$btnclass = 'class="btn '.$class.'"';
		} else {
			$btnclass = 'class="btn btn-default"';
		}
		echo "<button $btnclass>".$send."</button>\n";
	}

	public function options($arr,$select = NULL){
		$result = '';
		foreach ($arr as $key => $value) {
			if(isset($select['key']) && is_array($select['key'])) {
				if(in_array($key, $select['key'])) {
					$result .= '<option value="'.$key.'" selected>'.language_content($value).'</option>';
				} else {
					$result .= '<option value="'.$key.'">'.language_content($value).'</option>';
				}
			} else if(isset($select['value']) && is_array($select['value'])) {
				if(in_array($key, $select['value'])) {
					$result .= '<option value="'.$key.'" selected>'.language_content($value).'</option>';
				} else {
					$result .= '<option value="'.$key.'">'.language_content($value).'</option>';
				}
			} else if(isset($select['key']) && $select['key'] == $key) {
				$result .= '<option value="'.$key.'" selected>'.language_content($value).'</option>';
			} else if(isset($select['value']) && $select['value'] == $value ) {
				$result .= '<option value="'.$key.'" selected>'.language_content($value).'</option>';
			} else {
				$result .= '<option value="'.$key.'">'.language_content($value).'</option>';
			}
			
		}
		return $result;
	}

	public function textarea($name,$arr = NULL) {
		if(Message::$required != ''){
			$this->required = Message::$required;
		}
		$post_val = '';
		if(isset($_POST['data'][$name])) {
		$post_val = $_POST['data'][$name];	
		}
		$fra = explode(',', $this->required);
		if(in_array($name,$fra)) {
			$errorClass = 'form-error';	
		} else {
			$errorClass = '';
		}
		$id = 'id="input-'.$name.'" ';
		if(isset($arr['class'])) {
			$class = 'class="'.$arr['class'].' '.$errorClass.'"';
		} else {
			$class = 'class="form-control '.$errorClass.'"';
		}
		if(isset($arr['value'])){
			$value =  $arr['value'];		
		} else {
			$value = $post_val;
		}
		if(isset($arr['placeholder'])){
			$placeholder = 'placeholder="'.$arr['placeholder'].'"';
		} else {
			$placeholder = '';
		} 
		if(isset($arr['label'])) {
			$label = '<label for="input-'.$name.'">'.$arr['label'].'</label> ';
		} else {
			$label = '';
		}
		if(isset($arr['attribute'])){
			$attribute = $arr['attribute'];
		} else {
			$attribute = '';
		}
		if(isset($arr['label-pos'])){
			$pos = $arr['label-pos'];
		} else {
			$pos = 'before';
		}
		if(isset($arr['no-wrap'])){
			$nowrap = $arr['no-wrap'];
		} else {
			$nowrap = false;
		}
		$inputname = 'name="data['.$name.']"';
		if($nowrap == false){
		echo '<div class="form-group">' ."\n";
		}
		
		if($pos == 'before') {
		echo $label;
		echo "<textarea $inputname $class $id $placeholder $attribute>$value</textarea>\n";
		} else {
		echo "<textarea $inputname $class $id $placeholder $attribute>$value</textarea>\n";
		echo " " . $label;
		}

		if($nowrap == false){
		echo '</div>' . "\n";
		}

	}

	public function select($name,$arr = NULL) {
		if(Message::$required != ''){
			$this->required = Message::$required;
		}
		$fra = explode(',', $this->required);
		if(in_array($name,$fra)) {
			$errorClass = 'form-error';	
		} else {
			$errorClass = '';
		}
		$id = 'id="input-'.$name.'" ';
		if(isset($arr['class'])) {
			$class = 'class="'.$arr['class'].' '.$errorClass.'"';
		} else {
			$class = 'class="form-control '.$errorClass. Message::$required.'"';
		}

		if(isset($arr['options'])) {
			$options = '';
			foreach ($arr['options'] as $key => $value) {
				$selected = '';
				if(isset($arr['selected'])) {
					if(is_array($arr['selected'])) {
						if(in_array($key, $arr['selected'])) {
						$selected = 'selected';
						}
					} else {
						if($key == $arr['selected']) {
							$selected = 'selected';
						}
					}
				}
				$options .= '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
			}
		} else {
			$options = '';
		}

		$id = 'id="input-'.$name.'" ';
		if(isset($arr['class'])) {
			$class = 'class="'.$arr['class'].' '.$errorClass.'"';
		} else {
			$class = 'class="form-control '.$errorClass.'"';
		}		

		if(isset($arr['label'])) {
			$label = '<label for="input-'.$name.'">'.$arr['label'].'</label> ';
		} else {
			$label = '';
		}
		if(isset($arr['attribute'])){
			$attribute = $arr['attribute'];
		} else {
			$attribute = '';
		}
		if(isset($arr['label-pos'])){
			$pos = $arr['label-pos'];
		} else {
			$pos = 'before';
		}
		if(isset($arr['no-wrap'])){
			$nowrap = $arr['no-wrap'];
		} else {
			$nowrap = false;
		}
		$inputname = 'name="data['.$name.']"';

		if(isset($arr['multiple'])) {
			$multiple = 'multiple';
			$inputname = 'name="data['.$name.'][]"';
		} else {
			$multiple = '';
		}

		if($nowrap == false){
		echo '<div class="form-group">' ."\n";
		}
		
		if($pos == 'before') {
		echo $label;
		echo "<select $inputname $class $id $attribute $multiple>$options</select>\n";
		} else {
		echo "<select $inputname $class $id $attribute $multiple>$options</select>\n";
		echo " " . $label;
		}

		if($nowrap == false){
		echo '</div>' . "\n";
		}


	}

	
}