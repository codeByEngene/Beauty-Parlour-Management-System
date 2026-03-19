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
-- Table: tblappointments
-- -----------------------------
CREATE TABLE tblappointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    service_name VARCHAR(100) NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    message TEXT,
    status ENUM('Pending','Approved','Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
INSERT INTO tblappointments
(user_id, service_name, appointment_date, appointment_time, message)
VALUES
(1, 'Facial', '2026-01-10', '14:30', 'First time visit');

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

CREATE TABLE about_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    page_title VARCHAR(255),
    page_description TEXT
);

-- Insert a default row to update later
INSERT INTO about_settings (page_title, page_description) 
VALUES ('About Us', 'Our main focus is on quality and hygiene...');

CREATE TABLE IF NOT EXISTS tblpages (
  ID int(11) PRIMARY KEY AUTO_INCREMENT,
  PageType varchar(50),
  PageTitle varchar(200),
  Email varchar(200),
  MobileNumber bigint(12),
  Timing varchar(200),
  PageDescription mediumtext
);

-- Insert the initial record so we have something to update
INSERT INTO tblpages (PageType, PageTitle, Email, MobileNumber, Timing, PageDescription) 
VALUES ('contactus', 'Contact Us', 'parlour017@gmail.com', 9824159063, '10:00 am to 8:30 pm', 'Thamel, 16 Kathmandu Nepal');




