<?php
require_once 'ReviewService.php';

class ReviewFacade {
    private ReviewService $reviewService;

    public function __construct(PDO $pdo) {
        $this->reviewService = new ReviewService($pdo);
    }

    public function submitReview(int $reviewID, int $rating, string $comment, User $author, User $reviewedUser): void {
        $review = new Review($reviewID, $rating, $comment, $author, $reviewedUser);
        $this->reviewService->submitReview($review);
    }

    public function showReviews(): void {
        $reviews = $this->reviewService->getAllReviews();
        foreach ($reviews as $row) {
            echo "Review by {$row['authorName']} for {$row['reviewedUserName']}: {$row['rating']}/5 - {$row['comment']}<br><br>";
        }
    }
}
