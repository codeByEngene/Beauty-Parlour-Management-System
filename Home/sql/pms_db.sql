-- Create Database
CREATE DATABASE IF NOT EXISTS pms_db;
USE pms_db;

-- -----------------------------
-- Table: tbluser
-- -----------------------------
CREATE TABLE tblusers (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    FullName VARCHAR(100),
    MobileNumber VARCHAR(15),
    Email VARCHAR(100),
    Password VARCHAR(255),
    Role VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO tblusers
(FullName, MobileNumber, Email, Password, Role)
VALUES
('Admin', '9800000000', 'admin@gmail.com', MD5('admin123'), 'admin');

INSERT INTO tblusers
(FullName, MobileNumber, Email, Password, Role, created_at)
VALUES
('Anjan Shrestha', '9866654435', 'anjanstha090@gmail.com', MD5('1234'), 'user', '2026-01-03 23:11:07');

-- -----------------------------
-- Table: tblservices
-- -----------------------------
CREATE TABLE tblservices (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    ServiceName VARCHAR(200),
    ServiceDescription MEDIUMTEXT,
    Cost INT(10),
    Image VARCHAR(200),
    CreationDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (ID)
);

-- -----------------------------
-- Table: tblbook
-- -----------------------------
CREATE TABLE tblbook (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    UserID INT(10),
    AptNumber INT(10),
    AptDate DATE,
    AptTime TIME,
    Message MEDIUMTEXT,
    BookingDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Remark VARCHAR(250),
    Status VARCHAR(250),
    RemarkDate TIMESTAMP NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (ID)
);

-- -----------------------------
-- Table: tblcontact
-- -----------------------------
CREATE TABLE tblcontact (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(100),
    Email VARCHAR(100),
    Phone VARCHAR(10),
    Message MEDIUMTEXT,
    PostingDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    IsRead INT DEFAULT 0
);
INSERT INTO tblcontact (Name, Phone, Email, Message)
VALUES ('Test User', '9800000000', 'test@gmail.com', 'Hello Admin');


-- -----------------------------
-- Table: tblinvoice
-- -----------------------------
CREATE TABLE tblinvoice (
    id INT(11) NOT NULL AUTO_INCREMENT,
    Userid INT(11),
    ServiceId INT(11),
    BillingId INT(11),
    PostingDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);

-- -----------------------------
-- Table: tblpage
-- -----------------------------
CREATE TABLE tblpage (
    ID INT(10) NOT NULL AUTO_INCREMENT,
    PageType VARCHAR(200),
    PageTitle MEDIUMTEXT,
    PageDescription MEDIUMTEXT,
    Email VARCHAR(200),
    MobileNumber BIGINT(10),
    UpdationDate DATE,
    Timing VARCHAR(200),
    PRIMARY KEY (ID)
);

INSERT INTO tblpage 
(PageType, PageTitle, PageDescription, Email, MobileNumber, Timing)
VALUES
('aboutus', 'About Us',
 'Our main focus is on quality and hygiene. We provide professional beauty services.',
 NULL, NULL, ''),
('contactus', 'Contact Us',
 '890, Sector 62, Gyan Sarovar, Noida',
 'info@gmail.com', 7896541236, '10:30 am to 7:30 pm');
