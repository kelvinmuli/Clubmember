<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NewsletterController extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
	**/
    public function newsletterView() 
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $data = $this->common->loadHeaderData('newsletter');
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $data['newsletterData'] = $this->db->select('*')
            ->from($customerDBSettingRow->database_name.'.newsletter')
            ->order_by('created_at', 'DESC')
            ->get()
            ->result();
        $data['customer_db_setting_id'] = $customer_db_setting_id;

        $this->load->view('admin/templates/header_view', $data);
        $this->load->view('admin/newsletter_view', $data);
        $this->load->view('admin/templates/footer_view', $data);
    }

    public function addNewsletterModal()
    {
        $this->common->checkSession();
        $this->common->loadSession();

        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
        $data['newsletter_id'] = generate_uuid();

        return $this->load->view('admin/add_edit_newsletter_modal', $data);
    }

    public function addNewsletter()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $postData = $this->input->post();
		if (isset($_FILES['thumbnail_url']['name'])) {
			$postData['thumbnail_url'] = file_upload('thumbnail_url', $postData['newsletter_id']);
		}
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $this->db->insert($customerDBSettingRow->database_name.'.newsletter', $postData);
        $this->session->set_flashdata('success', 'Newsletter saved successfully.');
        redirect('newsletter', 'refresh');
    }

	public function viewNewsletterModal($newsletter_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $newsletterRow = $this->db->from($customerDBSettingRow->database_name.'.newsletter')->where('newsletter_id', $newsletter_id)->get()->row();
        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
        $data['newsletterRow'] = $newsletterRow;
		$data['newsletter_id'] = $newsletter_id;

        return $this->load->view('admin/view_newsletter_modal', $data);
    }

    public function editNewsletterModal($newsletter_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $newsletterRow = $this->db->from($customerDBSettingRow->database_name.'.newsletter')->where('newsletter_id', $newsletter_id)->get()->row();
        $data['activeData'] = $this->db->select('*')->from('m_active')->where('active', 1)->get()->result();
        $data['newsletterRow'] = $newsletterRow;
		$data['newsletter_id'] = $newsletter_id;

        return $this->load->view('admin/add_edit_newsletter_modal', $data);
    }

    public function editNewsletter()
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

        $postData = $this->input->post();
		$newsletter_id = $postData['newsletter_id'];
		if (isset($_FILES['thumbnail_url']['name'])) {
			$postData['thumbnail_url'] = file_upload('thumbnail_url', $newsletter_id);
		}
		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
        $this->db->update($customerDBSettingRow->database_name.'.newsletter', $postData, array('newsletter_id'=>$newsletter_id));

        $this->session->set_flashdata('success', 'Newsletter updated successfully.');
        redirect('newsletter', 'refresh');
    }

    public function removeNewsletterModal($newsletter_id = null)
    {
        $this->common->checkSession();
        $session_data = $this->common->loadSession();
        $customer_db_setting_id = $session_data['customer_db_setting_id'];

		$customerDBSettingRow = $this->db->select('*')->from('customer_db_setting')->where('customer_db_setting_id', $customer_db_setting_id)->get()->row();
		$newsletterRow = $this->db->from($customerDBSettingRow->database_name.'.newsletter')->where('newsletter_id', $newsletter_id)->get()->row();
        $data['table'] = $customerDBSettingRow->database_name.'.newsletter';
        $data['table_id'] = 'newsletter_id';
        $data['unique_id'] = $newsletter_id;
        $data['name'] = isset($newsletterRow->name) ? $newsletterRow->name : 'newsletter';
        $data['route'] = 'newsletter';

        return $this->load->view('admin/remove_global_modal', $data);
    }

}
