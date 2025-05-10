<?php
require_once 'User.php';

class Review {
    public int $reviewID;
    public int $rating;
    public string $comment;
    private User $author;
    private User $reviewedUser;

    public function __construct(int $reviewID, int $rating, string $comment, User $author, User $reviewedUser) {
        $this->reviewID = $reviewID;
        $this->rating = $rating;
        $this->comment = $comment;
        $this->author = $author;
        $this->reviewedUser = $reviewedUser;
    }

    public function getAuthorName(): string {
        return $this->author->name;
    }

    public function getReviewedUserName(): string {
        return $this->reviewedUser->name;
    }

    public function getReview(): string {
        return "Review by {$this->getAuthorName()} for {$this->getReviewedUserName()}: {$this->rating}/5 - {$this->comment}";
    }
}
