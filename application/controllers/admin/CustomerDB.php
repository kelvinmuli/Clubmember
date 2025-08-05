<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CustomerDB extends CI_Controller {

    public function __construct() {
        parent::__construct();

         $this->load->model('ClubModel');
        // $this->load->library('session');
        $this->load->helper('url');
        // $this->load->library('common');
         
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     *      http://example.com/index.php/welcome
     *  - or -
     *      http://example.com/index.php/welcome/index
     *  - or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/userguide3/general/urls.html
     */
          public function index() {

            $this->load->model('ClubModel'); // Load your model
            $data['customers'] = $this->ClubModel->get_customers(); // Fetch customers
            $this->load->view('admin/customer_db_view', $data); // Pass data to view

     }


     public function create_database()
{
    // Load helper and session library
    $this->load->helper('url');
    $this->load->library('session');

    // Validate required fields
    $this->load->library('form_validation');
    $this->form_validation->set_rules('customer_id', 'Customer', 'required');
    $this->form_validation->set_rules('database_user', 'Database User', 'required');
    $this->form_validation->set_rules('database_pwd', 'Database Password', 'required');
    $this->form_validation->set_rules('status', 'Status', 'required');
    $this->form_validation->set_rules('sub_domain', 'sub_domain', 'required');

    if ($this->form_validation->run() == FALSE) {
        $this->session->set_flashdata('error', validation_errors());
        redirect('customer-db-config'); // change this as needed
    }

    // Generate a custom customer DB ID using timestamp
    $customer_db_id = time();

    // Prepare insert data
    $data = [
        'customer_db_id'  => $customer_db_id, // ← Added
        'customer_id'     => $this->input->post('customer_id'),
        'database_name'   => $this->input->post('database_name'),
        'database_user'   => $this->input->post('database_user'),
        'database_pwd'    => $this->input->post('database_pwd'),
        'sub_domain'    => $this->input->post('sub_domain'),
        'status'          => $this->input->post('status')
        // 'created_at'      => date('Y-m-d H:i:s') // optional
    ];

    // print_r($data);
    // exixt();

    // Insert into database
    $this->db->insert('customer_db_settings', $data);

    $this->session->set_flashdata('success', 'Database configuration saved successfully. DB Name: ' . $this->input->post('database_name'));
    redirect('customer-db-config'); // change redirect target as needed
}








                    


}
