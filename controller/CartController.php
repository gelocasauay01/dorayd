<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/data_source/DataSource.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/Cart.php");


class CartController
{
    private DataSource $dataSource;
    private array $cart;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
        $this->cart = [];
    }

    public function intializeCart(int $userId)
    {
        $this->cart = $this->dataSource->executeGetQueryWithSerializer(
            "SELECT CartId, Quantity, Cart.VariantId, pv.VariantName, pv.Stock, pv.Price, cat.ProductName, cat.CategoryName, cat.CategoryId, pd.ImageUrl
        FROM Cart
        INNER JOIN ProductVariants pv ON Cart.VariantId = pv.VariantId
        INNER JOIN (
            SELECT Products.ProductId, Products.ProductName, CategoryName, Products.CategoryId
            FROM Products
            INNER JOIN categories ON categories.CategoryId = products.CategoryId
        ) cat ON cat.ProductId = pv.ProductId
        INNER JOIN (
            SELECT VariantId, ImageUrl
            FROM ProductDisplays
            WHERE DisplayId = (
                SELECT MIN(DisplayId)
                FROM ProductDisplays pd
                WHERE pd.VariantId = ProductDisplays.VariantId
            )
        ) pd on pd.VariantId = pv.VariantId
        WHERE UserId = ?",
            "i",
            function ($rawCart) {
                return Cart::fromAssocArray($rawCart);
            },
            $userId
        );
    }

    public function deleteCartItems(array $cartIds)
    {
        $this->dataSource->executeMultiplePostQuery("DELETE FROM Cart WHERE CartId = ?", "i", $cartIds);
    }

    public function setQuantity(int $cartId, int $quantity)
    {
        $this->dataSource->executePostQuery("UPDATE Cart SET Quantity = ? WHERE CartId = ? ", "ii", $quantity, $cartId);
    }

    public function getCart()
    {
        return $this->cart;
    }

    public function getSubtotal()
    {
        $subtotal = 0;
        foreach ($this->cart as $item) {
            $subtotal += $item->getVariantPrice();
        }
        return $subtotal;
    }

    public function getTotal(array $addOns)
    {
        return $this->getSubtotal() + array_sum($addOns);
    }
}
