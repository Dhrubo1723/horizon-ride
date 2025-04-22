<?php
require_once 'Passenger.php';

abstract class PassengerDecorator implements Passenger {
    protected Passenger $passenger;

    public function __construct(Passenger $passenger) {
        $this->passenger = $passenger;
    }

    public function getDetails(): string {
        return $this->passenger->getDetails();
    }
}
