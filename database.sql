-- ============================================================
-- ML Engineer / AI Engineer Application System
-- Run this in phpMyAdmin or MySQL to set up the database
-- ============================================================

CREATE DATABASE IF NOT EXISTS ml_engineer_db;
USE ml_engineer_db;

CREATE TABLE IF NOT EXISTS applicants (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    first_name       VARCHAR(100)  NOT NULL,
    last_name        VARCHAR(100)  NOT NULL,
    email            VARCHAR(150)  NOT NULL,
    specialization   VARCHAR(100)  NOT NULL,
    programming_lang VARCHAR(100)  NOT NULL,
    years_experience INT           NOT NULL,
    education_level  VARCHAR(50)   NOT NULL,
    date_added       TIMESTAMP     DEFAULT CURRENT_TIMESTAMP
);
