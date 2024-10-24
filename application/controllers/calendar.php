<?php

class Calendar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Event_model');
        //check login
        //if(!$this->session->userdata('logged_in')){
       // redirect('users/login');
        // }
    }

    public function index()
    {
        $data = [
            'view'          => 'pages/calendar',
            'title'         => 'calendrier',
           // 'pending_count' => $this->session->userdata('pending_count'),
        ];
       
        $this->load->view('templates/header',$data);
        $this->load->view('templates/sidebar',$data);

    }

    public function display_event()
    {
        $events = $this->Event_model->get_events();
        if ( ! empty($events)) {
            $data_arr = [];
            foreach ($events as $i => $event) {
                $data_arr[$i]['event_id'] = $event['event_id'];
                $data_arr[$i]['title']    = $event['event_name'];
                $data_arr[$i]['start']    = $event['event_start_datetime'];
                $data_arr[$i]['end']      = $event['event_end_datetime'];
                $data_arr[$i]['color']    = '#36CD36';
            }

            $data = [
                'status' => true,
                'msg'    => 'successfully!',
                'data'   => $data_arr,
            ];
        } else {
            $data = [
                'status' => false,
                'msg'    => 'Error!',
            ];
        }
        echo json_encode($data);
    }

    public function save_event()
    {
        $event_name           = $this->input->post('event_name');
        $event_start_datetime = $this->input->post('event_start_datetime');
        $event_end_datetime   = $this->input->post('event_end_datetime');

        $event = [
            'event_name'           => $event_name,
            'event_start_datetime' => $event_start_datetime,
            'event_end_datetime'   => $event_end_datetime,
        ];

        if ($this->Event_model->save_event($event)) {
            $data = [
                'status' => true,
                'msg'    => 'Événement ajouté avec succès!',
            ];
        } else {
            $data = [
                'status' => false,
                'msg'    => 'Désolé, l\'événement n\'a pas été ajouté.',
            ];
        }
        echo json_encode($data);
    }

    public function update_event()
    {
        $event_id             = $this->input->post('event_id');
        $event_name           = $this->input->post('event_name');
        $event_start_datetime = $this->input->post('event_start_datetime');
        $event_end_datetime   = $this->input->post('event_end_datetime');

        $event = [
            'event_name'           => $event_name,
            'event_start_datetime' => $event_start_datetime,
            'event_end_datetime'   => $event_end_datetime,
        ];

        if ($this->Event_model->update_event($event_id, $event)) {
            $data = [
                'status' => true,
                'msg'    => 'Événement mis à jour avec succès!',
            ];
        } else {
            $data = [
                'status' => false,
                'msg'    => 'Désolé, l\'événement n\'a pas été mis à jour.',
            ];
        }
        echo json_encode($data);
    }

    public function delete_event()
    {
        $event_id = $this->input->post('event_id');

        if ($this->Event_model->delete_event($event_id)) {
            $data = [
                'status' => true,
                'msg'    => 'Événement supprimé avec succès!',
            ];
        } else {
            $data = [
                'status' => false,
                'msg'    => 'Désolé, l\'événement n\'a pas été supprimé.',
            ];
        }
        echo json_encode($data);
    }


    // rendez-vous

    public function save_rendezvous()
    {
        $rendezvousDate      = $this->input->post('rendezvousDate');
        $rendezvousStartTime = $this->input->post('rendezvousStartTime');
        $rendezvousEndTime   = $this->input->post('rendezvousEndTime');
        $prospectName        = $this->input->post('prospectName');
        $added_by            = $this->input->post('added_by');


        $rendezvous = [
            'event_name'           => 'Rendez-vous avec '.$prospectName,
            'event_start_datetime' => $rendezvousDate.' '.$rendezvousStartTime,
            'event_end_datetime'   => $rendezvousDate.' '.$rendezvousEndTime,
            'added_by'             => $added_by,
        ];

        if ($this->Event_model->save_event($rendezvous)) {
            $data = [
                'status' => true,
                'msg'    => 'Rendez-vous ajouté avec succès!',
            ];
        } else {
            $data = [
                'status' => false,
                'msg'    => 'Désolé, le rendez-vous n\'a pas été ajouté.',
            ];
        }

        echo json_encode($data);
    }

    // rendez-vous for the day

    public function getMyRendezvous()
    {
        $user_id = $this->session->userdata('id'); // Get the logged-in user ID
        $today   = date('Y-m-d'); // Get today's date

        // Load the Event_model
        $this->load->model('Event_model');

        // Fetch rendez-vous for today
        $data['rendezvous'] = $this->Event_model->get_rendezvous_by_user_and_date($user_id, $today);

        // Load the view and pass the data
        $this->load->view('rendezvous_banner', $data);
    }


}
