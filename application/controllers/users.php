<?php

class Users extends CI_Controller{
    private $logger;

    public function __construct() {
        parent::__construct(); // Call the parent constructor
        $this->load->model('user_model');
        $this->load->model('document'); // Load the Post_model
        $this->load->library('session');

        // Load Log4php from the correct path
        require_once APPPATH . 'libraries/log4php/src/main/php/Logger.php';  // Adjust the path if necessary
        //Logger::configure('config/log4php_config.php');   
        Logger::configure(APPPATH . 'config/log4php_config.xml');

        $this->logger = Logger::getRootLogger();

       // $this->load->library('SplunkLogger');
       define('console', 'my_console_logger');

    }

    public function testLogging() {
        // Log a test message
        //$this->logger->info("This is a test log message!");
        //console.log("This is a test log message!");
        $this->logger->info(console, "This is a log message");

        echo "Log message sent. Check the output!";
    }

    public function usersTable()
    {
        $data = [
            "title"         => "Liste des commerciaux",
           // "view"          => "dashboard/users_table",
            'pending_count' => $this->session->userdata('pending_count'),
        ];

        $this->load->view('templates/header');
        $this->load->view('users/users_table', $data);
        $this->load->view('templates/footer');   
     }

     public function fetchUsers()
     {
         $query           = $this->db->get('users');
         $data            = $query->result_array();
         $currentUserId   = (int) $this->session->userdata('id');
         $currentUserRole = $this->session->userdata('role');
 
         $formattedData = array_map(function ($row) use ($currentUserId, $currentUserRole) {
             $rowUserId        = (int) $row['id'];
             $rowUserRole      = $row['role'];
             //$rowUserSuspended = $row['suspended'];
 
             if ($rowUserId != $currentUserId) {
                 if ($currentUserId == 1 || ($currentUserRole == 'admin' && $rowUserRole == 'user')) {
                     $suspendIcon = $rowUserSuspended
                         ? '<a class="btn btn-success btn-sm mr-1" href="'.base_url('DashboardController/suspendre_user/'.$row['id']).'" title="Réactiver"><i class="fas fa-play-circle text-white"></i></a>'
                         : '<a class="btn btn-warning btn-sm mr-1" href="'.base_url('DashboardController/suspendre_user/'.$row['id']).'" title="Suspendre"><i class="fas fa-pause-circle text-white"></i></a>';
 
                     $row['actions'] = '
                 <div class="d-flex justify-content-around">
                     <a class="btn btn-danger btn-sm mr-1" href="'.base_url('DashboardController/delete_user/'.$row['id']).'" title="Supprimer"><i class="fas fa-trash-alt text-white"></i></a>
                     <a class="btn btn-primary btn-sm mr-1" href="'.base_url('DashboardController/edit_user/'.$row['id']).'" title="Modifier"><i class="fas fa-edit text-white"></i></a>'
                         .$suspendIcon.'
                 </div>';
                 } else {
                     $row['actions'] = '';
                 }
             } else {
                 $row['actions'] = '';
             }
 
             return $row;
         }, $data);
 
         echo json_encode(['data' => $formattedData]);
     }


     public function register() {
        $data['title'] = 'Sign up';
    
        // Validation des champs
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('password2', 'Confirm password', 'required|matches[password]');
    
        if ($this->form_validation->run() === FALSE) {
            // Si la validation échoue, recharge la page d'inscription
            $this->load->view('templates/header');
            $this->load->view('users/register', $data);
            $this->load->view('templates/footer');
        } else {
            // Hachage sécurisé du mot de passe avec password_hash() (utilise bcrypt par défaut)
            $enc_password = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
    
            // Enregistrement de l'utilisateur avec le mot de passe haché
            $this->user_model->register($enc_password);
    
            // Message flash de confirmation
            $this->session->set_flashdata('user_registered', 'You are now registered and can log in');
            redirect('documents');
        }
    }
    
    public function login() {
        $data['title'] = 'Sign In';
        
        // Validation of form fields
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
    
        if ($this->form_validation->run() === FALSE) {
            // If validation fails, reload the login page
            $this->load->view('templates/header');
            $this->load->view('users/login', $data);
            $this->load->view('templates/footer');
        } else {
            // Verify Google reCAPTCHA
            $recaptchaResponse = $this->input->post('g-recaptcha-response');
            $secretKey = '6Lcoe2EqAAAAAFfsGXOEhP3iLDLqyOZaNYhE3qnp';
            $verifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");
            $responseData = json_decode($verifyResponse);
    /*
            if (!$responseData->success) {
                // reCAPTCHA verification failed, show error message
                $this->session->set_flashdata('captcha_failed', 'Captcha verification failed. Please try again.');
                redirect('users/login');
                return;
            }
    */
            // Get form data
            $username = $this->input->post('username');
            $password = $this->input->post('password');
    
            // Log the login attempt
            $this->logger->info("Login attempt by user: $username");
    
            // Get user by username
            $user = $this->user_model->get_user_by_username($username);
    
            if ($user && password_verify($password, $user['password'])) {
/*    
                // Step 1: Generate OTP
                $otp = rand(100000, 999999); // A 6-digit OTP
                $otp_generated_at = time(); // Store current timestamp
    
                // Step 2: Save OTP in session (or DB for persistence)
                $this->session->set_userdata('otp', $otp);
                $this->session->set_userdata('otp_generated_at', $otp_generated_at);
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('username', $username);

                // Step 3: Send OTP to user via email
                $this->load->library('email');
                $this->email->from('btissa.alami@gmail.com', 'docapp');
                $this->email->to($user['email']);
                $this->email->subject('Your OTP for Login');
                $this->email->message('Your OTP is: ' . $otp);
                $this->email->send();
    
                // If email sent, redirect to OTP verification page
                redirect('users/verify_otp');
                */
                $this->session->set_userdata('logged_in', true);
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('username', $username);

                redirect('documents');

            } else {
                // Invalid login
                $this->session->set_flashdata('user_failed', 'Login invalid');
                redirect('users/login');
            }
        }
    }
    
    

    public function verify_otp() {
        // Get OTP from the session
        $otp_in_session = $this->session->userdata('otp');
        $user_id = $this->session->userdata('user_id');
        $username = $this->session->userdata('username');
        $otp_generated_at = $this->session->userdata('otp_generated_at');

     // Validation of form fields
     $this->form_validation->set_rules('otp', 'otp', 'required');
 
     if ($this->form_validation->run() === FALSE) {
         // If validation fails, reload the login page
         $this->load->view('templates/header');
         $this->load->view('users/verify_otp');
         $this->load->view('templates/footer');
     } else {
        // Get the OTP entered by the user
        $entered_otp = $this->input->post('otp');

        if (time() - $otp_generated_at > 600) {
            // OTP expired
            $this->session->set_flashdata('error', 'Your OTP has expired. Please request a new one.');
            redirect('users/login');
        } elseif ($entered_otp == $otp_in_session) {
            // OTP is valid, log the user in
            $this->session->set_userdata('logged_in', true);
    
            // Clear OTP session data
            $this->session->unset_userdata('otp');
            $this->session->unset_userdata('otp_generated_at'); // Clear OTP generation time

            // Redirect to the secure area
            $this->session->set_flashdata('user_logedin', 'OTP verified, you are logged in');
            redirect('documents');
        } else {
            // Invalid OTP
            $this->session->set_flashdata('error', 'Invalid OTP, please try again');
            redirect('users/verify_otp');
            
        }
    }
}
    
    

    public function logout(){
        $user_id = $this->session->userdata('user_id');   
        $user = $this->user_model->get_user_by_id($user_id);

         // Log the logout event
         //$this->logger->info("User {$user->username} logged out.");

        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');


        $this->session->set_flashdata('user_loggedout', 'You are now logged out');
        redirect('users/login');
    }



    public function change_password() {
        // Ensure the user is logged in
       // if (!$this->session->userdata('logged_in')) {
       //     redirect('users/login');
       // }

        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[8]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'matches[new_password]');

        if ($this->form_validation->run() === FALSE) {
            // Load the view with errors
            $data['title'] = 'Change Password';
            $data = [
                "title"         => "Liste des documents.",
                'view'          => 'users/change_password',
            ];
            $this->load->view('templates/header',$data);
            $this->load->view('templates/sidebar',$data);
         
            
        } else {
            $old_password = $this->input->post('old_password');
            $new_password = password_hash($this->input->post('new_password'), PASSWORD_DEFAULT); // Hash the new password

            // Load user data (assuming you have a method to get the current user's info)
            $user_id = $this->session->userdata('user_id');
            $user = $this->user_model->get_user($user_id);

            // Verify old password matches
            if (password_verify($old_password, $user['password'])) {
                // Update the password
                $this->user_model->update_password($user_id, $new_password);
                $this->session->set_flashdata('password_changed', 'Your password has been updated.');
                redirect('users/profile'); // Redirect to profile or any appropriate page
            } else {
                $this->session->set_flashdata('password_error', 'Old password is incorrect.');
                redirect('users/change_password');
            }
        }
    }
}