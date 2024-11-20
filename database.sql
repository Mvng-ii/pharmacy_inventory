CREATE DATABASE pharmacy_inventory;

USE pharmacy_inventory;

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Patient', 'Doctor', 'Superadmin') DEFAULT 'Patient'
);

-- Medicines Table
CREATE TABLE medicines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    quantity INT DEFAULT 0,
    expiration_date DATE NOT NULL,
    batch_number VARCHAR(50),
    picture_url VARCHAR(255)
);

-- Prescriptions Table
CREATE TABLE prescriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT,
    medicine_id INT,
    dosage VARCHAR(100),
    notes TEXT,
    date_prescribed DATE NOT NULL,
    doctor_id INT NOT NULL,
    doctor_name VARCHAR(100),  -- Added doctor_name column
    FOREIGN KEY (patient_id) REFERENCES users(id),
    FOREIGN KEY (medicine_id) REFERENCES medicines(id),
    FOREIGN KEY (doctor_id) REFERENCES users(id)  -- Foreign key reference for doctor_id
);
