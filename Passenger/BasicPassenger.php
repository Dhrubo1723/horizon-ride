<?php
require_once 'Passenger.php';

class BasicPassenger implements Passenger {
    private int $passengerID;
    private string $name;

    public function __construct(int $id, string $name) {
        $this->passengerID = $id;
        $this->name = $name;
    }

    public function getDetails(): string {
        return "Passenger ID: {$this->passengerID}, Name: {$this->name}";
    }
}
