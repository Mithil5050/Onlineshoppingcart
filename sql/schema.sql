-- Customer Table
CREATE TABLE Customer (
    CustId INT AUTO_INCREMENT PRIMARY KEY,
    F_Name VARCHAR(50),
    L_Name VARCHAR(50),
    Address TEXT,
    City VARCHAR(50),
    State VARCHAR(50),
    PinCode VARCHAR(10),
    ContactNo VARCHAR(15)
);

-- Admin Table
CREATE TABLE Admin (
    AdminId INT AUTO_INCREMENT PRIMARY KEY,
    AdminName VARCHAR(50),
    AdminRole VARCHAR(50)
);

-- Supplier Table
CREATE TABLE Supplier (
    SupplierId INT AUTO_INCREMENT PRIMARY KEY,
    SupplierName VARCHAR(100),
    SupplierAddress TEXT,
    ContactNo VARCHAR(15)
);

-- Category Table
CREATE TABLE Category (
    CategoryId INT AUTO_INCREMENT PRIMARY KEY,
    CategoryName VARCHAR(50)
);

-- Product Table
CREATE TABLE Product (
    ProductId INT AUTO_INCREMENT PRIMARY KEY,
    ProductName VARCHAR(100),
    CategoryId INT,
    SupplierId INT,
    Quantity INT,
    Size VARCHAR(20),
    ProductPrice DECIMAL(10,2),
    ProdStatus VARCHAR(20),
    FOREIGN KEY (CategoryId) REFERENCES Category(CategoryId),
    FOREIGN KEY (SupplierId) REFERENCES Supplier(SupplierId)
);

-- Cart Table
CREATE TABLE Cart (
    CartId INT AUTO_INCREMENT PRIMARY KEY,
    CustId INT,
    ProductId INT,
    Quantity INT,
    FOREIGN KEY (CustId) REFERENCES Customer(CustId),
    FOREIGN KEY (ProductId) REFERENCES Product(ProductId)
);

-- Order Table
CREATE TABLE `Order` (
    OrderNo INT AUTO_INCREMENT PRIMARY KEY,
    CustId INT,
    OrderDate DATE,
    OrderAmount DECIMAL(10,2),
    FOREIGN KEY (CustId) REFERENCES Customer(CustId)
);

-- OrderDetails Table (Many-to-Many between Order and Product)
CREATE TABLE OrderDetails (
    OrderDetailId INT AUTO_INCREMENT PRIMARY KEY,
    OrderNo INT,
    ProductId INT,
    Quantity INT,
    FOREIGN KEY (OrderNo) REFERENCES `Order`(OrderNo),
    FOREIGN KEY (ProductId) REFERENCES Product(ProductId)
);

-- Payment Table
CREATE TABLE Payment (
    PaymentNo INT AUTO_INCREMENT PRIMARY KEY,
    OrderNo INT,
    PaymentDate DATE,
    PaymentAmount DECIMAL(10,2),
    FOREIGN KEY (OrderNo) REFERENCES `Order`(OrderNo)
);

-- Tracking Table
CREATE TABLE Tracking (
    TrackingNo INT AUTO_INCREMENT PRIMARY KEY,
    OrderNo INT,
    CourierName VARCHAR(100),
    TrackingDetail TEXT,
    FOREIGN KEY (OrderNo) REFERENCES `Order`(OrderNo)
);
