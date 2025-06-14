<?php
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit;
}

// Tek sorguda hem son 5 sınavı hem de netleri alalım(Grafik için ve liste için gerekli)
$stmt = $pdo->prepare("
    SELECT 
        id,
        exam_name, 
        exam_date, 
        turkce_dogru,
        turkce_yanlis,
        matematik_dogru,
        matematik_yanlis,
        fen_dogru,
        fen_yanlis,
        inkilap_dogru,
        inkilap_yanlis,
        yabancidil_dogru,
        yabancidil_yanlis,
        din_dogru,
        din_yanlis,
        (turkce_dogru - (turkce_yanlis/4)) as turkce_net,
        (matematik_dogru - (matematik_yanlis/4)) as matematik_net,
        (fen_dogru - (fen_yanlis/4)) as fen_net,
        (inkilap_dogru - (inkilap_yanlis/4)) as inkilap_net,
        (yabancidil_dogru - (yabancidil_yanlis/4)) as yabancidil_net,
        (din_dogru - (din_yanlis/4)) as din_net
    FROM exams 
    WHERE user_id = ? 
    ORDER BY exam_date DESC 
    LIMIT 5
");
$stmt->execute([$user_id]);
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Toplam sınav sayısını alma
$stmt = $pdo->prepare("SELECT COUNT(*) FROM exams WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_exams = $stmt->fetchColumn();

// Verileri hazırlama
$recent_exams = $exams;
$examTrends = array_reverse($exams);        // Grafik için ters sırala

// Grafik verilerini işleme
$labels = [];
$turkceNets = $matematikNets = $fenNets = $inkilapNets = $yabancidilNets = $dinNets = [];

foreach ($examTrends as $exam) {
    $labels[] = date('d.m.Y', strtotime($exam['exam_date']));
    $turkceNets[] = $exam['turkce_net'];
    $matematikNets[] = $exam['matematik_net'];
    $fenNets[] = $exam['fen_net'];
    $inkilapNets[] = $exam['inkilap_net'];
    $yabancidilNets[] = $exam['yabancidil_net'];
    $dinNets[] = $exam['din_net'];
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
    <title>Dashboard - Öğrenci Deneme Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        :root{
            --purple: #7643EEFF;
        }
        .total-exam-card{
            background-color: var(--purple);
        }
        .card {
          transition: transform 0.3s ease;
        }
        .card:hover {
          transform: scale(1.03);
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


    <!-- Karşılama mesajı ve toplam sınav sayısı kartı -->
    <div class="container" style="padding-top: 80px;">
    <div class="mb-4 text-center">
        <h2 class="fw-bold text-primary">👋 Hoş geldin, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h2>
        <p class="text-muted">Deneme sınavlarını düzenli takip et, gelişimini gözlemle! 🚀</p>
    </div>
        <div class="row justify-content-center mb-4">
        <div class="col-md-4">
            <div class="card shadow-lg border-0 total-exam-card text-white text-center">
                <div class="card-body">
                    <h1 class="display-4 fw-bold"><?php echo $total_exams; ?></h1>
                    <p class="mb-0">Toplam Sınav</p>
                </div>
            </div>
        </div>
    </div>
        <!-- Sınav ekleme tüm sınavları görme butonları  -->
        <div class="mb-4">
            <h5>Hızlı İşlemler</h5>
            <div class="d-flex gap-3">
                <a href="add_exam.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Yeni Sınav Ekle</a>
                <a href="list_exams.php" class="btn btn-success"><i class="bi bi-list-ul"></i> Tüm Sınavları Görüntüle</a>
            </div>
        </div> 

        <!-- Son girilen 5 sınavın listelenmesi -->
        <?php if ($recent_exams): ?>
        <div class="mt-5">
            <h5>Son Sınavlar</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Sınav Adı</th>
                            <th>Tarih</th>
                            <th>Türkçe Net</th>
                            <th>Matematik Net</th>
                            <th>Fen Net</th>
                            <th>İnkılap Net</th>
                            <th>Yabancı Dil Net</th>
                            <th>Din Kültürü Net</th>
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Tüm sınavlar için ad ve ders ders net yazdırma + görüntüleme düzenleme ve silme işlemleri için için buton -->
                        <?php foreach ($recent_exams as $exam): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($exam['exam_name']); ?></td>
                            <td><?php echo date('d.m.Y', strtotime($exam['exam_date'])); ?></td>
                            <td><?php echo number_format(calculateNet($exam['turkce_dogru'], $exam['turkce_yanlis']), 2); ?></td>
                            <td><?php echo number_format(calculateNet($exam['matematik_dogru'], $exam['matematik_yanlis']), 2); ?></td>
                            <td><?php echo number_format(calculateNet($exam['fen_dogru'], $exam['fen_yanlis']), 2); ?></td>
                            <td><?php echo number_format(calculateNet($exam['inkilap_dogru'], $exam['inkilap_yanlis']), 2); ?></td>
                            <td><?php echo number_format(calculateNet($exam['yabancidil_dogru'], $exam['yabancidil_yanlis']), 2); ?></td>
                            <td><?php echo number_format(calculateNet($exam['din_dogru'], $exam['din_yanlis']), 2); ?></td>
                            <td class="d-flex justify-content-center align-items-center gap-2">
                           <div class="btn-group" role="group">
                             <a class="btn btn-sm btn-outline-primary me-2" href="view_exam.php?id=<?php echo $exam['id']; ?>"><i class="bi bi-eye"></i> Görüntüle</a>  
                            <a class="btn btn-sm btn-outline-warning me-2" href="edit_exam.php?id=<?php echo $exam['id']; ?>"><i class="bi bi-pencil"></i> Düzenle</a> 
                            <a class="btn btn-sm btn-outline-danger" href="delete_exam.php?id=<?php echo $exam['id']; ?>"><i class="bi bi-trash"></i> Sil</a></td>
                           </div>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-info mt-5">
            <h5>Henüz sınav eklenmemiş</h5>
            <p>İlk sınavını ekleyerek başla!</p>
            <a class="btn btn-success" href="add_exam.php">İlk Sınavını Ekle</a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Grafik için gerekli html -->
    <div class="row mt-5">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5>Son 5 Sınavın Net Karşılaştırması</h5>
                </div>
                <div class="card-body">
                    <div style="height: 400px;">    <!-- Sabit yükseklik -->
                        <canvas id="trendChart"></canvas>
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
    

    <!-- Grafik için gerekli olan Chart.js -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('trendChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [
                        {
                            label: 'Türkçe',
                            data: <?= json_encode($turkceNets) ?>,
                            borderColor: '#4361ee',
                            tension: 0.1
                        },
                        {
                            label: 'Matematik',
                            data: <?= json_encode($matematikNets) ?>,
                            borderColor: '#0CA339FF',
                            tension: 0.1
                        },
                        {
                            label: 'Fen',
                            data: <?= json_encode($fenNets) ?>,
                            borderColor: '#4cc9f0',
                            tension: 0.1
                        },
                        {
                            label: 'İnkılap',
                            data: <?= json_encode($inkilapNets) ?>,
                            borderColor: '#f8961e',
                            tension: 0.1
                        },
                        {
                            label: 'Yabancı Dil',
                            data: <?= json_encode($yabancidilNets) ?>,
                            borderColor: '#d90429',
                            tension: 0.1
                        },
                        {
                            label: 'Din',
                            data: <?= json_encode($dinNets) ?>,
                            borderColor: '#6c757d',
                            tension: 0.1
                        }
                    ]
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
                            beginAtZero: false,
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