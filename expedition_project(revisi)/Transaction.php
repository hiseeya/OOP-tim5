<?php
require_once 'Database.php';
require_once 'Expedition.php';

class Transaction {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getDB() {
        return $this->db->getConnection();
    }

    public function createTransaction(ExpeditionInterface $expedition, $serviceId, $customerName, $distance, $route = null) {
        $price = $expedition->calculatePrice($distance);

        $query = "INSERT INTO transactions (service_id, customer_name, distance, total_price, route) VALUES (?, ?, ?, ?, ?)";
        $stmt  = $this->db->getConnection()->prepare($query);
        $stmt->execute([$serviceId, $customerName, $distance, $price, $route]);

        return [
            "customer" => $customerName,
            "service_id" => $serviceId,
            "service"  => $expedition->getDescription(),
            "distance" => $distance,
            "route"    => $route,
            "price"    => $price
        ];
    }

    public function getAllTransactions() {
        $query = "SELECT t.id, s.name as service_name, t.customer_name, t.distance, t.total_price, t.route, t.created_at
                  FROM transactions t
                  JOIN services s ON t.service_id = s.id
                  ORDER BY t.id DESC";
        $stmt = $this->db->getConnection()->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
