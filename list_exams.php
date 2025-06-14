<?php
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit;
}

// Toplam sınav sayısını al
$stmt = $pdo->prepare("SELECT COUNT(*) FROM exams WHERE user_id = ?");
$stmt->execute([$user_id]);
$total_exams = $stmt->fetchColumn();

// Tüm sınavları al 
$stmt = $pdo->prepare("SELECT * FROM exams WHERE user_id = ? ORDER BY exam_date DESC");
$stmt->execute([$user_id]);
$exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Net hesaplama fonksiyonu
function calculateNet($dogru, $yanlis) {
    return $dogru - ($yanlis / 4);
}

// Renk sınıfı belirleme fonksiyonu
function getNetClass($net_value) {
    if ($net_value > 0)
        return 'positive-net';
    elseif ($net_value < 0) 
        return 'negative-net';
    else 
        return 'zero-net';
}

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sınavlarım - Öğrenci Deneme Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
        .table-hover tbody tr:hover {
            background-color: #f8f9fa;
        } 
        .net-score {
            font-weight: bold;
        }
        /* Netlere pozitif negatif olma durumuna göre renk verdim */
        .positive-net {
            color: #198754 !important;
        }
        .negative-net {
            color: #dc3545 !important;
        }
        .zero-net {
            color: #6c757d !important;
        }
        .subject-card {
            transition: transform 0.3s ease;
        }
        .subject-card:hover {
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

    <div class="container" style="padding-top: 80px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Sınavlarım</h2>
            <a href="add_exam.php" class="btn btn-primary">Yeni Sınav Ekle</a>
        </div>

        <!-- Sınav listesi - detaylı ders ders gösterim -->
        <?php if ($total_exams > 0): ?>
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Toplam <?php echo $total_exams; ?> sınav bulundu</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Sınav Adı</th>
                                    <th>Tarih</th>
                                    <th>Türkçe Net</th>
                                    <th>Matematik Net</th>
                                    <th>Fen Net</th>
                                    <th>İnkılap Net</th>
                                    <th>Yabancı Dil Net</th>
                                    <th>Din Net</th>
                                    <th>Toplam Net</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($exams as $exam): 
                                    // Net hesaplamaları
                                    $turkce_net = calculateNet($exam['turkce_dogru'] ?? 0, $exam['turkce_yanlis'] ?? 0);
                                    $matematik_net = calculateNet($exam['matematik_dogru'] ?? 0, $exam['matematik_yanlis'] ?? 0);
                                    $fen_net = calculateNet($exam['fen_dogru'] ?? 0, $exam['fen_yanlis'] ?? 0);
                                    $inkilap_net = calculateNet($exam['inkilap_dogru'] ?? 0, $exam['inkilap_yanlis'] ?? 0);
                                    $yabancidil_net = calculateNet($exam['yabancidil_dogru'] ?? 0, $exam['yabancidil_yanlis'] ?? 0);
                                    $din_net = calculateNet($exam['din_dogru'] ?? 0, $exam['din_yanlis'] ?? 0);
                                    $toplam_net = $turkce_net + $matematik_net + $fen_net + $inkilap_net + $yabancidil_net + $din_net;
                                ?>
                                <tr>
                                    <!-- Tablo doldurma -->
                                    <td>
                                        <strong><?php echo htmlspecialchars($exam['exam_name']); ?></strong>
                                    </td>
                                    <td><?php echo date('d.m.Y', strtotime($exam['exam_date'])); ?></td>
                                    <td class="net-score <?php echo getNetClass($turkce_net); ?>">
                                        <?php echo number_format($turkce_net, 2); ?>
                                    </td>
                                    <td class="net-score <?php echo getNetClass($matematik_net); ?>">
                                        <?php echo number_format($matematik_net, 2); ?>
                                    </td>
                                    <td class="net-score <?php echo getNetClass($fen_net); ?>">
                                        <?php echo number_format($fen_net, 2); ?>
                                    </td>
                                    <td class="net-score <?php echo getNetClass($inkilap_net); ?>">
                                        <?php echo number_format($inkilap_net, 2); ?>
                                    </td>
                                    <td class="net-score <?php echo getNetClass($yabancidil_net); ?>">
                                        <?php echo number_format($yabancidil_net, 2); ?>
                                    </td>
                                    <td class="net-score <?php echo getNetClass($din_net); ?>">
                                        <?php echo number_format($din_net, 2); ?>
                                    </td>
                                    <td class="net-score <?php echo getNetClass($toplam_net); ?>">
                                        <strong><?php echo number_format($toplam_net, 2); ?></strong>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="view_exam.php?id=<?php echo $exam['id']; ?>" 
                                               class="btn btn-sm btn-outline-primary me-2" 
                                               title="Görüntüle">
                                                <i class="bi bi-eye"></i> Görüntüle
                                            </a>
                                            <a href="edit_exam.php?id=<?php echo $exam['id']; ?>" 
                                               class="btn btn-sm btn-outline-warning me-2" 
                                               title="Düzenle">
                                                <i class="bi bi-pencil"></i> Düzenle
                                            </a>
                                            <a href="delete_exam.php?id=<?php echo $exam['id']; ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               title="Sil">
                                                <i class="bi bi-trash"></i> Sil
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <!-- Hiç sınav yoksa -->
            <div class="card">
                <div class="card-body text-center py-5">
                    <h5 class="card-title">Henüz sınav eklenmemiş</h5>
                    <p class="card-text text-muted">İlk sınavını ekleyerek başla!</p>
                    <a href="add_exam.php" class="btn btn-primary">İlk Sınavını Ekle</a>
                </div>
            </div>
        <?php endif; ?>

        <!-- Genel İstatistikler bölümü -->
        <?php if ($total_exams > 0): ?>
        <div class="row mt-5">
            <div class="col-md-12">
                <h5>Genel İstatistikler</h5>
            </div>
            
            <?php 
            // Ortalama netleri hesapla (tüm dersler için)
            $avg_turkce = 0; $avg_matematik = 0; $avg_fen = 0; 
            $avg_inkilap = 0; $avg_yabancidil = 0; $avg_din = 0;
            
            if ($total_exams > 0) {
                foreach ($exams as $exam) {
                    $avg_turkce += calculateNet($exam['turkce_dogru'] ?? 0, $exam['turkce_yanlis'] ?? 0);
                    $avg_matematik += calculateNet($exam['matematik_dogru'] ?? 0, $exam['matematik_yanlis'] ?? 0);
                    $avg_fen += calculateNet($exam['fen_dogru'] ?? 0, $exam['fen_yanlis'] ?? 0);
                    $avg_inkilap += calculateNet($exam['inkilap_dogru'] ?? 0, $exam['inkilap_yanlis'] ?? 0);
                    $avg_yabancidil += calculateNet($exam['yabancidil_dogru'] ?? 0, $exam['yabancidil_yanlis'] ?? 0);
                    $avg_din += calculateNet($exam['din_dogru'] ?? 0, $exam['din_yanlis'] ?? 0);
                }
                
                $avg_turkce /= $total_exams;
                $avg_matematik /= $total_exams;
                $avg_fen /= $total_exams;
                $avg_inkilap /= $total_exams;
                $avg_yabancidil /= $total_exams;
                $avg_din /= $total_exams;
                $avg_toplam = $avg_turkce + $avg_matematik + $avg_fen + $avg_inkilap + $avg_yabancidil + $avg_din;
            }
            ?>
            <!-- Ortalama netlerin istatistik kartları -->
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body subject-card bg-primary text-white">
                        <h6 class="card-title ">Ortalama Türkçe Net</h6>
                        <p class="card-text h5 <?php echo $avg_turkce; ?>">
                            <?php echo number_format($avg_turkce, 2); ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body subject-card bg-success text-white">
                        <h6 class="card-title">Ortalama Matematik Net</h6>
                        <p class="card-text h5 <?php echo $avg_matematik; ?>">
                            <?php echo number_format($avg_matematik, 2); ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body subject-card bg-info text-white">
                        <h6 class="card-title">Ortalama Fen Net</h6>
                        <p class="card-text h5 <?php echo $avg_fen; ?>">
                            <?php echo number_format($avg_fen, 2); ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body subject-card bg-warning text-white">
                        <h6 class="card-title">Ortalama İnkılap Net</h6>
                        <p class="card-text h5 <?php echo $avg_inkilap; ?>">
                            <?php echo number_format($avg_inkilap, 2); ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body subject-card bg-danger text-white">
                        <h6 class="card-title">Ortalama Yabancı Dil Net</h6>
                        <p class="card-text h5 <?php echo $avg_yabancidil; ?>">
                            <?php echo number_format($avg_yabancidil, 2); ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body subject-card bg-secondary text-white">
                        <h6 class="card-title">Ortalama Din Kültürü Net</h6>
                        <p class="card-text h5 <?php echo $avg_din; ?>">
                            <?php echo number_format($avg_din, 2); ?>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-3 mb-3">
                <div class="card text-center">
                    <div class="card-body subject-card bg-dark text-white">
                        <h6 class="card-title">Ortalama Toplam Net</h6>
                        <p class="card-text h5 <?php echo $avg_toplam; ?>">
                            <strong><?php echo number_format($avg_toplam, 2); ?></strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
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
</body>
</html>