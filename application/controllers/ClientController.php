<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ClientController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ClientModel'); // Load the ClientModel
        $this->load->library('form_validation'); // Load the form_validation library
        $this->load->helper('date'); // Load the date helper

        //check login
        // if(!$this->session->userdata('logged_in')){
        //    redirect('users/login');
        //}
    }

    public function clientsTable()
    {
        $data = [
            "title"         => "Liste de tous les clients.",
            "view"          => "clients/clients_table",
            'pending_count' => $this->session->userdata('pending_count'),
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
    }

    public function fetchClients($status = null)
    {
        if ($status) {
            $this->db->where('status', $status);
        }
        $query = $this->db->get('clients');
        $data  = $query->result_array();

        $formattedData = array_map(function ($row) {
            $actions = '
    <div class="d-flex justify-content-center align-items-center">
        <a class="btn btn-success btn-sm mr-1" href="'.base_url('ClientController/selectClient/'.$row['id']).'" title="Ajouter à contacter">
            <i class="fas fa-plus text-white mt-1"></i>
        </a>
        <a class="btn btn-primary btn-sm mr-1" href="'.base_url('ClientController/edit_client/'.$row['id']).'" title="Modifier">
            <i class="fas fa-edit"></i>
        </a>';

            // Check if the user has the admin role
            if ($this->session->userdata('role') === 'admin') {
                $actions .= '
        <a class="btn btn-danger btn-sm" href="'.base_url('ClientController/delete_client/'.$row['id']).'" title="Supprimer">
            <i class="fas fa-trash"></i>
        </a>';
            }

            $actions .= '</div>';

            $row['actions'] = $actions;

            return $row;
        }, $data);

        echo json_encode(['data' => $formattedData]);
    }

    public function registerClient()
    {
        $data = [
            "title"         => "Créer un client",
            'view' => 'clients/register_client',
            'pending_count' => $this->session->userdata('pending_count'),
        ];

        // Load the view to display the form
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
    }

    public function register()
    {
        var_dump($this->session->userdata('id'));

        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email', [
            'required'    => 'Le champ E-mail est obligatoire.',
            'valid_email' => 'Veuillez fournir une adresse e-mail valide.',
        ]);
        $this->form_validation->set_rules('company', 'Entreprise', 'required', [
            'required' => 'Le champ Entreprise est obligatoire.',
        ]);
        $this->form_validation->set_rules('ville', 'Ville', 'required', [
            'required' => 'Le champ Ville est obligatoire.',
        ]);
        $this->form_validation->set_rules('address', 'Adresse', 'required', [
            'required' => 'Le champ Adresse est obligatoire.',
        ]);

        // Validate phone numbers
        $phone_numbers = $this->input->post('phone_number');
        if (empty($phone_numbers) || ! is_array($phone_numbers)) {
            $this->form_validation->set_rules('phone_number[]', 'Numéros de téléphone', 'required', [
                'required' => 'Le champ Numéros de téléphone est obligatoire.',
            ]);
        }

        if ($this->form_validation->run() === false) {
            $data = [
                'title'             => 'Créer un nouveau client',
                'is_admin_exists'   => $this->user_model->count_admins() > 0,
                'validation_errors' => validation_errors(),
                'view' => 'clients/register_client',
            ];

            // Load the view to display the form
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
        } else {

            $client_data = [
                'name'          => $this->input->post('name'),
                'email'         => $this->input->post('email'),
                'company'       => $this->input->post('company'),
                'phone_numbers' => json_encode($this->input->post('phone_number')), // Store phone numbers as JSON
                'ville'         => $this->input->post('ville'),
                'address'       => $this->input->post('address'),
                'interets'      => json_encode($this->input->post('interets')), // Store interests as JSON
                'status'        => 'nouveau', // Default status
                'assigned_to'   => $this->session->userdata('id'), // Set the assigned_to field
            ];

            if ($this->ClientModel->insert_client($client_data)) {
                $this->session->set_flashdata('success', 'Le client a été ajouté avec succès.');
                redirect('register_client');
            } else {
                $this->session->set_flashdata('error',
                    'Un problème est survenu lors de l\'ajout du client. Veuillez réessayer.');
                $data = [
                    'title'             => 'Créer un nouveau client',
                    'is_admin_exists'   => $this->user_model->count_admins() > 0,
                    'validation_errors' => validation_errors(),
                    'view' => 'clients/register_client',
                ];

                // Load the view to display the form
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
            }
        }
    }

    public function edit_client($id)
    {
        $this->load->library('form_validation');
        $this->load->model('ClientModel');
        $this->load->model('user_model');

        $this->form_validation->set_rules('first_name', 'Prénom', 'required');
        $this->form_validation->set_rules('last_name', 'Nom', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email');
        $this->form_validation->set_rules('company', 'Entreprise', 'required');
        $this->form_validation->set_rules('ville', 'Ville', 'required');
        $this->form_validation->set_rules('address', 'Adresse', 'required');

        $phone_numbers = $this->input->post('phone_number');
        if (empty($phone_numbers) || ! is_array($phone_numbers)) {
            $this->form_validation->set_rules('phone_number[]', 'Numéros de téléphone', 'required');
        }

        $this->form_validation->set_rules('assigned_to', 'Assigné à', 'required|integer');

        $user = $this->session->userdata('user');

        if ($this->form_validation->run() === false) {
            $client    = $this->ClientModel->get_client($id);
            $users     = $this->user_model->get_all_users();
            $interests = $this->ClientModel->get_interests_list($id); // Get the interests list
            $data      = [
                'title'         => 'Modifier Client',
                'user'          => $user,
                'client'        => $client,
                'users'         => $users,
                'interests'     => $interests,
                'pending_count' => $this->session->userdata('pending_count'),
                'view'          => 'clients/edit_client',
            ];
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
        } else {
            $data = [
                'first_name'    => $this->input->post('first_name'),
                'last_name'     => $this->input->post('last_name'),
                'email'         => $this->input->post('email'),
                'company'       => $this->input->post('company'),
                'phone_numbers' => json_encode($this->input->post('phone_number')),
                'ville'         => $this->input->post('ville'),
                'address'       => $this->input->post('address'),
                'assigned_to'   => $this->input->post('assigned_to'),
                'interets'      => json_encode($this->input->post('interets')), // Update interests
                'status'        => 'nouveau',
            ];

            if ($this->ClientModel->update_client($id, $data)) {
                $this->session->set_flashdata('success', 'Le client a été modifié avec succès!');
                redirect('ClientController/consult_client/'.$id);
            } else {
                $client    = $this->ClientModel->get_client($id);
                $users     = $this->user_model->get_all_users();
                $interests = $this->ClientModel->get_interests_list($id); // Get the interests list
                $data      = [
                    'title'         => 'Modifier Client',
                    'user'          => $user,
                    'client'        => $client,
                    'users'         => $users,
                    'interests'     => $interests,
                    'pending_count' => $this->session->userdata('pending_count'),
                    'view'          => 'clients/edit_client',
                ];
                $this->session->set_flashdata('error',
                    'Une erreur s\'est produite lors de la mise à jour des informations du client.');
                $this->load->view('templates/header', $data);
                $this->load->view('templates/sidebar', $data);
            }
        }
    }

    public function consult_client($id)
    {
        $client = $this->ClientModel->get_client($id);
        $users  = $this->user_model->get_all_users();
        $data   = [
            'title'         => 'Consultation Client',
            'client'        => $client,
            'users'         => $users,
            'pending_count' => $this->session->userdata('pending_count'),
            'view'          => 'clients/consult_client',
        ];

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
    }

    public function delete_client($id)
    {
        $this->ClientModel->delete_client($id);
        $this->session->set_flashdata('success', 'Le client a été supprimé avec succès.');
        redirect('ClientController/clientsTable');
    }

    public function selectClient($client_id)
    {
        $client = $this->ClientModel->get_client($client_id);

        if ($client) {
            // Perform necessary actions for selecting the client
            // You can set a flash message or redirect based on your logic
            $this->session->set_flashdata('success', 'Le client a été sélectionné pour être contacté.');
        } else {
            $this->session->set_flashdata('error', 'Client non trouvé.');
        }

        redirect('ClientController/clientsTable');
    }
}
