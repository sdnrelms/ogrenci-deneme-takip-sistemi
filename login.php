<?php
require_once 'config.php';

$error = '';

// Kullanıcının ad ve şifre bilgilerini al
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Veritabanı sorgusu ve giriş kontrolü
    if (empty($username) || empty($password)) {
        $error = 'Kullanıcı adı ve şifre gereklidir.';
    } else {
        try {
            // Kullanıcı adı ya da e-posta ile giriş yapılabilir
            $stmt = $pdo->prepare("SELECT id, password, full_name FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            //Kullanıcı bilgileri kaydedilir ve ana sayfaya yönlendirilir
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                redirect('dashboard.php');
            } else {
                $error = 'Kullanıcı adı/e-posta veya şifre hatalı.';
            }
        } catch (PDOException $e) {
            $error = 'Giriş işlemi sırasında bir hata oluştu.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Giriş Yap - Öğrenci Deneme Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Giriş Yap</h3>

                    <!-- Hata oluşması durumunda alert ile göster -->
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <!-- Giriş Formu -->
                    <form method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Kullanıcı Adı / E-posta</label>
                            <input type="text" id="username" name="username" 
                                   class="form-control"
                                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Şifre</label>
                            <input type="password" id="password" name="password" 
                                   class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-secondary">Giriş Yap</button>
                        </div>
                    </form>

                    <p class="mt-3 text-center">
                        Hesabınız yok mu? <a href="register.php">Kayıt olun</a>
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
