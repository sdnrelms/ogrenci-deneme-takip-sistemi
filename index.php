<?php
require_once 'config.php';

// Oturum açık mı kontrolü yap ve kullanıcının verilerini al
$loggedIn = isLoggedIn();
$user = $loggedIn ? getUser($pdo, $_SESSION['user_id']) : null;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Deneme Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }
        
        .header-section {
            background-size: cover;
            padding: 5rem 0;
            position: relative;
            color: white;
        }
        
        .header-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: #4361ee;
        }
        
    </style>
</head>
<body>
    <!-- Header - Üst tarafta görünen başlık -->
    <section class="header-section text-center mb-5">
        <div class="container position-relative">
            <h1 class="display-4 fw-bold mb-3">📊 Öğrenci Deneme Takip Sistemi</h1>
            <p class="lead mb-4">Deneme sınavı sonuçlarınızı takip edin, performansınızı analiz edin ve başarınızı artırın!</p>
        </div>
    </section>

    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            <!-- Sistem özelliklerini gösteren kart -->
            <div class="col-lg-5 col-md-6">
                <div class="card h-100 shadow-sm p-4">
                    <div class="card-body text-center">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <h3 class="card-title h4">Kapsamlı Analizler</h3>
                        <ul class="list-unstyled text-start mx-auto" style="max-width: 300px;">
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Ders bazında detaylı istatistikler</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Zaman içinde gelişim grafikleri</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Net ve puan hesaplama</li>
                            <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Doğru/Yanlış/Boş analizleri</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kayıt ol ve Giriş Yap Kartı (giriş yapıldıysa kullanıcı adı görülür ve ana sayfaya yönlendirir) -->
            <div class="col-lg-5 col-md-6">
                <div class="card h-100 shadow-sm p-4">
                    <div class="card-body text-center">
                        <?php if ($loggedIn): ?>
                            <div class="feature-icon">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <h3 class="card-title h4">Hoş Geldiniz, <?= htmlspecialchars($user['username']) ?>!</h3>
                            <p class="card-text">Sisteme başarıyla giriş yaptınız. Panelinize giderek sınav sonuçlarınızı girebilir ve analizleri görüntüleyebilirsiniz.</p>
                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                                <a href="dashboard.php" class="btn btn-primary px-4">Panele Git</a>
                                <a href="logout.php" class="btn btn-outline-secondary px-4">Çıkış Yap</a>
                            </div>
                        <?php else: ?>
                            <div class="feature-icon">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h3 class="card-title h4">Hemen Başlayın</h3>
                            <p class="card-text">Sınav sonuçlarınızı takip etmek için hesabınızı oluşturun veya giriş yapın.</p>
                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                                <a href="register.php" class="btn btn-primary px-4">Kayıt Ol</a>
                                <a href="login.php" class="btn btn-outline-primary px-4">Giriş Yap</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ekstra Sistem Özellikleri Bölümü -->
        <div class="row mt-5">
            <div class="col-12 text-center mb-4">
                <h2 class="h1">Neden Bizim Sistemimizi Kullanmalısınız?</h2>
                <p class="lead text-muted">İşte sizi başarıya götürecek bazı özellikler</p>
            </div>
            

            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body text-center">
                        <i class="fas fa-pencil-alt feature-icon text-primary"></i>
                        <h4 class="h5">Veri Girişi</h4>
                        <p>Sınav adı, sınav tarihi ve doğru-yanlış-boş şeklinde detaylı veri girişi. </p>
                    </div>
                </div>
            </div>
            

            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body text-center">
                        <i class="far fa-calendar feature-icon text-primary"></i>
                        <h4 class="h5">Düzenli Takip</h4>
                        <p>Grafik gösterimleriyle durumunuzu düzenli olarak takip edin.</p>
                    </div>
                </div>
            </div>
            
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body text-center">
                        <i class="fas fa-trophy feature-icon text-primary"></i>
                        <h4 class="h5">Başarı Takibi</h4>
                        <p>Hedeflerinize ne kadar yaklaştığınızı görün.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-secondary text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0">&copy; <?php echo date('Y'); ?> Öğrenci Deneme Takip Sistemi</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="https://github.com/sdnrelms" class="text-white"><i class="bi bi-github"></i></a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>