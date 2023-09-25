<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/Category.php");

class Cart
{
    private int $id;
    private string $imageUrl;
    private string $productName;
    private string $variantName;
    private int $stock;
    private Category $category;
    private float $variantPrice;
    private int $quantity;

    public function __construct(int $id, string $imageUrl, string $productName, string $variantName, int $stock, Category $category, float $variantPrice, int $quantity)
    {
        $this->id = $id;
        $this->imageUrl = $imageUrl;
        $this->productName = $productName;
        $this->variantName = $variantName;
        $this->stock = $stock;
        $this->category = $category;
        $this->variantPrice = $variantPrice;
        $this->quantity = $quantity;
    }

    public static function fromAssocArray($rawCart)
    {
        $id = $rawCart["CartId"];
        $imageUrl = $rawCart["ImageUrl"];
        $productName = $rawCart["ProductName"];
        $variantName = $rawCart["VariantName"];
        $stock = $rawCart["Stock"];
        $category = Category::fromAssocArray($rawCart);
        $variantPrice = $rawCart["Price"];
        $quantity = $rawCart["Quantity"];
        return new self($id, $imageUrl, $productName, $variantName, $stock, $category, $variantPrice, $quantity);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function getProductName()
    {
        return $this->productName;
    }

    public function getVariantName()
    {
        return $this->variantName;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function getVariantPrice()
    {
        return $this->variantPrice;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function getSubtotal()
    {
        return $this->variantPrice * $this->quantity;
    }
}
