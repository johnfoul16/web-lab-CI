<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 * @property CI_Encryption $encryption // Though not directly used for hashing/verification here
 */
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        // The encryption library is loaded, but password_hash() and password_verify() are PHP native functions.
        // If you were encrypting other data, this would be relevant.
        // $this->load->library('encryption'); 
    }

    /**
     * Creates a new user in the database.
     * Assigns a default 'user' role.
     *
     * @param string $username
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function create_user($username, $email, $password) {
        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT), // Secure password hashing
            'role' => 'user', // Assign a default 'user' role
            'created_at' => date('Y-m-d H:i:s') // Set current timestamp
        );
        return $this->db->insert('users', $data);
    }

    /**
     * Retrieves all products from the 'products' table.
     * @return array
     */
     public function get_products($search_query = null) {
        if ($search_query) {
            $this->db->like('name', $search_query);
            $this->db->or_like('description', $search_query);
        }
        return $this->db->get('products')->result_array();
    } 


    /**
     * Inserts a new product into the 'products' table.
     * @param array $data Product data (name, description, price, stock)
     * @return bool
     */
    public function insert_products($data) {
        return $this->db->insert('products', $data);
    }

    /**
     * Retrieves a single product by its ID from the 'products' table.
     * This method is the canonical one, replacing the duplicate.
     * @param int $id Product ID
     * @return array|null
     */
    public function get_product_by_id($id) {
        $query = $this->db->get_where('products', ['id' => $id]);
        return $query->row_array();
    }

    /**
     * Updates an existing product in the 'products' table.
     * @param int $id Product ID
     * @param array $data Updated product data
     * @return bool
     */
    public function update_products($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    /**
     * Deletes a product from the 'products' table by ID.
     * Renamed from delete_user to reflect its actual function.
     * @param int $id Product ID
     * @return bool
     */
    public function delete_product($id) {
        $this->db->where('id', $id);
        return $this->db->delete('products');
    }

    /**
     * Verifies user credentials (email and password).
     * Retrieves user data including their role.
     *
     * @param string $email
     * @param string $password
     * @return array|false User data array on success, false on failure
     */
    public function verify_user($email, $password) {
        // Fetch user by email, ensure 'role' column is selected
        $user = $this->db->get_where('users', array('email' => $email))->row_array();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Returns all columns, including 'role' if present in DB
        }
        return false;
    }

    /**
     * Counts the total number of users in the database.
     * @return int The total number of users.
     */
    public function count_users() {
        return $this->db->count_all_results('users');
    }

     public function get_user_by_id($id) {
        $query = $this->db->get_where('users', ['id' => $id]);
        return $query->row_array();
    }

    public function update_user_profile($user_id, $data) {
        $this->db->where('id', $user_id);
        return $this->db->update('users', $data);
    }

    /**
     * Retrieves all users from the 'users' table.
     * @return array An array of all user data.
     */
    public function get_all_users() {
        return $this->db->get('users')->result_array();
    }

    /**
     * Optional: Deletes a user from the 'users' table by their ID.
     * Implement only if you have a specific administration feature for user deletion.
     * @param int $id The ID of the user to delete
     * @return bool TRUE on successful deletion, FALSE on failure
     */
    public function delete_user_by_id($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
}
