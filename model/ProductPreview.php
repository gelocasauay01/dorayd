<?php
class ProductPreview
{
    private int $productId;
    private string $imageUrl;
    private string $name;
    private float $rating;
    private float $price;

    public function __construct(int $productId, string $imageUrl, string $name, float $rating, float $price)
    {
        $this->productId = $productId;
        $this->imageUrl = $imageUrl;
        $this->name = $name;
        $this->rating = $rating;
        $this->price = $price;
    }

    public function getProductId()
    {
        return $this->productId;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public static function fromAssocArray(array $productPreview)
    {
        $productId = $productPreview["ProductId"];
        $imageUrl = $productPreview["ImageUrl"];
        $name = $productPreview["ProductName"];
        $rating = $productPreview["RatingAverage"];
        $price = $productPreview["Price"];
        return new self($productId, $imageUrl, $name, $rating, $price);
    }
}
