CREATE DATABASE IF NOT EXISTS faq_db;
USE faq_db;

CREATE TABLE faq (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    likes_count INT DEFAULT 0
);

INSERT INTO faq (title, content) VALUES
('What is Machine Learning?', 'Machine Learning (ML) is a subset of artificial intelligence that enables systems to learn from data and make decisions or predictions without being explicitly programmed.'),
('What is the difference between AI and Machine Learning?', 'AI is a broader concept of machines performing tasks smartly. ML is a subset of AI focused on algorithms that learn from data.'),
('What is feature engineering?', 'Feature engineering is the process of selecting, modifying, or creating new input features to improve model performance.');
