<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function save_order($data) {
        // created_at is auto-filled by MySQL
        return $this->db->insert('orders', $data);
    }

    public function get_all_orders() {
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('orders')->result_array();
    }

    public function get_order_by_id($id) {
        return $this->db->get_where('orders', ['id' => $id])->row_array();
    }
    
    public function update_shipping_status($order_id, $status) {
        $this->db->where('id', $order_id);
        return $this->db->update('orders', ['shipping_status' => $status]);
    }
    
    // Get orders by customer name
    public function get_orders_by_customer_name($customer_name) {
        $this->db->where('customer_name', $customer_name);
        $this->db->order_by('id', 'DESC');
        return $this->db->get('orders')->result_array();
    }
    
    // Get orders paginated (optional)
    public function get_orders_paginated($customer_name = null, $limit = 10, $offset = 0) {
        if ($customer_name) {
            $this->db->where('customer_name', $customer_name);
        }
        $this->db->order_by('created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get('orders')->result_array();
    }
    
    // Count orders (for pagination)
    public function count_orders($customer_name = null) {
        if ($customer_name) {
            $this->db->where('customer_name', $customer_name);
        }
        return $this->db->count_all_results('orders');
    }
}