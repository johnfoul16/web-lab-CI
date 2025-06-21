<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model
 * @property Order_model $Order_model // Added for reports
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Security $security // Still reference for clarity, but not explicitly loaded here
 * @property CI_Loader $load
 */
class UserController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Order_model'); // Load Order_model for reports
        $this->load->helper('url');
        $this->load->helper('app_helpers_helper');
        $this->load->library('session');
        $this->load->library('form_validation'); // Load form validation here for all methods
         $this->load->library('upload');// Removed: $this->load->library('security'); // CodeIgniter often auto-loads this when CSRF is enabled in config.php
    }

    /**
     * Private helper method to check if the logged-in user is an admin.
     * Redirects to dashboard with an error message if not an admin or not logged in.
     */
    private function _check_admin() {
        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') !== 'admin') {
            $this->session->set_flashdata('error', 'Access Denied: You do not have permission to perform this action.');
            redirect('dashboard'); // Redirect to a suitable page
            exit(); // Stop further execution
        }
    }

    /**
     * Handles user registration.
     */
    public function register() {
        // Set validation rules for registration
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[20]|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'required|matches[password]');

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, reload the registration view to display errors
            $this->load->view('users/register');
        } else {
            // Sanitize input data (TRUE for XSS filtering)
            $username = $this->input->post('username', TRUE);
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            // User_model::create_user should now assign a default 'user' role
            if ($this->User_model->create_user($username, $email, $password)) {
                $this->session->set_flashdata('success', 'Registration successful! Please login.');
                redirect('login');
            } else {
                $this->session->set_flashdata('error', 'Registration failed. Please try again.');
                redirect('register');
            }
        }
    }

    /**
     * Handles user login.
     */
    public function login() {
        // Set validation rules for login
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, reload the login view to display errors
            $this->load->view('users/login');
        } else {
            // Sanitize input data
            $email = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            // Verify user credentials through User_model
            $user = $this->User_model->verify_user($email, $password);
            
            if ($user) {
                // Store essential user data including role in session
                $this->session->set_userdata('user_id', $user['id']);
                $this->session->set_userdata('username', $user['username']);
                $this->session->set_userdata('logged_in', TRUE);
                $this->session->set_userdata('name', $user['username']); // Assuming 'username' is used for display name
                $this->session->set_userdata('role', $user['role']); // Store user's role from the database
                
                log_message('debug', 'User logged in: ' . $user['username'] . ' with role: ' . $user['role']);
                
                redirect('dashboard'); // Redirect to dashboard on successful login
            } else {
                $this->session->set_flashdata('error', 'Invalid email or password');
                redirect('login'); // Redirect back to login on failure
            }
        }
    }

    /**
     * Handles user logout.
     */
    public function logout() {
        // Unset all relevant session data for a clean logout
        $this->session->unset_userdata(['user_id', 'username', 'logged_in', 'name', 'role']);
        $this->session->sess_destroy(); // Destroy entire session
        redirect('login'); // Redirect to login page after logout
    }
    
    /**
     * Displays the user dashboard.
     * Accessible by any logged-in user.
     */
   public function dashboard() {
        // Ensure user is logged in to view dashboard
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $data['username'] = $this->session->userdata('username');
        
        // Fetch data for widgets only if admin
        if ($this->session->userdata('role') === 'admin') {
            $data['total_orders'] = $this->Order_model->count_all_orders();
            $data['total_revenue'] = $this->Order_model->get_total_revenue();
            $data['total_users'] = $this->User_model->count_users();
        }

        $this->load->view('users/dashboard', $data);    
    }

    /**
     * Displays the product listing (admin view).
     * Accessible only by users with 'admin' role.
     */
    public function index() {
        $this->_check_admin(); // Enforce admin access
        $data['products'] = $this->User_model->get_products(); // Assumes User_model handles products
        $this->load->view('products/index', $data);
    }

    /**
     * Displays the form to create a new product (admin view).
     * Accessible only by users with 'admin' role.
     */
    public function create() {
        $this->_check_admin(); // Enforce admin access
        $this->load->view('products/add');
    }

    /**
     * Stores a new product (admin view).
     */
    public function store() {
        $this->_check_admin(); // Admin-only access

        $this->form_validation->set_rules('name', 'Product Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'trim|max_length[1000]');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('stock', 'Stock', 'required|integer|greater_than_equal_to[0]');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('products/add');
        } else {
            $data = array(
                'name'        => $this->input->post('name', TRUE),
                'description' => $this->input->post('description', TRUE),
                'price'       => $this->input->post('price', TRUE),
                'stock'       => $this->input->post('stock', TRUE),
                'image_path'  => NULL // Default to NULL, will be updated if image uploaded
            );

            // Configure upload
            $config['upload_path']   = './assets/uploads/'; // Directory for uploaded images
            $config['allowed_types'] = 'gif|jpg|png|jpeg'; // Allowed image types
            $config['max_size']      = 2048; // 2MB max size
            $config['encrypt_name']  = TRUE; // Encrypt file name to prevent conflicts

            // Ensure the upload directory exists
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE); // Create the directory if it doesn't exist
            }

            $this->upload->initialize($config); // Initialize upload library with config

            // Attempt to upload the image
            if (!empty($_FILES['product_image']['name'])) { // Check if an image was selected
                if ($this->upload->do_upload('product_image')) {
                    $upload_data = $this->upload->data();
                    $data['image_path'] = 'assets/uploads/' . $upload_data['file_name']; // Save relative path
                } else {
                    // Image upload failed, set flashdata error and reload form
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $this->load->view('products/add');
                    return; // Stop execution
                }
            }

            // Insert product data (with or without image path)
            if ($this->User_model->insert_products($data)) {
                $this->session->set_flashdata('success', 'Product added successfully.');
                redirect(site_url('products'));
                exit();
            } else {
                $this->session->set_flashdata('error', 'Failed to add product. Please try again.');
                redirect(site_url('products/create'));
                exit();
            }
        }
    }

    /**
     * Displays the form to edit an existing product (admin view).
     * Accessible only by users with 'admin' role.
     * @param int $id Product ID
     */
   public function edit($id) {
        $this->_check_admin(); // Admin-only access
        $data['product'] = $this->User_model->get_product_by_id($id); // Renamed from 'products' to 'product' for single item
        if (empty($data['product'])) {
            show_404();
        }
        $this->load->view('products/edit', $data);
    }

    

    /**
     * Updates an existing product (admin view).
     * Accessible only by users with 'admin' role.
     * @param int $id Product ID
     */
     public function update($id) {
        $this->_check_admin(); // Admin-only access

        $this->form_validation->set_rules('name', 'Product Name', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('description', 'Description', 'trim|max_length[1000]');
        $this->form_validation->set_rules('price', 'Price', 'required|numeric|greater_than[0]');
        $this->form_validation->set_rules('stock', 'Stock', 'required|integer|greater_than_equal_to[0]');

        if ($this->form_validation->run() === FALSE) {
            $data['product'] = $this->User_model->get_product_by_id($id); // Re-fetch product data for the form
            if (empty($data['product'])) {
                show_404();
            }
            $this->load->view('products/edit', $data);
        } else {
            $data = array(
                'name'        => $this->input->post('name', TRUE),
                'description' => $this->input->post('description', TRUE),
                'price'       => $this->input->post('price', TRUE),
                'stock'       => $this->input->post('stock', TRUE)
            );

            // Configure upload for update
            $config['upload_path']   = './assets/uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']      = 2048;
            $config['encrypt_name']  = TRUE;

            // Ensure the upload directory exists
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'], 0777, TRUE); // Create the directory if it doesn't exist
            }

            $this->upload->initialize($config);

            // Attempt to upload new image if selected
            if (!empty($_FILES['product_image']['name'])) {
                // Get existing product to check for old image to delete
                $existing_product = $this->User_model->get_product_by_id($id);

                if ($this->upload->do_upload('product_image')) {
                    $upload_data = $this->upload->data();
                    $data['image_path'] = 'assets/uploads/' . $upload_data['file_name']; // New image path

                    // Delete old image file if it exists and a new one was uploaded successfully
                    if (!empty($existing_product['image_path']) && file_exists($existing_product['image_path'])) {
                        unlink($existing_product['image_path']); // Delete the actual file
                    }
                } else {
                    // Image upload failed during update
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    $data['product'] = $this->User_model->get_product_by_id($id); // Re-fetch data
                    $this->load->view('products/edit', $data);
                    return;
                }
            }
            // If no new image selected, the 'image_path' field is not included in $data,
            // which means its value in the database will remain unchanged.

            // Update product data
            if ($this->User_model->update_products($id, $data)) {
                $this->session->set_flashdata('success', 'Product updated successfully.');
                redirect(site_url('products'));
                exit();
            } else {
                $this->session->set_flashdata('error', 'Failed to update product. Please try again.');
                redirect(site_url('products/edit/' . $id));
                exit();
            }
        }
    }

    /**
     * Deletes a product (admin view).
     * Accessible only by users with 'admin' role.
     * Method name changed from `delete_user` to `delete` and acts on products.
     * @param int $id Product ID
     */
    public function delete($id) {
        $this->_check_admin(); // Enforce admin access
        
        // Call User_model (or Product_model if separated) to delete product
        if ($this->User_model->delete_product($id)) {
            $this->session->set_flashdata('success', 'Product deleted successfully.');
            redirect(site_url('products'));
        } else {
            $this->session->set_flashdata('error', 'Failed to delete product. It might not exist.');
            log_message('error', 'Failed to delete product with ID: ' . $id);
            redirect(site_url('products')); // Redirect back to product list on failure
        }
    }

    public function manage_user(){
        $this->_check_admin();
        $data['users'] = $this->User_model->get_all_users();
         $this->load->view('users/manage_user', $data);
    }

    /**
     * Displays Admin Reports.
     * Accessible only by users with 'admin' role.
     */
    public function reports() {
        $this->_check_admin(); // Enforce admin access for reports
        
        // Fetch data for reports
        $data['total_orders'] = $this->Order_model->count_all_orders();
        $data['total_sales'] = $this->Order_model->get_total_revenue();
        $data['total_users'] = $this->User_model->count_users(); // Fetch total users
        $data['recent_orders'] = $this->Order_model->get_recent_orders(5); // Get 5 recent orders
        $data['top_selling_products'] = $this->Order_model->get_top_selling_products(5); // Get 5 top selling products

        $this->load->view('products/reports', $data);
    }

    /**
     * Displays and handles updates for the user's profile.
     * Accessible only by logged-in users.
     */
    public function profile() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_user_by_id($user_id);

        if (empty($user)) {
            $this->session->set_flashdata('error', 'User profile not found.');
            redirect('dashboard');
            return;
        }

        // Set validation rules for profile update
        // Note: Password change should be a separate form/method for security
        $this->form_validation->set_rules('username', 'Username', 'required|min_length[3]|max_length[20]|callback_username_check[' . $user_id . ']');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check[' . $user_id . ']');
        
        // Custom callback to check uniqueness while allowing current user's own data
        // Callback function needs to be defined in this controller
        // public function username_check($username, $user_id) { ... }
        // public function email_check($email, $user_id) { ... }


        if ($this->form_validation->run() === FALSE) {
            $data['user'] = $user;
            $this->load->view('users/profile', $data);
        } else {
            $update_data = array(
                'username' => $this->input->post('username', TRUE),
                'email'    => $this->input->post('email', TRUE)
                // Add other fields you want to allow updating here (e.g., 'name', 'address')
            );

            if ($this->User_model->update_user_profile($user_id, $update_data)) {
                // Update session data if username/email changes
                $this->session->set_userdata('username', $update_data['username']);
                $this->session->set_flashdata('success', 'Profile updated successfully.');
                redirect('profile');
            } else {
                $this->session->set_flashdata('error', 'Failed to update profile. No changes or an error occurred.');
                redirect('profile');
            }
        }
    }

    /**
     * Callback for username uniqueness check during profile update.
     * Allows current user to keep their username.
     * @param string $username The username to check.
     * @param int $user_id The ID of the current user.
     * @return bool
     */
    public function username_check($username, $user_id) {
        $this->db->where('username', $username);
        $this->db->where('id !=', $user_id); // Exclude current user's ID
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('username_check', 'The {field} is already taken.');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Callback for email uniqueness check during profile update.
     * Allows current user to keep their email.
     * @param string $email The email to check.
     * @param int $user_id The ID of the current user.
     * @return bool
     */
    public function email_check($email, $user_id) {
        $this->db->where('email', $email);
        $this->db->where('id !=', $user_id); // Exclude current user's ID
        $query = $this->db->get('users');

        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('email_check', 'The {field} is already registered.');
            return FALSE;
        }
        return TRUE;
    }

    /**
     * Optional: Handles changing user password.
     * Should be a separate method for security.
     */
    public function change_password() {
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }

        $this->form_validation->set_rules('current_password', 'Current Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|min_length[6]');
        $this->form_validation->set_rules('new_password_confirm', 'Confirm New Password', 'required|matches[new_password]');

        if ($this->form_validation->run() === FALSE) {
            // Load view for password change (e.g., users/change_password)
            $this->load->view('users/change_password');
        } else {
            $user_id = $this->session->userdata('user_id');
            $current_password = $this->input->post('current_password', TRUE);
            $new_password = $this->input->post('new_password', TRUE);

            // Verify current password first
            $user = $this->User_model->get_user_by_id($user_id);
            if ($user && password_verify($current_password, $user['password'])) {
                // Update password in DB
                $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
                if ($this->User_model->update_user_profile($user_id, ['password' => $hashed_new_password])) {
                    $this->session->set_flashdata('success', 'Password updated successfully.');
                    redirect('profile'); // Redirect to profile or dashboard
                } else {
                    $this->session->set_flashdata('error', 'Failed to update password.');
                    redirect('change_password');
                }
            } else {
                $this->session->set_flashdata('error', 'Incorrect current password.');
                redirect('change_password');
            }
        }
    }
  
   public function update_user($id) {
        $this->_check_admin();

        $current_user_data = $this->User_model->get_user_by_id($id);
        if (empty($current_user_data)) {
            show_404(); // User not found
            return; // Stop execution
        }

        // Set validation rules for user update
        // Use a callback for unique email that excludes the current user
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[3]|max_length[20]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_unique_email_on_update[' . $id . ']');
        $this->form_validation->set_rules('role', 'Role', 'required|in_list[user,admin]');
        
        // Password field is optional; only validate if provided
        if (!empty($this->input->post('password'))) {
            $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
            $this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'matches[password]');
        }

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, redirect back to manage_users with validation errors
            // We need to set flashdata for errors and then redirect.
            $this->session->set_flashdata('error', validation_errors());
            redirect('admin/users'); // Redirect back to the manage users list
        } else {
            $update_data = array(
                'username' => $this->input->post('username', TRUE),
                'email'    => $this->input->post('email', TRUE),
                'role'     => $this->input->post('role', TRUE)
            );

            // Update password only if provided
            if (!empty($this->input->post('password'))) {
                $update_data['password'] = password_hash($this->input->post('password', TRUE), PASSWORD_BCRYPT);
            }

            if ($this->User_model->update_user_profile($id, $update_data)) {
                // If the updated user is the currently logged-in user and their role changed, update session
                if ($this->session->userdata('user_id') == $id && $this->session->userdata('role') !== $update_data['role']) {
                    $this->session->set_userdata('role', $update_data['role']);
                    $this->session->set_flashdata('success', 'Your own role has been updated. User updated successfully.');
                } else {
                    $this->session->set_flashdata('success', 'User updated successfully.');
                }
                redirect('admin/users');
            } else {
                $this->session->set_flashdata('error', 'Failed to update user. Please try again.');
                redirect('admin/users'); // Redirect back on failure
            }
        }
    }

    /**
     * Callback function for form validation to check email uniqueness on update.
     * @param string $email The email address being checked.
     * @param int $id The ID of the user being updated.
     * @return bool TRUE if email is unique or belongs to the current user, FALSE otherwise.
     */
    public function unique_email_on_update($email, $id) {
        $this->db->where('email', $email);
        $this->db->where('id !=', $id); // Exclude the current user's ID
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('unique_email_on_update', 'This email is already taken by another user.');
            return FALSE;
        }
        return TRUE;
    }


    /**
     * Deletes a user (admin view).
     * Accessible only by users with 'admin' role.
     * Requires a POST request with CSRF token for security.
     * @param int $id The ID of the user to delete.
     */
    public function delete_user($id) {
        $this->_check_admin();

        // Ensure it's a POST request and CSRF token is valid
        if ($this->input->method() === 'post' && $this->security->get_csrf_hash() === $this->input->post($this->security->get_csrf_token_name())) {
            
            // Prevent deleting self (the logged-in admin)
            if ($this->session->userdata('user_id') == $id) {
                $this->session->set_flashdata('error', 'You cannot delete your own account from here.');
                redirect('admin/users');
                return;
            }

            if ($this->User_model->delete_user_by_id($id)) {
                $this->session->set_flashdata('success', 'User deleted successfully.');
            } else {
                $this->session->set_flashdata('error', 'Failed to delete user. User might not exist.');
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid request or CSRF token missing.');
        }
        redirect('admin/users'); // Redirect back to the user list
    }
}
