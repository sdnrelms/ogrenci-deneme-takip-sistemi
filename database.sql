-- Kullanıcılar tablosu
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);



-- Sınav sonuçları tablosu
CREATE TABLE exams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    exam_name VARCHAR(100) NOT NULL,
    exam_date DATE NOT NULL,
    turkce_dogru INT DEFAULT 0,
    turkce_yanlis INT DEFAULT 0,
    turkce_bos INT DEFAULT 0,
    matematik_dogru INT DEFAULT 0,
    matematik_yanlis INT DEFAULT 0,
    matematik_bos INT DEFAULT 0,
    fen_dogru INT DEFAULT 0,
    fen_yanlis INT DEFAULT 0,
    fen_bos INT DEFAULT 0,
    inkilap_dogru INT DEFAULT 0,
    inkilap_yanlis INT DEFAULT 0,
    inkilap_bos INT DEFAULT 0,
    yabancidil_dogru INT DEFAULT 0,
    yabancidil_yanlis INT DEFAULT 0,
    yabancidil_bos INT DEFAULT 0,
    din_dogru INT DEFAULT 0,
    din_yanlis INT DEFAULT 0,
    din_bos INT DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);