<?php

try {
    // Connect to master database first
    $conn = new PDO(
        "sqlsrv:Server=127.0.0.1,1433;Database=master;TrustServerCertificate=1",
        "SA",
        "Password_123#"
    );
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create PICA_BETA database if it doesn't exist
    $conn->exec("IF NOT EXISTS (SELECT * FROM sys.databases WHERE name = 'PICA_BETA')
                BEGIN
                    CREATE DATABASE PICA_BETA;
                END");
    
    // Switch to PICA_BETA database
    $conn->exec("USE PICA_BETA");
    
    // Create MS_HS_LGN_SMART_FORM table if it doesn't exist
    $conn->exec("IF NOT EXISTS (SELECT * FROM sys.objects WHERE object_id = OBJECT_ID(N'[dbo].[MS_HS_LGN_SMART_FORM]') AND type in (N'U'))
                BEGIN
                    CREATE TABLE MS_HS_LGN_SMART_FORM (
                        id INT IDENTITY(1,1) PRIMARY KEY,
                        nik VARCHAR(50),
                        login_time DATETIME DEFAULT GETDATE(),
                        logout_time DATETIME,
                        status VARCHAR(50),
                        created_at DATETIME DEFAULT GETDATE(),
                        updated_at DATETIME DEFAULT GETDATE()
                    )
                END");
    
    echo "Database and tables created successfully\n";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
