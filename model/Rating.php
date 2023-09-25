<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/User.php");
class Rating
{
    private int $id;
    private User $user;
    private float $value;
    private ?string $comment;

    public function __construct(int $id, User $user, float $value, ?string $comment)
    {
        $this->id = $id;
        $this->user = $user;
        $this->value = $value;
        $this->comment = $comment;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public static function FromAssocArray(array $rawRating)
    {
        return new self(
            $rawRating["RatingId"],
            User::fromAssocArray($rawRating),
            $rawRating["RatingValue"],
            $rawRating["RatingComment"]
        );
    }
}
