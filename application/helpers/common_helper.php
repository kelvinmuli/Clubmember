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
//////////////////////////////



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







?>
