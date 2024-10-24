<?php

defined('BASEPATH') or exit('No direct script access allowed');

class ClientModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database(); // Load database library if not loaded already
    }

    public function insert_client($data)
    {
        return $this->db->insert('clients', $data); // Changed table to 'clients'
    }

    public function delete_user_by_id($id)
    {
        $this->db->where('id', $id);

        return $this->db->delete('clients'); // Changed table to 'clients'
    }

    public function get_client($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('clients'); // Changed table to 'clients'

        $client = $query->row_array(); // Return the result as an associative array

        if (!empty($client['phone_numbers'])) {
            $client['phone_numbers'] = json_decode($client['phone_numbers'], true);
        }

        return $client;
    }

    public function update_client($id, $data)
    {
        // Ensure interests are encoded to JSON if provided
        if (isset($data['interets'])) {
            $data['interets'] = json_encode($data['interets']);
        }

        $this->db->where('id', $id);

        return $this->db->update('clients', $data); // Changed table to 'clients'
    }

    public function get_client_consult($id)
    {
        $query = $this->db->get_where('clients', array('id' => $id)); // Changed table to 'clients'

        $client = $query->row();

        if (!empty($client->phone_numbers)) {
            $client->phone_numbers = json_decode($client->phone_numbers, true);
        }

        return $client;
    }

    public function fetchClients($status, $numberOfClients)
    {
        // Fetch the clients with the given status and limit
        $this->db->where('status', $status);
        $this->db->limit($numberOfClients);
        $query = $this->db->get('clients'); // Changed table to 'clients'

        return $query->result_array();
    }

    public function updateActiveClients($numberOfClients, $status)
    {
        // Update the 'active' column based on the conditions
        $this->db->where('status', $status);
        $this->db->where('active', 0); // Assuming you want to update only inactive clients
        $this->db->limit($numberOfClients);
        $this->db->update('clients', ['active' => 1]); // Changed table to 'clients'
    }

    public function get_active_clients()
    {
        $this->db->where('active', 1);
        $query = $this->db->get('clients'); // Changed table to 'clients'

        return $query->result_array();
    }

    public function update_status($id, $status)
    {
        $data = array(
            'status' => $status,
        );

        $this->db->where('id', $id);
        $this->db->update('clients', $data); // Changed table to 'clients'
    }

    public function set_active_status($id, $status)
    {
        $data = array(
            'active' => $status,
        );

        $this->db->where('id', $id);
        $this->db->update('clients', $data); // Changed table to 'clients'
    }

    public function get_all_clients()
    {
        $query = $this->db->get('clients'); // Changed table to 'clients'

        return $query->result();
    }

    public function insert_batch($data)
    {
        $this->db->insert_batch('clients', $data); // Changed table to 'clients'
    }

    // charts
    public function get_clients_by_status()
    {
        $this->db->select("status, COUNT(*) as count");
        $this->db->group_by("status");
        $query = $this->db->get("clients"); // Changed table to 'clients'

        return $query->result_array();
    }

    public function get_total_clients()
    {
        return $this->db->count_all("clients"); // Changed table to 'clients'
    }

    public function get_clients_over_time()
    {
        $this->db->select("DATE(created_at) as day, COUNT(*) as client_count");
        $this->db->group_by("DATE(created_at)");
        $query = $this->db->get("clients"); // Changed table to 'clients'

        return $query->result_array();
    }

    public function get_conversion_percentage()
    {
        $this->db->select('status, COUNT(*) as count');
        $this->db->from('clients'); // Changed table to 'clients'
        $this->db->group_by('status');
        $query   = $this->db->get();
        $results = $query->result_array();

        $total            = 0;
        $conversion_count = 0;

        foreach ($results as $row) {
            if ($row['status'] == 'converti') {
                $conversion_count = $row['count'];
            }
            $total += $row['count'];
        }

        $percentage_conversion = $total > 0 ? ($conversion_count / $total) * 100 : 0;

        return [
            'conversion_percentage' => $percentage_conversion,
            'total'                 => $total,
        ];
    }

    public function updateActiveStatus($id, $status)
    {
        // Update the active column for the specified ID
        $this->db->where('id', $id);

        return $this->db->update('clients', array('active' => $status)); // Changed table to 'clients'
    }

    // Get total number of reminders
    public function get_total_reminders()
    {
        return $this->db->count_all('rappels'); // Assuming you have a 'reminders' table
    }

    // Get number of active clients
    public function get_active_clients_count()
    {
        $this->db->where('active', 1);

        return $this->db->count_all_results('clients'); // Changed table to 'clients'
    }

    // Get number of new clients
    public function get_new_clients()
    {
        $this->db->where('status', 'nouveau');

        return $this->db->count_all_results('clients'); // Changed table to 'clients'
    }

    public function getClientStatus($id)
    {
        $this->db->select('active');
        $this->db->from('clients'); // Changed table to 'clients'
        $this->db->where('id', $id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row()->active;
        } else {
            return null; // or handle it as needed
        }
    }

    public function delete_notes_by_client_id($id)
    {
        return $this->db->delete('notes', array('client_id' => $id)); // Changed to 'client_id'
    }

    public function has_related_notes($id)
    {
        $this->db->where('client_id', $id); // Changed to 'client_id'
        $query = $this->db->get('notes');

        return $query->num_rows() > 0;
    }

    // interests
    public function get_interests_list($id)
    {
        // Fetch the client by ID
        $this->db->select('interets');
        $this->db->from('clients'); // Changed table to 'clients'
        $this->db->where('id', $id);
        $query = $this->db->get();

        $result = $query->row_array();

        // Decode the JSON interests column
        if (!empty($result['interets'])) {
            $interests = json_decode($result['interets'], true);
        } else {
            $interests = [];
        }

        return $interests;
    }

    // rendez vous
    public function get_client_name($client_id)
    {
        $this->db->select('first_name, last_name');
        $this->db->from('clients'); // Changed table to 'clients'
        $this->db->where('id', $client_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $client = $query->row();

            return $client->first_name . ' ' . $client->last_name;
        } else {
            return null;
        }
    }

    
    public function getTotalCustomers() {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM clients");
        return $query->row()->total;
    }
}

?>
