<?php
class User {
    public int $userID;
    public string $name;

    public function __construct(int $userID, string $name) {
        $this->userID = $userID;
        $this->name = $name;
    }
}
