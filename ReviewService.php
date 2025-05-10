<?php
require_once 'db.php';
require_once 'Review.php';

class ReviewService {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function submitReview(Review $review): void {
        $stmt = $this->pdo->prepare("INSERT INTO reviews (rating, comment, authorName, reviewedUserName) VALUES (?, ?, ?, ?)");
        $stmt->execute([
            $review->rating,
            $review->comment,
            $review->getAuthorName(),
            $review->getReviewedUserName()
        ]);
        echo "✅ Review submitted successfully!<br>";
    }

    public function getAllReviews(): array {
        $stmt = $this->pdo->query("SELECT * FROM reviews ORDER BY reviewID DESC");
        return $stmt->fetchAll();
    }
}
