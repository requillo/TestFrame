<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Forms_model extends Model {

	function __construct()
	{
		parent::__construct();
	}

	function get_form($id) {
		$sql = "SELECT * FROM ".PRE."forms WHERE id = :id";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':id' => $id));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);
		return $rows;
	}

	function get_all_forms(){
		$sql = "SELECT * FROM ".PRE."forms WHERE status = 1";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;

	}

	function html_form($json, $lang = NULL) {
		$theform = language_content($json, $lang);
		$theforminputs = json_decode($theform, true);
		$isfile = false;
		foreach ($theforminputs as $value) {
			if($value['type'] == 'file') {
				$isfile = true;
			}
		}

		if($isfile == true) {
			$res = '<form method="post" enctype="multipart/form-data">';
		} else {
			$res = '<form method="post">';
		}
		$res .= $this->html_form_inputs($json, $lang);
		$res .= '</form>';
		return $res;
	}

	public function update_settings_inputs($key, $update){
		$sql = "UPDATE ".PRE."form_settings SET value = :value WHERE meta = :meta";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(":value"=>$update,':meta' => $key));
		return $stmt->rowCount() ? 1 : 0;
	}


	public function get_all_settings(){
		$sql = "SELECT *  FROM ".PRE."form_settings";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $rows;
	}

	public function get_settings($meta, $value){
		$sql = "SELECT $value  FROM ".PRE."form_settings WHERE meta = :meta";
		$stmt = $this->pdo->prepare($sql);
		$stmt->execute(array(':meta' => $meta));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row[$value];
	}

	public function get_settings_inputs(){
		$settings = $this->get_all_settings();
		$fdata = '';
		foreach ($settings as $key => $value) {
			$fdata .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="form-group">
			<label for="sett-id-'.$value['id'].'">'.__(ucwords(str_replace('_', ' ', $value['meta']))).'</label><br>';
			$fdata .= '<small>'.__($value['description']).'</small>';
			$fdata .= '<input type="text" class="form-control" name="data['.$value['meta'].']" id="sett-id-'.$value['id'].'" value="'.$value['value'].'">';
			$fdata .= '</div></div>';
		}
		return $fdata;
	}

	function form_shortcode($json, $lang = NULL) {
		$theform = language_content($json, $lang);
		$theforminputs = json_decode($theform, true);
		$res = '';
		foreach ($theforminputs  as $value) {
			if(isset($value['name'])) {
				$name = $value['name'];
				$id = 'input_'.$name;
			} else {
				$name = '';
			}
			if($name != '') {
				$res .= '{'.$name.'}, ';
			}
		}
		$res = rtrim($res);
		$res = rtrim($res,',');
		return $res;
	}

	function html_form_inputs($json, $lang = NULL, $shortcode = false) {
	$theform = language_content($json, $lang);
	$theforminputs = json_decode($theform, true);
	$res = '';
	foreach ($theforminputs  as $value) {
		// Type autocomplete
		if($value['type'] == 'autocomplete') {
			if(isset($value['name'])) {
				$name = $value['name'];
				$dname = 'data['.$name.']';
				$id = 'input_'.$name;
			} else {
				$name = '';
				$dname = '';
			}
			if($shortcode == true) {
				$sc = '<div class="form-shortcode">'.__('Shortcode').': {'.$name.'}</div>';
				$dname = $name;
			} else {
				$sc = '';
				$dname = '';
			}
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['description'])) {
				$desc = ' <span class="popinfo popinfo-hide" data-info="'.$value['description'].'"></span>';
				$desctxt = '<div class="form-input-description input-description-hide">'.$value['description'].'</div>';
			} else {
				$desc = '';
				$desctxt = '';
			}
			if(isset($value['placeholder'])) {
				$placeholder = ' placeholder="'.$value['placeholder'].'"';
			} else {
				$placeholder = '';
			}
			if(isset($value['required'])) {
				$required = ' required';
				$txtreq = ' <span class="requiredlabel"></span>';
			} else {
				$required = '';
				$txtreq = '';
			}
			if(isset($value['label'])) {
				$label = $value['label'];
			} else {
				$label = '';
			}
			$type = 'text';
			if($name != '') {
				$res .= '<div class="form-group">';
				$res .= '<label for="'.$id.'" class="main-form-label">'.$label.$txtreq.$desc.'</label>';
				$res .= $desctxt;
				$res .= $sc;
				$res .= '<input type="'.$type.'" name="'.$dname.'" class="'.$class.'" id="'.$id.'"'.$placeholder.'>';
				// Do extra for list
				$res .= '</div>';
			}
		}
		// Type date
		if($value['type'] == 'date') {
			if(isset($value['name'])) {
				$name = $value['name'];
				$dname = 'data['.$name.']';
				$id = 'input_'.$name;
			} else {
				$name = '';
				$dname = '';
			}
			if($shortcode == true) {
				$sc = '<div class="form-shortcode">'.__('Shortcode').': {'.$name.'}</div>';
				$dname = $name;
			} else {
				$sc = '';
				$dname = '';
			}
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['description'])) {
				$desc = ' <span class="popinfo popinfo-hide" data-info="'.$value['description'].'"></span>';
				$desctxt = '<div class="form-input-description input-description-hide">'.$value['description'].'</div>';
			} else {
				$desc = '';
				$desctxt = '';
			}
			if(isset($value['placeholder'])) {
				$placeholder = ' placeholder="'.$value['placeholder'].'"';
			} else {
				$placeholder = '';
			}
			if(isset($value['required'])) {
				$required = ' required';
				$txtreq = ' <span class="requiredlabel"></span>';
			} else {
				$required = '';
				$txtreq = '';
			}
			if(isset($value['label'])) {
				$label = $value['label'];
			} else {
				$label = '';
			}
			$type = 'date';
			if($name != '') {
				$res .= '<div class="form-group">';
				$res .= '<label for="'.$id.'" class="main-form-label">'.$label.$txtreq.$desc.'</label>';
				$res .= $desctxt;
				$res .= $sc;
				$res .= '<input type="'.$type.'" name="'.$dname.'" class="'.$class.'" id="'.$id.'"'.$placeholder.'>';
				$res .= '</div>';
			}
		}
		// Type Hidden
		if($value['type'] == 'hidden') {
			if(isset($value['name'])) {
				$name = $value['name'];
				$dname = 'data['.$name.']';
				$id = 'input_'.$name;
			} else {
				$name = '';
				$dname = '';
			}
			if($shortcode == true) {
				$sc = '<div class="form-shortcode">'.__('Shortcode').': {'.$name.'}</div>';
				$dname = $name;
			} else {
				$sc = '';
				$dname = '';
			}
			if(isset($value['value'])) {
				$val = ' value="'.$value['value'].'"';
			} else {
				$val = '';
			}
			$type = 'hidden';
			if($name != '') {
				$res .= '<div class="form-group">';
				$res .= '<input type="'.$type.'" name="'.$dname.'" id="'.$id.'"'.$val.'>';
				$res .= '</div>';
			}
		}
		// Type Text
		if($value['type'] == 'text') {
			if(isset($value['name'])) {
				$name = $value['name'];
				$dname = 'data['.$name.']';
				$id = 'input_'.$name;
			} else {
				$name = '';
				$dname = '';
			}
			if($shortcode == true) {
				$sc = '<div class="form-shortcode">'.__('Shortcode').': {'.$name.'}</div>';
				$dname = $name;
			} else {
				$sc = '';
				$dname = '';
			}
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['description'])) {
				$desc = ' <span class="popinfo popinfo-hide" data-info="'.$value['description'].'"></span>';
				$desctxt = '<div class="form-input-description input-description-hide">'.$value['description'].'</div>';
			} else {
				$desc = '';
				$desctxt = '';
			}
			if(isset($value['maxlength'])) {
				$maxlength = ' maxlength="'.$value['maxlength'].'"';
			} else {
				$maxlength = '';
			}
			if(isset($value['placeholder'])) {
				$placeholder = ' placeholder="'.$value['placeholder'].'"';
			} else {
				$placeholder = '';
			}
			if(isset($value['required'])) {
				$required = ' required';
				$txtreq = ' <span class="requiredlabel"></span>';
			} else {
				$required = '';
				$txtreq = '';
			}
			if(isset($value['value'])) {
				$val = ' value="'.$value['value'].'"';
			} else {
				$val = '';
			}
			if(isset($value['label'])) {
				$label = $value['label'];
			} else {
				$label = '';
			}
			$type =  $value['subtype'];
			if($name != '') {
				$res .= '<div class="form-group">';
				$res .= '<label for="'.$id.'" class="main-form-label">'.$label.$txtreq.$desc.'</label> ';
				$res .= $desctxt;
				$res .= $sc;
				$res .= '<input type="'.$type.'" name="'.$dname.'" class="'.$class.'" id="'.$id.'"'.$placeholder.$maxlength.$val.'>';
				$res .= '</div>';
			}
		}
		// Type Textarea
		if($value['type'] == 'textarea') {
			if(isset($value['name'])) {
				$name = $value['name'];
				$dname = 'data['.$name.']';
				$id = 'input_'.$name;
			} else {
				$name = '';
				$dname = '';
			}
			if($shortcode == true) {
				$sc = '<div class="form-shortcode">'.__('Shortcode').': {'.$name.'}</div>';
				$dname = $name;
			} else {
				$sc = '';
				$dname = '';
			}
			if(isset($value['subtype'])) {
				if($value['subtype'] == 'full-editor') {
					$subclass = ' full-editor';
				} else if($value['subtype'] == 'minimal-editor') {
					$subclass = ' minimal-editor';
				} else {
					$subclass = '';
				}
			} else {
				$subclass = '';
			}
			if(isset($value['className'])) {
				$class = $value['className'].$subclass;
			} else {
				$class = ''.$subclass;
			}
			if(isset($value['description'])) {
				$desc = ' <span class="popinfo popinfo-hide" data-info="'.$value['description'].'"></span>';
				$desctxt = '<div class="form-input-description input-description-hide">'.$value['description'].'</div>';
			} else {
				$desc = '';
				$desctxt = '';
			}
			if(isset($value['maxlength'])) {
				$maxlength = ' maxlength="'.$value['maxlength'].'"';
			} else {
				$maxlength = '';
			}
			if(isset($value['placeholder'])) {
				$placeholder = ' placeholder="'.$value['placeholder'].'"';
			} else {
				$placeholder = '';
			}
			if(isset($value['required'])) {
				$required = ' required';
				$txtreq = ' <span class="requiredlabel"></span>';
			} else {
				$required = '';
				$txtreq = '';
			}
			if(isset($value['rows'])) {
				$rows = ' rows="'.$value['rows'].'"';
			} else {
				$rows = '';
			}
			if(isset($value['value'])) {
				$val = $value['value'];
			} else {
				$val = '';
			}
			if(isset($value['label'])) {
				$label = $value['label'];
			} else {
				$label = '';
			}
			if($name != '') {
				$res .= '<div class="form-group">';
				$res .= '<label for="'.$id.'" class="main-form-label">'.$label.$txtreq.$desc.'</label> ';
				$res .= $desctxt;
				$res .= $sc;
				$res .= '<textarea name="'.$dname.'" class="'.$class.'" id="'.$id.'"'.$rows.$maxlength.$placeholder.'>'.$val.'</textarea>';
				$res .= '</div>';
			}
		}
		// Type Number
		if($value['type'] == 'number') {
			if(isset($value['name'])) {
				$name = $value['name'];
				$dname = 'data['.$name.']';
				$id = 'input_'.$name;
			} else {
				$name = '';
				$dname = '';
			}
			if($shortcode == true) {
				$sc = '<div class="form-shortcode">'.__('Shortcode').': {'.$name.'}</div>';
				$dname = $name;
			} else {
				$sc = '';
				$dname = '';
			}
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['min'])) {
				$min = ' min="'.$value['min'].'"';
			} else {
				$min = '';
			}
			if(isset($value['max'])) {
				$max = ' max="'.$value['max'].'"';
			} else {
				$max = '';
			}
			if(isset($value['step'])) {
				$step = ' step="'.$value['step'].'"';
			} else {
				$step = '';
			}
			if(isset($value['required'])) {
				$required = ' required';
				$txtreq = ' <span class="requiredlabel"></span>';
			} else {
				$required = '';
				$txtreq = '';
			}
			if(isset($value['placeholder'])) {
				$placeholder = ' placeholder="'.$value['placeholder'].'"';
			} else {
				$placeholder = '';
			}
			if(isset($value['description'])) {
				$desc = ' <span class="popinfo popinfo-hide" data-info="'.$value['description'].'"></span>';
				$desctxt = '<div class="form-input-description input-description-hide">'.$value['description'].'</div>';
			} else {
				$desc = '';
				$desctxt = '';
			}
			if(isset($value['label'])) {
				$label = $value['label'];
			} else {
				$label = '';
			}
			$type =  'number';
			if($name != '') {
				$res .= '<div class="form-group">';
				$res .= '<label for="'.$id.'" class="main-form-label">'.$label.$txtreq.$desc.'</label>';
				$res .= $desctxt;
				$res .= $sc;
				$res .= '<input type="'.$type.'" name="'.$dname.'" class="'.$class.'" id="'.$id.'"'.$min.$max.$step.$placeholder.'>';
				// Do extra for list
				$res .= '</div>';
			}
		}
		// Type Checkbox
		if($value['type'] == 'checkbox-group') {
			if(isset($value['name'])) {
				$name = $value['name'];
				$dname = 'data['.$name.']';
				$id = 'input_'.$name;
			} else {
				$name = '';
				$dname = '';
			}
			if($shortcode == true) {
				$sc = '<div class="form-shortcode">'.__('Shortcode').': {'.$name.'}</div>';
				$dname = $name;
			} else {
				$sc = '';
				$dname = '';
			}
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['description'])) {
				$desc = ' <span class="popinfo popinfo-hide" data-info="'.$value['description'].'"></span>';
				$desctxt = '<div class="form-input-description input-description-hide">'.$value['description'].'</div>';
			} else {
				$desc = '';
				$desctxt = '';
			}
			if(isset($value['required'])) {
				$required = ' required';
				$txtreq = ' <span class="requiredlabel"></span>';
			} else {
				$required = '';
				$txtreq = '';
			}
			if(isset($value['inline'])) {
				$inline = ' checkbox-inline';
			} else {
				$inline = ' checkbox';
			}
			if(isset($value['label'])) {
				$label = $value['label'];
			} else {
				$label = '';
			}
			if($name != '') {
				$res .= '<div class="form-group">';
				$res .= '<label for="'.$id.'" class="main-form-label">'.$label.$txtreq.$desc.'</label> ';
				$res .= $desctxt;
				$res .= $sc;
				$i = 0;
				foreach ($value['values'] as $val) {
					if(isset($val['selected'])) {
						$checked = ' checked';
					} else {
						$checked = '';
					}
					$res .= '<div class="'.$inline.'">';
					$res .= '<input type="checkbox" name="'.$dname.'[]" class="'.$class.'" id="'.$name.'-'.$i.'" value="'.$val['value'].'"'.$checked.'> ';
					$res .= '<label for="'.$name.'-'.$i.'">'.$val['label'].'</label>';
					$res .= '</div>';
					$i++;
				}
				$res .= '</div>';
			}
		}
		// Type Radio
		if($value['type'] == 'radio-group') {
			if(isset($value['name'])) {
				$name = $value['name'];
				$dname = 'data['.$name.']';
				$id = 'input_'.$name;
			} else {
				$name = '';
				$dname = '';
			}
			if($shortcode == true) {
				$sc = '<div class="form-shortcode">'.__('Shortcode').': {'.$name.'}</div>';
				$dname = $name;
			} else {
				$sc = '';
				$dname = '';
			}
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['description'])) {
				$desc = ' <span class="popinfo popinfo-hide" data-info="'.$value['description'].'"></span>';
				$desctxt = '<div class="form-input-description input-description-hide">'.$value['description'].'</div>';
			} else {
				$desc = '';
				$desctxt = '';
			}
			if(isset($value['required'])) {
				$required = ' required';
				$txtreq = ' <span class="requiredlabel"></span>';
			} else {
				$required = '';
				$txtreq = '';
			}
			if(isset($value['inline'])) {
				$inline = ' radio-inline';
			} else {
				$inline = ' radio';
			}
			if(isset($value['label'])) {
				$label = $value['label'];
			} else {
				$label = '';
			}
			if($name != '') {
				$res .= '<div class="form-group">';
				$res .= '<label for="'.$id.'" class="main-form-label">'.$label.$txtreq.$desc.'</label> ';
				$res .= $desctxt;
				$res .= $sc;
				$i = 0;
				foreach ($value['values'] as $val) {
					if(isset($val['selected'])) {
						$checked = ' checked';
					} else {
						$checked = '';
					}
					$res .= '<div class="'.$inline.'">';
					$res .= '<input type="radio" name="'.$dname.'" class="'.$class.'" id="'.$name.'-'.$i.'" value="'.$val['value'].'"'.$checked.'> ';
					$res .= '<label for="'.$name.'-'.$i.'">'.$val['label'].'</label>';
					$res .= '</div>';
					$i++;
				}
				$res .= '</div>';
			}
		}
		// Type Select
		if($value['type'] == 'select') {
			if(isset($value['name'])) {
				$name = $value['name'];
				$dname = 'data['.$name.']';
				$id = 'input_'.$name;
			} else {
				$name = '';
				$dname = '';
			}
			if($shortcode == true) {
				$sc = '<div class="form-shortcode">'.__('Shortcode').': {'.$name.'}</div>';
				$dname = $name;
			} else {
				$sc = '';
				$dname = '';
			}
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['description'])) {
				$desc = ' <span class="popinfo popinfo-hide" data-info="'.$value['description'].'"></span>';
				$desctxt = '<div class="form-input-description input-description-hide">'.$value['description'].'</div>';
			} else {
				$desc = '';
				$desctxt = '';
			}
			if(isset($value['required'])) {
				$required = ' required';
				$txtreq = ' <span class="requiredlabel"></span>';
			} else {
				$required = '';
				$txtreq = '';
			}
			if(isset($value['inline'])) {
				$inline = ' radio-inline';
			} else {
				$inline = ' radio';
			}
			if(isset($value['multiple'])) {
				$multiple = ' multiple="true"';
				$name = 'data['.$name.'][]';
			} else {
				$multiple = '';
				$name = 'data['.$name.']';
			}
			if(isset($value['label'])) {
				$label = $value['label'];
			} else {
				$label = '';
			}
			if(isset($value['placeholder'])) {
				$placeholder = '<option>'.$value['placeholder'].'</option>';
			} else {
				$placeholder = '';
			}
			if($name != '') {
				$res .= '<div class="form-group">';
				$res .= '<label for="'.$id.'" class="main-form-label">'.$label.$txtreq.$desc.'</label> ';
				$res .= $desctxt;
				$res .= $sc;
				$res .= '<select name="'.$dname.'" class="'.$class.'"'.$multiple.'>';
				$res .= $placeholder;
				foreach ($value['values'] as $val) {
					if(isset($val['selected'])) {
						$selected = ' selected';
					} else {
						$selected = '';
					}
					$res .= '<option value="'.$val['value'].'"'.$selected.'>'.$val['label'].'</option>';
				}
				$res .= '</select>';
				$res .= '</div>';
			}
		}
		// Type file
		if($value['type'] == 'file') {
			if(isset($value['name'])) {
				$name = $value['name'];
				$dname = 'data['.$name.']';
				$id = 'input_'.$name;
			} else {
				$name = '';
				$dname = '';
			}
			if($shortcode == true) {
				$sc = '<div class="form-shortcode">'.__('Shortcode').': {'.$name.'}</div>';
				$dname = $name;
			} else {
				$sc = '';
				$dname = '';
			}
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['placeholder'])) {
				$placeholder = ' data-holder="'.$value['placeholder'].'"';
				$placeholdertxt = ' ('.$value['placeholder'].')';
			} else {
				$placeholder = '';
				$placeholdertxt = '';
			}
			if(isset($value['description'])) {
				$desc = ' <span class="popinfo popinfo-hide" data-info="'.$value['description'].'"'.$placeholder.'></span>';
				$desctxt = '<div class="form-input-description input-description-hide">'.$value['description'].$placeholdertxt.'</div>';
			} else {
				$desc = '';
				$desctxt = '';
			}
			if(isset($value['required'])) {
				$required = ' required';
				$txtreq = ' <span class="requiredlabel"></span>';
			} else {
				$required = '';
				$txtreq = '';
			}
			if(isset($value['multiple'])) {
				$multiple = ' multiple';
			} else {
				$multiple = '';
			}
			if(isset($value['value'])) {
				$val = ' value="'.$value['value'].'"';
			} else {
				$val = '';
			}
			if(isset($value['label'])) {
				$label = $value['label'];
			} else {
				$label = '';
			}
			$type =  'file';
			if($name != '') {
				$res .= '<div class="form-group">';
				$res .= '<label for="'.$id.'" class="main-form-label file-label">'.$label.$txtreq.$desc.$desctxt.'</label> ';
				$res .= $sc;
				$res .= '<input type="'.$type.'" name="'.$dname.'" class="'.$class.'" id="'.$id.'"'.$placeholder.$val.$multiple.'>';
				$res .= '<div class="qq-uploader-selector qq-uploader qq-gallery" qq-drop-area-text="Drop files here"></div>';
				$res .= '</div>';
			}
		}
		// Type Header
		if($value['type'] == 'header') {
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['label'])) {
				$label = $value['label'];
			} else {
				$label = '';
			}
			$type =  $value['subtype'];
			if($label != '') {
				$res .= '<div class="form-group">';
				$res .= '<'.$type.' class="'.$class.'">'.$label.'</'.$type.'>';
				$res .= '</div>';
			}
		}
		// Type Garagraph
		if($value['type'] == 'paragraph') {
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['label'])) {
				$label = nl2br($value['label']);
			} else {
				$label = '';
			}
			$type =  $value['subtype'];
			if($label != '') {
				$res .= '<div class="form-group">';
				$res .= '<'.$type.' class="'.$class.'">'.$label.'</'.$type.'>';
				$res .= '</div>';
			}
		}
		// Type Button
		if($value['type'] == 'button') {
			if(isset($value['className'])) {
				$class = $value['className'];
			} else {
				$class = '';
			}
			if(isset($value['label'])) {
				$label = nl2br($value['label']);
			} else {
				$label = '';
			}
			if($shortcode == true) {
				$type =  'a';
			} else {
				$type =  'button';
			}
			if($label != '') {
				$res .= '<div class="form-group">';
				$res .= '<'.$type.' class="'.$class.'">'.$label.'</'.$type.'>';
				$res .= '</div>';
			}	
		}	
	}
	return $res;
	}

}