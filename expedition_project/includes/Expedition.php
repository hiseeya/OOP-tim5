<?php
require_once 'Database.php';

class Expedition {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getServices() {
        $query = "SELECT * FROM services";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute();
        $services = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $services[] = $row;
        }
        return $services;
    }

    public function getServiceById($id) {
        $query = "SELECT * FROM services WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}