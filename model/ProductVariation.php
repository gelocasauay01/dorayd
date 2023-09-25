<?php
class ProductVariation
{
    private int $id;
    private string $name;
    private array $imageUrls;
    private float $price;
    private int $variationStock;

    public function __construct(int $id, string $name, array $imageUrls, float $price, int $variationStock)
    {
        $this->id = $id;
        $this->name = $name;
        $this->imageUrls = $imageUrls;
        $this->price = $price;
        $this->variationStock = $variationStock;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getImageUrls()
    {
        return $this->imageUrls;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function getStock()
    {
        return $this->variationStock;
    }

    public function insertToImageUrls(string $imageUrl)
    {
        array_push($this->imageUrls, $imageUrl);
    }

    public static function fromAssocArray(array $rawVariant)
    {
        $id = $rawVariant["VariantId"];
        $name = $rawVariant["VariantName"];
        $imageUrls = [$rawVariant["ImageUrl"]];
        $price = $rawVariant["Price"];
        $variationStock = $rawVariant["Stock"];
        return new self($id, $name, $imageUrls, $price, $variationStock);
    }
}
