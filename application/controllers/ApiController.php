<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model
 * @property Order_model $Order_model
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Form_validation $form_validation
 * @property CI_Session $session // Needed if API uses session-based auth (less common for pure APIs)
 * @property CI_DB_forge $dbforge // Not needed for basic API but useful for DB ops
 */
class ApiController extends CI_Controller {

    // A simple, placeholder API key for demonstration.
    // In a real application, this would be retrieved from a database
    // and would be much more complex (e.g., OAuth tokens, JWT).
    private $api_key = 'your_super_secret_api_key_123'; // CHANGE THIS TO A REAL KEY

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Order_model');
        $this->load->library('form_validation');
        // No session library load by default for pure REST APIs unless you need it for authentication.
        // If you're doing token-based auth (JWT, API Keys), you might not need session.
    }

    /**
     * Private helper to authenticate API requests.
     * In a real app, this would involve more robust token/JWT validation.
     * @return bool True if authenticated, false otherwise.
     */
    private function _authenticate_api_key() {
        $received_api_key = $this->input->get_request_header('X-Api-Key', TRUE); // Get API key from header
        
        if ($received_api_key === $this->api_key) {
            return TRUE;
        } else {
            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(401) // Unauthorized
                 ->set_output(json_encode(['status' => 'error', 'message' => 'Unauthorized: Invalid API Key']));
            return FALSE;
        }
    }

    /**
     * Get all products or a specific product by ID.
     * Example: GET /api/products
     * Example: GET /api/products/123
     * @param int|null $id Product ID
     */
    public function products_get($id = NULL) {
        if (!$this->_authenticate_api_key()) {
            return; // Authentication failed, response already sent
        }

        if ($id === NULL) {
            $products = $this->User_model->get_products();
            $response = ['status' => 'success', 'data' => $products];
        } else {
            $product = $this->User_model->get_product_by_id($id);
            if ($product) {
                $response = ['status' => 'success', 'data' => $product];
            } else {
                $response = ['status' => 'error', 'message' => 'Product not found'];
                $this->output->set_status_header(404); // Not Found
            }
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($response));
    }

    /**
     * Delete a specific product by ID.
     * Example: DELETE /api/products/123
     * @param int $id Product ID
     */
    public function products_delete($id = NULL) {
        if (!$this->_authenticate_api_key()) {
            return; // Authentication failed, response already sent
        }

        // Check if ID is provided
        if ($id === NULL) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(400) // Bad Request
                ->set_output(json_encode(['status' => 'error', 'message' => 'Product ID is required']));
            return;
        }

        // Check if product exists
        $product = $this->User_model->get_product_by_id($id);
        if (!$product) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(404) // Not Found
                ->set_output(json_encode(['status' => 'error', 'message' => 'Product not found']));
            return;
        }

        // Attempt to delete the product
        $deleted = $this->User_model->delete_product($id); // Assuming this method exists in User_model
        
        if ($deleted) {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(200) // OK
                ->set_output(json_encode(['status' => 'success', 'message' => 'Product deleted successfully', 'deleted_product' => $product]));
        } else {
            $this->output
                ->set_content_type('application/json')
                ->set_status_header(500) // Internal Server Error
                ->set_output(json_encode(['status' => 'error', 'message' => 'Failed to delete product']));
        }
    }

    /**
     * Place a new order via API.
     * Expects POST request with JSON body for order details.
     * Example: POST /api/order
     * JSON Body:
     * {
     * "customer_name": "API User",
     * "address": "123 API Street",
     * "payment_method": "paypal",
     * "items": [
     * {"id": 1, "qty": 2, "price": 10.50, "name": "Product A"},
     * {"id": 3, "qty": 1, "price": 25.00, "name": "Product C"}
     * ]
     * }
     */
    public function order_post() {
        if (!$this->_authenticate_api_key()) {
            return;
        }

        // Get raw JSON input
        $input_json = $this->input->raw_input_stream;
        $order_data_raw = json_decode($input_json, TRUE);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(400) // Bad Request
                 ->set_output(json_encode(['status' => 'error', 'message' => 'Invalid JSON payload']));
            return;
        }

        // Set validation rules for the incoming JSON data
        $this->form_validation->set_data($order_data_raw);
        $this->form_validation->set_rules('customer_name', 'Customer Name', 'required|trim|max_length[100]');
        $this->form_validation->set_rules('address', 'Delivery Address', 'required|trim|max_length[255]');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required|in_list[cod,gcash,paypal]');
        $this->form_validation->set_rules('items', 'Order Items', 'required|array');
        
        // Basic validation for items array structure (could be more detailed)
        if (isset($order_data_raw['items']) && is_array($order_data_raw['items'])) {
            foreach ($order_data_raw['items'] as $index => $item) {
                if (!isset($item['id']) || !isset($item['qty']) || !isset($item['price']) || !isset($item['name'])) {
                    $this->output
                         ->set_content_type('application/json')
                         ->set_status_header(400)
                         ->set_output(json_encode(['status' => 'error', 'message' => "Invalid item structure at index {$index}"]));
                    return;
                }
                if (!is_numeric($item['id']) || !is_numeric($item['qty']) || !is_numeric($item['price']) || $item['qty'] <= 0 || $item['price'] <= 0) {
                     $this->output
                         ->set_content_type('application/json')
                         ->set_status_header(400)
                         ->set_output(json_encode(['status' => 'error', 'message' => "Invalid numeric value for item at index {$index}"]));
                    return;
                }
            }
        }


        if ($this->form_validation->run() === FALSE) {
            $errors = validation_errors(); // Get validation errors
            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(400) // Bad Request
                 ->set_output(json_encode(['status' => 'error', 'message' => 'Validation Failed', 'errors' => $errors]));
            return;
        }

        $items_in_order = $order_data_raw['items'];
        $total_amount = 0;
        $processed_items = []; // To store actual items after stock check

        // Check stock availability and calculate total
        foreach ($items_in_order as $item) {
            $product_id = $item['id'];
            $requested_qty = $item['qty'];
            $product_details = $this->User_model->get_product_by_id($product_id);

            if (empty($product_details) || ($product_details['stock'] ?? 0) < $requested_qty) {
                $this->output
                     ->set_content_type('application/json')
                     ->set_status_header(409) // Conflict
                     ->set_output(json_encode(['status' => 'error', 'message' => "Product '{$item['name']}' (ID: {$product_id}) is out of stock or insufficient quantity."]));
                return;
            }
            $total_amount += ($product_details['price'] ?? 0) * $requested_qty;
            // Store actual product details from DB to prevent price tampering
            $processed_items[$product_id] = [
                'id' => $product_id,
                'name' => $product_details['name'],
                'price' => $product_details['price'],
                'qty' => $requested_qty
            ];
        }

        // Prepare order data for the database
        $order_insert_data = [
            'customer_name'  => $order_data_raw['customer_name'],
            'address'        => $order_data_raw['address'],
            'payment_method' => $order_data_raw['payment_method'],
            'order_data'     => json_encode($processed_items), // Store actual processed cart items as JSON
            'shipping_status' => 'Pending', // Initial status for API orders
            'total_amount'   => $total_amount, // Store calculated total
            'created_at'     => date('Y-m-d H:i:s')
        ];

        // Save order via Order_model
        $order_id = $this->Order_model->save_order($order_insert_data);

        if ($order_id) {
            // Reduce stock for each product in the order
            foreach ($processed_items as $item_id => $item) {
                $current_product = $this->User_model->get_product_by_id($item_id);
                if ($current_product) { // Should always be true due to prior stock check
                    $new_stock = ($current_product['stock'] ?? 0) - $item['qty'];
                    $this->User_model->update_products($item_id, ['stock' => $new_stock]);
                }
            }

            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(201) // Created
                 ->set_output(json_encode(['status' => 'success', 'message' => 'Order placed successfully!', 'order_id' => $order_id, 'total_amount' => $total_amount]));
        } else {
            $this->output
                 ->set_content_type('application/json')
                 ->set_status_header(500) // Internal Server Error
                 ->set_output(json_encode(['status' => 'error', 'message' => 'Failed to place order.']));
        }
    }

    /**
     * Get user details by ID (example of authenticated user API).
     * This endpoint assumes a user ID is passed. In a real-world scenario,
     * the API key would be tied to a specific user or role, and details
     * would be fetched based on that authenticated context.
     * Example: GET /api/user/1
     * @param int $user_id User ID
     */
    public function user_get($user_id) {
        if (!$this->_authenticate_api_key()) {
            return;
        }

        $user = $this->User_model->get_user_by_id($user_id); // Assuming this method exists in User_model

        if ($user) {
            // Remove sensitive information like password hash before sending
            unset($user['password']);
            $response = ['status' => 'success', 'data' => $user];
        } else {
            $response = ['status' => 'error', 'message' => 'User not found'];
            $this->output->set_status_header(404);
        }

        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode($response));
    }
}
