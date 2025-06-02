<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ShopController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Order_model');
        $this->load->helper('url');
        $this->load->library('session'); // Load session library
    }

    public function shop() {
        $data['products'] = $this->User_model->get_products();
        $this->load->view('userProducts/shop', $data);
    }

    public function addToCart($id) {
        $product = $this->User_model->get_product_by_id($id); // You need to add this method in your model

        if (!$product) {
            show_error('Product not found', 404);
        }

        // Retrieve current cart from session
        $cart = $this->session->userdata('cart') ?? [];

        // If product already in cart, increase quantity
        if (isset($cart[$id])) {
            $cart[$id]['qty'] += 1;
        } else {
            $cart[$id] = [
                'id'    => $product['id'],
                'name'  => $product['name'],
                'price' => $product['price'],
                'qty'   => 1
            ];
        }

        // Save cart back to session
        $this->session->set_userdata('cart', $cart);

        redirect('ShopController/cart');
    }

    public function cart() {
        $data['cart'] = $this->session->userdata('cart') ?? [];
        $this->load->view('userProducts/cart', $data);
    }

    public function removeFromCart($id) {
        $cart = $this->session->userdata('cart') ?? [];

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $this->session->set_userdata('cart', $cart);
        }

        redirect('ShopController/cart');
    }
   public function completePayment() {
    $name = $this->input->post('name', true);
    $address = $this->input->post('address', true);
    $payment_method = $this->input->post('payment_method', true);
    $cart = $this->session->userdata('cart');

    if (empty($cart)) {
        show_error('Cart is empty');
    }

    $order_data = [
        'customer_name'   => $this->session->userdata('username'),
        'address'         => $address,
        'payment_method'  => $payment_method,
        'order_data'      => json_encode($cart),
    ];

    $result = $this->Order_model->save_order($order_data);
    if ($result) {
        log_message('debug', 'Order saved successfully with ID: ' . $result);
    } else {
        log_message('error', 'Failed to save order');
    }

    $this->session->unset_userdata('cart');
    $this->session->unset_userdata('cart_count');

    $data = [
        'name' => $name,
        'address' => $address,
        'payment_method' => strtoupper($payment_method),
        'message' => 'Payment successful! Thank you for your order.',
    ];

    $this->load->view('userProducts/payment_success', $data);
    }

    public function orderHistory() {
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login'); // Redirect to login page if not logged in
            return;
        }
        
        // In orderHistory method
        $customer_name = $this->session->userdata('username');
        log_message('debug', 'Retrieving orders for customer: ' . $customer_name);
        $data['orders'] = $this->Order_model->get_orders_by_customer_name($customer_name);
        log_message('debug', 'Found ' . count($data['orders']) . ' orders');

        $this->load->view('userProducts/order_history', $data);
    }

    // Method to view a specific order
    public function viewOrder($order_id) {
        // Check if user is logged in
        if (!$this->session->userdata('logged_in')) {
            redirect('login');
            return;
        }
        
        $customer_name = $this->session->userdata('name');
        $order = $this->Order_model->get_order_by_id($order_id);
        
        // Make sure the order belongs to the logged-in customer
        if (!$order || $order['customer_name'] != $customer_name) {
            show_error('Order not found or you do not have permission to view it', 404);
        }
        
        $data['order'] = $order;
        $data['order_items'] = json_decode($order['order_data'], true);
        
        // Calculate total amount since it's not stored in the database
        $data['total_amount'] = 0;
        foreach ($data['order_items'] as $item) {
            $data['total_amount'] += $item['price'] * $item['qty'];
        }
        
        $this->load->view('userProducts/order_detail', $data);
    }
}
?>