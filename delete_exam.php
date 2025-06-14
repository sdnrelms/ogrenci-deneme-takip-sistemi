<?php
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit;
}

// Eğer silme işlemi onaylandıysa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    $exam_id = $_POST['exam_id'] ?? 0;
    
    // Sınavın kullanıcıya ait olduğunu kontrol et
    $stmt = $pdo->prepare("SELECT id FROM exams WHERE id = ? AND user_id = ?");
    $stmt->execute([$exam_id, $_SESSION['user_id']]);
    $exam = $stmt->fetch();

    // Eğer sınav varsa silme yaplır olası bi hata durumunda uyarı verilir, kullanıcı ana sayfaya yönlendirilir
    if ($exam) {
        try {
            $stmt = $pdo->prepare("DELETE FROM exams WHERE id = ?");
            $stmt->execute([$exam_id]);
            $_SESSION['success_message'] = 'Sınav kaydı başarıyla silindi.';
            redirect('dashboard.php');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error_message'] = 'Sınav silinirken bir hata oluştu: ' . $e->getMessage();
            redirect('dashboard.php');
            exit;
        }
    } else {
        $_SESSION['error_message'] = 'Geçersiz sınav ID veya yetkisiz işlem.';
        redirect('dashboard.php');
        exit;
    }
}

// Eğer GET ile gelindiyse, onay sayfasını göster
$exam_id = $_GET['id'] ?? 0;

// Sınav bilgilerini al
$stmt = $pdo->prepare("SELECT exam_name, exam_date FROM exams WHERE id = ? AND user_id = ?");
$stmt->execute([$exam_id, $_SESSION['user_id']]);
$exam = $stmt->fetch();

if (!$exam) {
    $_SESSION['error_message'] = 'Sınav bulunamadı veya silme yetkiniz yok.';
    redirect('dashboard.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Sınav Silme Onayı - Öğrenci Deneme Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <!-- Silme ekranı kart olarak kullanıcıya gösterilir (sınav adı, tarihi verilir ve onay istenir) -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-danger text-white">
                        <h4>Sınav Silme</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Sınav Adı:</strong> <?= htmlspecialchars($exam['exam_name']) ?></p>
                        <p><strong>Sınav Tarihi:</strong> <?= htmlspecialchars($exam['exam_date']) ?></p>
                        <p class="text-danger">Bu sınav kaydını silmek istediğinizden emin misiniz? Bu işlem geri alınamaz!</p>
                        
                        <form method="post">
                            <input type="hidden" name="exam_id" value="<?= $exam_id ?>">
                            <button type="submit" name="confirm_delete" class="btn btn-danger">Evet, Sil</button>
                            <a href="dashboard.php" class="btn btn-secondary">İptal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>