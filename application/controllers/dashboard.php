<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('form_validation');
            
        //check login
       // if(!$this->session->userdata('logged_in')){
        //    redirect('users/login');
       // }
    }

    public function adminDashboard()
    {
        $user_id         = $this->session->userdata('id');
        //$pending_rappels = $this->Rappel_model->get_rappels_by_user($user_id);
        //$pending_count   = count($pending_rappels);

        // Load the Event_model
        $this->load->model('Event_model');

        // Fetch rendez-vous for today
        $today      = date('Y-m-d');
       // $rendezvous = $this->Event_model->get_rendezvous_by_user_and_date($user_id, $today);

        // Set session data
       // $this->session->set_userdata('pending_count', $pending_count);

       // Get upcoming events
        // $data['upcoming_deadlines'] = $this->Event_model->get_upcoming_events();


        $data = [
            "title"         => 'Admin Dashboard',
            'view'          => 'pages/dashboard',
            'upcoming_deadlines' => $this->Event_model->get_upcoming_events(),
            'total_documents' => $this->document->getTotalDocuments(),
            'total_customers' => $this->ClientModel->getTotalCustomers(),
            'pending_approval' => $this->document->getPending_approval(),

            
            //"firstname"     => $this->session->userdata('first_name'),
            //"lastname"      => $this->session->userdata('last_name'),
           // "role"          => $this->session->userdata('role'),
            //'pending_count' => $this->session->userdata('pending_count'),
            //'rendezvous'    => 'rrr',
        ];

        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);

    }
}
?>