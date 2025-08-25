<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Function Name
 *
 * Function description
 *
 * @access	public
 * @param	type	name
 * @return	type	
 */
 
if (!function_exists('get_broken_name')) 
{
	function get_broken_name($param1 = '', $param2 = ' ', $param3 = 0, $param4=' ', $param5=true) 
	{
		$initials = "";
	 	$initialsExplode = explode($param2, $param1);
		for ($i=$param3; $i < count($initialsExplode); $i++) 
		{ 
			$initials .= (isset($initialsExplode[$i]) ? ($param5 ? ucfirst($initialsExplode[$i].$param4) : $initialsExplode[$i].$param4) : ($param3 == $i ? '#' : $param4));
		}
		return $initials;
	}
}

if (!function_exists('get_combine_column_to_table')) 
{
	function get_combine_column_to_table($column_id, $startName='', $endName='')
	{
		$dataCombine = '';
		$valueExplode = explode('_', substr($column_id, 0,-3));
		for ($i = 0; $i < count($valueExplode); $i++) 
		{
			$dataCombine .= $i >= 1 ? ucfirst($valueExplode[$i]) : $valueExplode[$i];
		}
		return $startName.$dataCombine.$endName;
	}
}

if (! function_exists('get_user_type_id'))
{
	function get_user_type_id($param1= '',$param2= '')
	{
		 //get main CodeIgniter object
       $ci =& get_instance();

       $userType = $ci->Maintenance_model->getUserType();
       $user = $ci->LoginModel->get();

       switch ($param2) {

       	case 'CONF':

			foreach ($userType as $value) {
				$getUserTypeIdAssoc[$value->tag] = $value->user_type_id;
			}
       		break;

       	case 'USER':
			
	        foreach ($user as $value) {
	        	$getUserTypeIdAssoc[$value->user_id] = $value->user_type_id;
	        }
       		break;	
       	
       	default:
       		$getUserTypeIdAssoc = array();
       		break;
       }



        return $getUserTypeIdAssoc[$param1];
	}
}

if (! function_exists('get_user_type_from_id'))
{
      function get_user_type_from_id($param1= '')
      {
             //get main CodeIgniter object
             $ci =& get_instance();

            $userData = $ci->LoginModel->get($param1);

            return $userData[0]->user_type;
      }
}

if (! function_exists('get_user_type_name'))
{
      function get_user_type_name($param1= '')
      {
             //get main CodeIgniter object
             $ci =& get_instance();

            $userType = $ci->Maintenance_model->getUserType();

            if(!empty($userType)): foreach ($userType as  $value): 
            $getUserNameAssoc[$value->user_type_id] = $value->name;
            endforeach; endif;

            return $getUserNameAssoc[$param1];
      }
}

if (! function_exists('get_user_type_tag'))
{
      function get_user_type_tag($param1= '')
      {
             //get main CodeIgniter object
             $ci =& get_instance();

            $userType = $ci->Maintenance_model->getUserTypeDefault();

            if(!empty($userType)): foreach ($userType as  $value): 
            $getUserNameAssoc[$value->short_code] = $value->user_type_id;
            endforeach; endif;

            return $getUserNameAssoc[$param1];
      }
}


if (! function_exists('get_branch_name'))
{
      function get_branch_name($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            $Branch = $ci->Maintenance_model->getBranch();

            if(!empty($Branch)): foreach ($Branch as  $value): 
            $getBranchAssoc[$value->branch_id] = $value->name;
            endforeach; endif;

            return $getBranchAssoc[$param1];

      }
}


if (! function_exists('get_user_rights'))
{
      function get_user_rights($param1= '',$param2='')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

             $ci->load->model('Maintenance_model');

            $userRightsArray = $ci->Maintenance_model->getUserRights();

            if(!empty($userRightsArray)): foreach ($userRightsArray as  $value): 
            $UserRights[$value->user_type_id][$value->module_id] = "X";
            endforeach; endif;

            return $UserRights[$param1][$param2];

      }
}

if (! function_exists('get_module'))
{
      function get_module($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();
            $dataArray = $ci->Maintenance_model->getModule();

            if(!empty($dataArray)): foreach ($dataArray as  $value): 
            $moduleArr[$value->module_tag] = $value->module_id;
            endforeach; endif;

            return $moduleArr[$param1];

      }
}


if (! function_exists('get_user_name'))
{
      function get_user_name($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

             $ci->load->model('User_model');

            $user = $ci->User_model->get();
            foreach ($user as $value) {
            $getUserNameAssoc[$value->user_id] = $value->full_name;
            }

            return $getUserNameAssoc[$param1];

      }
}

if (! function_exists('get_companies_count'))
{
      function get_companies_count($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->CompanyModel->get();
      
            return count($data);

      }
}




if (! function_exists('get_clubs_name'))
      {
        function get_clubs_name($param1= '')
        {
           //get main CodeIgniter object
             $ci =& get_instance();

           $club_name = $ci->db->select('*')->from('zidii_clubs')->where('club_id', $param1)->get()->row()->club_name;

             return $club_name;
        }
      } 

      if (! function_exists('get_clubs_logo'))
      {
        function get_clubs_logo($param1= '')
        {
           //get main CodeIgniter object
             $ci =& get_instance();

           $club_logo = $ci->db->select('*')->from('zidii_clubs')->where('club_id', $param1)->get()->row()->club_logo;

             return $club_logo;
        }
      } 

      if (! function_exists('get_facility_name'))
      {
        function get_facility_name($param1= '')
        {
           //get main CodeIgniter object
             $ci =& get_instance();

           $facility_name = $ci->db->select('*')->from('club_facility_banda')->where('facility_id', $param1)->get()->row()->facility_name;

             return $facility_name;
        }
      }



      if (! function_exists('get_shop_category_name'))
      {
        function get_shop_category_name($param1= '')
        {
           //get main CodeIgniter object
             $ci =& get_instance();

           $category_name = $ci->db->select('*')->from('club_shop_category_maintenance')->where('category_id', $param1)->get()->row()->category_name;

             return $category_name;
        }
      } 


       if (! function_exists('get_shop_type_name'))
      {
        function get_shop_type_name($param1= '')
        {
           //get main CodeIgniter object
             $ci =& get_instance();

           $type_name = $ci->db->select('*')->from('club_shop_type_maintenance')->where('type_id', $param1)->get()->row()->type_name;

             return $type_name;
        }
      } 



      if (! function_exists('get_user_email'))
      {
        function get_user_email($param1= '')
        {
           //get main CodeIgniter object
             $ci =& get_instance();

           $email = $ci->db->select('*')->from('users')->where('user_id', $param1)->get()->row()->email;

             return $email;
        }
      } 

       if (! function_exists('get_user_phone'))
      {
        function get_user_phone($param1= '')
        {
           //get main CodeIgniter object
             $ci =& get_instance();

           $phone_number = $ci->db->select('*')->from('users')->where('user_id', $param1)->get()->row()->phone_number;

             return $phone_number;
        }
      } 


if (! function_exists('get_clubs_id'))
{
      function get_clubs_id($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->ClubModel->get();
      
          foreach ($data as $value) {
            $getUserNameAssoc[$value->club_name] = $value->club_id;
            }

            return $getUserNameAssoc[$param1];

      }
}


if (! function_exists('get_user_companies_count'))
{
      function get_user_companies_count($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();
             // $ci->load->model('ClubModel');

            // $where = array('subject_id'=>$param1);
            $data = $ci->CompanyModel->getUserCompanies(array('user_id'=>$param1));
      
            return count($data);

      }
}


if (! function_exists('check_user_clubs'))
{
      function check_user_clubs($param1= '',$param2= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->ClubModel->getUserClubs();
            foreach ($data as $value) {
            $getUserNameAssoc[$value->user_id][$value->club_id] = "X";
            }

      
            return $getUserNameAssoc[$param1][$param2];

      }
}

//
if (! function_exists('check_facility_camps'))
{
      function check_facility_camps($param1= '',$param2= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->ClubModel->getFacilityItems();
            foreach ($data as $value) {
            $getUserNameAssoc[$value->club_id][$value->facility_id] = "X";
            }

            return $getUserNameAssoc[$param1][$param2];

      } 
}
//

if (! function_exists('check_facility_banda'))
{
      function check_facility_banda($param1= '',$param2= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->ClubModel->getFacilityname();
            foreach ($data as $value) {
            $getUserNameAssoc[$value->club_id][$value->facility_id] = "X";
            }

            return $getUserNameAssoc[$param1][$param2];

      }
}

if (! function_exists('check_user_companies'))
{
      function check_user_companies($param1= '',$param2= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->CompanyModel->getUserCompanies();
            foreach ($data as $value) {
            $getUserNameAssoc[$value->user_id][$value->company_id] = "X";
            }

      
            return $getUserNameAssoc[$param1][$param2];

      }
}


if (! function_exists('get_club_id_from_user_id'))
{
      function get_club_id_from_user_id($param1= '')
      {
 
             //get main CodeIgniter object 
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->ClubModel->getUserClubs();
            foreach ($data as $value) {
            $getUserNameAssoc[$value->user_id] = $value->club_id;
            }

      
            return $getUserNameAssoc[$param1];

      }
}


if (! function_exists('get_company_id_from_user_id'))
{
      function get_company_id_from_user_id($param1= '')
      {

             //get main CodeIgniter object 
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->CompanyModel->getUserCompanies();
            foreach ($data as $value) {
            $getUserNameAssoc[$value->user_id] = $value->company_id;
            }

      
            return $getUserNameAssoc[$param1];

      }
}



if (! function_exists('get_loan_application_count'))
{
      function get_loan_application_count($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->PersonalSecuredLoansModel->get();
      
            return count($data);

      }
}

if (! function_exists('get_user_loan_application_count'))
{
      function get_user_loan_application_count($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->PersonalSecuredLoansModel->get(array('user_id'=>$param1));
      
            return count($data);

      }
}


if (! function_exists('get_loan_application_file_count'))
{
      function get_loan_application_file_count($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->PersonalSecuredLoansModel->getFiles($param1);
      
            return count($data);

      }
}


if (! function_exists('get_car_application_count'))
{
      function get_car_application_count($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->CarApplicationModel->get();
      
            return count($data);

      }
}

if (! function_exists('get_user_car_application_count'))
{
      function get_user_car_application_count($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->CarApplicationModel->get(array('user_id'=>$param1));
      
            return count($data);

      }
}


if (! function_exists('get_car_application_file_count'))
{
      function get_car_application_file_count($param1= '')
      {

             //get main CodeIgniter object
             $ci =& get_instance();

            // $where = array('subject_id'=>$param1);
            $data = $ci->CarApplicationModel->getFiles($param1);
      
            return count($data);

      }
}



if (! function_exists('check_rate'))
{
      function check_rate($firstday= '', $lastday= '')
      {
            $ci =& get_instance();
            // booking_rates
            // Mon – Thursday – 1,800 per banda per night
            // Fri – Saturday Night – 3,800 per banda per night 

            $start = new DateTime($firstday);
            $end = new DateTime($lastday);

            $interval = new DateInterval('P1D'); // 1 Day interval
            $period = new DatePeriod($start, $interval, $end);
            $total_days_amount = 0;

            foreach ($period as $day) {
                if ($day->format('N') < 6) { // 6 and 7 are Saturday and Sunday
                    // echo $day->format('l') . "\n"; // Outputs the day name

                    $dateData = $ci->db->select('*')->from('booking_rates')->where('booking_rate_name', $day->format('l'))->get()->row();

                    $total_days_amount += $dateData->amount;
                }
            }

            $lastdayDate = new DateTime($lastday);
            $lastdayDateName = date_format(date_create($lastdayDate->modify('+0 day')->format('Y-m-d')),'l');
            
            $checkData = $ci->db->select('*')->from('booking_rates')->where('booking_rate_name', $lastdayDateName)->get()->row();

            return $total_days_amount + $checkData->amount;
            exit();

            
            return $cost;          

      }
  } 

if (! function_exists('check_rate_per_day'))
{
      function check_rate_per_day($firstday= '')
      {
            $ci =& get_instance();

            $firstdaydayDate = new DateTime($firstday);
            $firstdaydayDateName = date_format(date_create($firstdaydayDate->modify('+0 day')->format('Y-m-d')),'l');
          
            $year = date_format(date_create($firstday),"Y");

            $checkData = $ci->db->select('*')->from('booking_rates')->where('booking_rate_name', $firstdaydayDateName)->where('year', $year)->get()->row();

            return $checkData->amount;
           
      }
}


////////////////////
if (! function_exists('check_rate_per_day_member_type'))
{
      function check_rate_per_day_member_type($firstday= '',$rate_name='')
      {
            $ci =& get_instance();

            $firstdaydayDate = new DateTime($firstday);
            $firstdaydayDateName = date_format(date_create($firstdaydayDate->modify('+0 day')->format('Y-m-d')),'l');
          
            $year = date_format(date_create($firstday),"Y");

            $checkData = $ci->db->select('*')->from('booking_rates')->where('booking_rate_name', $rate_name)->where('days', $firstdaydayDateName)->where('year', $year)->get()->row();

            return $checkData->amount;
           
      }
}

if (! function_exists('get_total_cost_booking_details'))
{
      function get_total_cost_booking_details($booking_id= '')
      {
            $ci =& get_instance();

      // SELECT SUM(costs) AS costs FROM `booking_details` WHERE booking_id = '63a213dca267e';
           
            $sumData = $ci->db->select_sum('total_cost')->from('booking_details')->where('booking_id', $booking_id)->get()->row();

            return $sumData->total_cost;
           
      }
}


 if (! function_exists('check_booking_facility_camp_date'))
      {
      function check_booking_facility_camp_date($facility_id= '', $facility_camp_name='', $days='')
      {
            $ci =& get_instance(); 

        
            $facilityData = $ci->db->select('*')->from('booking_details')->where('facility_id', $facility_id)->where('status', "Paid")->like('facility_camp_name', $facility_camp_name)->where('blocked_days', $days)->get()->row();
          
          // $myQuery = "SELECT * FROM booking_details WHERE facility_id LIKE '%".$facility_id."%' AND facility_camp_name LIKE '%".$facility_camp_name."%' AND days LIKE '%".$days."%'";


            // print_r($facilityData);
            // exit();

            $truthful = false;
            if ($facilityData) {
                $truthful = true;
            } 
            

            // print_r($truthful);
            // exit();

            // return $sumData->total_cost;
              return $truthful; 
      }
}

if (!function_exists('get_initial')) 
{
	function get_initial($param1 = '') 
	{
	 	$initialsExplode = explode(" ", $param1);
		return (isset($initialsExplode[0]) ? $initialsExplode[0][0] : 'ML').(isset($initialsExplode[1]) ? $initialsExplode[1][0] : '');
	}
}

if (!function_exists('get_title_id'))
{
	function get_title_id($title, $explode, $separator)
	{
		$nameId = '';
        $name = strtolower(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $title));
        $explodeBlog = explode($explode, $name);
        foreach ($explodeBlog as $key => $value) {
            $nameId .= $key == 0 ? $value :  $separator.$value;
        }
		return $nameId;
	}
}

if (!function_exists('get_module_type')) 
{
	function get_module_type($param1 = '', $param2 = '')
	{
		return get_table('m_module_type', 'module_type_id', $param1, $param2);
	}
}

if (!function_exists('do_file_upload')) 
{
	function do_file_upload($filename, $path='assets/img/')
	{
		$ci =& get_instance();
		$config['upload_path'] = './'.$path;
		$config['allowed_types'] = 'gif|jpg|jpeg|png|iso|dmg|zip|rar|doc|docx|xls|xlsx|xlsm|ppt|pptx|csv|ods|odt|odp|pdf|rtf|sxc|sxi|txt|exe|avi|mpeg|mp3|mp4|3gp|webp|svg';
		$config['max_size'] = 100000;
		$config['overwrite'] = TRUE;
		$config['encrypt_name'] = TRUE;
		$config['remove_spaces'] = TRUE;

		$ci->load->library('upload', $config);
		if (!$ci->upload->do_upload($filename)) 
		{
			return array('error' => $ci->upload->display_errors());
		} 
		else 
		{
			return array('file' => $ci->upload->data());
		}
	}
}

if (!function_exists('get_user_right')) 
{
	function get_user_right($param1 = '', $param2 = '', $column = '', $param3 = 0)
	{
		$UserRights = array();
		$ci =& get_instance();
		$session_data = $ci->session->userdata(GlobalModel::SESSION);
		$databaseName = get_table('customer_db_setting', 'customer_db_setting_id', $session_data['customer_db_setting_id'], 'database_name');
		$arrayRightsArray = $ci->MaintenanceModel->getTable($databaseName.'.user_right');
		if (!empty($arrayRightsArray)): foreach ($arrayRightsArray as $value):
			if (!empty($column))
				$UserRights[$value->user_type_id][$value->module_id][$value->$column] = "X";
			else
			$UserRights[$value->user_type_id][$value->module_id] = "X";
		endforeach; endif;

		if (!empty($column))
			return isset($UserRights[$param1][$param2][$param3]) ? $UserRights[$param1][$param2][$param3] : NULL;
		else
			return isset($UserRights[$param1][$param2]) ? $UserRights[$param1][$param2] : NULL;
	}
}

if (!function_exists('get_explode_select')) 
{
	function get_explode_select($param1 = '', $param2 = '')
	{
		$result = '';
		$variable = explode(',', $param1);
		foreach ($variable as $key => $value) {
			if ($value == $param2) {
				$result = $value;
			}
		}
		return $result;
	}
}

if (!function_exists('get_sys_control')) 
{
	function get_sys_control($param1 = '', $column = '', $param3 = 0)
	{
		$table = array();
		$ci =& get_instance();
		$tableArray = $ci->MaintenanceModel->getTable('s_sys-control');
		if (isset($tableArray)): foreach ($tableArray as $value):
			$table[$value->maintenance_id][$value->$column] = $value->$column;
		endforeach; endif;

		return isset($table[$param1][$param3]) ? $table[$param1][$param3] : 0;
	}
}

if (!function_exists('get_maintenance_column')) 
{
	function get_maintenance_column($param1 = '', $param2 = '', $param3 = 0)
	{
		$table = array();
		$ci =& get_instance();
		$tableArray = $ci->MaintenanceModel->getTable('m_maintenance_column');
		if (isset($tableArray)): foreach ($tableArray as $value):
			$table[$value->maintenance_id][$value->column_id][$value->toggle] = $value->toggle;
		endforeach; endif;
		
		return isset($table[$param1][$param2][$param3]) ? $table[$param1][$param2][$param3] : NULL;
	}
}

if (!function_exists('get_maintenance_naming')) 
{
	function get_maintenance_naming($param1 = '', $param2 = '', $param3='')
	{
		$ci =& get_instance();
		$array = $ci->MaintenanceModel->getTable('maintenance_naming');
		foreach ($array as $value) 
		{
			$arrayAssoc[$value->maintenance_naming_id] = !empty($param2) ? $value->$param2 : $value->name;
			$arrayAssoc[$value->maintenance] = !empty($param2) ? $value->$param2 : $value->name;
		}
		return isset($arrayAssoc[$param1]) ? $arrayAssoc[$param1] : ($param3==null ? 'N/A' : $param3.'*');
	}
}

if (!function_exists('get_maintenance_column_naming'))
{
	function get_maintenance_column_naming($table, $param1 = '', $param2 = '', $param3='')
	{
		$ci =& get_instance();
		$array = $ci->MaintenanceModel->getTable('maintenance_column_naming', '', array('maintenance'=>$table));
		foreach ($array as $value) 
		{
			$arrayAssoc[$value->maintenance_column_naming_id] = !empty($param2) ? $value->$param2 : $value->name;
			$arrayAssoc[$value->column_name] = !empty($param2) ? $value->$param2 : $value->name;
		}
		return isset($arrayAssoc[$param1]) ? $arrayAssoc[$param1] : ($param3==null ? 'N/A' : $param3);
	}
}

if (!function_exists('get_table')) 
{
	function get_table($table, $column_id, $param1 = '', $param2 = '')
	{
		static $cache = [];
		$ci = &get_instance();

		// Cache key
		$cacheKey = md5($table . '|' . $column_id . '|' . $param1 . '|' . $param2);
		if (isset($cache[$cacheKey])) {
			return $cache[$cacheKey];
		}

		// If $param2 is empty, return value from list
		if (empty($param2)) {
			$result = $ci->MaintenanceModel->getTable($table, $column_id);
			$arrayAssoc = [];

			foreach ($result as $row) {
				$arrayAssoc[$row->$column_id] = $row;
			}

			$cache[$cacheKey] = $arrayAssoc[$param1] ?? 'N/A';
			return $cache[$cacheKey];
		}

		// Otherwise, fetch single row and column
		$row = $ci->MaintenanceModel->getTableRow($table, $column_id, $param1, $param2);

		if (!empty($row) && isset($row->$param2)) {
			$cache[$cacheKey] = $row->$param2;
			return $row->$param2;
		}

		$fallbacks = ['eta_at', 'name'];
		$cache[$cacheKey] = in_array($param2, $fallbacks) ? '-' : (in_array($param2, array('price_instant', 'price_installment')) ? '0.00' : 'N/A');
		return $cache[$cacheKey];
	}
}

if (!function_exists('generate_uuid')) 
{
    function generate_uuid()
    {
        $uuid = time();
        return substr($uuid, 0, 6).mt_rand(substr($uuid, -6), 9000000);
    }
}

?>
