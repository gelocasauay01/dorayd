<?php
class Category
{
    private int $id;
    private string $name;

    public function __construct(int $id, $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public static function fromAssocArray(array $rawCategory)
    {
        return new self($rawCategory["CategoryId"], $rawCategory["CategoryName"]);
    }
}
