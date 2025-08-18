<?php defined('BASEPATH') OR exit('No direct script access allowed');

class MaintenanceController extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		$this->maintenanceView('', '');
	}

	public function moduleSetupView()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('all-maintenance', 'module-setup');
		$data = $headerData;

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$data['moduleTypeData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.m_module_type')->get()->result();
		$maintenanceTableData = [];
		$allTablesData = $this->db->list_tables();
		foreach ($allTablesData as $value) 
		{
			if (in_array(substr($value, 0, 2), array('m_', 's_'))) 
			{
				$maintenanceTableData[] = $value;
			}
		}

		$maintenanceGroupTableData = []; $maintenanceCheckData = [];
		$maintenanceArrayData = $this->db->from($customerDBSettingRow->database_name.'.maintenance')->order_by('name', 'ASC')->get()->result();
		foreach ($maintenanceArrayData as $maintenance) 
		{
			$maintenanceCheckData[$maintenance->name] = $maintenance->name;
			foreach ($maintenanceTableData as $value) 
			{
				if ($maintenance->name == $value)
					$maintenanceGroupTableData[$maintenance->module_type_id][] = $value;
			}
		}

		foreach ($maintenanceTableData as $value) 
		{
			if (!isset($maintenanceCheckData[$value]))
				$maintenanceGroupTableData['1234567890'][] = $value;
		}

		$data['maintenanceData'] = $maintenanceArrayData;
		$data['maintenanceTableData'] = $maintenanceTableData;
		$data['maintenanceGroupTableData'] = $maintenanceGroupTableData;

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/module_setup_view', $data);
		$this->load->view('admin/templates/footer_view', $headerData);
	}

	public function addModuleSetupModal($module_type_id)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$allTablesData = $this->db->list_tables();
		$finalData = [];
		foreach ($allTablesData as $key => $value) 
		{
			if (in_array(substr($value, 0, 2), array('m_', 's_')))  
			{
				$valueDataArray = [];
				$maintenanceTableData[] = $value;
				$maintenanceFieldData[$value] = $this->db->field_data($customerDBSettingRow->database_name.'.'.$value);
				$valueData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.'.$value)->order_by('created_at', 'ASC')->get()->result();
				$maintenanceFieldValueData[$value] = $valueData;
				foreach ($valueData as $key => $vd) 
				{
					$name = substr($value, 2) . '_id';
					$valueDataArray[$vd->$name] = $vd;
				}
				$dataCombine = $this->getDataCombine($value);
				$finalData[$dataCombine.'Data'] = $valueDataArray;
			}
		}

		$maintenanceGroupTableData = []; $maintenanceCheckData = [];
		$maintenanceArrayData = $this->db->from($customerDBSettingRow->database_name.'.maintenance')->order_by('name', 'ASC')->get()->result();
		foreach ($maintenanceArrayData as $maintenance) 
		{
			$maintenanceCheckData[$maintenance->name] = $maintenance->name;
			foreach ($maintenanceTableData as $value) 
			{
				if ($maintenance->name == $value)
					$maintenanceGroupTableData[$maintenance->module_type_id][] = $value;
			}
		}

		foreach ($maintenanceTableData as $value) 
		{
			if (empty($maintenanceCheckData[$value]))
				$maintenanceGroupTableData['0123456789'][] = $value;
		}

		$moduleTypeName = get_table($customerDBSettingRow->database_name.'.m_module_type', 'module_type_id',  $module_type_id, 'name');

		$modal = '<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">'.$moduleTypeName.' Setup</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<form action="'.base_url('add-module-setup/all-maintenance').'" method="POST" enctype="multipart/form-data">
							<div class="row">
								<div class="modal-body">								
									<div class="row">
										<input id="maintenance_id" name="maintenance_id" value="'.generate_uuid().'" hidden>
										<input id="module_type_id" name="module_type_id" value="'.$module_type_id.'" hidden>
										<div class="col-lg-12">
											<div class="mb-3">
												<label class="form-label">Maintenance</label>
												<select class="form-select btn-pill" id="name" name="name[]" required>
													<option value="" selected disabled hidden>Select Maintenance</option>';
													if (isset($maintenanceGroupTableData)): foreach($maintenanceGroupTableData as $key => $maintenanceGroup):
														$modal .= '<optgroup label="'.get_table('m_module_type', 'module_type_id', $key, 'name').'">';
															if (isset($maintenanceGroup)): foreach($maintenanceGroup as $maintenance):
																$modal .= '<option value="'.$maintenance.'" required>'.get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1)).'</option>';
															endforeach; endif;
														$modal .= '</optgroup>';
													endforeach; endif;
												$modal .= '</select>
											</div>										
										</div>	
									</div>						
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/200/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="10" y1="14" x2="21" y2="3" /><path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
									Add '.$moduleTypeName.' Setup
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function addModuleSetup($refer='module-setup')
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$postData = $this->input->post();
		$module_type_id = $postData['module_type_id'];
		$name = $postData['name'];
		$nameOther = "";
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		foreach ($name as $key => $value) 
		{
			$nameOther .= get_maintenance_naming($value, 'name', get_broken_name($value, '_', 1)).', ';
			$postData['name'] = $value;
			$maintenanceData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance')->where('name', $value)->get()->row();
			if (!empty($maintenanceData))
			{
				$this->db->update($customerDBSettingRow->database_name.'.maintenance', $postData, array('maintenance_id'=>$maintenanceData->maintenance_id));
			}
			else
			{
				$this->db->insert($customerDBSettingRow->database_name.'.maintenance', $postData);
			}
		}
		$description = $nameOther.' added successfully ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$session_data['user_id'].' : '.$description));
		redirect(($refer=='module-setup' ? $refer : $refer.'/'.$module_type_id), 'refresh');
	}

	public function maintenanceView($module_type_id='', $selected_table_id='')
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('all-maintenance');
		$data = $headerData;

		$finalData = []; $allTableLimitedData = []; $maintenanceModuleTypeData = []; $sustenanceData = []; $maintenanceFieldData = []; $maintenanceFieldValueData = [];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		if (empty($module_type_id))
		{
			$allTableLimitedData = $this->db->query("SHOW TABLES FROM ".$customerDBSettingRow->database_name)->result_array();//$this->db->list_tables();
		}
		else
		{
			$maintenanceModuleTypeData = $this->db->from($customerDBSettingRow->database_name.'.maintenance')->where('module_type_id', $module_type_id)->order_by('module_type_id', 'ASC')->get()->result();
			foreach ($maintenanceModuleTypeData as $value) 
			{
				$allTableLimitedData[] = $value->name;
			}
		}

		foreach ($allTableLimitedData as $value) 
		{
			if (in_array(substr($value, 0, 2), array('m_', 's_')))  
			{
				$sustenanceData[] = $value;
				$maintenanceFieldData[$value] = $this->db->field_data($customerDBSettingRow->database_name.'.'.$value);
			}
		}

		$allTablesData = $this->db->query("SHOW TABLES FROM ".$customerDBSettingRow->database_name)->result_array();//$this->db->list_tables();
		foreach ($allTablesData as $table) 
		{
			$value = array_values($table)[0];
			if (in_array(substr($value, 0, 2), array('m_', 's_')) || in_array($value, array('maintenance')))  
			{
				$valueDataArray = [];
				$maintenanceTableData[] = $value;
				$maintenanceFieldData[$value] = $this->db->field_data($customerDBSettingRow->database_name.'.'.$value);
				if ($value == 'm_quote') {
					$valueData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.'.$value)->where('module_type_id', $module_type_id)->order_by('created_at', 'DESC')->get()->result();
				} elseif ($value == 'm_module') {
					$valueData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.'.$value)->order_by('order', 'ASC')->get()->result();
				} else {
					$valueData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.'.$value)->order_by('created_at', 'ASC')->get()->result();
				}
				$maintenanceFieldValueData[$value] = $valueData;
				foreach ($valueData as $vd) 
				{
					$name = in_array($value, array('maintenance')) ? $value.'_id' : substr($value, 2).'_id';
					$valueDataArray[$vd->$name] = $vd;
				}
				$dataCombine = '';
				$valueExplode = explode('_', substr($value, 2));
				for ($i=0; $i < count($valueExplode); $i++) { 
					$dataCombine .= $i >= 1 ? ucfirst($valueExplode[$i]) : $valueExplode[$i];
				}
				$finalData[$dataCombine.'Data'] = $valueDataArray;
				$data['maintenanceFinalData'] = $finalData;
			}
		}
		
		$maintenanceGroupTableData = []; $maintenanceCheckData = [];
		$maintenanceArrayData = $this->db->from($customerDBSettingRow->database_name.'.maintenance')->order_by('name', 'ASC')->get()->result();
		foreach ($maintenanceArrayData as $maintenance) 
		{
			$maintenanceCheckData[$maintenance->name] = $maintenance->name;
			foreach ($maintenanceTableData as $value) 
			{
				if ($maintenance->name == $value)
					$maintenanceGroupTableData[$maintenance->module_type_id][] = $value;
			}
		}

		foreach ($maintenanceTableData as $value) 
		{
			if (empty($maintenanceCheckData[$value]))
				$maintenanceGroupTableData['0123456789'][] = $value;
		}

		// print_r(json_encode($maintenanceGroupTableData));
		// exit;

		$headerData['module_type_id'] = $module_type_id;
		$data['module_type_id'] = $module_type_id;
		$data['selected'] = $selected_table_id;
		$data['selectedTableId'] = $selected_table_id;
		$data['numericSelectData'] = $finalData['numericSelectData'];
		$data['maintenanceFieldData'] = $maintenanceFieldData;
		$data['maintenanceFieldValueData'] = $maintenanceFieldValueData;
		$data['sustenanceData'] = $sustenanceData;
		$data['maintenanceModuleTypeData'] = $maintenanceModuleTypeData;
		$data['maintenanceTableData'] = $maintenanceTableData;
		$data['maintenanceGroupTableData'] = $maintenanceGroupTableData;

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('admin/maintenance_view', $data);
		$this->load->view('admin/templates/footer_view', $headerData);
	}

	public function addMaintenanceModal($module_id, $module_type_id, $maintenance, $column_id='', $data_id='')
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$finalData = [];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$allTablesData = $this->db->query("SHOW TABLES FROM ".$customerDBSettingRow->database_name)->result_array();//$this->db->list_tables();
		foreach ($allTablesData as $table) 
		{
			$value = array_values($table)[0];
			if (in_array(substr($value, 0, 2), array('m_', 's_')))  
			{
				$valueDataArray = [];
				$maintenanceFieldData[$value] = $this->db->field_data($customerDBSettingRow->database_name.'.'.$value);
				$valueData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.'.$value)->order_by('created_at', 'ASC')->get()->result();
				foreach ($valueData as $vd) 
				{
					$name = substr($value, 2) . '_id';
					$valueDataArray[$vd->$name] = $vd;
				}
				$dataCombine = $this->getDataCombine($value);
				$finalData[$dataCombine.'Data'] = $valueDataArray;
			}
		}
		
		$finalData['maintenanceData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance')->order_by('created_at', 'ASC')->get()->result();

		$groupStart = false;
		$counter = 0;
		$modal ='<div class="modal-dialog modal-'.(in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753636030565', 'multi_table'))) ? 'full-width' : 'lg').' modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">New '.get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1)).'</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('add-maintenance').'" method="POST" enctype="multipart/form-data">
							<input id="module_id" name="module_id" value="'.$module_id.'" hidden>
							<input id="module_type_id" name="module_type_id" value="'.$module_type_id.'" hidden>
							<input id="table" name="table" value="'.$maintenance.'" hidden>
							<input id="'.(substr($maintenance, 2).'_id').'" name="'.(substr($maintenance, 2).'_id').'" value="'.generate_uuid().'" hidden>
							<div class="modal-body" '.(in_array($maintenance, array('m_property_plot')) ? '' : 'hidden').'>
								<div class="row">
									<div class="col-lg-6">					
										<div class="mb-3">
											<label class="form-label">How many '.get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1)).'</label>
											<input id="how_many" name="how_many" type="number" class="form-control btn-pill" placeholder="How Many '.get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1)).'">
										</div>			
									</div>
								</div>
							</div>';
							if (isset($maintenanceFieldData[$maintenance])): foreach($maintenanceFieldData[$maintenance] as $pos => $maintenanceField): if (!in_array($maintenanceField->name, explode(',', get_table('m_column_define', 'column_define_id', '1753658383444', 'multi_column'))) && $pos != 1): 
							$nameField = $maintenanceField->name; $combineColumnToTable = get_combine_column_to_table($nameField);
							if ($counter % (in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753636030565', 'multi_table'))) ? 4 : 2) === 0) {
								$modal .= '<div class="modal-body"><div class="row">';
								$groupStart = true;
							}
							$modal .= '<div class="col-lg-'.(in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753523895711', 'multi_column'))) ? (in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753636030565', 'multi_table'))) ? 6 : 12) : (in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753636030565', 'multi_table'))) ? 3 : 6)).'">
								<div class="mb-3">';
								if (in_array($nameField, array('state', 'active'))) {
									$modal .= '<label class="form-label">Select '.ucfirst($nameField).'</label>
									<select id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" class="form-select btn-pill" required>
										<option value="" selected disabled>Select '.$nameField.'</option>';
										$stateActiveData = ($nameField == 'state' ? $finalData['stateData'] : $finalData['activeData']); 
										if (isset($stateActiveData)): foreach($stateActiveData as $data):
											$modal .= '<option value="'.$data->num.'"'.($data->active == 0 ? 'disabled' : '').'>'.$data->name.'</option>';
										endforeach; endif;
									$modal .= '</select>';
								} elseif (substr($nameField, -3) == '_id' && !in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753656187721', 'multi_column')))) {
									$modal .= '<label class="form-label">'.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0, -3), '_'))).'</label>
									<select id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" class="form-select btn-pill" required>
										<option value="" selected disabled>Select '.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0, -3), '_'))).'</option>';
										if (isset($finalData[$combineColumnToTable.'Data'])): foreach($finalData[$combineColumnToTable.'Data'] as $data):
											$modal .= '<option value="'.$data->$nameField.'"'.($data->active == 0 ? 'disabled' : '').' '.($nameField == $column_id && $data->$column_id == $data_id ? 'selected' : '').'>'.$data->name.'</option>';
										endforeach; endif;
									$modal .= '</select>';	
								} elseif (in_array($nameField, array('multi_table'))) {
									$modal .= '<label class="form-label">'.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0), '_'))).'</label>
										<select id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'[]" class="form-select btn-pill" style="width:100%" multiple>';
										if (isset($finalData['maintenanceData'])): foreach($finalData['maintenanceData'] as $data):
											$modal .= '<option value="'.$data->name.'">'.$data->name.'</option>';
										endforeach; endif;
									$modal .= '</select>';																																																	
								} elseif (in_array($nameField, array('main_id', 'module_id'))) {
									$modal .= '<label class="form-label">Module</label>
									<select id="input_'.$maintenance.'_'.($nameField == 'main_id' ? 'main_id' : 'module_id').'" name="'.($nameField == 'main_id' ? 'main_id' : 'module_id').'" class="form-select btn-pill" required>
										<option value="" selected disabled>Select Module</option>';
										if ($nameField == 'main_id'):
											$modal .= '<option value="N/A">Not Applicable</option>';
										endif;
										if (isset($finalData['platformData'])): foreach($finalData['platformData'] as $platform):
											$modal .= '<optgroup label="'.$platform->name.'">';
												if (isset($finalData['moduleData'])): foreach($finalData['moduleData'] as $data): if ($data->sub == 0 && $platform->platform_id == $data->platform_id):
													$modal .= '<option value="'.$data->module_id.'"'.(in_array($maintenance, array('m_quote')) && $data->module_type_id == $module_type_id ? 'selected' : '').' '.($data->active == 0 ? 'disabled' : '').'>'.$data->name.'</option>';
												endif; endforeach; endif;
											$modal .= '</optgroup>';
										endforeach; endif;
									$modal .= '</select>';
								} elseif (in_array($nameField, array('color_id'))) {
									$modal .= '<label class="form-label">'.ucfirst(get_broken_name($nameField, '_')).'</label>
									<select id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" class="form-select btn-pill" required>
										<option value="" selected>Select Color</option>';
										if (isset($finalData['colorData'])): foreach($finalData['colorData'] as $data):
											$modal .= '<option value="'.$data->color_id.'"'.($data->active == 0 ? 'disabled' : '').'>'.$data->name.'</option>';
										endforeach; endif;
									$modal .= '</select>';
								} elseif (in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753528719052', 'multi_column'))) && !in_array($maintenance, array('m_choice'))) {
									$modal .= '<label class="form-label">'.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0), '_'))).'</label>
									<select id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" class="form-select btn-pill" required>
										<option value="" selected>Select '.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0), '_'))).'</option>';
										if (isset($finalData['choiceData'])): foreach($finalData['choiceData'] as $data):
											$modal .= '<option value="'.$data->num.'"'.($data->active == 0 ? 'disabled' : '').'>'.$data->name.'</option>';
										endforeach; endif;
									$modal .= '</select>';	
								} elseif (in_array($nameField, array('sold_color_id')) && !in_array($maintenance, array('m_color'))) {
									$modal .= '<label class="form-label">'.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0, -3), '_'))).'</label>
									<select id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" class="form-select btn-pill" required>
										<option value="" disabled>Select '.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0, -3), '_'))).'</option>';
										if (isset($finalData['colorData'])): foreach($finalData['colorData'] as $data):
											$modal .= '<option value="'.$data->color_id.'">'.$data->name.'</option>';
										endforeach; endif;
									$modal .= '</select>';																												
								} elseif (in_array($nameField, array('module_type_id'))) {
									$modal .= '<label class="form-label">Module Type</label>
									<select id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" class="form-select btn-pill" required>
										<option value="" selected disabled>Select Module Type</option>';
										if (isset($finalData['moduleTypeData'])): foreach($finalData['moduleTypeData'] as $data):
											$modal .= '<option value="'.$data->module_type_id.'"'.(in_array($maintenance, array('m_quote')) && $data->module_type_id == $module_type_id ? 'selected' : '').' '.($data->active == 0 ? 'disabled' : '').'>'.$data->name.'</option>';
										endforeach; endif;
									$modal .= '</select>';																																
								} elseif (in_array($nameField, array('user_id'))) {	
									$modal .= '<label class="form-label">Users</label>
									<select id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" class="form-select btn-pill" required>
										<option value="" selected disabled>Select User</option>';
										if (isset($finalData['userData'])): foreach($finalData['userData'] as $data): if (!in_array($data->user_type_id, array(GlobalModel::TEACHER_TYPE, GlobalModel::STUDENT_TYPE))):
											$modal .= '<option value="'.$data->user_id.'" data-custom-properties="&lt;span class=&quot;avatar avatar-xs&quot;&gt;'.get_initial($data->full_legal_name).'&lt;/span&gt;">'.$data->full_legal_name.'</option>';
										endif; endforeach; endif;
									$modal .= '</select>';
								} elseif (in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753524572547', 'multi_column'))) && !in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753631350542', 'multi_table')))) {	
									$modal .= '<div class="form-label">'.ucfirst(get_broken_name($nameField, '_')).'</div>
									<input id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" type="file" class="form-control btn-pill" />';
								} elseif (in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753524572547', 'multi_column'))) && in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753631350542', 'multi_table')))) {	
									$modal .= '<div class="form-label">'.ucfirst($nameField).' In Bulk</div>
									<input id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'[]" type="file" class="form-control btn-pill" multiple/>';
								} elseif (in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753528816500', 'multi_column')))) {	
									$modal .= '<label class="form-label">'.ucfirst(get_broken_name($nameField, '_')).'
										<span class="form-help" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="'.ucfirst(get_broken_name($nameField, '_')).'">?</span>
									</label>
									<textarea id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" rows="3" class="form-control btn-pill" placeholder="Input '.ucfirst(get_broken_name($nameField, '_')).'" required></textarea>';	
								} elseif (in_array($nameField, array('password'))) {	
									$modal .= '<label class="form-label">'.ucfirst($nameField).'</label>	
									<div class="input-group input-group-flat">
										<input id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" type="password" class="form-control btn-pill" placeholder="Input '.$nameField.'" required>
										<span class="input-group-text">
											<a href="#" id="togglePassword" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
											</a>
										</span>
									</div>';																						
								} elseif (in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753633893334', 'multi_column')))) {
									$title = in_array($maintenance, array('m_property', 'm_video_testimonial', 'm_quote', 'm_house_design', 'm_csr_video')) ? 'Youtube Link' : ucfirst(get_broken_name($nameField, '_'));
									$modal .= '<label class="form-label">'.$title.'</label>
									<div class="input-group">
										<span class="input-group-text">'.(in_array($maintenance, array('m_property', 'm_video_testimonial', 'm_quote', 'm_house_design', 'm_csr_video')) ? 'https://youtu.be/' : 'https://.../').'</span>
										<input id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" type="text" class="form-control btn-pill" placeholder="Input '.$title.'" required>
									</div>';
								} else {
									$maintenanceFieldType = $maintenanceField->type;
									if ($maintenanceField->type == 'int') {
										$maintenanceFieldType = 'number';
									} elseif (in_array($maintenanceField->type, array('varchar', 'decimal'))) {
										$maintenanceFieldType = 'text';
									}
									$modal .= '<label class="form-label">'.ucfirst(get_broken_name($nameField, '_')).'</label>
									<input id="input_'.$maintenance.'_'.$nameField.'" name="'.$nameField.'" type="'.$maintenanceFieldType.'" class="form-control btn-pill" placeholder="Input '.ucfirst(get_broken_name($nameField, '_')).'" required>';
								}
								$modal .= '</div>
							</div>';	
							$counter++;
							if ($counter % (in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753636030565', 'multi_table'))) ? 4 : 2) === 0) {
								$modal .= '</div></div>';
								$groupStart = false;
							}		
							endif; endforeach; endif; 
							if ($groupStart) {
								$modal .= '</div></div>';
							}
							$modal .= '<div class="modal-footer">
								<button type="submit" href="" class="btn btn-warning btn-pill">Add '.get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1)).'</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function addMaintenance()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$postData = $this->input->post();

		$arrayData = $postData;
		$table = $postData['table'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$moduleRow = $this->db->select('*')->from('m_module')->where('module_id', $postData['module_id'])->get()->row();
		$name = isset($postData['name']) ? $postData['name'] : $postData[substr($table, 2).'_id'];
		$module_type_id = $postData['module_type_id'];
		$how_many = $postData['how_many'] ?? 0;
		unset($arrayData['module_id'], $arrayData['table'], $arrayData['how_many'], $arrayData['password']);
		if (!in_array($table, array('m_module_type'))) 
		{
			unset($arrayData['module_type_id']);
		}

		if (isset($postData['multi_table'])) 
		{
			$commaArray = '';
			foreach ($postData['multi_table'] as $value) {
				$commaArray .= $value.',';
			}
			$arrayData['multi_table'] = $commaArray;
		}

		if (isset($postData['password']) && !empty($postData['password'])) 
		{
			$arrayData['password'] = sha1($postData['password']);
		}

		if (in_array($table, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753645578872', 'multi_table'))))
		{
			$arrayData['name_id'] = get_title_id($name, ' ', '-');
		}

		$path = "assets/img/";
		$explodeColumnDefineImages = explode(',', get_table('m_column_define', 'column_define_id', '1753524572547', 'multi_column'));
		foreach ($explodeColumnDefineImages as $value) 
		{
			$path = in_array($value, explode(',', get_table('m_column_define', 'column_define_id', '1753654719137', 'multi_column'))) ? "assets/doc/" :"assets/img/";
			if (isset($_FILES[$value]['name']))
			{
				$image = do_file_upload($value, $path);
				$arrayData[$value] = $path.$image['file']['file_name'];
			}
			else
			{
				unset($arrayData[$value]);
			}
		}

		if (is_array($_FILES["url"]["name"]) && (in_array($table, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753631350542', 'multi_table')))))
		{
			$path = "assets/img/";
			foreach ($_FILES['url']['name'] as $key => $tmp_name) 
			{
				$file_name = $_FILES['url']['name'][$key];
				$file_tmp = $_FILES['url']['tmp_name'][$key];
				$file_type = $_FILES['url']['type'][$key];
				$file_size = $_FILES['url']['size'][$key];
		
				if ($file_name === "" || $file_size == 0) {
					continue;
				}

				$originalFileName = basename($file_name);
				$explode = explode('.', $originalFileName);
				$target_path = $path.sha1($explode[0]).$explode[1];

				move_uploaded_file($file_tmp, $target_path);
				$arrayData[substr($table, 2).'_id'] = generate_uuid();
				$arrayData['url'] = $target_path;
				$res = $this->db->insert($table, $arrayData);
			}
		}
		else
		{
			foreach ($explodeColumnDefineImages as $value) 
			{
				if (isset($_FILES[$value]['name']))
				{
					$image = do_file_upload($value, $path);
					$arrayData[$value] = $path.$image['file']['file_name'];
				}
				else
				{
					unset($arrayData[$value]);
				}
			}

			if (!empty($how_many) && $how_many >= 1)
			{
				for ($i = 0; $i < $how_many; $i++) { 
					$arrayData[substr($table, 2).'_id'] = generate_uuid();
					$res = $this->db->insert($customerDBSettingRow->database_name.'.'.$table, $arrayData);
				}
			}
			else
			{
				$res = $this->db->insert($customerDBSettingRow->database_name.'.'.$table, $arrayData);
			}
		}

		$description = $res ? $name.' added successful 😉' : 'Adding '.$name.' went wrong 😞';
		$this->session->set_flashdata($res ? 'message' : 'err', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$session_data['user_id'].' : '.$table.' : '.$description));
		redirect($moduleRow->path.'/'.$module_type_id.'/'.$table, 'refresh');
	}

	public function editMaintenanceModal($module_id, $module_type_id, $maintenance, $unique_id)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$finalData = [];
		$maintenanceFieldData = [];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$allTablesData = $this->db->query("SHOW TABLES FROM ".$customerDBSettingRow->database_name)->result_array();//$this->db->list_tables();
		foreach ($allTablesData as $table) 
		{
			$value = array_values($table)[0];
			if (in_array(substr($value, 0, 2), array('m_', 's_')))  
			{
				$valueDataArray = [];
				$maintenanceFieldData[$value] = $this->db->field_data($customerDBSettingRow->database_name.'.'.$value);
				$valueData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.'.$value)->order_by('created_at', 'ASC')->get()->result();
				foreach ($valueData as $vd) 
				{
					$name = substr($value, 2).'_id';
					$valueDataArray[$vd->$name] = $vd;
				}
				$dataCombine = '';
				$valueExplode = explode('_', substr($value, 2));
				for ($i = 0; $i < count($valueExplode); $i++) 
				{
					$dataCombine .= $i >= 1 ? ucfirst($valueExplode[$i]) : $valueExplode[$i];
				}
				$finalData[$dataCombine.'Data'] = $valueDataArray;
			}
		}
		$finalData['maintenanceData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance')->order_by('created_at', 'ASC')->get()->result();

		$column = $maintenanceFieldData[$maintenance][1]->name; 
		$maintenance_id = substr($maintenance, 2).'_id';
		$maintenanceFieldValue = $this->db->select('*')->from($maintenance)->where($maintenance_id, $unique_id)->order_by('created_at', 'ASC')->get()->row();

		$groupStart = false;
		$counter = 0;
		$modal ='<div class="modal-dialog modal-'.(in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753636030565', 'multi_table'))) ? 'full-width' : 'lg').' modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit '.get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1)).' ( '.$maintenanceFieldValue->$column.' )</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('edit-maintenance').'" method="POST" enctype="multipart/form-data" style="background-color: #fdfdfd;">
							<input id="module_id" name="module_id" type="hidden" value="'.$module_id.'">
							<input id="module_type_id" name="module_type_id" type="hidden" value="'.$module_type_id.'" required>
							<input id="table" name="table" type="hidden" value="'.$maintenance.'">
							<input id="unique_id" name="unique_id" type="hidden" value="'.$maintenanceFieldValue->$column.'">';
								if (isset($maintenanceFieldData[$maintenance])): foreach($maintenanceFieldData[$maintenance] as $pos => $maintenanceField): if (!in_array($maintenanceField->name, explode(',', get_table('m_column_define', 'column_define_id', '1753658383444', 'multi_column'))) && $pos != 1):
									$columns = $maintenanceFieldData[$maintenance][$pos]->name; $nameField = $maintenanceField->name; $combineColumnToTable = get_combine_column_to_table($nameField);
									if ($counter % (in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753636030565', 'multi_table'))) ? 4 : 2) === 0) {
										$modal .= '<div class="modal-body"><div class="row">';
										$groupStart = true;
									}
									$modal .= '<div class="col-lg-'.(in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753523895711', 'multi_column'))) ? (in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753636030565', 'multi_table'))) ? 6 : 12) : (in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753636030565', 'multi_table'))) ? 3 : 6)).'">
										<div class="mb-3">';
											if (in_array($nameField, array('state', 'active'))) {
												$modal .= '<label class="form-label">'.ucfirst($nameField).'</label>
												<select id="edit_'.$maintenance.'_'.$nameField.'_'.$maintenanceFieldValue->$column.'" name="'.$nameField.'" class="form-select btn-pill">
													<option value="" disabled>Select '.ucfirst($nameField).'</option>';
													$stateActiveData = ($nameField == 'state' ? $finalData['stateData'] : $finalData['activeData']); 
													if (isset($stateActiveData)): foreach($stateActiveData as $data):
														$num = $nameField;
														$modal .= '<option value="'.$data->num.'" '.($data->num == $maintenanceFieldValue->$num ? 'selected' : '').' '.($data->active == 0 ? 'disabled' : '').'>'.$data->name.'</option>';
													endforeach; endif;
												$modal .= '</select>';
											} elseif (substr($nameField, -3) == '_id' && !in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753656187721', 'multi_column')))) {
												$modal .= '<label class="form-label">'.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0, -3), '_'))).'</label>
												<select id="edit_'.$maintenance.'_'.$nameField.'_'.$maintenanceFieldValue->$column.'" name="'.$nameField.'" class="form-select btn-pill" '.(get_maintenance_column(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), $nameField, 1) ? 'disabled' : '').' required>
													<option value="" selected disabled>Select '.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0, -3), '_'))).'</option>';
													if (isset($finalData[$combineColumnToTable.'Data'])): foreach($finalData[$combineColumnToTable.'Data'] as $data):
														$modal .= '<option value="'.$data->$nameField.'" '.($data->$nameField == $maintenanceFieldValue->$columns ? 'selected' : '').' '.($data->active == 0 ? 'disabled' : '').'>'.$data->name.'</option>';
													endforeach; endif;
												$modal .= '</select>';	
											} elseif (in_array($nameField, array('multi_table'))) {
												$modal .= '<label class="form-label">'.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0), '_'))).'</label>
													<select id="edit_'.$maintenance.'_'.$nameField.'_'.$maintenanceFieldValue->$column.'" name="'.$nameField.'[]" class="form-select btn-pill" style="width:100%" '.(get_maintenance_column(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), $nameField, 1) ? 'disabled' : '').' multiple>';
													if (isset($finalData['maintenanceData'])): foreach($finalData['maintenanceData'] as $data):
														$modal .= '<option value="'.$data->name.'" '.($data->name == get_explode_select($maintenanceFieldValue->$columns, $data->name) ? 'selected' : '').'>'.$data->name.'</option>';
													endforeach; endif;
												$modal .= '</select>';
											} elseif (in_array($nameField, array('user_id'))) {
												$modal .= '<label class="form-label">Users</label>
												<select id="edit_'.$maintenance.'_'.$nameField.'_'.$maintenanceFieldValue->$column.'" name="'.$nameField.'" '.(get_maintenance_column(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), $nameField, 1) ? 'disabled' : '').' class="form-select btn-pill" required>
													<option value="" disabled>Select User</option>';
													if (isset($finalData['userData'])): foreach($finalData['userData'] as $data): if (!in_array($data->user_type_id, array(GlobalModel::TEACHER_TYPE, GlobalModel::STUDENT_TYPE))):
														$modal .= '<option value="'.$data->user_id.'" data-custom-properties="&lt;span class=&quot;avatar avatar-xs&quot;&gt;'.get_initial($data->full_legal_name).'&lt;/span&gt;"'.($data->user_id == $maintenanceFieldValue->$columns ? 'selected' : '').'>'.$data->full_legal_name.'</option>';
													endif; endforeach; endif;
												$modal .= '</select>';
											} elseif (in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753528719052', 'multi_column'))) && !in_array($maintenance, array('m_choice'))) {
												$modal .= '<label class="form-label">'.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0), '_'))).'</label>
												<select id="edit_'.$maintenance.'_'.$nameField.'_'.$maintenanceFieldValue->$column.'" name="'.$nameField.'" class="form-select btn-pill" '.(get_maintenance_column(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), $nameField, 1) ? 'disabled' : '').'>
													<option value="" disabled>Select '.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0), '_'))).'</option>';
													if (isset($finalData['choiceData'])): foreach($finalData['choiceData'] as $data):
														$modal .= '<option value="'.$data->num.'"'.($data->num == $maintenanceFieldValue->$nameField ? 'selected' : '').' '.($data->active == 0 ? 'disabled' : '').'>'.$data->name.'</option>';
													endforeach; endif;
												$modal .= '</select>';
											} elseif (in_array($nameField, array('sold_color_id')) && !in_array($maintenance, array('m_color'))) {
												$modal .= '<label class="form-label">'.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0), '_'))).'</label>
												<select id="edit_'.$maintenance.'_'.$nameField.'_'.$maintenanceFieldValue->$column.'" name="'.$nameField.'" class="form-select btn-pill" '.(get_maintenance_column(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), $nameField, 1) ? 'disabled' : '').'>
													<option value="" disabled>Select '.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0), '_'))).'</option>';
													if (isset($finalData['colorData'])): foreach($finalData['colorData'] as $data):
														$modal .= '<option value="'.$data->color_id.'"'.($data->color_id == $maintenanceFieldValue->$nameField ? 'selected' : '').' '.($data->active == 0 ? 'disabled' : '').'>'.$data->name.'</option>';
													endforeach; endif;
												$modal .= '</select>';																																																																									
											} elseif (in_array($nameField, array('main_id', 'module_id'))) {
												$modal .= '<label class="form-label">Module</label>
												<select id="edit_'.$maintenance.'_'.($nameField == 'main_id' ? 'main_id' : 'module_id').'" name="'.($nameField == 'main_id' ? 'main_id' : 'module_id').'_'.$maintenanceFieldValue->$column.'" class="form-select btn-pill" '.(get_maintenance_column(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), $nameField, 1) ? 'disabled' : '').' required>
													<option value="" disabled>Select Module</option>';
													if ($nameField == 'main_id'):
														$modal .= '<option value="N/A">Not Applicable</option>';
													endif;
													if (isset($finalData['platformData'])): foreach($finalData['platformData'] as $key => $platform):
														$modal .= '<optgroup label="'.$platform->name.'">';
															if (isset($finalData['moduleData'])): foreach($finalData['moduleData'] as $data): if ($data->sub == 0 && $platform->platform_id == $data->platform_id):
																$modal .= '<option value="'.$data->module_id.'"'.(in_array($maintenance, array('m_quote')) && $data->module_type_id == $module_type_id ? 'selected' : '').' '.($data->module_id == $maintenanceFieldValue->$columns ? 'selected' : '').' '.($data->active == 0 ? 'disabled' : '').'>'.$data->name.'</option>';
															endif; endforeach; endif;
														$modal .= '</optgroup>';
													endforeach; endif;
												$modal .= '</select>';		
											} elseif (in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753528816500', 'multi_column')))) {	
												$modal .= '<label class="form-label">'.ucfirst(get_broken_name($nameField, '_')).'
													<span class="form-help" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-content="'.ucfirst(get_broken_name($nameField, '_')).'">?</span>
												</label>
												<textarea id="edit_'.$maintenance.'_'.$nameField.'_'.$maintenanceFieldValue->$column.'" name="'.$nameField.'" rows="3" class="form-control btn-pill" placeholder="Input '.ucfirst(get_broken_name($nameField, '_')).'" '.(get_maintenance_column(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), $nameField, 1) ? 'disabled' : '').' required>'.$maintenanceFieldValue->$columns.'</textarea>';
											} elseif (in_array($nameField, array('password'))) {	
												$modal .= '<label class="form-label">'.ucfirst($nameField).'</label>
												<div class="input-group input-group-flat">
													<input id="input_'.$maintenance.'_'.$nameField.'_'.$maintenanceFieldValue->$column.'" name="'.$nameField.'" type="password" class="form-control btn-pill" placeholder="Input '.ucfirst(get_broken_name($nameField, '_')).'" '.(get_maintenance_column(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), $nameField, 1) ? 'disabled' : '').'></input>
													<span class="input-group-text">
														<a href="#" id="togglePassword" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
															<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
														</a>
													</span>
												</div>';																
											} elseif (in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753633893334', 'multi_column')))) {
												$title = in_array($maintenance, array('m_property', 'm_video_testimonial', 'm_quote', 'm_house_design', 'm_csr_video')) ? 'Youtube Link' : ucfirst(get_broken_name($nameField, '_'));
												$modal .= '<label class="form-label">'.$title.'</label>
												<div class="input-group">
													<span class="input-group-text">'.(in_array($maintenance, array('m_property', 'm_video_testimonial', 'm_quote', 'm_house_design', 'm_csr_video')) ? 'https://youtu.be/' : 'https://.../').'</span>
													<input id="edit_'.$maintenance.'_'.$nameField.'_'.$maintenanceFieldValue->$column.'" name="'.$nameField.'" type="text" class="form-control btn-pill" placeholder="Input '.$title.'" value="'.$maintenanceFieldValue->$columns.'" '.(get_maintenance_column(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), $nameField, 1) ? 'disabled' : '').' required>
												</div>';
											} elseif (!in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753524572547', 'multi_column')))) {
												$maintenanceFieldType = $maintenanceField->type;
												if ($maintenanceField->type == 'int') {
													$maintenanceFieldType = 'number';
												} elseif (in_array($maintenanceField->type, array('varchar', 'decimal'))) {
													$maintenanceFieldType = 'text';
												}
												$modal .= '<label class="form-label">'.ucfirst(get_broken_name($nameField, '_')).'</label>
												<input id="edit_'.$maintenance.'_'.$nameField.'_'.$maintenanceFieldValue->$column.'" name="'.$nameField.'" type="'.$maintenanceFieldType.'" class="form-control btn-pill" placeholder="Input '.ucfirst(get_broken_name($nameField, '_')).'" value="'.$maintenanceFieldValue->$columns.'" '.(get_maintenance_column(get_table('maintenance', 'name', $maintenance, 'maintenance_id'), $nameField, 1) ? 'disabled' : '').' required>';
											}	
										$modal .= '</div>
									</div>';	
									$counter++;
									if ($counter % (in_array($maintenance, explode(',', get_table('m_maintenance_define', 'maintenance_define_id', '1753636030565', 'multi_table'))) ? 4 : 2) === 0) {
										$modal .= '</div></div>';
										$groupStart = false;
									}					
								endif; endforeach; endif; 
								if ($groupStart) {
									$modal .= '</div></div>';
								}	
							$modal .= '<div class="modal-footer">
								<button type="submit" href="" class="btn btn-warning btn-pill">Update ( '.$maintenanceFieldValue->$column.' )</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function removeMaintenanceModal($module_id, $module_type_id, $maintenance, $unique_id)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$maintenanceFieldData = [];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$allTablesData = $this->db->query("SHOW TABLES FROM ".$customerDBSettingRow->database_name)->result_array();//$this->db->list_tables();
		foreach ($allTablesData as $table) 
		{
			$value = array_values($table)[0];
			if (in_array(substr($value, 0, 2), array('m_', 's_')))  
			{
				$valueDataArray = [];
				$maintenanceTableData[] = $value;
				$maintenanceFieldData[$value] = $this->db->field_data($customerDBSettingRow->database_name.'.'.$value);
				$valueData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.'.$value)->order_by('created_at', 'ASC')->get()->result();
				$maintenanceFieldValueData[$value] = $valueData;
				foreach ($valueData as $key => $vd) 
				{
					$name = substr($value, 2) . '_id';
					$valueDataArray[$vd->$name] = $vd;
				}
				$dataCombine = '';
				$valueExplode = explode('_', substr($value, 2));
				for ($i = 0; $i < count($valueExplode); $i++) 
				{
					$dataCombine .= $i >= 1 ? ucfirst($valueExplode[$i]) : $valueExplode[$i];
				}
				$finalData[$dataCombine.'Data'] = $valueDataArray;
			}
		}

		$column = $maintenanceFieldData[$maintenance][1]->name; 
		$maintenance_id = substr($maintenance, 2) . '_id';
		$maintenanceFieldValue = $this->db->select('*')->from($customerDBSettingRow->database_name.'.'.$maintenance)->where($maintenance_id, $unique_id)->order_by('created_at', 'ASC')->get()->row();

		$modal ='<div class="modal-dialog modal-sm modal-dialog-centered" role="document">
					<div class="modal-content">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						<div class="modal-status bg-danger"></div>

						<form action="'.base_url('remove-maintenance').'" method="POST" enctype="multipart/form-data">
							<input id="module_id" name="module_id" type="hidden" value="'.$module_id.'">
							<input id="table" name="table" value="'.$maintenance.'" type="hidden">
							<input id="module_type_id" name="module_type_id" value="'.$module_type_id.'" type="hidden">
							<input id="unique_id" name="unique_id" type="hidden" value="'.$maintenanceFieldValue->$column.'">
							<div class="modal-body text-center py-4">
								<svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 9v2m0 4v.01" /><path d="M5 19h14a2 2 0 0 0 1.84 -2.75l-7.1 -12.25a2 2 0 0 0 -3.5 0l-7.1 12.25a2 2 0 0 0 1.75 2.75" /></svg>
								<h3>Are you sure?</h3>';
								$maintenanceExplode = explode('_', $maintenance); $tableName = (ucfirst($maintenanceExplode[1]).' '.ucfirst(isset($maintenanceExplode[2]) ? $maintenanceExplode[2] : ''));
								$modal .= '<div class="text-muted">Do you really want to delete <strong>'.$maintenanceFieldValue->$column.'</strong>?<br> What you\'ve done to <strong>'.$tableName.'</strong> record cannot be undone.</div>
							</div>
							<div class="modal-footer">
								<div class="w-100">
									<div class="row">
										<div class="col">
											<a href="#" class="btn btn-white btn-pill w-100" data-bs-dismiss="modal">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="18" y1="6" x2="6" y2="18" /><line x1="6" y1="6" x2="18" y2="18" /></svg> Cancel
											</a>
										</div>
										<div class="col">
											<button type="submit" href="#" class="btn btn-danger btn-pill">
												<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="4" y1="7" x2="20" y2="7" /><line x1="10" y1="11" x2="10" y2="17" /><line x1="14" y1="11" x2="14" y2="17" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
												'.$maintenanceFieldValue->$column.'
											</button>
										</div>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function editMaintenance()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$postData = $this->input->post();

		$arrayData = $postData;
		$unique_id = $postData['unique_id'];
		$name = isset($postData['name']) ? $postData['name'] : $unique_id;
		$module_type_id = $postData['module_type_id'];
		unset($arrayData['module_id'], $arrayData['module_type_id'], $arrayData['table'], $arrayData['unique_id']);
		$table = $postData['table'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$moduleRow = $this->db->select('*')->from('m_module')->where('module_id', $postData['module_id'])->get()->row();
		if (isset($postData['multi_table'])) {
			$commaArray = '';
			foreach ($postData['multi_table'] as $value) {
				$commaArray .= $value.',';
			}
			$arrayData['multi_table'] = $commaArray;
		}

		$path = "assets/img/";
		$config['upload_path'] = './'.$path;
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size'] = 5000;

		$explodeColumnDefineImages = explode(',', get_table('m_column_define', 'column_define_id', '1753524572547', 'multi_column'));
		foreach ($explodeColumnDefineImages as $value) 
		{
			$path = in_array($value, explode(',', get_table('m_column_define', 'column_define_id', '1753654719137', 'multi_column'))) ? "assets/doc/" :"assets/img/";
			if (isset($_FILES[$value]['name']))
			{
				$image = do_file_upload($value, $path);
				$arrayData[$value] = $path.$image['file']['file_name'];
			}
			else
			{
				unset($arrayData[$value]);
			}
		}

		$this->db->update($customerDBSettingRow->database_name.'.'.$table, $arrayData, array(substr($table, 2).'_id'=>$unique_id));
		$description = $name.' records updated successful ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$session_data['user_id'].' : '.$table.' : '.$description));
		redirect($moduleRow->path.'/'.$module_type_id.'/'.$table, 'refresh');
	}

	public function editMaintenanceImageModal($module_id, $module_type_id, $maintenance, $unique_id, $table_id='')
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$maintenanceFieldData = [];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$allTablesData = $this->db->query("SHOW TABLES FROM ".$customerDBSettingRow->database_name)->result_array();//$this->db->list_tables();
		foreach ($allTablesData as $table) 
		{
			$value = array_values($table)[0];
			if (in_array(substr($value, 0, 2), array('m_', 's_')))  
			{
				$valueDataArray = [];
				$maintenanceTableData[] = $value;
				$maintenanceFieldData[$value] = $this->db->field_data($customerDBSettingRow->database_name.'.'.$value);
				$valueData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.'.$value)->order_by('created_at', 'ASC')->get()->result();
				$maintenanceFieldValueData[$value] = $valueData;
				foreach ($valueData as $vd) 
				{
					$name = substr($value, 2) . '_id';
					$valueDataArray[$vd->$name] = $vd;
				}
				$dataCombine = '';
				$valueExplode = explode('_', substr($value, 2));
				for ($i = 0; $i < count($valueExplode); $i++) 
				{
					$dataCombine .= $i >= 1 ? ucfirst($valueExplode[$i]) : $valueExplode[$i];
				}
				$finalData[$dataCombine.'Data'] = $valueDataArray;
			}
		}

		$column = $maintenanceFieldData[$maintenance][1]->name; 
		$maintenance_id = substr($maintenance, 2) . '_id';
		$maintenanceFieldValue = $this->db->select('*')->from($customerDBSettingRow->database_name.'.'.$maintenance)->where($maintenance_id, $unique_id)->order_by('created_at', 'ASC')->get()->row();
		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit '.get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1)).' ( '.$maintenanceFieldValue->$column.' )</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('edit-maintenance').'" method="POST" enctype="multipart/form-data">
							<input id="module_id" name="module_id" value="'.$module_id.'" hidden>
							<input id="module_type_id" name="module_type_id" value="'.$module_type_id.'" required hidden>
							<input id="table" name="table" value="'.$maintenance.'" hidden>
							<input id="unique_id" name="unique_id" value="'.$maintenanceFieldValue->$column.'" hidden>
							<div class="modal-body">
								<div class="row">';
									if (isset($maintenanceFieldData[$maintenance])): foreach($maintenanceFieldData[$maintenance] as $pos => $maintenanceField): if (!in_array($maintenanceField->name, explode(',', get_table('m_column_define', 'column_define_id', '1753658383444', 'multi_column'))) && $pos != 1):
										$columns = $maintenanceFieldData[$maintenance][$pos]->name; $nameField = $maintenanceField->name;
										if ($table_id == $nameField && in_array($nameField, explode(',', get_table('m_column_define', 'column_define_id', '1753524572547', 'multi_column')))) {	
											$modal .= '<div class="form-label">'.ucfirst(get_maintenance_column_naming($maintenance, $nameField, 'name', get_broken_name(substr($nameField, 0), '_'))).'</div>
											<img src="'.base_url($maintenanceFieldValue->$columns).'"/>
											<div class="d-flex align-items-center" style="margin-top: 10px;">
												<input id="'.$nameField.'" name="'.$nameField.'" type="file" class="form-control btn-pill"/>
											</div>';																	
										}
									endif; endforeach; endif;
								$modal .= '</div>
							</div>
							<div class="modal-footer">
								<button type="submit" href="" class="btn btn-warning btn-pill">Update ( '.$maintenanceFieldValue->$column.' )</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function removeMaintenance()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$postData = $this->input->post();

		$arrayData = $postData;
		$module_type_id = $postData['module_type_id'];
		$table = $postData['table'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$moduleRow = $this->db->select('*')->from('m_module')->where('module_id', $postData['module_id'])->get()->row();
		unset($arrayData['module_id'], $arrayData['module_type_id'], $arrayData['table'], $arrayData['unique_id']);

		$this->db->delete($customerDBSettingRow->database_name.'.'.$table, array(substr($table, 2).'_id'=>$postData['unique_id']));
		$description = $postData['name'].' deleted successful ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$session_data['user_id'].' : '.$table.' : '.$description));
		redirect($moduleRow->path.'/'.$module_type_id.'/'.$table, 'refresh');
	}

	/**
	 * Maintenance Naming
	 */
	public function maintenanceNamingView()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('all-maintenance', 'maintenance-naming');
		$data = $headerData;

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$data['maintenanceNamingData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance_naming')->get()->result();
		$data['maintenanceData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance')->get()->result();

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('maintenance_naming_view', $data);
		$this->load->view('admin/templates/footer_view');
	}

	public function addMaintenanceNamingModal()
	{
		$this->common->checkSession(array('dialog'=>1));
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('all-maintenance', 'maintenance-naming');
		$subModuleMenu = $headerData['subModuleMenu'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$allTablesData = $this->db->query("SHOW TABLES FROM ".$customerDBSettingRow->database_name)->result_array();//$this->db->list_tables();
		foreach ($allTablesData as $table) 
		{
			$value = array_values($table)[0];
			if (in_array(substr($value, 0, 2), array('m_', 's_')))  
			{
				$maintenanceTableData[] = $value;
			}
		}

		$maintenanceGroupTableData = []; $maintenanceCheckData = [];
		$maintenanceArrayData = $this->db->from($customerDBSettingRow->database_name.'.maintenance')->order_by('name', 'ASC')->get()->result();
		foreach ($maintenanceArrayData as $maintenance) 
		{
			$maintenanceCheckData[$maintenance->name] = $maintenance->name;
			foreach ($maintenanceTableData as $value) 
			{
				if ($maintenance->name == $value)
					$maintenanceGroupTableData[$maintenance->module_type_id][] = $value;
			}
		}

		foreach ($maintenanceTableData as $value) 
		{
			if (!isset($maintenanceCheckData[$value]))
				$maintenanceGroupTableData['0123456789'][] = $value;
		}

		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">'.$subModuleMenu->name.'</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<form action="'.base_url('add-maintenance-naming').'" method="POST" enctype="multipart/form-data">
							<div class="row">
								<div class="modal-body">								
									<div class="row">
										<input id="maintenance_naming_id" name="maintenance_naming_id" value="'.generate_uuid().'" hidden>
										<div class="col-lg-6">
											<div class="mb-3">
												<label class="form-label">Real Name</label>
												<input id="name" name="name" type="text" class="form-control btn-pill" placeholder="Your Real Name">
											</div>
										</div>
										<div class="col-lg-6">
											<div class="mb-3">
												<label class="form-label">Maintenance</label>
												<select class="form-select btn-pill" id="maintenance" name="maintenance" required>
													<option value="" selected disabled>Select Maintenance</option>';
													if (isset($maintenanceGroupTableData)): foreach($maintenanceGroupTableData as $key => $maintenanceGroup):
														$modal .= '<optgroup label="'.get_table(GlobalModel::TABLE_MODULE_TYPE, 'module_type_id', $key, 'name').'">';
															if (isset($maintenanceGroup)): foreach($maintenanceGroup as $maintenance): 
																$modal .= '<option value="'.$maintenance.'" required>'.get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1)).'</option>';
															endforeach; endif; 
														$modal .= '</optgroup>';
													endforeach; endif;
												$modal .= '</select>
											</div>										
										</div>	
									</div>						
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="10" y1="14" x2="21" y2="3" /><path d="M21 3l-6.5 18a0.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a0.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
									Add '.$subModuleMenu->name.'
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function addMaintenanceNaming()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$postData = $this->input->post();
		$maintenance = $postData['maintenance'];
		$name = $postData['name'];
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$maintenanceNamingData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance_naming')->where('maintenance', $maintenance)->get()->row();
		if (!empty($maintenanceNamingData))
		{
			$this->db->delete('maintenance_naming', array('maintenance_naming_id'=>$maintenanceNamingData->maintenance_naming_id));
		}
		$this->db->insert($customerDBSettingRow->database_name.'.maintenance_naming', $postData);
		$description = $name.' linked to '.get_broken_name($maintenance, '_', 1).' successfully ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$session_data['user_id'].' : '.$description));
		redirect('maintenance-naming', 'refresh');
	}

	public function editMaintenanceNamingModal($maintenance_naming_id)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$maintenanceNaming = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance_naming')->where('maintenance_naming_id', $maintenance_naming_id)->get()->row();

		$modal = '<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit Name For '.get_broken_name($maintenanceNaming->maintenance, '_', 1).'</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>

						<form action="'.base_url('edit-maintenance-naming').'" method="POST" enctype="multipart/form-data">
							<input id="maintenance_naming_id" name="maintenance_naming_id" value="'.$maintenanceNaming->maintenance_naming_id.'" hidden>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Real Name</label>
											<input id="name" name="name" type="text" class="form-control btn-pill" placeholder="Your Real Name" value="'.$maintenanceNaming->name.'">
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
									Edit 
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function editMaintenanceNaming()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$postData = $this->input->post();
		$maintenance_naming_id = $postData['maintenance_naming_id'];
		$name = $postData['name'];
		unset($postData['maintenance_naming_id']);
		
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$this->db->update($customerDBSettingRow->database_name.'.maintenance_naming', $postData, array('maintenance_naming_id'=>$maintenance_naming_id));
		$description = $name.' updated successfully ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$name.' : '.$description));
		redirect('maintenance-naming', 'refresh');
	}

	public function maintenanceColumnNamingView()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('all-maintenance', 'maintenance-column-naming');
		$data = $headerData;
		
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$data['maintenanceColumnNamingData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance_column_naming')->get()->result();
		$data['maintenanceData'] = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance')->get()->result();

		$this->load->view('admin/templates/header_view', $headerData);
		$this->load->view('maintenance_column_naming_view', $data);
		$this->load->view('admin/templates/footer_view');
	}

	public function addMaintenanceColumnNamingModal()
	{
		$this->common->checkSession(array('dialog'=>1));
		$session_data = $this->common->loadSession();
		$headerData = $this->common->loadHeaderData('all-maintenance', 'maintenance-column-naming');
		$subModuleMenu = $headerData['subModuleMenu'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$allTablesData = $this->db->query("SHOW TABLES FROM ".$customerDBSettingRow->database_name)->result_array();//$this->db->list_tables();
		foreach ($allTablesData as $table) 
		{
			$value = array_values($table)[0];
			if (in_array(substr($value, 0, 2), array('m_', 's_')))  
			{
				$maintenanceTableData[] = $value;
			}
		}

		$maintenanceGroupTableData = []; $maintenanceCheckData = [];
		$maintenanceArrayData = $this->db->from($customerDBSettingRow->database_name.'.maintenance')->order_by('name', 'ASC')->get()->result();
		foreach ($maintenanceArrayData as $maintenance) 
		{
			$maintenanceCheckData[$maintenance->name] = $maintenance->name;
			foreach ($maintenanceTableData as $value) 
			{
				if ($maintenance->name == $value)
					$maintenanceGroupTableData[$maintenance->module_type_id][] = $value;
			}
		}

		foreach ($maintenanceTableData as $value) 
		{
			if (!isset($maintenanceCheckData[$value]))
				$maintenanceGroupTableData['0123456789'][] = $value;
		}

		$modal ='<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">'.$subModuleMenu->name.'</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<form action="'.base_url('add-maintenance-column-naming').'" method="POST" enctype="multipart/form-data">
							<div class="modal-body">								
								<div class="row">
									<input id="maintenance_column_naming_id" name="maintenance_column_naming_id" value="'.generate_uuid().'" hidden>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Maintenance</label>
											<select id="add_maintenance" name="maintenance" class="form-select btn-pill" required>
												<option value="" selected disabled>Select Maintenance</option>';
												if (isset($maintenanceGroupTableData)): foreach($maintenanceGroupTableData as $key => $maintenanceGroup):
													$modal .= '<optgroup label="'.get_table('m_module_type', 'module_type_id', $key, 'name').'">';
														if (isset($maintenanceGroup)): foreach($maintenanceGroup as $maintenance): 
															$modal .= '<option value="'.$maintenance.'" required>'.get_maintenance_naming($maintenance, 'name', get_broken_name($maintenance, '_', 1)).'</option>';
														endforeach; endif; 
													$modal .= '</optgroup>';
												endforeach; endif;
											$modal .= '</select>
										</div>										
									</div>
									<div class="col-lg-6">
										<div id="column_name_container" class="mb-3">
											<label class="form-label">Column Name</label>
											<select id="column_name" name="column_name" class="form-select btn-pill" required>
												<option value="" selected disabled>Select Column Name</option>';
												if (isset($maintenanceArrayData)): foreach($maintenanceArrayData as $maintenance):
													$modal .= '<optgroup label="'.get_maintenance_naming($maintenance->name, 'name', get_broken_name($maintenance->name, '_', 1)).'">';
														$columns = $this->db->field_data($maintenance->name);
														if (isset($columns)): foreach($columns as $column): if (!in_array($column->name, explode(',', get_table('m_column_define', 'column_define_id', '1753658383444', 'multi_column')))):
															$modal .= '<option value="'.$column->name.'" required>'.ucfirst(get_broken_name($column->name, '_')).'</option>';
														endif; endforeach; endif;
													$modal .= '</optgroup>';
												endforeach; endif;
											$modal .= '</select>
										</div>
									</div>
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Real Name</label>
											<input id="name" name="name" type="text" class="form-control btn-pill" placeholder="Your Real Name">
											<div class="invalid-feedback" id="name-feedback"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Add '.$subModuleMenu->name.' 
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function addMaintenanceColumnNaming()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$postData = $this->input->post();
		$maintenance = $postData['maintenance'];
		$name = $postData['name'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$maintenanceColumnNamingData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance_column_naming')->where('maintenance', $maintenance)->where('column_name', $postData['column_name'])->get()->row();
		if (!empty($maintenanceColumnNamingData))
		{
			$this->db->delete($customerDBSettingRow->database_name.'.maintenance_column_naming', array('maintenance_column_naming_id'=>$maintenanceColumnNamingData->maintenance_column_naming_id));
		}
		
		$this->db->insert($customerDBSettingRow->database_name.'.maintenance_column_naming', $postData);
		$description = $name.' linked to '.get_broken_name($maintenance, '_', 1).' successfully ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$session_data['user_id'].' : '.$description));
		redirect('maintenance-column-naming', 'refresh');
	}

	public function editMaintenanceColumnNamingModal($maintenance_column_naming_id)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$maintenanceColumnNaming = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance_column_naming')->where('maintenance_column_naming_id', $maintenance_column_naming_id)->get()->row();

		$modal = '<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Edit '.get_broken_name($maintenanceColumnNaming->maintenance, '_', 1).' Column ( '.get_broken_name($maintenanceColumnNaming->column_name, '_').' )</h5>
							<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						
						<form action="'.base_url('edit-maintenance-naming').'" method="POST" enctype="multipart/form-data">
							<input id="maintenance_column_naming_id" name="maintenance_column_naming_id" value="'.$maintenanceColumnNaming->maintenance_column_naming_id.'" hidden>
							<div class="modal-body">
								<div class="row">
									<div class="col-lg-6">
										<div class="mb-3">
											<label class="form-label">Real Name</label>
											<input id="name" name="name" type="text" class="form-control btn-pill" placeholder="Your Real Name" value="'.$maintenanceColumnNaming->name.'">
										</div>
									</div>
								</div>
							</div>
							<div class="modal-footer">
								<a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
								<button href="#" type="submit" class="btn btn-primary ms-auto btn-pill">
									<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg> Update 
								</button>
							</div>
						</form>
					</div>
				</div>';
		print_r($modal);
	}

	public function editMaintenanceColumnNaming()
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$postData = $this->input->post();
		$maintenance_column_naming_id = $postData['maintenance_column_naming_id'];
		$name = $postData['name'];
		unset($postData['maintenance_column_naming_id']);

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$this->db->update($customerDBSettingRow->database_name.'.maintenance_column_naming', $postData, array('maintenance_column_naming_id'=>$maintenance_column_naming_id));
		$description = $name.' updated successfully ✔️';
		$this->session->set_flashdata('message', $description);
		$this->db->insert('system_log', array('system_log_id'=>generate_uuid(), 'log_type_id'=>'1636952180', 'description'=>$name.' : '.$description));
		redirect('maintenance-column-naming', 'refresh');
	}

	public function getMaintenanceColumnHtml($table, $includeSelect=1)
	{
		$this->common->checkSession();
		$session_data = $this->common->loadSession();

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $session_data['customer_db_setting_id'])->get()->row();
		$maintenanceArrayData = $this->db->select('*')->from($customerDBSettingRow->database_name.'.maintenance')->order_by('name', 'ASC')->get()->result();

		if ($includeSelect == 1) {
			$modal ='<label class="form-label">Columns for '.get_maintenance_naming($table, 'name', get_broken_name($table, '_', 1)).'</label>
				<select id="column_name" name="column_name" class="form-select btn-pill" required>';
		}
			$modal .= '<option value="" selected disabled>Select '.get_maintenance_naming($table, 'name', get_broken_name($table, '_', 1)).' Columns</option>';
			if (isset($maintenanceArrayData)): foreach($maintenanceArrayData as $maintenance): if ($maintenance->name == $table):
				$modal .= '<optgroup label="'.get_maintenance_naming($maintenance->name, 'name', get_broken_name($maintenance->name, '_', 1)).'">';
					$columns = $this->db->field_data($maintenance->name);
					if (isset($columns)): foreach($columns as $column): if (!in_array($column->name, explode(',', get_table('m_column_define', 'column_define_id', '1753658383444', 'multi_column')))):
						$modal .= '<option value="'.$column->name.'" required>'.ucfirst(get_broken_name($column->name, '_')).'</option>';
					endif; endforeach; endif;
				$modal .= '</optgroup>';
			endif; endforeach; endif;
		if ($includeSelect == 1) {
			$modal .= '</select>';
		}
		print_r($modal);
	}

	public function getDataCombine($column_id)
	{
		$dataCombine = '';
		$valueExplode = explode('_', substr($column_id, 2));
		for ($i = 0; $i < count($valueExplode); $i++) 
		{
			$dataCombine .= $i >= 1 ? ucfirst($valueExplode[$i]) : $valueExplode[$i];
		}
		return $dataCombine;
	}
	
	public function getTableData($table, $column_id, $data_id='', $param1='') 
	{
		print_r(get_table($table, $column_id, $data_id, $param1));
	}

	function do_file_upload($filename, $path='assets/img')
	{
		$config['upload_path'] = './'.$path;
		$config['allowed_types'] = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|xlsm|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp';
		$config['max_size'] = 100000;
		$config['overwrite'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$config['remove_spaces'] = TRUE;
	
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload($filename)) 
		{
			return array('error' => $this->upload->display_errors());
		} 
		else 
		{
			return array('file' => $this->upload->data());
		}
	}	
}
