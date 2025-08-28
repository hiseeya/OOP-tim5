<?php
require_once 'Database.php';

class Transaction {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }



    public function createTransaction($service_id, $customer_name, $distance) {
        $service_query = "SELECT base_price FROM services WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($service_query);
        $stmt->execute([$service_id]);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$service) return false;

        $total_price = $service_id == 3 ? $service['base_price'] * $distance : $service['base_price'];

        $query = "INSERT INTO transactions (service_id, customer_name, distance, total_price) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->getConnection()->prepare($query);
        return $stmt->execute([$service_id, $customer_name, $distance, $total_price]);
    }

    public function getTransactions() {
        $query = "SELECT t.*, s.name as service_name 
          FROM transactions t 
          JOIN services s ON t.service_id = s.id 
          ORDER BY t.created_at DESC, t.id DESC";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        $transactions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $transactions[] = $row;
        }
        return $transactions;
    }
}
?>

