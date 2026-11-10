CREATE DATABASE IF NOT EXISTS gym_management
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gym_management;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(120) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','member') NOT NULL DEFAULT 'member',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plan_name ENUM('Basic','Standard','Premium') NOT NULL DEFAULT 'Basic',
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status ENUM('Active','Expired','Cancelled') NOT NULL DEFAULT 'Active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_membership_user FOREIGN KEY (user_id)
      REFERENCES users(id) ON DELETE CASCADE
);

-- Demo admin account:
-- Username: admin
-- Password: Admin123!
-- Change this password after your first login.
INSERT INTO users (full_name, username, email, password, role)
SELECT 'Gym Administrator', 'admin', 'admin@gym.local',
'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'
WHERE NOT EXISTS (SELECT 1 FROM users WHERE username = 'admin');
