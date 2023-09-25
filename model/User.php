<?php
class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private ?string $imageUrl;
    private int $userType;

    public function __construct(int $id, string $firstName, string $lastName, ?string $imageUrl, int $userType)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->imageUrl = $imageUrl;
        $this->userType = $userType;
    }

    public static function fromAssocArray(array $userData)
    {
        $id = $userData["UserId"];
        $firstName = $userData["FirstName"];
        $lastName = $userData["LastName"];
        $imageUrl = $userData["ImageUrl"];
        $userType = $userData["UserType"];
        return new self($id, $firstName, $lastName, $imageUrl, $userType);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCompleteName()
    {
        return $this->firstName . " " . $this->lastName;
    }

    public function checkAdmin()
    {
        $adminCode = 2;
        return $this->userType === $adminCode;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }
}
