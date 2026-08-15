-- Create & select database
CREATE DATABASE IF NOT EXISTS school_db;
USE school_db;

-- 1. STUDENT Table
CREATE TABLE IF NOT EXISTS STUDENT (
    StudentID VARCHAR(10) PRIMARY KEY,
    LastName VARCHAR(50) NOT NULL,
    FirstName VARCHAR(50) NOT NULL,
    MiddleName VARCHAR(50),
    Address VARCHAR(100),
    ContactNumber VARCHAR(15),
    Email VARCHAR(100),
    DateOfBirth DATE,
    Password VARCHAR(255) NOT NULL -- for login
);

-- 2. COURSE Table
CREATE TABLE IF NOT EXISTS COURSE (
    CourseCode VARCHAR(10) PRIMARY KEY,
    CourseName VARCHAR(100) NOT NULL,
    Description TEXT,
    Duration VARCHAR(30)
);

-- 3. SUBJECT Table
CREATE TABLE IF NOT EXISTS SUBJECT (
    SubjectCode VARCHAR(10) PRIMARY KEY,
    CourseCode VARCHAR(10) NOT NULL,
    SubjectName VARCHAR(100) NOT NULL,
    Units INT NOT NULL,
    Description TEXT,
    FOREIGN KEY (CourseCode) REFERENCES COURSE(CourseCode) ON DELETE CASCADE
);

-- 4. INSTRUCTOR Table
CREATE TABLE IF NOT EXISTS INSTRUCTOR (
    InstructorID VARCHAR(10) PRIMARY KEY,
    LastName VARCHAR(50) NOT NULL,
    FirstName VARCHAR(50) NOT NULL,
    Specialization VARCHAR(100),
    ContactNumber VARCHAR(15),
    Email VARCHAR(100)
);

-- 5. ENROLLMENT Table
CREATE TABLE IF NOT EXISTS ENROLLMENT (
    EnrollmentID INT AUTO_INCREMENT PRIMARY KEY,
    StudentID VARCHAR(10) NOT NULL,
    SubjectCode VARCHAR(10) NOT NULL,
    EnrollmentDate DATE NOT NULL,
    Grade DECIMAL(4,2),
    Status VARCHAR(20) NOT NULL,
    FOREIGN KEY (StudentID) REFERENCES STUDENT(StudentID) ON DELETE CASCADE,
    FOREIGN KEY (SubjectCode) REFERENCES SUBJECT(SubjectCode) ON DELETE CASCADE
);

-- 6. PAYMENT Table
CREATE TABLE IF NOT EXISTS PAYMENT (
    PaymentID INT AUTO_INCREMENT PRIMARY KEY,
    EnrollmentID INT NOT NULL,
    Amount DECIMAL(10,2) NOT NULL,
    PaymentDate DATE NOT NULL,
    PaymentMethod VARCHAR(50) NOT NULL,
    Status VARCHAR(20) NOT NULL,
    FOREIGN KEY (EnrollmentID) REFERENCES ENROLLMENT(EnrollmentID) ON DELETE CASCADE
);

-- Insert sample data
INSERT INTO STUDENT (StudentID, LastName, FirstName, MiddleName, Address, ContactNumber, Email, DateOfBirth, Password) VALUES
('S20', 'Santos', 'Clara', 'Reyes', 'Lemery, Batangas', '09171234567', 'clara@school.com', '2005-05-10', 'clara123'),
('S21', 'Galang', 'Mark', 'Cruz', 'Taal, Batangas', '09179876543', 'mark@school.com', '2004-11-22', 'mark123');

INSERT INTO COURSE (CourseCode, CourseName, Description, Duration) VALUES
('BSIS', 'Bachelor of Science in Information Systems', '4‑year IT business degree', '4 Years'),
('BSCS', 'Bachelor of Science in Computer Science', '4‑year computing degree', '4 Years');

INSERT INTO SUBJECT (SubjectCode, CourseCode, SubjectName, Units, Description) VALUES
('CS101', 'BSIS', 'Programming', 3, 'Intro to programming'),
('CS102', 'BSIS', 'Database Design', 3, 'Relational database concepts'),
('IT101', 'BSCS', 'Web Development', 3, 'HTML, CSS, JS basics');

INSERT INTO ENROLLMENT (StudentID, SubjectCode, EnrollmentDate, Grade, Status) VALUES
('S20', 'CS101', '2026-08-05', 1.50, 'Enrolled'),
('S20', 'CS102', '2026-08-05', 1.75, 'Enrolled'),
('S21', 'CS101', '2026-08-06', 2.00, 'Enrolled'),
('S21', 'IT101', '2026-08-06', 1.25, 'Enrolled');

INSERT INTO PAYMENT (EnrollmentID, Amount, PaymentDate, PaymentMethod, Status) VALUES
(1, 5000.00, '2026-08-05', 'Cash', 'Paid'),
(2, 5000.00, '2026-08-05', 'GCash', 'Paid'),
(3, 7500.00, '2026-08-06', 'Bank Transfer', 'Paid'),
(4, 5000.00, '2026-08-06', 'Cash', 'Paid');
-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.4.3 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.8.0.6908
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for bsis3a
CREATE DATABASE IF NOT EXISTS `bsis3a` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `bsis3a`;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
