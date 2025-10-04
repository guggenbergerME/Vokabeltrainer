CREATE TABLE IF NOT EXISTS vocab (
    id INT AUTO_INCREMENT PRIMARY KEY,
    word VARCHAR(255) NOT NULL,
    translation VARCHAR(255) NOT NULL,
    language VARCHAR(50) DEFAULT 'Latein',
    UNIQUE (word, language)
);
