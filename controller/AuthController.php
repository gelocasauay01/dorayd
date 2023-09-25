<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/exceptions/NoAccountException.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/User.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/data_source/DataSource.php");

class AuthController
{
    private DataSource $dataSource;
    private ?User $user;


    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
        $this->user = null;
    }

    public function loginWithId(int $userId)
    {
        $user = $this->dataSource->executeGetQueryWithSerializer("SELECT * FROM Users WHERE UserId = ? LIMIT 1", "i", function ($user) {
            return User::fromAssocArray($user);
        }, $userId);
        if (empty($user)) {
            throw new NoAccountException("Account with id " . $userId . " does not exist or password is incorrect");
        } else {
            $this->user = $user[0];
        }
    }

    public function loginWithCredentials(string $email, string $password)
    {
        $user = $this->dataSource->executeGetQueryWithSerializer("SELECT * FROM Users WHERE Email = ? AND Passkey = ? LIMIT 1", "ss", function ($user) {
            return User::fromAssocArray($user);
        }, $email, md5($password));
        if (empty($user)) {
            throw new NoAccountException("Account with email " . $email . " does not exist or password is incorrect");
        } else {
            $this->user = $user[0];
        }
    }

    public function logout()
    {
        $this->user = null;
    }

    public function register(array $userData)
    {
        // Extract the data from request body
        $email = $userData['email'];
        $firstName = $userData['first_name'];
        $lastName = $userData['last_name'];
        $password = md5($userData['password']);
        $userType = 1;
        $newUser = $this->dataSource->executePostQuery("INSERT INTO Users (Email, FirstName, LastName, Passkey) VALUES (?, ?, ?, ?)", "ssss", $email, $firstName, $lastName, $password);
        $this->user = new User($newUser[0], $newUser[1], $newUser[2], null, $userType);
    }

    public function checkLoggedIn()
    {
        return $this->user !== null;
    }


    public function getUser()
    {
        return $this->user;
    }
}
