<?php

class Event_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_events()
    {
        $query = $this->db->get('events');

        return $query->result_array();
    }

    public function save_event($event)
    {
        return $this->db->insert('events', $event);
    }

    public function update_event($event_id, $event)
    {
        $this->db->where('event_id', $event_id);

        return $this->db->update('events', $event);
    }

    public function delete_event($event_id)
    {
        $this->db->where('event_id', $event_id);

        return $this->db->delete('events');
    }

    // chart
    public function get_events_over_time()
    {
        $this->db->select("MONTH(event_start_datetime) as month, COUNT(*) as event_count");
        $this->db->group_by("MONTH(event_start_datetime)");
        $query = $this->db->get("events");

        return $query->result_array();
    }

    // dashboard cards
    // Get total number of events
    public function get_total_events()
    {
        return $this->db->count_all('events'); // Assuming you have an 'events' table
    }


    // show the rendez-vous for the day
    public function get_rendezvous_by_user_and_date($user_id, $date)
    {
        // Ensure the date is in the format 'Y-m-d'
        $start_of_day = $date.' 00:00:00';
        $end_of_day   = $date.' 23:59:59';

        $this->db->select('event_name, event_start_datetime, event_end_datetime');
        $this->db->from('events'); // Change 'events' to your actual table name if different
        $this->db->where('added_by', $user_id);
        $this->db->where('event_start_datetime >=', $start_of_day);
        $this->db->where('event_end_datetime <=', $end_of_day);

        $query = $this->db->get();

        return $query->result_array();
    }

    public function get_upcoming_events()
{
    $current_date = date('Y-m-d H:i:s'); // Get the current date and time

    // Fetch events that are starting in the future
    $this->db->select('event_name, event_start_datetime');
    $this->db->from('events');
    $this->db->where('event_start_datetime >=', $current_date); // Only upcoming events
    $this->db->order_by('event_start_datetime', 'ASC'); // Sort by start time

    $query = $this->db->get();
    return $query->result_array();
}


}
