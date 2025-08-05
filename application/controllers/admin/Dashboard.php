<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();

         $this->load->model('ClubModel');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('common');
         
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
            
    // $this->common->checkSession();
         // $session_data = $this->common->loadSession();
         // $headerData = $this->common->loadHeaderData('dashboard');

    $data['customers'] = $this->db->order_by('created_at', 'DESC')->get('customer')->result();
    $data['total_customers'] = $this->ClubModel->count_customers();

    $data['success'] = $this->session->flashdata('success');
    $data['error']   = $this->session->flashdata('error');

    $this->load->view('admin/dashboard_view', $data);
}





            public function create()
{
    $upload_path = './assets/uploads/';
    $allowed_types = 'gif|jpg|png|jpeg|pdf';

    $logo_name = 'logo_' . time();
    $agreement_name = 'agreement_' . time();
    $customer_id = time(); // ← Set customer_id based on current timestamp

    // Upload logo
    $config_logo = [
        'upload_path'   => $upload_path,
        'allowed_types' => $allowed_types,
        'file_name'     => $logo_name,
        'overwrite'     => true,
    ];
    $this->load->library('upload', $config_logo);

    if (!$this->upload->do_upload('logo')) {
        $this->session->set_flashdata('error', $this->upload->display_errors());
        redirect('dashboard');
    }
    $logoData = $this->upload->data();

    // Upload agreement
    $config_agreement = [
        'upload_path'   => $upload_path,
        'allowed_types' => $allowed_types,
        'file_name'     => $agreement_name,
        'overwrite'     => true,
    ];
    $this->upload->initialize($config_agreement);

    if (!$this->upload->do_upload('agreement')) {
        $this->session->set_flashdata('error', $this->upload->display_errors());
        redirect('dashboard');
    }
    $agreementData = $this->upload->data();

    // Insert data
    $data = [
        'customer_id'        => $customer_id, // ← Add to DB
        'name'               => $this->input->post('name'),
        'short_name'         => $this->input->post('short_name'),
        'email'              => $this->input->post('email'),
        'tel_no'             => $this->input->post('tel_no'),
        'type'               => $this->input->post('type'),
        'country'            => $this->input->post('country'),
        'town'               => $this->input->post('town'),
        'reg_no'             => $this->input->post('reg_no'),
        'physical_address'   => $this->input->post('physical_address'),
        'postal_address'     => $this->input->post('postal_address'),
        'status'             => $this->input->post('status'),
        'logo'               => $logoData['file_name'],
        'agreement'          => $agreementData['file_name'],
    ];

    $this->db->insert('customer', $data);

    // You can still use the DB auto-increment ID if needed
    $insert_id = $this->db->insert_id();

    // $this->session->set_flashdata('success', 'Customer created successfully. Customer Name: ' . $name);
    $this->session->set_flashdata('success', 'Customer "' . $data['name'] . '" created successfully.');
    redirect('dashboard');
}



        public function update()
        {
            $customer_id = $this->input->post('customer_id');

            $data = [
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'tel_no' => $this->input->post('tel_no'),
                'country' => $this->input->post('country'),
                'town' => $this->input->post('town'),
                'reg_no' => $this->input->post('reg_no'),
                'physical_address' => $this->input->post('physical_address'),
                'postal_address' => $this->input->post('postal_address'),
                'status' => $this->input->post('status'),
                'type' => $this->input->post('type')
            ];

            // Optional: Handle logo upload
            if (!empty($_FILES['logo']['name'])) {
                $config['upload_path']   = './assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('logo')) {
                    $upload_data = $this->upload->data();
                    $data['logo'] = $upload_data['file_name'];
                }
            }

            // Optional: Handle agreement upload
            if (!empty($_FILES['agreement']['name'])) {
                $config['upload_path']   = './assets/uploads/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|pdf';
                $this->upload->initialize($config);

                if ($this->upload->do_upload('agreement')) {
                    $upload_data = $this->upload->data();
                    $data['agreement'] = $upload_data['file_name'];
                }
            }

            $this->db->where('customer_id', $customer_id);
            $this->db->update('customer', $data);

            $this->session->set_flashdata('success', 'Customer updated successfully');
            redirect('dashboard');
        }


        public function delete()
        {
            $customer_id = $this->input->post('customer_id');
            if ($customer_id) {
                $this->db->where('customer_id', $customer_id);
                $this->db->delete('customer');
                $this->session->set_flashdata('success', 'Customer deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Customer ID missing.');
            }
            redirect('dashboard'); // Adjust path as needed
        }



}
