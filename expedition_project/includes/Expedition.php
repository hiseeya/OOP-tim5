<?php
require_once 'Database.php';

class Expedition {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Simpan instance Database
    }

    public function getServices() {
        $query = "SELECT * FROM services";
        $result = $this->db->getConnection()->query($query);
        $services = [];
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
        return $services;
    }

    public function getServiceById($id) {
        $query = "SELECT * FROM services WHERE id = ?";
        $stmt = $this->db->getConnection()->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?>