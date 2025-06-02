<?php 
class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('encryption');
    }

    public function create_user($username, $email, $password) {
        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'created_at' => date('Y-m-d H:i:s')
        );
        return $this->db->insert('users', $data);
    }

    public function get_products() {
        return $this->db->get('products')->result_array();
    } 
    public function insert_products($data) {
        return $this->db->insert('products', $data);
    }

    public function get_products_by_id($id) {
        return $this->db->get_where('products', array('id' => $id))->row_array();
    }

    public function update_products($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('products', $data);
    }

    public function delete_user($id) {
        $this->db->where('id', $id);
        return $this->db->delete('products');
    }

    public function verify_user($email, $password) {
        $user = $this->db->get_where('users', array('email' => $email))->row_array();
        
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
    public function get_product_by_id($id) {
        $query = $this->db->get_where('products', ['id' => $id]);
        return $query->row_array();
    }
}
?>