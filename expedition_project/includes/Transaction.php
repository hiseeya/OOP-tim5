<?php
require_once 'Database.php';

class Transaction {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Simpan instance Database
    }

    public function createTransaction($service_id, $customer_name, $distance) {
        $service_query = "SELECT base_price FROM services WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($service_query);
        $stmt->bind_param("i", $service_id);
        $stmt->execute();
        $service = $stmt->get_result()->fetch_assoc();
        
        $total_price = $service_id == 3 ? $service['base_price'] * $distance : $service['base_price'];
        
        $query = "INSERT INTO transactions (service_id, customer_name, distance, total_price) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("isdd", $service_id, $customer_name, $distance, $total_price);
        return $stmt->execute();
    }

    public function getTransactions() {
        $query = "SELECT t.*, s.name as service_name FROM transactions t JOIN services s ON t.service_id = s.id";
        $result = $this->db->getConnection()->query($query);
        $transactions = [];
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
        }
        return $transactions;
    }
}


?>