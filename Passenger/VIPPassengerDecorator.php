<?php
require_once 'PassengerDecorator.php';

class VIPPassengerDecorator extends PassengerDecorator {
    private string $vipLevel;

    public function __construct(Passenger $passenger, string $vipLevel = "Gold") {
        parent::__construct($passenger);
        $this->vipLevel = $vipLevel;
    }

    public function getDetails(): string {
        return parent::getDetails() . ", VIP Status: {$this->vipLevel}";
    }
}
