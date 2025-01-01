<?php
class User_model extends CI_Model{
    
    public function __construct() { 
        $this->load->database();
    }

    public function register($enc_password){
        $data = array(
            'name' => $this->input->post('name'),
            'zipcode' => $this->input->post('zipcode'),
            'email' => $this->input->post('email'),
            'username' => $this->input->post('username'),
            'password' =>$enc_password,
        
        );
        return $this->db->insert('users',$data);
    }
 
    // Log user in
		public function login($username, $password){
			// Validate
			$this->db->where('username', $username);
			$this->db->where('password', $password);

			$result = $this->db->get('users');

			if($result->num_rows() == 1){
				return $result->row(0)->id;
			} else {
				return false;
			}
		}

        public function get_user_by_username($username)
    {
        $query = $this->db->get_where('users', ['username' => $username]);

        return $query->row_array();
    }

		// Check username exists
		public function check_username_exists($username){
			$query = $this->db->get_where('users', array('username' => $username));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

		// Check email exists
		public function check_email_exists($email){
			$query = $this->db->get_where('users', array('email' => $email));
			if(empty($query->row_array())){
				return true;
			} else {
				return false;
			}
		}

		public function get_user_name($user_id)
		{
			// Query the users table to get the name by user_id
			$this->db->select('name'); // or 'first_name', 'last_name' depending on your database structure
			$this->db->from('users');
			$this->db->where('id', $user_id);
			$query = $this->db->get();
	
			if ($query->num_rows() > 0) {
				return $query->row()->name; // Assuming you have a 'name' column
			} else {
				return 'Unknown User'; // Default if user not found
			}
		}

		public function get_user_by_id($id)
    {
        $query = $this->db->get_where('users', ['id' => $id]);

        return $query->row_array();
    }

	public function count_admins()
    {
        $this->db->where('role', 'admin');
        $this->db->from('users');

        return $this->db->count_all_results();
    }



	public function update_password($user_id, $new_password) {
        $data = array(
            'password' => $new_password
        );

        $this->db->where('id', $user_id);
        return $this->db->update('users', $data); // Assuming 'users' is your table
    }

    // Example method to get user data
    public function get_user($user_id) {
        $query = $this->db->get_where('users', array('id' => $user_id));
        return $query->row_array();
    }

	public function get_all_users()
    {
        $query = $this->db->get('users');

        return $query->result_array();
    }



	public function delete($id){
        $this->db->where('id', $id);
        $this->db->delete('users');
        return true;
    }
}