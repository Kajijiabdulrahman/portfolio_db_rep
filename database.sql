-- ============================================================
--  Portfolio Database — Abdulrahman Abubakar Kajiji
--  Import this file via phpMyAdmin or:
--    mysql -u root -p < database.sql
-- ============================================================

CREATE DATABASE IF NOT EXISTS portfolio_db
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE portfolio_db;

-- ------------------------------------------------------------
-- Contact form messages
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  subject VARCHAR(200),
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  is_read TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Admin users
-- Default login: admin / admin123
-- (hash generated with password_hash('admin123', PASSWORD_DEFAULT))
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) UNIQUE NOT NULL,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Seed admin (password: admin123 — bcrypt hash generated with password_hash('admin123', PASSWORD_DEFAULT))
INSERT INTO admins (username, password_hash) VALUES
('admin', '$2y$10$bk.DJn8wmfcGyJ3lYmUY8.19WBv7ejfNueWpqEooBvYQeomiR/VPu');

-- ------------------------------------------------------------
-- Projects (used by the admin dashboard stats + available to pages)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  slug VARCHAR(50) UNIQUE NOT NULL,
  title VARCHAR(100) NOT NULL,
  tagline VARCHAR(200),
  description TEXT,
  hero_image_url VARCHAR(500),
  youtube_video_id VARCHAR(50),
  tech_stack VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO projects (slug, title, tagline, description, hero_image_url, youtube_video_id, tech_stack) VALUES
('taskflow', 'TaskFlow', 'A lightweight productivity app', 'A task manager with drag-and-drop, offline saving, and reminders.', 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?auto=format&fit=crop&w=1200&q=80', 'dQw4w9WgXcQ', 'HTML,CSS,JavaScript,LocalStorage'),
('weatherscope', 'WeatherScope', 'Real-time weather dashboard', 'A dashboard showing current weather + 7-day forecast for any city.', 'https://images.unsplash.com/photo-1504608524841-42fe6f032b4b?auto=format&fit=crop&w=1200&q=80', 'dQw4w9WgXcQ', 'JavaScript,REST API,Chart.js,CSS Grid'),
('codecollab', 'CodeCollab', 'Collaborative code editor', 'Multi-user real-time code editor with shared rooms.', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?auto=format&fit=crop&w=1200&q=80', 'dQw4w9WgXcQ', 'React,Node.js,Socket.io,Monaco');
