<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/Category.php");

class Product
{
    private int $id;
    private string $productName;
    private string $description;
    private Category $category;
    private array $ratings;
    private array $variations;

    public function __construct(int $id, string $productName, string $description, Category $category, array $ratings, array $variations)
    {
        $this->id = $id;
        $this->productName = $productName;
        $this->description = $description;
        $this->category = $category;
        $this->ratings = $ratings;
        $this->variations = $variations;
    }

    public function getRatingAverage()
    {
        $ratingSum = 0;
        $itemCount = 0;
        foreach ($this->ratings as $rating) {
            $ratingSum += $rating->getValue();
            $itemCount++;
        }
        return $itemCount > 0 ? $ratingSum / $itemCount : 0;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->productName;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getRatings()
    {
        return $this->ratings;
    }

    public function getVariations()
    {
        return $this->variations;
    }
}
