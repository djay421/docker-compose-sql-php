-- RevZone Users Table
USE scooterparts;

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Demo user for testing
INSERT INTO users (username, password) VALUES ('admin', '$2y$10$YIjlrDfl02eN7.S6.dKpLewKpjxjhN8Gf/7.KF8bG8kKp8jHKpH7e');
-- Password: password123

