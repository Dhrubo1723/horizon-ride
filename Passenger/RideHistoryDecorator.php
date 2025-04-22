<?php
require_once 'PassengerDecorator.php';

class RideHistoryDecorator extends PassengerDecorator {
    private array $rideHistory;

    public function __construct(Passenger $passenger, array $rideHistory) {
        parent::__construct($passenger);
        $this->rideHistory = $rideHistory;
    }

    public function getDetails(): string {
        $details = parent::getDetails();
        $history = implode(", ", $this->rideHistory);
        return "$details, Ride History: [$history]";
    }
}
