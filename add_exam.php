<?php
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit;
}

// Form verilerini saklamak için değişkenler
$exam_name = '';
$exam_date = '';
$turkce_dogru = $turkce_yanlis = $turkce_bos = 0;
$matematik_dogru = $matematik_yanlis = $matematik_bos = 0;
$fen_dogru = $fen_yanlis = $fen_bos = 0;
$inkilap_dogru = $inkilap_yanlis = $inkilap_bos = 0;
$yabancidil_dogru = $yabancidil_yanlis = $yabancidil_bos = 0;
$din_dogru = $din_yanlis = $din_bos = 0;

// Form gönderildiğinde
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Form verilerini al ve temizle
    $exam_name = trim($_POST['exam_name']);
    $exam_date = $_POST['exam_date'];
    
    // Ders bilgilerini al
    $turkce_dogru = (int)$_POST['turkce_dogru'];
    $turkce_yanlis = (int)$_POST['turkce_yanlis'];
    $turkce_bos = (int)$_POST['turkce_bos'];
    
    $matematik_dogru = (int)$_POST['matematik_dogru'];
    $matematik_yanlis = (int)$_POST['matematik_yanlis'];
    $matematik_bos = (int)$_POST['matematik_bos'];
    
    $fen_dogru = (int)$_POST['fen_dogru'];
    $fen_yanlis = (int)$_POST['fen_yanlis'];
    $fen_bos = (int)$_POST['fen_bos'];
    
    $inkilap_dogru = (int)$_POST['inkilap_dogru'];
    $inkilap_yanlis = (int)$_POST['inkilap_yanlis'];
    $inkilap_bos = (int)$_POST['inkilap_bos'];
    
    $yabancidil_dogru = (int)$_POST['yabancidil_dogru'];
    $yabancidil_yanlis = (int)$_POST['yabancidil_yanlis'];
    $yabancidil_bos = (int)$_POST['yabancidil_bos'];
    
    $din_dogru = (int)$_POST['din_dogru'];
    $din_yanlis = (int)$_POST['din_yanlis'];
    $din_bos = (int)$_POST['din_bos'];
   
    $errors = [];
    
    if (empty($exam_name) || empty($exam_date)) {
        $errors[] = "Sınav adı ve sınav tarihi boş bırakılamaz";
    }
    
    // Soru sayısı kontrolleri
    $turkce_toplam = $turkce_dogru + $turkce_yanlis + $turkce_bos;
    if ($turkce_toplam != 20) {
        $errors[] = "Türkçe dersi toplam soru sayısı 20 olmalı (Girilen: $turkce_toplam)";
    }
    
    $matematik_toplam = $matematik_dogru + $matematik_yanlis + $matematik_bos;
    if ($matematik_toplam != 20) {
        $errors[] = "Matematik dersi toplam soru sayısı 20 olmalı (Girilen: $matematik_toplam)";
    }
    
    $fen_toplam = $fen_dogru + $fen_yanlis + $fen_bos;
    if ($fen_toplam != 20) {
        $errors[] = "Fen Bilimleri dersi toplam soru sayısı 20 olmalı (Girilen: $fen_toplam)";
    }
    
    $inkilap_toplam = $inkilap_dogru + $inkilap_yanlis + $inkilap_bos;
    if ($inkilap_toplam != 10) {
        $errors[] = "İnkılap Tarihi dersi toplam soru sayısı 10 olmalı (Girilen: $inkilap_toplam)";
    }
    
    $yabancidil_toplam = $yabancidil_dogru + $yabancidil_yanlis + $yabancidil_bos;
    if ($yabancidil_toplam != 10) {
        $errors[] = "Yabancı Dil dersi toplam soru sayısı 10 olmalı (Girilen: $yabancidil_toplam)";
    }
    
    $din_toplam = $din_dogru + $din_yanlis + $din_bos;
    if ($din_toplam != 10) {
        $errors[] = "Din Kültürü dersi toplam soru sayısı 10 olmalı (Girilen: $din_toplam)";
    }
    
    // Eğer hata yoksa eklemeyi yap
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO exams (
            user_id, exam_name, exam_date,
            turkce_dogru, turkce_yanlis, turkce_bos,
            matematik_dogru, matematik_yanlis, matematik_bos,
            fen_dogru, fen_yanlis, fen_bos,
            inkilap_dogru, inkilap_yanlis, inkilap_bos,
            yabancidil_dogru, yabancidil_yanlis, yabancidil_bos,
            din_dogru, din_yanlis, din_bos
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $stmt->execute([
            $user_id, $exam_name, $exam_date,
            $turkce_dogru, $turkce_yanlis, $turkce_bos,
            $matematik_dogru, $matematik_yanlis, $matematik_bos,
            $fen_dogru, $fen_yanlis, $fen_bos,
            $inkilap_dogru, $inkilap_yanlis, $inkilap_bos,
            $yabancidil_dogru, $yabancidil_yanlis, $yabancidil_bos,
            $din_dogru, $din_yanlis, $din_bos
        ]);
        
        $exam_id = $pdo->lastInsertId();
        $_SESSION['success_message'] = "Sınav başarıyla eklendi!";
        header("Location: view_exam.php?id=$exam_id");
        exit;
    }
}

// Net hesaplama fonksiyonu
function calculateNet($dogru, $yanlis) {
    return $dogru - ($yanlis / 4);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sınav Ekle - Öğrenci Deneme Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .subject-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        .subject-card:hover {
            transform: translateY(-5px);
        }
        .card-header {
            font-weight: bold;
        }
        .form-section {
            margin-bottom: 30px;
        }
        .question-info {
            font-size: 0.9em;
            color: #6c757d;
            margin-top: 5px;
        }
        .total-questions {
            font-weight: bold;
            color: #495057;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-secondary fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
                <i class="bi bi-journal-bookmark-fill me-2"></i>
                <span class="fw-bold">Öğrenci Deneme Takip Sistemi</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="dashboard.php">
                            <i class="bi bi-house-door me-1"></i>
                            <span>Ana Sayfa</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="add_exam.php">
                            <i class="bi bi-plus-circle me-1"></i>
                            <span>Sınav Ekle</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="list_exams.php">
                            <i class="bi bi-list-check me-1"></i>
                            <span>Sınavlarım</span>
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            <span><?php echo htmlspecialchars($_SESSION['full_name']); ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Çıkış Yap</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="padding-top: 80px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Yeni Sınav Ekle</h2>
            <a href="list_exams.php" class="btn btn-secondary">Geri Dön</a>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo $error; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Sınav adı ve tarihi ekleme -->
        <form method="POST">
            <div class="card mb-4">
                <div class="card-header bg-dark text-white">
                    <h4 class="mb-0">Genel Bilgiler</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="exam_name" class="form-label">Sınav Adı</label>
                            <input type="text" class="form-control" id="exam_name" name="exam_name" required value="<?php echo htmlspecialchars($exam_name); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exam_date" class="form-label">Sınav Tarihi</label>
                            <input type="date" class="form-control" id="exam_date" name="exam_date" required value="<?php echo htmlspecialchars($exam_date); ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Her ders için ayrı kart ve ekleme alanı -->
            <div class="form-section">
                <h4 class="mb-3">Ders Bilgileri</h4>
                
                <div class="row">
                    <!-- Türkçe -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card subject-card border-primary">
                            <div class="card-header bg-primary text-white">
                                Türkçe
                                <div class="question-info text-dark">Maksimum 20 soru</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="turkce_dogru" class="form-label">Doğru Sayısı</label>
                                    <input type="number" class="form-control question-input" id="turkce_dogru" name="turkce_dogru" 
                                           min="0" max="20" value="<?php echo $turkce_dogru; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="turkce_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="turkce_yanlis" name="turkce_yanlis" 
                                           min="0" max="20" value="<?php echo $turkce_yanlis; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="turkce_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="turkce_bos" name="turkce_bos" 
                                           min="0" max="20" value="<?php echo $turkce_bos; ?>">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count"><?php echo $turkce_dogru + $turkce_yanlis + $turkce_bos; ?></span>/20
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: <?php echo calculateNet($turkce_dogru, $turkce_yanlis); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Matematik -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card subject-card border-success">
                            <div class="card-header bg-success text-white">
                                Matematik
                                <div class="question-info text-dark">Maksimum 20 soru</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="matematik_dogru" class="form-label">Doğru Sayısı</label>
                                    <input type="number" class="form-control question-input" id="matematik_dogru" name="matematik_dogru" 
                                           min="0" max="20" value="<?php echo $matematik_dogru; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="matematik_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="matematik_yanlis" name="matematik_yanlis" 
                                           min="0" max="20" value="<?php echo $matematik_yanlis; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="matematik_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="matematik_bos" name="matematik_bos" 
                                           min="0" max="20" value="<?php echo $matematik_bos; ?>">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count"><?php echo $matematik_dogru + $matematik_yanlis + $matematik_bos; ?></span>/20
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: <?php echo calculateNet($matematik_dogru, $matematik_yanlis); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Fen Bilimleri -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card subject-card border-info">
                            <div class="card-header bg-info text-white">
                                Fen Bilimleri
                                <div class="question-info text-dark">Maksimum 20 soru</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="fen_dogru" class="form-label">Doğru Sayısı</label>
                                    <input type="number" class="form-control question-input" id="fen_dogru" name="fen_dogru" 
                                           min="0" max="20" value="<?php echo $fen_dogru; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="fen_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="fen_yanlis" name="fen_yanlis" 
                                           min="0" max="20" value="<?php echo $fen_yanlis; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="fen_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="fen_bos" name="fen_bos" 
                                           min="0" max="20" value="<?php echo $fen_bos; ?>">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count"><?php echo $fen_dogru + $fen_yanlis + $fen_bos; ?></span>/20
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: <?php echo calculateNet($fen_dogru, $fen_yanlis); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- İnkılap Tarihi -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card subject-card border-warning">
                            <div class="card-header bg-warning text-white">
                                İnkılap Tarihi
                                <div class="question-info text-dark">Maksimum 10 soru</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="inkilap_dogru" class="form-label">Doğru Sayısı</label>
                                    <input type="number" class="form-control question-input" id="inkilap_dogru" name="inkilap_dogru" 
                                           min="0" max="10" value="<?php echo $inkilap_dogru; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="inkilap_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="inkilap_yanlis" name="inkilap_yanlis" 
                                           min="0" max="10" value="<?php echo $inkilap_yanlis; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="inkilap_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="inkilap_bos" name="inkilap_bos" 
                                           min="0" max="10" value="<?php echo $inkilap_bos; ?>">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count"><?php echo $inkilap_dogru + $inkilap_yanlis + $inkilap_bos; ?></span>/10
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: <?php echo calculateNet($inkilap_dogru, $inkilap_yanlis); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Yabancı Dil -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card subject-card border-danger">
                            <div class="card-header bg-danger text-white">
                                Yabancı Dil
                                <div class="question-info text-dark">Maksimum 10 soru</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="yabancidil_dogru" class="form-label">Doğru Sayısı</label>
                                    <input type="number" class="form-control question-input" id="yabancidil_dogru" name="yabancidil_dogru" 
                                           min="0" max="10" value="<?php echo $yabancidil_dogru; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="yabancidil_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="yabancidil_yanlis" name="yabancidil_yanlis" 
                                           min="0" max="10" value="<?php echo $yabancidil_yanlis; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="yabancidil_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="yabancidil_bos" name="yabancidil_bos" 
                                           min="0" max="10" value="<?php echo $yabancidil_bos; ?>">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count"><?php echo $yabancidil_dogru + $yabancidil_yanlis + $yabancidil_bos; ?></span>/10
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: <?php echo calculateNet($yabancidil_dogru, $yabancidil_yanlis); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Din Kültürü -->
                    <div class="col-md-6 col-lg-4">
                        <div class="card subject-card border-secondary">
                            <div class="card-header bg-secondary text-white">
                                Din Kültürü
                                <div class="question-info text-dark">Maksimum 10 soru</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="din_dogru" class="form-label">Doğru Sayısı</label>
                                    <input type="number" class="form-control question-input" id="din_dogru" name="din_dogru" 
                                           min="0" max="10" value="<?php echo $din_dogru; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="din_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="din_yanlis" name="din_yanlis" 
                                           min="0" max="10" value="<?php echo $din_yanlis; ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="din_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="din_bos" name="din_bos" 
                                           min="0" max="10" value="<?php echo $din_bos; ?>">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count"><?php echo $din_dogru + $din_yanlis + $din_bos; ?></span>/10
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: <?php echo calculateNet($din_dogru, $din_yanlis); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Kaydet ve iptal butonu -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mb-5">
                <button type="submit" class="btn btn-primary me-md-2">Kaydet</button>
                <a href="list_exams.php" class="btn btn-secondary">İptal</a>
            </div>
        </form>
    </div>
    <!-- Footer kısmı -->
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
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Input değerleri değiştiğinde netleri ve toplam sayıları otomatik hesaplamak için
        document.querySelectorAll('.question-input').forEach(input => {
            input.addEventListener('input', function() {
                const cardBody = this.closest('.card-body');
                const dogru = parseInt(cardBody.querySelector('input[name$="_dogru"]').value) || 0;
                const yanlis = parseInt(cardBody.querySelector('input[name$="_yanlis"]').value) || 0;
                const bos = parseInt(cardBody.querySelector('input[name$="_bos"]').value) || 0;
                
                // Net hesaplama
                const net = (dogru - (yanlis / 4)).toFixed(2);
                cardBody.querySelector('.alert').textContent = `Net: ${net}`;
                
                // Toplam hesaplama
                const toplam = dogru + yanlis + bos;
                const totalCountElement = cardBody.querySelector('.total-count');
                totalCountElement.textContent = toplam;
                
                // Maksimum kontrol (toplam soru sayısı sağlanmadığı sürece renk değişimi)
                const totalQuestionsElement = cardBody.querySelector('.total-questions');
                const cardHeader = cardBody.closest('.card').querySelector('.card-header');
                const maxQuestions = cardHeader.textContent.includes('20') ? 20 : 10;
                
                if (toplam != maxQuestions) {
                    totalQuestionsElement.style.color = '#dc3545';
                    totalCountElement.style.fontWeight = 'bold';
                } else {
                    totalQuestionsElement.style.color = '#495057';
                    totalCountElement.style.fontWeight = 'bold';
                }
            });
        });
    </script>
</body>
</html>