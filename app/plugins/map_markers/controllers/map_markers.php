<?php
defined('BASEPATH') OR exit('No direct script access allowed');  
/**
* 
*/
class Map_markers extends Controller {

	function __construct(){ 
		parent::__construct();
		$this->settings_meta = array('gas-station-icons' => 'Gas Stations Icon');
	}

	public function admin_index(){
		$this->title = __('Hello', 'map_markers');
	}

	public function admin_settings() {
		$this->title = __('Setting page', 'map_markers');
		$this->set('settings', $this->map_markers->get_settings('gas-station-icon'));
		$this->set('map_api_key', $this->map_markers->get_settings('google-map-api-key',1));
		$this->set('map_height', $this->map_markers->get_settings('map-height',1));
		$this->set('region_colors', $this->map_markers->get_settings('map-marker-region-color'));
	}

	public function admin_add_region(){
		$this->title = __('Add Region', 'map_markers');
		$region_colors_setting = $this->map_markers->get_settings('map-marker-region-color');
		$region_colors = array();
		$option_colors = array();
		if(!empty($region_colors_setting)) {
			foreach ($region_colors_setting as $key => $value) {
				$option_colors[$value['id']] = $value['description'];
				$region_colors[$value['id']] = $value['value'];
			}
		}
		$regions = $this->map_markers->get_all_regions();
		foreach ($regions as $key => $value) {
			$regions[$key]['region_data'] = unserialize($value['region_data']);
			if(isset($region_colors[$value['color']])) {
				$regions[$key]['color_code'] = '#'.$region_colors[$value['color']];
			} else {
				$regions[$key]['color_code'] = '#cccccc';
			}
		}
		$this->set('Regions',$regions);
		$this->set('option_colors',$option_colors);
		$this->set('region_colors',$region_colors);
		$this->set('map_api_key', $this->map_markers->get_settings('google-map-api-key',1));
	}

	public function admin_add_to_map(){
		$this->title = __('Add Markers', 'map_markers');
		$icon_options = array();
		$map_icons = array();
		$map_icons_data = $this->map_markers->get_settings('gas-station-icon');
		foreach ($map_icons_data as $key => $value) {
			$icon_options[$value['id']] = $value['description'];
			$map_icons[$value['id']] = $value['value'];
		}
		$map_markers = $this->map_markers->get_all_stations();
		foreach ($map_markers as $key => $value) {
			$map_markers[$key]['station_data'] = unserialize($value['station_data']);
			
			if(isset($icon_options[$value['station']])) {
				$map_markers[$key]['station_type'] = $icon_options[$value['station']];
			} else {
				$map_markers[$key]['station_type'] = '';
			}
		}

		if($this->is_plugin_active('fuel_inventory')) {
			$this->set('fuel_inventory', true);
			$this->loadmodel('fuel_inventory');
			$sites = $this->fuel_inventory->get_all_sites('site_id,dealer');
			$marker_option = array();
			$relm = $this->map_markers->get_related_markers();
			$ch_relm = array();
			$e = 0;
			foreach ($relm as $value) {
				if($value['site_id'] > 0) {
					$ch_relm[$e] = $value['site_id'];
					$e++;
				}
			}

			foreach ($sites as $value) {
				if(!in_array($value['site_id'], $ch_relm)) {
					$marker_option[$value['site_id']] = $value['dealer'];
				}
				
			}
			$this->set('marker_option', $marker_option);
		} else {
			$this->set('fuel_inventory', false);
		}

		if($this->is_plugin_active('fuel-inventory')) {
			$this->set('fuel_inventory', true);
		} else {
			$this->set('fuel_inventory', false);
		}
		$this->set('icons_options', $icon_options);
		$this->set('icons', $map_icons);
		$this->set('stations', $map_markers);
		$this->set('map_api_key', $this->map_markers->get_settings('google-map-api-key',1));
	}

	public function admin_map(){
		$this->title = __('Map', 'map_markers');
		$map_icons = array();
		$dealer_options = array();
		$map_icons_data = $this->map_markers->get_settings('gas-station-icon');
		foreach ($map_icons_data as $key => $value) {
			$icon_options[$value['id']] = $value['description'];
			$map_icons[$value['id']] = $value['value'];
		}
		$map_markers = $this->map_markers->get_all_stations();
		foreach ($map_markers as $key => $value) {

			$map_markers[$key]['station_data'] = unserialize($value['station_data']);
			$da = ''; $dd = ''; $di = ''; $dg = ''; 

			$dealer_options[$value['latitude'].','.$value['longitude']] = $map_markers[$key]['station_data']['dealer'];
			
			$dt = '<div class="gas-map-dealer text-success">'.$map_markers[$key]['station_data']['dealer'].'</div>';
			if(!empty($map_markers[$key]['station_data']['address'])) {
				$da = '<div class="gas-map-address"><i class="fa fa-home" aria-hidden="true"></i> '.$map_markers[$key]['station_data']['address'].'</div>';
			}
			if(!empty($map_markers[$key]['station_data']['description'])) {
				$dd = '<div class="gas-map-description"><i class="fa fa-info-circle" aria-hidden="true"></i> '.$map_markers[$key]['station_data']['description'].'</div>';
			}
			if($map_markers[$key]['site_id'] != 0) {
				if(widget_isset('fuel_inventory','show-inventory-link-in-map-markers')){
					$dd .= '<div class="fuel-inventory-link">';
					$dd .= '<a class="text-success" href="'.admin_url('fuel-inventory/site/'.$map_markers[$key]['site_id']).'/"><i class="glyphicons glyphicons-gas-station"></i> ';
					$dd .= __('View Fuel Inventory','map_markers');
					$dd .= '</div>';
				}
			}
			if(!empty($map_markers[$key]['station_data']['comp_image'])) {
				$di = '<li><img src="'.admin_url('media/get-file/'.$map_markers[$key]['station_data']['comp_image']).'" alt=""></li>';
			}
			if(!empty($map_markers[$key]['station_data']['gallery'])) {
				$galls = rtrim($map_markers[$key]['station_data']['gallery'],',');
				$galls = explode(',', $galls);
				foreach ($galls as  $val) {
					$dg .= '<li><img src="'.admin_url('media/get-file/'.$val).'" alt=""></li>';
				}
				
			}

			if($di == '' && $dg == ''){
				$ds = '';
			} else {
				$ds = '<div class="rslides_container"><ul class="rslides" id="slider'.$key.'">'.$di.$dg.'</ul></div>';
			}
			if(isset($icon_options[$value['station']])) {
				$map_markers[$key]['station_type'] = $icon_options[$value['station']];
			} else {
				$map_markers[$key]['station_type'] = '';
			}
			if($ds == '') {
				$map_markers[$key]['map_info'] = '<div class="map-info">'.$dt.$da.$dd.'</div>';
			} else {
				$map_markers[$key]['map_info'] = '<div class="map-holder"><div class="map-image">'.$ds.'</div><div class="map-info">'.$dt.$da.$dd.'</div></div>';
			}
			
		}
		$region_colors_setting = $this->map_markers->get_settings('map-marker-region-color');
		$region_colors = array();
		if(!empty($region_colors_setting)) {
			foreach ($region_colors_setting as $key => $value) {
				$region_colors[$value['id']] = $value['value'];
			}
		}
		$regions = $this->map_markers->get_all_regions();
		foreach ($regions as $key => $value) {
			$regions[$key]['region_data'] = unserialize($value['region_data']);
			if(isset($region_colors[$value['color']])) {
				$regions[$key]['color_code'] = '#'.$region_colors[$value['color']];
			} else {
				$regions[$key]['color_code'] = '#cccccc';
			}
		}
		$this->set('Regions',$regions);
		$this->set('icons', $map_icons);
		$this->set('stations', $map_markers);
		$this->set('dealer_options', $dealer_options);
		$this->set('map_api_key', $this->map_markers->get_settings('google-map-api-key',1));
		$this->set('map_height', $this->map_markers->get_settings('map-height',1));
	}

	public function admin_edit_marker($id = NULL){
		$this->title = __('Edit Gas Station','map_markers');
		$station = $this->map_markers->get_station($id);
		if(!empty($station)) {
			$station['station_data'] = unserialize($station['station_data']);
			if(!empty($station['station_data']['gallery'])) {
				$station['station_data']['gallery'] = explode(',', rtrim($station['station_data']['gallery'],','));
			}
			$icon_options = array();
			$map_icons = array();
			$map_icons_data = $this->map_markers->get_settings('gas-station-icon');
			foreach ($map_icons_data as $key => $value) {
				$icon_options[$value['id']] = $value['description'];
				$map_icons[$value['id']] = $value['value'];
			}
			$this->set('has_data',true);
			$this->set('icon_options',$icon_options);
			$this->set('map_icons',$map_icons);
			$this->set('station',$station);
			$this->set('map_api_key', $this->map_markers->get_settings('google-map-api-key',1));

		} else {
			$this->set('has_data',false);
		}

		if(!empty($this->data)){
			$sd = array();
			$sd['gallery'] = '';
			if(isset($this->data['gallery_image'])){
				foreach ($this->data['gallery_image'] as $value) {
					$sd['gallery'] .= $value . ',';
				}
				//unset($this->data['gallery_image']);
			}
			$sd['dealer'] = $this->data['dealer'];
			$sd['address'] = $this->data['address'];
			$sd['description'] = $this->data['description'];
			$sd['comp_image'] = $this->data['featured_image'];
			unset($this->data['dealer']);
			unset($this->data['address']);
			unset($this->data['description']);
			//unset($this->data['featured_image']);
			$this->data['station_data'] = serialize($sd);
			$this->loadmodel('map_markers');
			$this->map_markers->id = $id;
			if($this->map_markers->id != NULL) {
				$ch = $this->map_markers->save($this->data);
				if($ch > 0) {
					Message::flash(__('Gas Station has been saved','map_markers'));
				} else {
					Message::flash(__('Nothing saved','map_markers'),'error');
				}
			} else {
				Message::flash(__('Could not edit Gas Station, no id was selected','map_markers'),'error');
			}
			$this->admin_redirect('map-markers/edit-marker/'.$id);
		}
		
	}

	public function rest_add_marker(){
		$data = array();
		if(!empty($this->data)) {
			$station_data = array();
			$station_data['dealer'] = $this->data['dealer'];
			$station_data['address'] = $this->data['address'];
			$station_data['description'] = $this->data['description'];
			$station_data['comp_image'] = $this->data['comp_image'];
			$station_data['gallery'] = $this->data['gallery'];
			$this->data['station_data'] = serialize($station_data);
			$this->data['status'] = 1 ;
			unset($this->data['dealer']);
			unset($this->data['address']);
			unset($this->data['description']);
			unset($this->data['comp_image']);
			unset($this->data['gallery']);
			$ch = $this->map_markers->save($this->data);
			if($ch > 0) {
				$data['ok'] = 'success';
			} else {
				$data['ok'] = 'failed';
			}
		}
		echo json_encode($data);
	}

	public function rest_add_region(){
		$data = array();
		if(!empty($this->data)) {
			$region_data = array();
			$region_data['name'] = $this->data['name'];
			$region_data['description'] = $this->data['description'];
			$this->data['region_data'] = serialize($region_data);
			$this->data['status'] = 1 ;
			unset($this->data['name']);
			unset($this->data['description']);
			$this->loadmodel('map_marker_regions');
			if($this->data['id'] > 0) {
				$this->map_marker_regions->id = $this->data['id'];
				unset($this->data['coordinates']);
			} else {
				unset($this->data['id']);
			}
			$ch = $this->map_marker_regions->save($this->data);
			if($ch > 0) {
				$data['ok'] = 'success';
			} else {
				$data['ok'] = 'failed';
			}
		}
		echo json_encode($data);
	}

	public function rest_remove_region($id){
		$data = array();
		$this->loadmodel('map_marker_regions');
		$this->map_marker_regions->id = $id;
		$this->data['status'] = 0;
		$ch = $this->map_marker_regions->save($this->data);
		if($ch > 0) {
			$data['ok'] = 'success';
		} else {
			$data['ok'] = 'failed';
		}
		echo json_encode($data);
	}

	public function rest_delete_marker(){
		$data = array();
		if(!empty($this->data)) {
			$this->data['status'] = 0 ;
			$this->map_markers->id = $this->data['id'];
			$ch = $this->map_markers->save($this->data);
			if($ch > 0) {
				$data['ok'] = 'success';
			} else {
				$data['ok'] = 'failed';
			}
		}
		echo json_encode($data);
	}

	public function rest_get_marker($id){
		$data = array();
		$station = $this->map_markers->get_station($id);
		if(!empty($station)) {
			$data['ok'] = 'success';
			$station['station_data'] = unserialize($station['station_data']);
			$data['station'] = $station;
		} else {
			$data['ok'] = 'failed';
		}
		
		
		echo json_encode($data);
	}

	public function rest_file_upload(){
		if(isset($this->data['comp'])) {
			$document = $this->map_markers->behavior->upload_protect_ajax('upload-map-data',array('size' => 5,'dir' => 'map/companies'));
		} else if(isset($this->data['gall'])) {
			$document = $this->map_markers->behavior->upload_protect_ajax('upload-map-data',array('size' => 5,'dir' => 'map/galleries'));
		} else {
			$document = $this->map_markers->behavior->upload_ajax('upload-map-data',array('size' => 5,'dir' => 'map/icons'));
		}
		echo $document;		
	}

	public function rest_settings(){
		$data = array();
		if(!empty($this->data)){
			$this->loadmodel('map_marker_settings');
			if(isset($this->data['api'])){
				$this->data['value'] = $this->data['api'];
				$this->map_marker_settings->column('meta','google-map-api-key');
				$ch = $this->map_marker_settings->save($this->data);
				$this->data['value'] = $this->data['map-height'];
				$this->map_marker_settings->column('meta','map-height');
				$ch = $this->map_marker_settings->save($this->data);
			} else if(isset($this->data['delet-icon'])) {
				$this->data['status'] = 0;
				$this->map_marker_settings->id = $this->data['id'];
				$ch = $this->map_marker_settings->save($this->data);
			} else if(isset($this->data['id'])) {
				$this->map_marker_settings->id = $this->data['id'];
				$ch = $this->map_marker_settings->save($this->data);
			} else {
				$this->data['status'] = 1;
				$ch = $this->map_marker_settings->save($this->data);
			}
			if($ch > 0) {
				$data['ok'] = 'success';
			} else {
				$data['ok'] = 'failed';
			}
		}

		echo json_encode($data);
	}

	public function rest_get_station($id){
		if($this->is_plugin_active('fuel_inventory')) {
			$this->loadmodel('fuel_inventory');
			$site['ok'] = 'success';
			$site['station'] = $this->fuel_inventory->get_site_data($id);
			echo json_encode($site);
		} 
	}

	

}