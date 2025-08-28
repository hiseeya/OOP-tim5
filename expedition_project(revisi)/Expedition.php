<?php
interface ExpeditionInterface {
    public function calculatePrice($distance);
    public function getDescription();
}

abstract class BaseExpedition implements ExpeditionInterface {
    protected $basePrice;
    protected $name;

    public function __construct($name, $basePrice) {
        $this->name = $name;
        $this->basePrice = $basePrice;
    }

    public function getDescription() {
        return $this->name . " (Base Rp" . number_format($this->basePrice, 0, ',', '.') . ")";
    }

    abstract public function calculatePrice($distance);
}

class InstantExpedition extends BaseExpedition {
    public function calculatePrice($distance) {
        return $this->basePrice; // flat price
    }
}

class RegularExpedition extends BaseExpedition {
    public function calculatePrice($distance) {
        return $this->basePrice; // fixed price
    }
}

class DistanceExpedition extends BaseExpedition {
    public function calculatePrice($distance) {
        return $this->basePrice * $distance; // per km
    }
}
