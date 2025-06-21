<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property User_model $User_model
 * @property Order_model $Order_model
 * @property CI_Input $input
 * @property CI_Session $session
 * @property CI_Form_validation $form_validation
 * @property CI_Security $security // Still reference for clarity, but not explicitly loaded here
 * @property CI_Loader $load
 */
class ShopController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Order_model');
        $this->load->helper('url');
         $this->load->helper('app_helpers_helper');
        $this->load->library('session'); // Load session library
        $this->load->library('form_validation'); // Load form validation here
        // Removed: $this->load->library('security'); // CodeIgniter often auto-loads this when CSRF is enabled in config.php
    }

    /**
     * Displays the main shop page with available products.
     */
    public function shop() {
         $search_query = $this->input->get('search', TRUE); // Get search query, TRUE for XSS filtering
        $data['search_query'] = $search_query; // Pass search query back to view to keep it in the search bar

        // Fetch products, applying the search filter if one exists
        $data['products'] = $this->User_model->get_products($search_query); 
        
        $this->load->view('userProducts/shop', $data);
    }

    /**
     * Adds a product to the user's shopping cart (stored in session).
     * @param int $id Product ID to add
     */
    public function addToCart($id) {
        $product = $this->User_model->get_product_by_id($id); // Get product details

        if (empty($product)) {
            show_error('Product not found', 404); // Display error if product does not exist
            return; // Stop execution
        }
        
        // Basic check for stock availability before adding to cart
        if (($product['stock'] ?? 0) <= 0) {
            $this->session->set_flashdata('error', 'This product is currently out of stock.');
            redirect('shop'); // Redirect back to shop with error
            return;
        }

        // Retrieve current cart from session
        $cart = $this->session->userdata('cart') ?? [];

        // If product already in cart, increase quantity, ensuring not to exceed stock
        if (isset($cart[$id])) {
            // Check if adding one more would exceed stock
            if ($cart[$id]['qty'] < ($product['stock'] ?? 0)) {
                $cart[$id]['qty'] += 1;
                $this->session->set_flashdata('success', htmlspecialchars($product['name']) . ' quantity updated in cart!');
            } else {
                $this->session->set_flashdata('error', 'Cannot add more ' . htmlspecialchars($product['name']) . '. Maximum stock reached.');
            }
        } else {
            // Add new product to cart
            $cart[$id] = [
                'id'    => $product['id'],
                'name'  => $product['name'],
                'price' => $product['price'],
                'qty'   => 1
            ];
            $this->session->set_flashdata('success', htmlspecialchars($product['name']) . ' added to cart!');
        }

        // Save updated cart back to session
        $this->session->set_userdata('cart', $cart);

        redirect('cart'); // Redirect to cart page
    }

    /**
     * Displays the user's shopping cart.
     */
    public function cart() {
        $data['cart'] = $this->session->userdata('cart') ?? []; // Get cart from session
        $this->load->view('userProducts/cart', $data);
    }

    /**
     * Removes a product from the user's shopping cart.
     * @param int $id Product ID to remove
     */
    public function removeFromCart($id) {
        $cart = $this->session->userdata('cart') ?? [];

        if (isset($cart[$id])) {
            $product_name = $cart[$id]['name']; // Get product name before unsetting
            unset($cart[$id]); // Remove item from cart
            $this->session->set_userdata('cart', $cart); // Update session
            $this->session->set_flashdata('success', htmlspecialchars($product_name) . ' removed from cart.');
        } else {
             $this->session->set_flashdata('error', 'Product not found in cart.');
        }

        redirect('cart'); // Redirect back to cart page
    }

    /**
     * Handles the completion of payment and order creation.
     */
    public function completePayment() {
        // Ensure cart is not empty before processing payment
        $cart = $this->session->userdata('cart');
        if (empty($cart)) {
            $this->session->set_flashdata('error', 'Your cart is empty. Cannot complete payment.');
            redirect('shop'); // Redirect to shop if cart is empty
            return;
        }

        // Set validation rules for checkout form inputs
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('address', 'Delivery Address', 'required|trim|min_length[10]|max_length[255]');
        $this->form_validation->set_rules('payment_method', 'Payment Method', 'required|in_list[cod,gcash,paypal]');

        if ($this->form_validation->run() === FALSE) {
            // Validation failed, reload the cart page to display errors
            $data['cart'] = $cart; // Pass cart data back to the view so it's not lost
            $this->load->view('userProducts/cart', $data);
        } else {
            // Sanitize input data
            $name = $this->input->post('name', TRUE);
            $address = $this->input->post('address', TRUE);
            $payment_method = $this->input->post('payment_method', TRUE);
            
            // Calculate total amount from cart items
            $total_amount = 0;
            foreach ($cart as $item) {
                $total_amount += ($item['qty'] ?? 0) * ($item['price'] ?? 0);
            }

            // Prepare order data for the database
            $order_data = [
                'customer_name'  => $this->session->userdata('username'), // Use logged-in username
                'address'        => $address,
                'payment_method' => $payment_method,
                'total_amount'   => $total_amount, // Add the calculated total_amount
                'order_data'     => json_encode($cart), // Store cart as JSON
                'shipping_status' => 'Processing', // Default status for new orders
                'created_at' => date('Y-m-d H:i:s') // Set current timestamp
            ];

            // Save order via Order_model
            $order_id = $this->Order_model->save_order($order_data); // Order_model should return the inserted ID or true/false

            if ($order_id) {
                log_message('debug', 'Order saved successfully with ID: ' . $order_id);
                // Reduce stock for each product in the order
                foreach ($cart as $item_id => $item) {
                    $current_product = $this->User_model->get_product_by_id($item_id);
                    if ($current_product && ($current_product['stock'] ?? 0) >= $item['qty']) {
                        $new_stock = ($current_product['stock'] ?? 0) - $item['qty'];
                        $this->User_model->update_products($item_id, ['stock' => $new_stock]);
                        log_message('debug', 'Reduced stock for product ' . $item_id . ' to ' . $new_stock);
                    } else {
                        // Log an error if stock issue occurs during checkout (e.g., race condition)
                        log_message('error', 'Stock insufficient for product ' . $item_id . ' during order ' . $order_id);
                    }
                }

                $this->session->unset_userdata('cart'); // Clear cart after successful payment

                // Prepare data for payment success view
                $data = [
                    'name' => $name,
                    'address' => $address,
                    'payment_method' => strtoupper($payment_method),
                    'message' => 'Payment successful! Thank you for your order.',
                ];
                $this->load->view('userProducts/payment_success', $data);
            } else {
                log_message('error', 'Failed to save order in completePayment.');
                $this->session->set_flashdata('error', 'Payment failed due to a system error. Please try again.');
                redirect('cart'); // Redirect back to cart on failure
            }
        }
    }

    /**
     * Displays the order history for the logged-in user.
     * Accessible only by logged-in users.
     */
    public function orderHistory() {
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login'); // Redirect to login page if not logged in
            return;
        }
        
        $customer_name = $this->session->userdata('username'); // Get username from session
        log_message('debug', 'Retrieving orders for customer: ' . $customer_name);
        $data['orders'] = $this->Order_model->get_orders_by_customer_name($customer_name);
        log_message('debug', 'Found ' . count($data['orders']) . ' orders for ' . $customer_name);

        $this->load->view('userProducts/order_history', $data);
    }

    /**
     * Method to view a specific order details.
     * Accessible only by logged-in users and only for their own orders.
     * @param int $order_id The ID of the order to view
     */
    public function viewOrder($order_id) {
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }
        
        $customer_username = $this->session->userdata('username'); // Get logged-in username from session
        $order = $this->Order_model->get_order_by_id($order_id); // Get order details
        
        // Ensure the order exists AND belongs to the logged-in customer for security
        if (empty($order) || ($order['customer_name'] !== $customer_username)) {
            show_error('Order not found or you do not have permission to view it', 404);
            return;
        }
        
        $data['order'] = $order;
        // Decode order_data, ensuring it's an array even if decoding fails
        $data['order_items'] = json_decode($order['order_data'], true) ?? []; 
        
        // Recalculate total amount for display (or retrieve from DB if stored)
        $data['total_amount'] = 0;
        foreach ($data['order_items'] as $item) {
            $data['total_amount'] += ($item['price'] ?? 0) * ($item['qty'] ?? 0);
        }
        
        $this->load->view('userProducts/order_detail', $data);
    }
}
