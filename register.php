<?php
require_once 'config.php';

// Hata ve başarı mesajlarını tutmak için 
$error = '';
$success = '';

// Form işlemleri
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form verilerini alma ve temizleme
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = trim($_POST['full_name']);
    
    // Alınan verilerin kontrolü
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'Tüm alanları doldurunuz.';
    } else if (strlen($username) < 3) {
        $error = 'Kullanıcı adı en az 3 karakter olmalıdır.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Geçerli bir e-posta adresi giriniz.';
    } else if (strlen($password) < 6) {
        $error = 'Şifre en az 6 karakter olmalıdır.';
    } else if ($password !== $confirm_password) {
        $error = 'Şifreler eşleşmiyor.';
    } else {
        try {
            // Kullanıcı adı veya email daha önceden kullanılmış mı
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            
            if ($stmt->fetch()) {
                $error = 'Bu kullanıcı adı veya e-posta zaten kullanılıyor.';
            } else {
                // Şifreyi hashleme ve kayıt işlemi
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name) VALUES (?, ?, ?, ?)");
                $stmt->execute([$username, $email, $hashed_password, $full_name]);
                
                $success = 'Kayıt başarılı! Şimdi giriş yapabilirsiniz.';
            }
        } catch (PDOException $e) {
            $error = 'Kayıt işlemi sırasında bir hata oluştu.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Ol - Öğrenci Deneme Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Yeni Hesap Oluştur</h3>

                    <!-- Hata veya başarı durumuna göre mesaj ve başarı durumunda ek bi giriş yap butonu -->
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php elseif ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                        <div class="text-center mt-3">
                            <a href="login.php" class="btn btn-success">Giriş Yap</a>
                        </div>
                    <?php else: ?>
                        <!-- Kayıt Formu -->
                        <form method="POST">
                            <div class="mb-3">
                                <label for="full_name" class="form-label">Ad Soyad</label>
                                <input type="text" id="full_name" name="full_name" 
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="username" class="form-label">Kullanıcı Adı</label>
                                <input type="text" id="username" name="username" 
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">E-posta</label>
                                <input type="email" id="email" name="email" 
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Şifre</label>
                                <input type="password" id="password" name="password" 
                                       class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Şifre Tekrar</label>
                                <input type="password" id="confirm_password" name="confirm_password" 
                                       class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-secondary">Kayıt Ol</button>
                            </div>
                        </form>
                    <?php endif; ?>

                    <p class="mt-3 text-center">
                        Zaten hesabınız var mı? <a href="login.php">Giriş yapın</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer kısmı -->
<footer class="bg-secondary text-white py-4 mt-5" style="position: fixed; bottom: 0; left: 0; right: 0; z-index: 1000;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Öğrenci Deneme Takip Sistemi</p>
            </div>
        </div>
    </div>
</footer>

</body>
</html>
