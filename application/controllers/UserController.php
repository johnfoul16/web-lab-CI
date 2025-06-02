<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model
 * @property CI_Input $input
 */
class UserController extends CI_Controller {

    public function register() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('users/register');
        } else {
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            if ($this->User_model->create_user($username, $email, $password)) {
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                redirect('register');
            }
        }
    }

    public function login() {
        $this->load->library('form_validation');
        
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
         log_message('debug', 'User logged in: ' . print_r($this->session->userdata(), true));

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('users/login');
        } else {
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->User_model->verify_user($email, $password);
            
            if ($user) {
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('username', $user['username']);
                $this->session->set_userdata('logged_in', TRUE); // Add this line
                $this->session->set_userdata('name', $user['username']); // Add this or use appropriate field
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Invalid email or password');
                redirect('login');
            }
        }
    }

    public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('name');
        redirect('login');
    }
    
    public function dashboard() {
        if (!$this->session->userdata('username')) {
            redirect('login');
            return;
        }

        $data['username'] = $this->session->userdata('username');
        $data['products'] = $this->User_model->get_products();
        $this->load->view('users/dashboard', $data);    
    }


    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->helper('url');
    }

    public function index() {
        $data['products'] = $this->User_model->get_products();
        $this->load->view('products/index', $data);
    }

    public function create() {
        $this->load->view('products/add');
    }

    public function store() {
        $data = array(
            'name'        => $this->input->post('name', true),
            'description' => $this->input->post('description', true),
            'price'       => $this->input->post('price', true),
            'stock'       => $this->input->post('stock', true)
        );

        $this->User_model->insert_products($data);
        redirect(site_url('UserController')); 
    }

    public function edit($id) {
        $data['products'] = $this->User_model->get_products_by_id($id);
        if (!$data['products']) {
            show_404();
        }
        $this->load->view('products/edit', $data);
    }

    public function update($id) {
        $data = array(
            'name'        => $this->input->post('name', true),
            'description' => $this->input->post('description', true),
            'price'       => $this->input->post('price', true),
            'stock'       => $this->input->post('stock', true)
        );

        $this->User_model->update_products($id, $data);
        redirect(site_url('UserController'));
    }

    public function delete($id) {
        if ($this->User_model->delete_user($id)) {
            redirect(site_url('UserController'));
        } else {
            show_error('Failed to delete product.', 500);
        }
    }
}
?>
