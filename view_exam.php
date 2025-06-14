<?php
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit;
}

// Sınav ID'sini al ve kontrol et
$exam_id = $_GET['id'] ?? null;
if (!$exam_id) {
    header('Location: list_exams.php');
    exit;
}

// Sınav bilgilerini veritabanından al
$stmt = $pdo->prepare("SELECT * FROM exams WHERE id = ? AND user_id = ?");
$stmt->execute([$exam_id, $user_id]);
$exam = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$exam) {
    header('Location: list_exams.php');
    exit;
}

// Net hesaplama fonksiyonu
function calculateNet($dogru, $yanlis) {
    return $dogru - ($yanlis / 4);
}

// Derslere göre netleri hesapla
$turkce_net = calculateNet($exam['turkce_dogru'], $exam['turkce_yanlis']);
$matematik_net = calculateNet($exam['matematik_dogru'], $exam['matematik_yanlis']);
$fen_net = calculateNet($exam['fen_dogru'], $exam['fen_yanlis']);
$inkilap_net = calculateNet($exam['inkilap_dogru'], $exam['inkilap_yanlis']);
$yabancidil_net = calculateNet($exam['yabancidil_dogru'], $exam['yabancidil_yanlis']);
$din_net = calculateNet($exam['din_dogru'], $exam['din_yanlis']);

$total_questions = 90;
$total_correct = $exam['turkce_dogru'] + $exam['matematik_dogru'] + $exam['fen_dogru'] + $exam['inkilap_dogru'] + $exam['yabancidil_dogru'] + $exam['din_dogru'];
$total_wrong = $exam['turkce_yanlis'] + $exam['matematik_yanlis'] + $exam['fen_yanlis'] + $exam['inkilap_yanlis'] + $exam['yabancidil_yanlis'] + $exam['din_yanlis'];
$toplam_net = $turkce_net + $matematik_net + $fen_net + $inkilap_net + $yabancidil_net + $din_net
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sınav Detayları - Öğrenci Deneme Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .net-score {
            font-size: 1.2rem;
            font-weight: bold;
        }
        .subject-card {
            transition: transform 0.3s;
        }
        .subject-card:hover {
            transform: translateY(-5px);
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
        <!-- Düzenleme, Silme ve Ana sayfaya Dönüş butonları  -->
    <div class="container" style="padding-top: 80px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Sınav Detayları</h2>
            <div>
                <a href="edit_exam.php?id=<?php echo $exam['id']; ?>" class="btn btn-warning me-2">Düzenle</a>
                <a href="dashboard.php" class="btn btn-secondary me-2">Geri Dön</a>
                <a href="delete_exam.php?id=<?php echo $exam['id']; ?>" class="btn btn-danger">Sil</a>
            </div>
        </div>
        <!-- Sınav özeti - toplam soru, net, doğru ve yanlış sayısı gösteriliyor -->
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                <h4 class="mb-0"><?php echo htmlspecialchars($exam['exam_name']); ?></h4>
            </div>
            <div class="card-body">

                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>Sınav Tarihi:</strong> <?php echo date('d.m.Y', strtotime($exam['exam_date'])); ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Toplam Soru:</strong> <?php echo $total_questions; ?></p>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <p><strong>Doğru Sayısı:</strong> <?php echo $total_correct; ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Yanlış Sayısı:</strong> <?php echo $total_wrong; ?></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>Toplam Net Sayısı:</strong> <?php echo $toplam_net; ?></p>
                    </div>
               </div>
               
            </div>
        </div>
        <!-- Her ders için bi kart -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card subject-card h-100 border-primary">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Türkçe</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="mb-1"><strong>Doğru:</strong> <?php echo $exam['turkce_dogru']; ?></p>
                        <p class="mb-1"><strong>Yanlış:</strong> <?php echo $exam['turkce_yanlis']; ?></p>
                        <p class="mb-0"><strong>Boş:</strong> <?php echo $exam['turkce_bos']; ?></p>
                        <hr>
                        <p class="net-score text-primary">Net: <?php echo number_format($turkce_net, 2); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="card subject-card h-100 border-success">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">Matematik</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="mb-1"><strong>Doğru:</strong> <?php echo $exam['matematik_dogru']; ?></p>
                        <p class="mb-1"><strong>Yanlış:</strong> <?php echo $exam['matematik_yanlis']; ?></p>
                        <p class="mb-0"><strong>Boş:</strong> <?php echo $exam['matematik_bos']; ?></p>
                        <hr>
                        <p class="net-score text-success">Net: <?php echo number_format($matematik_net, 2); ?></p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-3">
                <div class="card subject-card h-100 border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">Fen Bilimleri</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="mb-1"><strong>Doğru:</strong> <?php echo $exam['fen_dogru']; ?></p>
                        <p class="mb-1"><strong>Yanlış:</strong> <?php echo $exam['fen_yanlis']; ?></p>
                        <p class="mb-0"><strong>Boş:</strong> <?php echo $exam['fen_bos']; ?></p>
                        <hr>
                        <p class="net-score text-info">Net: <?php echo number_format($fen_net, 2); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card subject-card h-100 border-warning">
                    <div class="card-header bg-warning text-white">
                        <h5 class="mb-0">İnkılap Tarihi</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="mb-1"><strong>Doğru:</strong> <?php echo $exam['inkilap_dogru']; ?></p>
                        <p class="mb-1"><strong>Yanlış:</strong> <?php echo $exam['inkilap_yanlis']; ?></p>
                        <p class="mb-0"><strong>Boş:</strong> <?php echo $exam['inkilap_bos']; ?></p>
                        <hr>
                        <p class="net-score text-warning">Net: <?php echo number_format($inkilap_net, 2); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card subject-card h-100 border-danger">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">Yabancı Dil</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="mb-1"><strong>Doğru:</strong> <?php echo $exam['yabancidil_dogru']; ?></p>
                        <p class="mb-1"><strong>Yanlış:</strong> <?php echo $exam['yabancidil_yanlis']; ?></p>
                        <p class="mb-0"><strong>Boş:</strong> <?php echo $exam['yabancidil_bos']; ?></p>
                        <hr>
                        <p class="net-score text-danger">Net: <?php echo number_format($yabancidil_net, 2); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card subject-card h-100 border-secondary">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0">Din Kültürü</h5>
                    </div>
                    <div class="card-body text-center">
                        <p class="mb-1"><strong>Doğru:</strong> <?php echo $exam['din_dogru']; ?></p>
                        <p class="mb-1"><strong>Yanlış:</strong> <?php echo $exam['din_yanlis']; ?></p>
                        <p class="mb-0"><strong>Boş:</strong> <?php echo $exam['din_bos']; ?></p>
                        <hr>
                        <p class="net-score text-secondary">Net: <?php echo number_format($din_net, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>

    <!-- Mevcut sınavın bar grafiği -->
    <div class="row mt-5">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5>Ders Bazında Netler</h5>
                </div>
                <div class="card-body">
                    <div style="height: 400px;"> 
                        <canvas id="subjectNetChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Garfik için gerekli Chart.js -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('subjectNetChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Türkçe', 'Matematik', 'Fen', 'İnkılap', 'Yabancı Dil', 'Din'],
                datasets: [{
                    label: 'Net Sayıları',
                    data: [
                        <?= number_format($turkce_net, 2) ?>,
                        <?= number_format($matematik_net, 2) ?>,
                        <?= number_format($fen_net, 2) ?>,
                        <?= number_format($inkilap_net, 2) ?>,
                        <?= number_format($yabancidil_net, 2) ?>,
                        <?= number_format($din_net, 2) ?>
                    ],
                    backgroundColor: [
                        '#4361ee', '#0CA339FF', '#4cc9f0', '#f8961e', '#d90429', '#6c757d'
                    ],
                    borderColor: [
                        '#4361ee', '#0CA339FF', '#4cc9f0', '#f8961e', '#d90429', '#6c757d'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top', 
                        }
                    },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Net'
                        }
                    }
                }
            }
        });
    });
</script>

</body>
</html>