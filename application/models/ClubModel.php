<?php defined('BASEPATH') OR exit('No direct script access allowed');

class ClubModel extends CI_Model {

	  /** 
     * @name string TABLE_NAME Holds the name of the table in use by this model
     */
	const TABLE_NAME = 'zidii_clubs';
	const USER_COMPANIES = 'user_clubs';
    const CLUB_FACILITIES = 'club_facility_camps';
    const CLUB_FACILITIES_BANDA = 'club_facility_banda';
    const CLUB_JOINING_FEE = 'club_joining_fee_types';
    const CLUB_SUBSCRIPTIONS = 'club_subscriptions_types';
    const CLUB_SHOP = 'club_shop';
    const CLUB_JOINING_FEE_POST = 'club_joining_fees';
    const CLUB_SUBSCRIPTION_POST = 'club_subscription';
    const CLUB_REGULAR = 'regular_members';
    const CLUB_CORPORATE = 'corporate_members';
    const CLUB_BOOKING_POST = 'bookings';
    const CLUB_SHOP_DETAILS_POST = 'club_shop_details'; 
    const CLUB_BOOKING_RATES = 'booking_rates';
    const CLUB_BOOKING_DETAILS = 'booking_details';
    const CLUB_SMTP_DETAILS = 'zidii_smtp_settings';
    const CLUB_MEMBERS_DETAILS = 'users';
    const CLUB_CONTACT_US_DETAILS = 'zidii_contact_us';
    const CLUB_SUPPORT_US_DETAILS = 'zidii_support_us';

    // const CUSTOMER = 'customer';
    const CLUB_SHOP_CATEGORY_MAINTENANCE = 'club_shop_category_maintenance';
    const CLUB_SHOP_TYPE_MAINTENANCE = 'club_shop_type_maintenance';
	
    /**
     * @name string PRI_INDEX Holds the name of the tables' primary index used in this model
     */
	const company_docs = 'company_docs';
   
    /**
     * Retrieves record(s) from the database
     *
     * @param mixed $where Optional. Retrieves only the records matching given criteria, or all records if not given.
     *                      If associative array is given, it should fit field_name=>value pattern.
     *                      If string, value will be used to match against PRI_INDEX
     * @return mixed Single record if ID is given, or array of results
     */


    public function get_customers() {
        $query = $this->db->get('customer'); // Replace 'customers' with your actual table name
        return $query->result(); // Returns an array of objects
    }


     public function getFacilityname($where = NULL) {
        
        $this->db->select('*');
        $this->db->from(self::CLUB_FACILITIES_BANDA);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where("id",$where);
            }
        }
        $result = $this->db->get()->result();
        
        return $result;
    
    }

    public function count_customers()
{
    return $this->db->count_all('customer'); // adjust table name if different
}

    // public function getFacilityNameBanda($where = NULL) {
        
    //     $this->db->select('*');
    //     $this->db->from(self::CLUB_FACILITIES_BANDA);
    //     $this->db->order_by('id', 'DESC');
    //     if ($where !== NULL) {
    //         if (is_array($where)) {
    //             foreach ($where as $field=>$value) {
    //                 $this->db->where($field, $value);
    //             }
    //         } else {
    //             $this->db->where("id",$where);
    //         }
    //     }
    //     $result = $this->db->get()->result();
        
    //     return $result;
    
    // }

    public function getsubscriptionedit($where = NULL) {
        $this->db->select('*');
        $this->db->from('club_subscription');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('subscription_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

     public function getjoiningdit($where = NULL) {
        $this->db->select('*');
        $this->db->from('club_joining_fees');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('joining_fee_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function get($where = NULL) {
		$this->db->select('*');
        $this->db->from(self::TABLE_NAME);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('club_id', $where);
            }
        }
		$result = $this->db->get()->result();
		
       return $result;
          
	}


    public function getMembers($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_MEMBERS_DETAILS);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('user_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    

     public function getjoining($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_JOINING_FEE);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('joining_fee_type_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

     public function getSubs($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_SUBSCRIPTIONS);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('subscription_type_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }


    public function getShop($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_SHOP);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('shop_id', $where);
            }
        }
        $result = $this->db->get()->result();

       return $result;

    }

    public function getjoiningDetails($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_JOINING_FEE_POST);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('joining_fee_type_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getsubscriptionDetails($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_SUBSCRIPTION_POST);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('joining_fee_type_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getregularDetails($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_REGULAR);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('user_id', $where);
            }
        }
        $result = $this->db->get()->result();

       return $result;

    }

    public function getcorporateDetails($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_CORPORATE);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('user_id', $where);
            }
        }
        $result = $this->db->get()->result();

       return $result;

    }


    public function getbookingyearDetails($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_BOOKING_DETAILS);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('booking_details_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getsubscription($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_SUBSCRIPTIONS);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('subscription_type_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getusers($where = NULL) {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('user_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }



     public function getClubDocs($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_docs");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('club_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getClubNoticeboard($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_noticeboard");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('notice_board_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getClubMessages($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_messages");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('message_id', $where);
            }
        }
        $result = $this->db->get()->result();

       return $result;

    }


    public function getClubShop($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_shop");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('shop_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

     public function getClubShopDetails($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_shop_details");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('shop_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

     public function getClubShopCategoryMain($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_shop_category_maintenance");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('category_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getClubShopTypeMain($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_shop_type_maintenance");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('type_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }


    public function getProfileDetails($where = NULL) {

        $this->db->select('*');
        $this->db->from("users");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('user_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getFacilityBandas($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_facility_banda");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('club_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getFacilityCamps($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_facility_camps");
        // $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('club_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    

    public function getBookingRates($where = NULL) {

        $this->db->select('*');
        $this->db->from("booking_rates");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('club_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }


    public function getShops($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_shop_details");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('shop_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

     public function getShopsDetailsItems($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_shop_details");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('shop_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

     public function getJoiningFee($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_joining_fee_types");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('club_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }


    public function getBookingsDetailsID($where = NULL) {

        $this->db->select('*');
        $this->db->from("booking_details");
        $this->db->order_by('id', 'ASC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('booking_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }


    public function getShopPaymentDetailID($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_shop_details");
        $this->db->order_by('id', 'ASC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('item_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getDocuments($where = NULL) {

        $this->db->select('*');
        $this->db->from("booking_details");
        $this->db->order_by('id', 'ASC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('booking_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }


    public function getSubscriptiontypes($where = NULL) {

        $this->db->select('*');
        $this->db->from("club_subscriptions_types");
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('club_id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }


	public function getUserCompanies($where = NULL) {
		$this->db->select('*');
        $this->db->from(self::USER_COMPANIES);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('id', $where);
            }
        }
		$result = $this->db->get()->result();
		
       return $result;
          
	}

    public function getUserClubs($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::USER_COMPANIES);
        // $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

//
    public function getFacilityItems($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_FACILITIES);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    //
     public function getBookings($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_BOOKING_POST);
        $this->db->order_by('id', 'DESC');
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    } 

    public function getBookingsDetails($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_BOOKING_DETAILS);
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where('id', $where);
            }
        }
        $result = $this->db->get()->result();
        
       return $result;
          
    }

    public function getCompaniesFromUserId($user_id)
    {
        $companyArr = [];
        $userCompanies = $this->getUserCompanies(array('user_id'=>$user_id));
        foreach ($userCompanies as $value) { array_push($companyArr,$value->company_id); }

        if(!empty($companyArr)){
        $this->db->select('*');
        $this->db->from('zidii_clubs');
        $this->db->order_by('club_name', 'ASC');
        $this->db->where_in('club_id',$companyArr);
        $result = $this->db->get()->result();
        }

        return $result;
    }

    public function getClubsFromUserId($user_id)
    {
        $clubArr = [];
        $userClubs = $this->getUserCompanies(array('user_id'=>$user_id));
        foreach ($userClubs as $value) { array_push($clubArr,$value->club_id); }

        if(!empty($clubArr)){
        $this->db->select('*');
        $this->db->from('zidii_clubs');
        $this->db->order_by('club_name', 'ASC');
        $this->db->where_in('club_id',$clubArr);
        $result = $this->db->get()->result();
        }

        return $result;
    }



    /**
     * Inserts new data into database
     *
     * @param Array $data Associative array with field_name=>value pattern to be inserted into database
     * @return mixed Inserted row ID, or false if error occured
     */
    public function insert(Array $data) {

		if ($this->db->insert(self::TABLE_NAME, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}

     public function insertContact(Array $data) {

        if ($this->db->insert(self::CLUB_CONTACT_US_DETAILS, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertSupport(Array $data) {

        if ($this->db->insert(self::CLUB_SUPPORT_US_DETAILS, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }


 public function insertJoiningFeePost(Array $data) {

        if ($this->db->insert(self::CLUB_JOINING_FEE_POST, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertSubscriptionPost(Array $data) {

        if ($this->db->insert(self::CLUB_SUBSCRIPTION_POST, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }
    


	public function insertUserClubs(Array $data) {

		if ($this->db->insert(self::USER_COMPANIES, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


public function insertFacilityCamp(Array $data) {

        if ($this->db->insert(self::CLUB_FACILITIES, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertJoiningFee(Array $data) {

        if ($this->db->insert(self::CLUB_JOINING_FEE, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertSubscriptions(Array $data) {

        if ($this->db->insert(self::CLUB_SUBSCRIPTIONS, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

     public function insertBookingRates(Array $data) {

        if ($this->db->insert(self::CLUB_BOOKING_RATES, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

     public function insertBookingDetails(Array $data) {

        if ($this->db->insert(self::CLUB_BOOKING_DETAILS, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        } 
    }

    public function insertFacilityBanda(Array $data) {

        if ($this->db->insert(self::CLUB_FACILITIES_BANDA, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertBooking(Array $data) {

        if ($this->db->insert(self::CLUB_BOOKING_POST, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

    public function insertShopdetails(Array $data) {

        if ($this->db->insert(self::CLUB_SHOP_DETAILS_POST, $data)) {
            return $this->db->insert_id();
        } else {
            return false;
        }
    }

	
    /**
     * Updates selected record in the database
     *
     * @param Array $data Associative array field_name=>value to be updated
     * @param Array $where Optional. Associative array field_name=>value, for where condition. If specified, $id is not used
     * @return int Number of affected rows by the update query
     */
    public function update(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('club_id' => $where);
            }
        $this->db->update(self::TABLE_NAME, $data, $where);
        return $this->db->affected_rows();
	}

    public function updatejoining(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('joining_fee_type_id' => $where);
            }
        $this->db->update(self::CLUB_JOINING_FEE, $data, $where);
        return $this->db->affected_rows();
    }

     public function updatebooking(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('booking_id' => $where);
            }
        $this->db->update(self::CLUB_BOOKING_POST, $data, $where);
        return $this->db->affected_rows();
    }

    public function updatesub(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('subscription_type_id' => $where);
            }
        $this->db->update(self::CLUB_SUBSCRIPTIONS, $data, $where);
        return $this->db->affected_rows();
    }

    public function updateshop(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('shop_id' => $where);
            }
        $this->db->update(self::CLUB_SHOP, $data, $where);
        return $this->db->affected_rows();
    }

    public function updateshopItem(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('item_id' => $where);
            }
        $this->db->update(self::CLUB_SHOP_DETAILS_POST, $data, $where);
        return $this->db->affected_rows();
    }
 

     public function updateuser(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('user_id' => $where);
            }
        $this->db->update('users', $data, $where);
        return $this->db->affected_rows();
    }


    /**
     * Deletes specified record from the database
     *
     * @param Array $where Optional. Associative array field_name=>value, for where condition. If specified, $id is not used
     * @return int Number of rows affected by the delete query
     */
    public function delete($where = array()) {
        if (!is_array($where)) {
            $where = array(self::PRI_INDEX => $where);
        }
        $this->db->delete(self::TABLE_NAME, $where);
        return $this->db->affected_rows();
	}

     public function updatesubscriptionedit(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('subscription_id' => $where);
            }
        $this->db->update('club_subscription', $data, $where);
        return $this->db->affected_rows();
    }

     public function updatejoiningedit(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('joining_fee_id' => $where);
            }
        $this->db->update('club_joining_fees', $data, $where);
        return $this->db->affected_rows();
    }

     public function updatebookingsedit(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('booking_id' => $where);
            }
        $this->db->update('bookings', $data, $where);
        return $this->db->affected_rows();
    }

    public function updatebookingdetailsedit(Array $data, $where = array()) {
            if (!is_array($where)) {
                $where = array('id' => $where);
            }
        $this->db->update('booking_details', $data, $where);
        return $this->db->affected_rows();
    }

    public function getSmtp($where = NULL) {
        $this->db->select('*');
        $this->db->from(self::CLUB_SMTP_DETAILS);
        if ($where !== NULL) {
            if (is_array($where)) {
                foreach ($where as $field=>$value) {
                    $this->db->where($field, $value);
                }
            } else {
                $this->db->where(self::PRI_INDEX, $where);
            }
        }
        $result = $this->db->get()->result();
       
          return $result;
    }

    public function updateSmtp(Array $data, $id) {

         $this->db->set($data);
         $this->db->where('id', $id);
         $this->db->update(self::CLUB_SMTP_DETAILS);

         return $this->db->last_query(); 
    }

    public function countClubMessages($club_id) {
    $this->db->from('club_messages');
    // $this->db->where('club_id', $club_id); // Add condition to match the logged-in user's club_id
    return $this->db->count_all_results(); // Returns the count of rows
}
	


}

/* End of file ModelName.php */


?>
