<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_DB_query_builder $db
 */
class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        // Database is typically autoloaded or loaded in parent controller.
        // If not, ensure $this->load->database(); is called here.
    }

    /**
     * Saves a new order record into the 'orders' table.
     * @param array $data Associative array of order details.
     * @return int|bool The insert ID on success, or FALSE on failure.
     */
    public function save_order($data) {
        // 'created_at' is handled by the controller (ShopController) before passing data,
        // or can be set by MySQL default for current timestamp.
        $this->db->insert('orders', $data);
        return $this->db->insert_id(); // Return the ID of the inserted record
    }

    /**
     * Retrieves all orders from the 'orders' table.
     * Orders are sorted by creation date in descending order.
     * @return array An array of all order records.
     */
    public function get_all_orders() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('orders')->result_array();
    }

    /**
     * Retrieves a single order by its ID.
     * @param int $id The ID of the order to retrieve.
     * @return array|null An associative array of the order record if found, otherwise null.
     */
    public function get_order_by_id($id) {
        return $this->db->get_where('orders', ['id' => $id])->row_array();
    }
    
    /**
     * Updates the shipping status of a specific order.
     * @param int $order_id The ID of the order to update.
     * @param string $status The new shipping status.
     * @return bool TRUE on successful update, FALSE on failure.
     */
    public function update_shipping_status($order_id, $status) {
        $this->db->where('id', $order_id);
        return $this->db->update('orders', ['shipping_status' => $status]);
    }
    
    /**
     * Retrieves orders placed by a specific customer.
     * Orders are sorted by ID in descending order (most recent first).
     * @param string $customer_name The username of the customer.
     * @return array An array of order records for the given customer.
     */
    public function get_orders_by_customer_name($customer_name) {
        $this->db->where('customer_name', $customer_name);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('orders')->result_array();
    }
    
    /**
     * Counts the total number of orders in the database.
     * @return int The total number of orders.
     */
    public function count_all_orders() {
        return $this->db->count_all_results('orders');
    }

    /**
     * Calculates the total revenue from all orders.
     * @return float The sum of all order total amounts.
     */
    public function get_total_revenue() {
        $this->db->select_sum('total_amount');
        $query = $this->db->get('orders');
        return (float) ($query->row()->total_amount ?? 0);
    }

    /**
     * Optional: Retrieves orders with pagination.
     * Can filter by customer name.
     * @param string|null $customer_name Optional customer username to filter by.
     * @param int $limit The maximum number of records to return.
     * @param int $offset The offset for pagination.
     * @return array An array of paginated order records.
     */
    public function get_orders_paginated($customer_name = null, $limit = 10, $offset = 0) {
        if ($customer_name) {
            $this->db->where('customer_name', $customer_name);
        }
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('orders')->result_array();
    }
    
    /**
     * Optional: Counts the total number of orders.
     * Can filter by customer name for pagination purposes.
     * @param string|null $customer_name Optional customer username to filter by.
     * @return int The total count of orders.
     */
    public function count_orders($customer_name = null) {
        if ($customer_name) {
            $this->db->where('customer_name', $customer_name);
        }
        return $this->db->count_all_results('orders');
    }
    public function get_recent_orders($limit = 5) {
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get('orders')->result_array();
    }

     public function get_top_selling_products($limit = 5) {
        $all_orders = $this->get_all_orders(); // Get all orders
        $product_sales = [];

        foreach ($all_orders as $order) {
            $items = json_decode($order['order_data'], true);
            if (is_array($items)) {
                foreach ($items as $item) {
                    $product_name = $item['name'] ?? 'Unknown Product';
                    $qty_sold = $item['qty'] ?? 0;
                    
                    if (!isset($product_sales[$product_name])) {
                        $product_sales[$product_name] = 0;
                    }
                    $product_sales[$product_name] += $qty_sold;
                }
            }
        }

        // Sort products by total quantity sold in descending order
        arsort($product_sales);

        $top_products = [];
        $count = 0;
        foreach ($product_sales as $name => $qty) {
            if ($count >= $limit) {
                break;
            }
            $top_products[] = [
                'product_name' => $name,
                'total_qty_sold' => $qty
            ];
            $count++;
        }
        return $top_products;
    }
}
