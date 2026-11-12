<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Users table
        DB::statement('
            CREATE TABLE IF NOT EXISTS users (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                email_verified_at TIMESTAMP NULL,
                password VARCHAR(255) NOT NULL,
                remember_token VARCHAR(100) NULL,
                role ENUM("admin", "accountant", "sales_staff") DEFAULT "sales_staff",
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ');

        // Products table
        DB::statement('
            CREATE TABLE IF NOT EXISTS products (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                category VARCHAR(255) NULL,
                quantity INT DEFAULT 0,
                price DECIMAL(10,2) NOT NULL,
                sku VARCHAR(255) NULL UNIQUE,
                supplier_id BIGINT UNSIGNED NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ');

        // Customers table
        DB::statement('
            CREATE TABLE IF NOT EXISTS customers (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NULL,
                phone VARCHAR(255) NULL,
                address TEXT NULL,
                created_by BIGINT UNSIGNED NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ');

        // Suppliers table
        DB::statement('
            CREATE TABLE IF NOT EXISTS suppliers (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NULL,
                phone VARCHAR(255) NULL,
                address TEXT NULL,
                payment_due DECIMAL(10,2) DEFAULT 0,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ');

        // Invoices table
        DB::statement('
            CREATE TABLE IF NOT EXISTS invoices (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                invoice_number VARCHAR(255) NOT NULL UNIQUE,
                customer_id BIGINT UNSIGNED NOT NULL,
                user_id BIGINT UNSIGNED NOT NULL,
                total_amount DECIMAL(10,2) NOT NULL,
                discount DECIMAL(10,2) DEFAULT 0,
                tax DECIMAL(10,2) DEFAULT 0,
                payment_status ENUM("paid", "pending", "partial") DEFAULT "pending",
                due_date DATE NULL,
                notes TEXT NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ');

        // Invoice Items table
        DB::statement('
            CREATE TABLE IF NOT EXISTS invoice_items (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                invoice_id BIGINT UNSIGNED NOT NULL,
                product_id BIGINT UNSIGNED NOT NULL,
                quantity INT NOT NULL,
                price DECIMAL(10,2) NOT NULL,
                subtotal DECIMAL(10,2) NOT NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ');

        // Expenses table
        DB::statement('
            CREATE TABLE IF NOT EXISTS expenses (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                description VARCHAR(255) NOT NULL,
                amount DECIMAL(10,2) NOT NULL,
                category VARCHAR(255) NULL,
                expense_date DATE NULL,
                user_id BIGINT UNSIGNED NOT NULL,
                notes TEXT NULL,
                created_at TIMESTAMP NULL,
                updated_at TIMESTAMP NULL
            )
        ');

        // Cache table
        DB::statement('
            CREATE TABLE IF NOT EXISTS cache (
                `key` VARCHAR(255) PRIMARY KEY,
                value MEDIUMTEXT NOT NULL,
                expiration INT NOT NULL
            )
        ');

        // Cache Locks table
        DB::statement('
            CREATE TABLE IF NOT EXISTS cache_locks (
                `key` VARCHAR(255) PRIMARY KEY,
                owner VARCHAR(255) NOT NULL,
                expiration INT NOT NULL
            )
        ');

        // Sessions table
        DB::statement('
            CREATE TABLE IF NOT EXISTS sessions (
                id VARCHAR(255) PRIMARY KEY,
                user_id BIGINT UNSIGNED NULL,
                ip_address VARCHAR(45) NULL,
                user_agent TEXT NULL,
                payload LONGTEXT NOT NULL,
                last_activity INT NOT NULL
            )
        ');

        // Jobs table
        DB::statement('
            CREATE TABLE IF NOT EXISTS jobs (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                queue VARCHAR(255) NOT NULL,
                payload LONGTEXT NOT NULL,
                attempts TINYINT UNSIGNED NOT NULL,
                reserved_at INT UNSIGNED NULL,
                available_at INT UNSIGNED NOT NULL,
                created_at INT UNSIGNED NOT NULL
            )
        ');

        // Job Batches table
        DB::statement('
            CREATE TABLE IF NOT EXISTS job_batches (
                id VARCHAR(255) PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                total_jobs INT NOT NULL,
                pending_jobs INT NOT NULL,
                failed_jobs INT NOT NULL,
                failed_job_ids LONGTEXT NOT NULL,
                options MEDIUMTEXT NULL,
                cancelled_at INT NULL,
                created_at INT NOT NULL,
                finished_at INT NULL
            )
        ');

        // Failed Jobs table
        DB::statement('
            CREATE TABLE IF NOT EXISTS failed_jobs (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                uuid VARCHAR(255) NOT NULL UNIQUE,
                connection TEXT NOT NULL,
                queue TEXT NOT NULL,
                payload LONGTEXT NOT NULL,
                exception LONGTEXT NOT NULL,
                failed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ');

        echo "All tables created successfully!";
    }

    public function down(): void
    {
        DB::statement('DROP TABLE IF EXISTS invoice_items');
        DB::statement('DROP TABLE IF EXISTS invoices');
        DB::statement('DROP TABLE IF EXISTS customers');
        DB::statement('DROP TABLE IF EXISTS products');
        DB::statement('DROP TABLE IF EXISTS suppliers');
        DB::statement('DROP TABLE IF EXISTS expenses');
        DB::statement('DROP TABLE IF EXISTS jobs');
        DB::statement('DROP TABLE IF EXISTS job_batches');
        DB::statement('DROP TABLE IF EXISTS failed_jobs');
        DB::statement('DROP TABLE IF EXISTS sessions');
        DB::statement('DROP TABLE IF EXISTS cache_locks');
        DB::statement('DROP TABLE IF EXISTS cache');
        DB::statement('DROP TABLE IF EXISTS users');
        
        echo "All tables dropped!";
    }
};