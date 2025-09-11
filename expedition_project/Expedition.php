<?php
interface ExpeditionInterface {
    public function calculatePrice($distance);
    public function getDescription();
}


class BaseExpedition implements ExpeditionInterface {
    protected $basePrice;
    protected $name;

    public function __construct($name, $basePrice) {
        $this->name = $name;
        $this->basePrice = $basePrice;
    }

    public function calculatePrice($distance) {
        
        return $this->basePrice;
    }

    public function getDescription() {
        return $this->name . " (Rp " . number_format($this->basePrice, 0, ',', '.') . ")";
    }
}


class InstantExpedition extends BaseExpedition {
    public function __construct($name = "Instant", $basePrice = 50000) {
        parent::__construct($name, $basePrice);
    }
}


class RegularExpedition extends BaseExpedition {
    public function __construct($name = "Regular", $basePrice = 20000) {
        parent::__construct($name, $basePrice);
    }
}


class DistanceExpedition extends BaseExpedition {
    public function __construct($name = "Distance Based", $basePrice = 5000) {
        parent::__construct($name, $basePrice);
    }

    public function calculatePrice($distance) {
        return $this->basePrice * $distance; 
    }
}
