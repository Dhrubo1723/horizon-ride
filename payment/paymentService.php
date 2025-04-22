<?php
require_once 'db.php';

class Payment {
    public string $passengerName;
    public float $amount;
    public string $paymentMethod;

    public function __construct($name, $amount, $method) {
        $this->passengerName = $name;
        $this->amount = $amount;
        $this->paymentMethod = $method;
    }
}

class PaymentProcessor {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function storePayment(Payment $payment): bool {
        $stmt = $this->pdo->prepare("INSERT INTO payments (passenger_name, amount, payment_method, transaction_date) VALUES (?, ?, ?, NOW())");
        return $stmt->execute([
            $payment->passengerName,
            $payment->amount,
            $payment->paymentMethod
        ]);
    }
}

class PaymentFacade {
    private PaymentProcessor $processor;

    public function __construct($pdo) {
        $this->processor = new PaymentProcessor($pdo);
    }

    public function makePayment(string $name, float $amount, string $method): bool {
        $payment = new Payment($name, $amount, $method);
        return $this->processor->storePayment($payment);
    }
}
?>
