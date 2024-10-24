<?php
class Contact extends CI_controller {
    public function __construct() {
        parent::__construct(); // Call the parent constructor
       
        //check login
       // if(!$this->session->userdata('logged_in')){
        //redirect('users/login');
       // }
    }

    public function contactEmail() {
        // Load the email library and form validation
        $this->load->library('email');
        $this->load->helper('form');
        $this->load->library('form_validation');

        // Set form validation rules
        $this->form_validation->set_rules('to', 'To', 'required|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'required');

        if ($this->form_validation->run() == FALSE) {
            // If form validation fails, load the form view along with the header and footer
            $data = [
                "title" => "Contacter.",
                'view' => 'pages/contact',

            ];
            // Load the view to display the form
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
        } else {
            // Get form data
            $to = $this->input->post('to');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');

            // Set email parameters
            $this->email->set_newline("\r\n");
            $this->email->from('btissa.alami@gmail.com', 'FES MARKETING SERVICE');
            $this->email->to($to);
            $this->email->subject($subject);
            $this->email->message($message);

            // Send email
            if ($this->email->send()) {
                $this->session->set_flashdata('success', "L'email a été envoyé avec succès!");
            } else {
                $this->session->set_flashdata('warning', "Échec de l'envoi de l'email.");
            }
            redirect('contact'); // Redirect to the same contact page after email sending
        }
    }
}
