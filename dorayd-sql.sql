CREATE TABLE Users(
	UserId INT PRIMARY KEY AUTO_INCREMENT,
	Email VARCHAR(100) NOT NULL UNIQUE,
	FirstName VARCHAR(100) NOT NULL,
	LastName VARCHAR(100) NOT NULL,
	ImageUrl TEXT,
	Passkey TEXT NOT NULL,
	UserType INT DEFAULT 1
);

CREATE TABLE Categories(
	CategoryId INT PRIMARY KEY AUTO_INCREMENT,
	CategoryName VARCHAR(100) NOT NULL UNIQUE,
);

CREATE TABLE Products(
	ProductId INT PRIMARY KEY AUTO_INCREMENT,
	ProductName VARCHAR(100) NOT NULL,
	CategoryId INT,
	ProductDescription TEXT NOT NULL,
	FOREIGN KEY(CategoryId) REFERENCES Categories(CategoryId) ON DELETE SET NULL
);

CREATE TABLE ProductVariants(
	VariantId INT PRIMARY KEY AUTO_INCREMENT,
	ProductId INT,
	VariantName VARCHAR(100) NOT NULL,
	Price DECIMAL NOT NULL,
	Stock INT DEFAULT 0,
	FOREIGN KEY(ProductId) REFERENCES Products(ProductId) ON DELETE CASCADE 
);

CREATE TABLE ProductDisplays(
	DisplayId INT PRIMARY KEY AUTO_INCREMENT,
	VariantId INT,
	ImageUrl TEXT NOT NULL,
	FOREIGN KEY(VariantId) REFERENCES ProductVariants(VariantId) ON DELETE CASCADE 
);

CREATE TABLE ProductRating(
	RatingId INT PRIMARY KEY AUTO_INCREMENT,
	RatingValue INT NOT NULL,
	RatingComment TEXT,
	ProductId INT NOT NULL,
	UserId INT NOT NULL,
	FOREIGN KEY(ProductId) REFERENCES Products(ProductId) ON DELETE CASCADE,
	FOREIGN KEY(UserId) REFERENCES Users(UserId) ON DELETE cascade
);

CREATE TABLE Cart(
	CartId INT PRIMARY KEY AUTO_INCREMENT,
	UserId INT NOT NULL,
	VariantId INT NOT NULL,
	Quantity INT NOT NULL,
	FOREIGN KEY(UserId) REFERENCES Users(UserId),
	FOREIGN KEY(VariantId) REFERENCES ProductVariants(VariantId) ON DELETE CASCADE
)


SELECT Products.ProductId, ProductName, RatingAverage, ImageUrl
FROM Products
INNER JOIN (
	SELECT ProductRatings.ProductId, AVG(RatingValue) AS RatingAverage
	FROM ProductRatings
	GROUP BY ProductRatings.ProductId 
) AS pr ON pr.ProductId = Products.ProductId
INNER JOIN (
	SELECT ProductDisplays.DisplayId, ProductVariants.VariantId, ProductVariants.ProductId, ImageUrl, ProductVariants.Price
	FROM ProductVariants
	INNER JOIN ProductDisplays ON ProductDisplays.VariantId = ProductVariants.VariantId
	AND ProductDisplays.DisplayId = (
			SELECT MIN(pd.DisplayId)
			FROM ProductDisplays pd
			WHERE pd.VariantId = ( 
				SELECT MIN(pv.VariantId)
				FROM ProductVariants pv
				WHERE pv.ProductId = ProductVariants.ProductId
		)
	)
) AS pd on pd.ProductId = Products.ProductId


SELECT CartId, Quantity, Cart.VariantId, pv.VariantName, pv.Price, cat.ProductName, cat.CategoryName, cat.CategoryId, pd.ImageUrl
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



