# Yapay Zeka Promptları
###### Yardım alınan uygulamalar: DeepSeek, ChatGPT, Claude

## Prompt 1

```
<?php
require_once 'config.php';

$loggedIn = isLoggedIn();
$user = $loggedIn ? getUser($pdo, $_SESSION['user_id']) : null;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Öğrenci Deneme Takip Sistemi</title>
</head>
<body>
    <h1>Öğrenci Takip Sistemi</h1>
    <p>Deneme sınavı sonuçlarınızı takip edin ve performansınızı analiz edin!</p>
    <p>Matematik, Türkçe, Sosyal, Fen Bilimleri ve diğer derslerden aldığınız sınav sonuçlarını kaydedin.</p>
    <h5>Yeni Hesap</h5>
    <p>Henüz hesabınız yok mu? Hemen kayıt olun ve sınav sonuçlarınızı takip etmeye başlayın.</p>
    <a href="register.php">Kayıt Ol</a>
    <h5>Giriş Yap</h5>
    <p>Mevcut hesabınızla giriş yapın ve sınav sonuçlarınızı görüntüleyin.</p>
    <a href="login.php">Giriş Yap</a>
    <h5>Sistem Özellikleri</h5>
    <ul>
        <li>Sınav sonuçlarını kaydetme</li>
        <li>Ders bazında performans takibi</li>
        <li>Doğru/Yanlış/Boş analizi</li>
    </ul>
</body>
</html>
``` 

- boyle bi index.php m var ve ben bunun guzel gorunmesi için bootstraple yenıden duzenlensin istiyorum nasıl yapabilrm yardımcı olur musun

---

 Tabii ki Sudenur! Aşağıda, mevcut index.php dosyanı Bootstrap 5 kullanarak daha modern ve şık bir hale getirdim. Sade, okunabilir ve mobil uyumlu bir tasarım oluşturmaya çalıştım:

✅ Güncellenmiş index.php (Bootstrap 5 ile):
```
<?php
require_once 'config.php';

$loggedIn = isLoggedIn();
$user = $loggedIn ? getUser($pdo, $_SESSION['user_id']) : null;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Öğrenci Deneme Takip Sistemi</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center mb-4">
            <h1 class="display-5">📚 Öğrenci Takip Sistemi</h1>
            <p class="lead">Deneme sınavı sonuçlarınızı takip edin ve performansınızı analiz edin!</p>
        </div>

        <div class="row g-4">
            <!-- Özellik Kartı -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Sistem Özellikleri</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">✅ Sınav sonuçlarını kaydetme</li>
                            <li class="list-group-item">📊 Ders bazında performans takibi</li>
                            <li class="list-group-item">📈 Doğru / Yanlış / Boş analizi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kayıt ve Giriş Kartı -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Başlayın</h5>
                        <?php if ($loggedIn): ?>
                            <p class="text-success">Merhaba, <strong><?= htmlspecialchars($user['username']) ?></strong>! Sisteme giriş yaptınız.</p>
                            <a href="dashboard.php" class="btn btn-primary">Panel'e Git</a>
                        <?php else: ?>
                            <p>Hesabınız yok mu? Hemen kayıt olun ve sınav sonuçlarınızı takip etmeye başlayın.</p>
                            <a href="register.php" class="btn btn-success me-2">Kayıt Ol</a>
                            <hr>
                            <p>Zaten hesabınız var mı? Giriş yapın.</p>
                            <a href="login.php" class="btn btn-outline-primary">Giriş Yap</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opsiyonel) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

```
💡 Notlar:
Bootstrap ile uyumlu, kutulu (card) yapı kullandım.

Mobil cihazlarda da iyi görünmesi için container, row, col-md-6 gibi grid sınıfları kullandım.

Giriş yapmış kullanıcılar için ekstra bir "Panel'e Git" butonu koydum. (Veya bunu isteğine göre kaldırabiliriz.)

İstersen ilerleyen aşamalarda navbar, footer ya da grafiklerle görselleştirme gibi bölümleri de ekleyebiliriz. Tasarımı daha da zenginleştirmek istersen, haber ver yeter 🌟


## Prompt 2

```
<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = trim($_POST['full_name']);
    
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'Tüm alanları doldurunuz.';
    } elseif (strlen($username) < 3) {
        $error = 'Kullanıcı adı en az 3 karakter olmalıdır.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Geçerli bir e-posta adresi giriniz.';
    } elseif (strlen($password) < 6) {
        $error = 'Şifre en az 6 karakter olmalıdır.';
    } elseif ($password !== $confirm_password) {
        $error = 'Şifreler eşleşmiyor.';
    } else {
        try {
            // Kullanıcı adı ve e-posta kontrolü
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            
            if ($stmt->fetch()) {
                $error = 'Bu kullanıcı adı veya e-posta zaten kullanılıyor.';
            } else {
                // Şifreyi hash'le
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Kullanıcıyı kaydet
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
    <h4>Yeni Hesap Oluştur</h4>       
    <?php if ($success): ?>
    <a href="login.php">Giriş Yap</a>
    <?php else: 
        <form method="POST">
            <div>
                <label for="full_name">Ad Soyad</label>
                <input type="text" id="full_name" name="full_name" 
                       value="<?php echo htmlspecialchars($_POST['full_name'] ?? ''); ?>" required>
            </div>

            <div>
                <label for="username">Kullanıcı Adı</label>
                <input type="text" id="username" name="username" 
                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>" required>
            </div>

            <div>
                <label for="email">E-posta</label>
                <input type="email"  id="email" name="email" 
                       value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
            </div>

            <div>
                <label for="password">Şifre</label>
                <input type="password"  id="password" name="password" required>
            </div>

            <div>
                <label for="confirm_password" >Şifre Tekrar</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>

            <div>
                <button type="submit">Kayıt Ol</button>
            </div>
        </form>
    <?php endif; ?> 
    <p>
        Zaten hesabınız var mı? 
        <a href="login.php">Giriş yapın</a>
    </p>
      

```
- bi de boyle bi register.php'im var bunu da aynı sekilde index.phpyle uyumlu bootstraple yazar msın tekrardan sadece gorunumu guncelle ama

---

 Elbette Sudenur! Aşağıda register.php dosyanı Bootstrap 5 kullanarak şık ve kullanıcı dostu bir şekilde yeniden düzenledim. Form alanlarını form-control, mesajları ise alert sınıfı ile stilize ettim. Ayrıca kutuları ortaladım ve okunabilirliğe önem verdim.

✅ Güncellenmiş register.php (Bootstrap 5 ile):

```
<?php
require_once 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $full_name = trim($_POST['full_name']);
    
    if (empty($username) || empty($email) || empty($password) || empty($full_name)) {
        $error = 'Tüm alanları doldurunuz.';
    } elseif (strlen($username) < 3) {
        $error = 'Kullanıcı adı en az 3 karakter olmalıdır.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Geçerli bir e-posta adresi giriniz.';
    } elseif (strlen($password) < 6) {
        $error = 'Şifre en az 6 karakter olmalıdır.';
    } elseif ($password !== $confirm_password) {
        $error = 'Şifreler eşleşmiyor.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $email]);
            
            if ($stmt->fetch()) {
                $error = 'Bu kullanıcı adı veya e-posta zaten kullanılıyor.';
            } else {
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
    <title>Kayıt Ol - Öğrenci Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Yeni Hesap Oluştur</h3>

                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php elseif ($success): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                        <div class="text-center mt-3">
                            <a href="login.php" class="btn btn-success">Giriş Yap</a>
                        </div>
                    <?php else: ?>
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
                                <button type="submit" class="btn btn-primary">Kayıt Ol</button>
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

</body>
</html>

```

🎯 Ek Notlar:
Formu card içerisine aldım ve ortaladım.

alert kutuları hata ve başarı mesajlarını güzelce gösteriyor.

Bootstrap form bileşenleri ile mobil uyumlu ve profesyonel bir arayüz elde ettik.

Eğer dilersen renkleri ya da ikonları da özelleştirebiliriz (örn: Font Awesome desteği).

İstersen bir sonraki adımda login.php dosyasını da aynı şıklıkta düzenleyebiliriz. Yardımcı olmamı ister misin?


## Prompt 3

```
<?php
require_once 'config.php';


// İstatistikler
$stmt = $pdo->prepare("SELECT COUNT(*) as total_exams FROM exams WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total_exams = $stmt->fetch()['total_exams'];



// Ortalama net hesaplama fonksiyonu
function calculateNet($dogru, $yanlis) {
    return $dogru - ($yanlis * 0.25);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Öğrenci Deneme Takip Sistemi</title>
    
</head>
<body>
    <!-- Navbar -->
    <nav >
            <a href="dashboard.php">
                 Öğrenci Takip Sistemi
            </a>
                <ul >
                    <li >
                        <a  href="dashboard.php">
                            Ana Sayfa
                        </a>
                    </li>
                    <li >
                        <a  href="add_exam.php">
                            Sınav Ekle
                        </a>
                    </li>
                    <li >
                        <a href="list_exams.php">
                             Sınavlarım
                        </a>
                    </li>
                </ul>
                <ul >
                    <li >
                        <ul >
                            <li><a  href="logout.php">
                                 Çıkış Yap
                            </a></li>
                        </ul>
                    </li>
                </ul>
           
    </nav>


        <!-- Hoş geldin mesajı -->
        
                    <h4> Hoş geldin, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h4>
                    <p >Deneme sınavlarını takip etmek için sınavlarını ekleyebilir ve performansını analiz edebilirsin.</p>
          


        
                      
                        <h3><?php echo $total_exams; ?></h3>
                        <p >Toplam Sınav</p>
              
            
        

        <!-- Hızlı işlemler -->
        
                        <h5> Hızlı İşlemler</h5>
                    
                    
                            <div >
                                <a href="add_exam.php" >
                                    Yeni Sınav Ekle
                                </a>
                            </div>
                            <div >
                                <a href="list_exams.php" >
                                    Tüm Sınavları Görüntüle
                                </a>
                            </div>
                            
                    
        <!-- Son sınavlar -->
        <?php if ($recent_exams): ?>
       
                        <h5> Son Sınavlar</h5>
                   
                                <thead>
                                    <tr>
                                        <th>Sınav Adı</th>
                                        <th>Tarih</th>
                                        <th>Türkçe Net</th>
                                        <th>Matematik Net</th>
                                        <th>Fen Net</th>
                                        <th>İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_exams as $exam): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($exam['exam_name']); ?></td>
                                        <td><?php echo date('d.m.Y', strtotime($exam['exam_date'])); ?></td>
                                        <td>
                                            <span >
                                                <?php echo number_format(calculateNet($exam['turkce_dogru'], $exam['turkce_yanlis']), 2); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span >
                                                <?php echo number_format(calculateNet($exam['matematik_dogru'], $exam['matematik_yanlis']), 2); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span >
                                                <?php echo number_format(calculateNet($exam['fen_dogru'], $exam['fen_yanlis']), 2); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="view_exam.php?id=<?php echo $exam['id']; ?>" >
                                                Görüntüle
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>a<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT COUNT(*) as total_exams FROM exams WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total_exams = $stmt->fetch()['total_exams'];

$stmt = $pdo->prepare("SELECT * FROM exams WHERE user_id = ? ORDER BY exam_date DESC LIMIT 5");
$stmt->execute([$_SESSION['user_id']]);
$recent_exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

function calculateNet($dogru, $yanlis) {
    return $dogru - ($yanlis * 0.25);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Öğrenci Deneme Takip Sistemi</title>
</head>
<body>
    <nav>
        <a href="dashboard.php">Öğrenci Takip Sistemi</a>
        <ul>
            <li><a href="dashboard.php">Ana Sayfa</a></li>
            <li><a href="add_exam.php">Sınav Ekle</a></li>
            <li><a href="list_exams.php">Sınavlarım</a></li>
        </ul>
        <ul>
            <li><a href="logout.php">Çıkış Yap</a></li>
        </ul>
    </nav>

    <div>
        <h4>Hoş geldin, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h4>
        <p>Deneme sınavlarını takip etmek için sınavlarını ekleyebilir ve performansını analiz edebilirsin.</p>
    </div>

    <div>
        <h3><?php echo $total_exams; ?></h3>
        <p>Toplam Sınav</p>
    </div>

    <div>
        <h5>Hızlı İşlemler</h5>
        <div>
            <a href="add_exam.php">Yeni Sınav Ekle</a>
        </div>
        <div>
            <a href="list_exams.php">Tüm Sınavları Görüntüle</a>
        </div>
    </div>

    <?php if ($recent_exams): ?>
        <div>
            <h5>Son Sınavlar</h5>
            <table>
                <thead>
                    <tr>
                        <th>Sınav Adı</th>
                        <th>Tarih</th>
                        <th>Türkçe Net</th>
                        <th>Matematik Net</th>
                        <th>Fen Net</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_exams as $exam): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($exam['exam_name']); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($exam['exam_date'])); ?></td>
                        <td><?php echo number_format(calculateNet($exam['turkce_dogru'], $exam['turkce_yanlis']), 2); ?></td>
                        <td><?php echo number_format(calculateNet($exam['matematik_dogru'], $exam['matematik_yanlis']), 2); ?></td>
                        <td><?php echo number_format(calculateNet($exam['fen_dogru'], $exam['fen_yanlis']), 2); ?></td>
                        <td><a href="view_exam.php?id=<?php echo $exam['id']; ?>">Görüntüle</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="list_exams.php">Tümünü Görüntüle</a>
        </div>
    <?php else: ?>
        <div>
            <h5>Henüz sınav eklenmemiş</h5>
            <p>İlk sınavını ekleyerek başla!</p>
            <a href="add_exam.php">İlk Sınavını Ekle</a>
        </div>
    <?php endif; ?>
</body>
</html>
                      
                            <a href="list_exams.php" >
                                Tümünü Görüntüle 
                            </a>
                  
        <?php else: ?>
        
                        <h5>Henüz sınav eklenmemiş</h5>
                        <p >İlk sınavını ekleyerek başla!</p>
                        <a href="add_exam.php" > İlk Sınavını Ekle</a>
        
        <?php endif; ?>
    
</body>
</html>

```
- evet bunu da aynı sekilde bootstraple yazar mısın
---

 Aşağıda, verdiğin PHP tabanlı dashboard sayfasının Bootstrap 5 ile yeniden yazılmış, düzenli ve responsive hale getirilmiş versiyonu yer alıyor. Bu sürüm, navbar, hoş geldin mesajı, toplam sınav kartı, hızlı işlemler ve son sınavlar tablolarını şık şekilde sunar:

✅ dashboard.php (Bootstrap 5 ile)>

```
<?php
require_once 'config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$stmt = $pdo->prepare("SELECT COUNT(*) as total_exams FROM exams WHERE user_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$total_exams = $stmt->fetch()['total_exams'];

$stmt = $pdo->prepare("SELECT * FROM exams WHERE user_id = ? ORDER BY exam_date DESC LIMIT 5");
$stmt->execute([$_SESSION['user_id']]);
$recent_exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

function calculateNet($dogru, $yanlis) {
    return $dogru - ($yanlis * 0.25);
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Öğrenci Deneme Takip Sistemi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="dashboard.php">Öğrenci Takip Sistemi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link active" href="dashboard.php">Ana Sayfa</a></li>
        <li class="nav-item"><a class="nav-link" href="add_exam.php">Sınav Ekle</a></li>
        <li class="nav-item"><a class="nav-link" href="list_exams.php">Sınavlarım</a></li>
      </ul>
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Çıkış Yap</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- İçerik -->
<div class="container my-5">

    <!-- Hoş geldin mesajı -->
    <div class="mb-4">
        <h4>Hoş geldin, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h4>
        <p>Deneme sınavlarını takip etmek için sınavlarını ekleyebilir ve performansını analiz edebilirsin.</p>
    </div>

    <!-- Kartlar -->
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $total_exams; ?></h5>
                    <p class="card-text">Toplam Sınav</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <a href="add_exam.php" class="btn btn-success w-100 mb-3">Yeni Sınav Ekle</a>
        </div>
        <div class="col-md-4">
            <a href="list_exams.php" class="btn btn-secondary w-100 mb-3">Tüm Sınavları Görüntüle</a>
        </div>
    </div>

    <!-- Son Sınavlar -->
    <?php if ($recent_exams): ?>
    <div class="card">
        <div class="card-header bg-dark text-white">
            Son Sınavlar
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sınav Adı</th>
                        <th>Tarih</th>
                        <th>Türkçe Net</th>
                        <th>Matematik Net</th>
                        <th>Fen Net</th>
                        <th>İşlem</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_exams as $exam): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($exam['exam_name']); ?></td>
                        <td><?php echo date('d.m.Y', strtotime($exam['exam_date'])); ?></td>
                        <td><?php echo number_format(calculateNet($exam['turkce_dogru'], $exam['turkce_yanlis']), 2); ?></td>
                        <td><?php echo number_format(calculateNet($exam['matematik_dogru'], $exam['matematik_yanlis']), 2); ?></td>
                        <td><?php echo number_format(calculateNet($exam['fen_dogru'], $exam['fen_yanlis']), 2); ?></td>
                        <td><a href="view_exam.php?id=<?php echo $exam['id']; ?>" class="btn btn-sm btn-outline-primary">Görüntüle</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="card-footer text-end">
            <a href="list_exams.php" class="btn btn-sm btn-outline-secondary">Tümünü Görüntüle</a>
        </div>
    </div>
    <?php else: ?>
    <div class="alert alert-warning mt-4" role="alert">
        Henüz sınav eklenmemiş. <a href="add_exam.php" class="alert-link">İlk sınavını eklemek için buraya tıkla</a>.
    </div>
    <?php endif; ?>
</div>

<!-- Bootstrap JS (Opsiyonel - dropdown vb. için gerekli) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

```
📌 Açıklamalar:
Bootstrap'in Navbar, Card, Table, Button bileşenleri kullanıldı.

Responsive (mobil uyumlu) yapı sağlandı.

alert, table, btn, card gibi Bootstrap sınıfları düzenli görünüm sağlar.

Gerekirse Bootstrap renkleri (bg-primary, text-white, btn-outline-*) ihtiyacına göre değiştirilebilir.

İstersen sayfayı daha modern bir görünüme taşımak için grafik istatistik, chart.js, ikonlar da ekleyebiliriz. Yardımcı olmamı ister misin?

## Prompt 4

```
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

// Son 5 sınavı al (tarihe göre sıralanmış)
$stmt = $pdo->prepare("SELECT * FROM exams WHERE user_id = ? ORDER BY exam_date DESC LIMIT 5");
$stmt->execute([$user_id]);
$recent_exams = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Öğrenci Takip Sistemi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_exam.php">Sınav Ekle</a></li>
                    <li class="nav-item"><a class="nav-link" href="list_exams.php">Sınavlarım</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="mb-4">
            <h4>Hoş geldin, <?php echo htmlspecialchars($_SESSION['full_name']); ?>!</h4>
            <p>Deneme sınavlarını takip etmek için sınavlarını ekleyebilir ve performansını analiz edebilirsin.</p>
        </div>

        <div class="row text-center mb-4">
            <div class="col-md-4 offset-md-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h3 class="card-title"><?php echo $total_exams; ?></h3>
                        <p class="card-text">Toplam Sınav</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-4">
            <h5>Hızlı İşlemler</h5>
            <div class="d-flex gap-3">
                <a href="add_exam.php" class="btn btn-primary">Yeni Sınav Ekle</a>
                <a href="list_exams.php" class="btn btn-success">Tüm Sınavları Görüntüle</a>
            </div>
        </div>

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
                            <th>İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_exams as $exam): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($exam['exam_name']); ?></td>
                            <td><?php echo date('d.m.Y', strtotime($exam['exam_date'])); ?></td>
                            <td><?php echo number_format(calculateNet($exam['turkce_dogru'], $exam['turkce_yanlis']), 2); ?></td>
                            <td><?php echo number_format(calculateNet($exam['matematik_dogru'], $exam['matematik_yanlis']), 2); ?></td>
                            <td><?php echo number_format(calculateNet($exam['fen_dogru'], $exam['fen_yanlis']), 2); ?></td>
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
            <!-- <a class="btn btn-link" href="list_exams.php">Tümünü Görüntüle</a> -->
        </div>
        <?php else: ?>
        <div class="alert alert-info mt-5">
            <h5>Henüz sınav eklenmemiş</h5>
            <p>İlk sınavını ekleyerek başla!</p>
            <a class="btn btn-success" href="add_exam.php">İlk Sınavını Ekle</a>
        </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

```
- bu sayfayı biraz daha goze hıtap edecek sekilde yapmak istiyorum nasıl daha guzel seyler ekleyebilirlm

---

Sudenur, bu dashboard sayfan zaten fonksiyonel ve oldukça temiz yazılmış 🌟 Ama göze daha çok hitap etmesi için bazı modern tasarım dokunuşları ve görsel iyileştirmeler ekleyebiliriz. Aşağıda sana adım adım öneriler veriyorum:

🎨 1. Arka Plan ve Renk Paleti
Sayfanın genel havasını değiştirmek için açık renkli bir arka plan ve soft renkler kullanabilirsin:

```
body {
    background-color: #f4f6f9;
}
.card {
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

Bu tarzları doğrudan <style> etiketiyle <head> kısmına ekleyebilirsin.
```
🧑‍🎓 2. Kullanıcı Karşılama Kartı
Kullanıcı adını gösterdiğin kısmı bir kart haline getirip ikon ve daha görsel bir yapı ekleyebilirsin:


```
<div class="card bg-white p-4 mb-4 shadow-sm">
  <div class="d-flex align-items-center">
    <i class="bi bi-person-circle text-primary fs-1 me-3"></i>
    <div>
      <h4 class="mb-1">Hoş geldin, <?php echo htmlspecialchars($_SESSION['full_name']); ?> 👋</h4>
      <p class="mb-0 text-muted">Deneme sınavlarını ekleyerek gelişimini takip edebilirsin.</p>
    </div>
  </div>
</div>

```
📊 3. Toplam Sınav Sayısı Kartı
Bu kartın içine ikon ekleyebilir ve rengi biraz vurgulayabilirsin:

```
<div class="card text-white bg-primary">
  <div class="card-body">
    <h3 class="card-title"><?php echo $total_exams; ?></h3>
    <p class="card-text">Toplam Sınav</p>
    <i class="bi bi-bar-chart-fill fs-3"></i>
  </div>
</div>
```
⚡ 4. Hızlı İşlemler Butonlarını Kart İçine Al
Butonları sade bir kart içine alırsan, kullanıcı için daha hoş bir alan oluşturursun:

```
<div class="card bg-white shadow-sm p-3 mb-4">
    <h5>Hızlı İşlemler</h5>
    <div class="d-flex gap-3 mt-3">
        <a href="add_exam.php" class="btn btn-outline-primary"><i class="bi bi-plus-circle"></i> Yeni Sınav Ekle</a>
        <a href="list_exams.php" class="btn btn-outline-success"><i class="bi bi-list-ul"></i> Tüm Sınavları Gör</a>
    </div>
</div>
```
📈 5. Son Sınavlar Tablosu için Hover ve Satır Vurgusu
Tablonun görünümünü güzelleştirmek için table-hover, table-striped, rounded, shadow-sm sınıflarını ekleyebilirsin:

```
<table class="table table-hover table-striped rounded shadow-sm">
```
Ve tabloda boşluklar için padding ve simgelerle işlem sütununu zenginleştirebilirsin.

✅ 6. İşlem Sütunu Daha Modern Hale Getir

```
<td class="text-center">
  <a class="btn btn-sm btn-outline-primary me-1" href="view_exam.php?id=<?php echo $exam['id']; ?>" title="Görüntüle"><i class="bi bi-eye"></i></a>
  <a class="btn btn-sm btn-outline-warning me-1" href="edit_exam.php?id=<?php echo $exam['id']; ?>" title="Düzenle"><i class="bi bi-pencil"></i></a>
  <a class="btn btn-sm btn-outline-danger" href="delete_exam.php?id=<?php echo $exam['id']; ?>" title="Sil"><i class="bi bi-trash"></i></a>
</td>
```
📱 7. Mobil Uyum için Duyarlı Tasarımı Geliştir
Zaten Bootstrap kullanıyorsun ama butonların ve tabloların küçük ekranlarda daralmasını önlemek için table-responsive gibi sınıfları da yerinde kullanıyorsun, bu iyi 👍 İstersen grid sistemini daha sık kullanabilirsin:


```
<div class="row">
  <div class="col-md-6 col-lg-4 mb-3"> ... </div>
</div>
```
🎁 8. Ekstra Bonus: Grafik Ekleme (Opsiyonel)
Eğer veri analizini daha görsel yapmak istersen Chart.js ile toplam net ortalamalarını pasta veya çubuk grafikle gösterebilirsin. İstersen örnek grafik kodu da hazırlayabilirim.

İstersen tüm bu stilleri ve kodları senin için entegre bir hale getirip tek bir .php dosyası şeklinde sunabilirim. Veya bu tasarımı dark mode destekli hale de getirebiliriz.

Hazırsan, hangi temada devam etmek istersin? 🎨✨


## Prompt 5

```
<?php
require_once 'config.php';

$loggedIn = isLoggedIn();
$user = $loggedIn ? getUser($pdo, $_SESSION['user_id']) : null;
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Öğrenci Deneme Takip Sistemi</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="text-center mb-4">
            <h1 class="display-5">📚 Öğrenci Takip Sistemi</h1>
            <p class="lead">Deneme sınavı sonuçlarınızı takip edin ve performansınızı analiz edin!</p>
        </div>

        <div class="row g-4">
            <!-- Özellik Kartı -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Sistem Özellikleri</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">✅ Sınav sonuçlarını kaydetme</li>
                            <li class="list-group-item">📊 Ders bazında performans takibi</li>
                            <li class="list-group-item">📈 Doğru / Yanlış / Boş analizi</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kayıt ve Giriş Kartı -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Başlayın</h5>
                        <?php if ($loggedIn): ?>
                            <p class="text-success">Merhaba, <strong><?= htmlspecialchars($user['username']) ?></strong>! Sisteme giriş yaptınız.</p>
                            <a href="dashboard.php" class="btn btn-primary">Panel'e Git</a>
                            <a href="logout.php" class="btn btn-primary">Çıkış Yapın</a>
                        <?php else: ?>
                            <p>Hesabınız yok mu? Hemen kayıt olun ve sınav sonuçlarınızı takip etmeye başlayın.</p>
                            <a href="register.php" class="btn btn-success me-2">Kayıt Ol</a>
                            <hr>
                            <p>Zaten hesabınız var mı? Giriş yapın.</p>
                            <a href="login.php" class="btn btn-outline-primary">Giriş Yap</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS (opsiyonel) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

- bu benim ogrenci deneme takip sistemimin ana sayfası bunu biraz daha goze hıtap eder bi sekilde yapmak istiiyorum sence daha neler ekleyebilirim ya da nasıl guzellestırebilirlm

---

Öğrenci Deneme Takip Sistemi Geliştirme Önerileri
Mevcut tasarımınız zaten temel işlevselliği sağlıyor, ancak daha çekici ve kullanıcı dostu hale getirmek için şu önerileri yapabilirim:

Tasarım İyileştirmeleri
Modern Renk Paleti:

Eğitim temasına uygun mavi, yeşil tonları ekleyin

Gradyan arka planlar veya kartlar kullanabilirsiniz

Görsel Öğeler:

Öğrenci temalı illüstrasyonlar veya ikonlar ekleyin

Animasyonlu geçişler (hover efektleri, fade-in gibi)

Düzen ve Boşluklar:

Kartlara daha fazla padding ekleyerek daha ferah görünmesini sağlayın

Responsive tasarımı geliştirin (mobil uyumluluk)

İşlevsel Geliştirmeler
Örnek Ekran Görüntüleri:

Dashboard'dan küçük önizlemeler gösterin

Sistemin nasıl çalıştığını gösteren bir carousel ekleyin

Hızlı İstatistikler:

"X öğrenci şimdiden kayıt oldu" gibi bir bilgi ekleyin

Sistemdeki toplam deneme sayısını gösterebilirsiniz

Sosyal Kanıt:

Kullanıcı yorumları/testimonials bölümü ekleyin

Güven sembolleri (güvenli giriş, veri koruma vb.)

Örnek Kod Güncellemesi


```
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Deneme Takip Sistemi</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #4cc9f0;
        }
        
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 100vh;
        }
        
        .hero-section {
            background: url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center;
            background-size: cover;
            padding: 5rem 0;
            position: relative;
            color: white;
        }
        
        .hero-section::before {
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
            color: var(--primary-color);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary {
            color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-outline-primary:hover {
            background-color: var(--primary-color);
        }
    </style>
</head>
<body>
    <!-- Hero Section -->
    <section class="hero-section text-center mb-5">
        <div class="container position-relative">
            <h1 class="display-4 fw-bold mb-3">📊 Öğrenci Takip Sistemi</h1>
            <p class="lead mb-4">Deneme sınavı sonuçlarınızı takip edin, performansınızı analiz edin ve başarınızı artırın!</p>
            <?php if (!$loggedIn): ?>
                <a href="register.php" class="btn btn-primary btn-lg px-4 me-2">Ücretsiz Kayıt Ol</a>
                <a href="login.php" class="btn btn-outline-light btn-lg px-4">Giriş Yap</a>
            <?php endif; ?>
        </div>
    </section>

    <div class="container py-5">
        <div class="row g-4 justify-content-center">
            <!-- Özellik Kartı -->
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

            <!-- Kullanıcı İşlemleri Kartı -->
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

        <!-- Ekstra Özellikler Bölümü -->
        <div class="row mt-5">
            <div class="col-12 text-center mb-4">
                <h2 class="h1">Neden Bizim Sistemimizi Kullanmalısınız?</h2>
                <p class="lead text-muted">İşte sizi başarıya götürecek bazı özellikler</p>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body text-center">
                        <i class="fas fa-mobile-alt feature-icon text-primary"></i>
                        <h4 class="h5">Her Yerde Erişim</h4>
                        <p>Bilgisayar, tablet veya telefonunuzdan kolayca erişim sağlayın.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm p-3">
                    <div class="card-body text-center">
                        <i class="fas fa-bell feature-icon text-primary"></i>
                        <h4 class="h5">Hatırlatıcılar</h4>
                        <p>Sınav tarihleri ve çalışma programı için hatırlatıcılar alın.</p>
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

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">© 2023 Öğrenci Deneme Takip Sistemi. Tüm hakları saklıdır.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
```

Ek Öneriler
Dark Mode: Kullanıcı tercihine göre koyu tema seçeneği ekleyin

Canlı Demo: Sistemin nasıl çalıştığını gösteren interaktif bir demo ekleyin

SSS Bölümü: Sık sorulan sorular için bir bölüm oluşturun

Blog/İpuçları: Öğrenciler için çalışma ipuçları içeren bir blog bölümü

Sosyal Medya Entegrasyonu: Paylaşım butonları ve sosyal medya bağlantıları

Bu iyileştirmeler, sitenizin hem görsel çekiciliğini hem de kullanıcı deneyimini önemli ölçüde artıracaktır.


## Prompt 6

- şimdi ben sistemime bi de grafik eklemek istiyorum artık ama hangı sayfaya eklemek mantıklı olur ve ders bazında takip mi olmalı karar veremedim bana fikir verir misin

---

Grafik eklemek için en uygun sayfalar dashboard.php ve list_exams.php olacaktır. İşte detaylı öneriler:

1. Dashboard.php'ye Grafik Eklemek
Neden?

- Kullanıcılar ana sayfada özet bir performans görseli görmek ister.

- Zaman içindeki net değişimini gösteren bir çizgi grafik ekleyebilirsiniz.

- Ders bazında ortalama netleri gösteren bir pasta/bar grafik de kullanılabilir.

Önerilen Grafikler:

- Çizgi Grafik: Son 5-10 sınavın toplam netlerini tarihe göre gösterir.

- Bar Grafik: Derslere göre ortalama net karşılaştırması yapar.

- Mini İlerleme Grafiği: Önceki sınava göre artış/azalışı vurgular.

2. list_exams.php'ye Grafik Eklemek
Neden?

- Tüm sınavların listelendiği bu sayfa, detaylı analiz için idealdir.

- Kullanıcılar ders bazında veya zaman içindeki tüm verileri tek sayfada görmek isteyebilir.

Önerilen Grafikler:

- Dinamik Filtreli Grafik: Kullanıcı hangi dersin grafiğini görmek istediğini seçebilir.

- Karşılaştırmalı Grafik: İki sınavın sonuçlarını yan yana bar grafikle gösterebilir.

- Hedef Grafiği: Kullanıcının hedeflediği netlerle karşılaştıran bir grafik eklenebilir.

3. view_exam.php'ye Mini Grafik Eklemek
Neden?

- Tek bir sınavın detay sayfasında, o sınavın derslere göre dağılımını göstermek faydalı olabilir.

- Derslerin netlerini pasta grafikle veya yatay bar grafikle gösterebilirsiniz.

Önerilen Grafik:

- Pasta Grafik: Derslere göre doğru/yanlış/boş oranlarını gösterir.

- Yatay Bar Grafik: Ders netlerini karşılaştırmalı gösterir.

Grafik Kütüphanesi Önerisi
- Chart.js veya Google Charts kullanabilirsiniz.

Kolay entegre edilir ve responsive tasarım sunar.

Örnek Chart.js kodu:
```
<canvas id="myChart"></canvas>
<script>
  const ctx = document.getElementById('myChart').getContext('2d');
  new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['Sınav 1', 'Sınav 2', 'Sınav 3'],
      datasets: [{
        label: 'Toplam Net',
        data: [65, 72, 80],
        borderColor: '#4361ee'
      }]
    }
  });
</script>
```

Veri Yapısı
Grafikler için verileri şu şekilde hazırlayabilirsiniz:

```
// Örnek: Son 5 sınavın tarih ve netlerini çekme
$stmt = $pdo->prepare("SELECT exam_date, (turkce_dogru + matematik_dogru + ...) as total_net FROM exams WHERE user_id = ? ORDER BY exam_date DESC LIMIT 5");
$stmt->execute([$user_id]);
$examData = $stmt->fetchAll(PDO::FETCH_ASSOC);
```

Son Karar
Başlangıç için en mantıklı adım:

- Dashboard.php'ye basit bir çizgi grafik ekleyin (tüm sınavların toplam net trendi).

- list_exams.php'ye ders bazında filtrelenebilir bar grafik ekleyin.

- Kullanıcı geri bildirimlerine göre diğer sayfalara da yayın.

Bu şekilde kullanıcılar hem genel performansı hem de detayları görsel olarak takip edebilir.


## Prompt 7

```
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
$inkilap_net = calculateNet($exam['inkılap_dogru'], $exam['inkılap_yanlis']);
$yabancidil_net = calculateNet($exam['yabancıdil_dogru'], $exam['yabancıdil_yanlis']);
$din_net = calculateNet($exam['din_dogru'], $exam['din_yanlis']);

$total_questions = 90;
$total_correct = $exam['turkce_dogru'] + $exam['matematik_dogru'] + $exam['fen_dogru'] + $exam['inkılap_dogru'] + $exam['yabancıdil_dogru'] + $exam['din_dogru'];
$total_wrong = $exam['turkce_yanlis'] + $exam['matematik_yanlis'] + $exam['fen_yanlis'] + $exam['inkılap_yanlis'] + $exam['yabancıdil_yanlis'] + $exam['din_yanlis'];
$toplam_net = $turkce_net + $matematik_net + $fen_net + $inkilap_net + $yabancidil_net + $din_net
?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sınav Detayları - Öğrenci Deneme Takip Sistemi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top mb-4">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Öğrenci Takip Sistemi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_exam.php">Sınav Ekle</a></li>
                    <li class="nav-item"><a class="nav-link" href="list_exams.php">Sınavlarım</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>
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
                    <div class="col-md-6">
                        <p><strong>Sınav Tarihi:</strong> <?php echo date('d.m.Y', strtotime($exam['exam_date'])); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Toplam Soru:</strong> <?php echo $total_questions; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Toplam Net Sayısı:</strong> <?php echo $toplam_net; ?></p>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p><strong>Doğru Sayısı:</strong> <?php echo $total_correct; ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Yanlış Sayısı:</strong> <?php echo $total_wrong; ?></p>
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
                        <p class="mb-1"><strong>Doğru:</strong> <?php echo $exam['inkılap_dogru']; ?></p>
                        <p class="mb-1"><strong>Yanlış:</strong> <?php echo $exam['inkılap_yanlis']; ?></p>
                        <p class="mb-0"><strong>Boş:</strong> <?php echo $exam['inkılap_bos']; ?></p>
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
                        <p class="mb-1"><strong>Doğru:</strong> <?php echo $exam['yabancıdil_dogru']; ?></p>
                        <p class="mb-1"><strong>Yanlış:</strong> <?php echo $exam['yabancıdil_yanlis']; ?></p>
                        <p class="mb-0"><strong>Boş:</strong> <?php echo $exam['yabancıdil_bos']; ?></p>
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
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark text-white">
                    <h5>Ders Bazında Netler</h5>
                </div>
                <div class="card-body">
                    <canvas id="subjectNetChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    </div>

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
```

- burada grafıgı nasıl ortalarım

---

Grafiği ortalamak için Bootstrap'in grid sistemini ve CSS özelliklerini kullanabiliriz. İşte yapmanız gereken değişiklikler:

1. Grafik Kartını Ortalama

```
<div class="row mt-5">
    <div class="col-md-8 mx-auto"> <!-- mx-auto sınıfı ekleyin -->
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h5>Ders Bazında Netler</h5>
            </div>
            <div class="card-body">
                <canvas id="subjectNetChart"></canvas>
            </div>
        </div>
    </div>
</div>
```
Değişiklikler:

- col-md-12 yerine col-md-8 yaparak genişliği azalttık

- mx-auto sınıfı ekleyerek yatayda ortalanmasını sağladık (margin-left: auto; margin-right: auto)

2. Grafik Boyutunu Ayarlama

```
<div class="card-body">
    <div style="height: 400px;"> <!-- Sabit yükseklik ekleyin -->
        <canvas id="subjectNetChart"></canvas>
    </div>
</div>
```
3. Chart.js Ayarlarını Güncelleme

```
options: {
    responsive: true,
    maintainAspectRatio: false, // Oran korumasını kapat
    plugins: {
        legend: {
            position: 'top', // Açıklamaları üste al
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
```

Tam Çalışan Örnek:

```
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
```
Alternatif CSS Çözümü:
Eğer daha fazla kontrol istiyorsanız, özel CSS ekleyebilirsiniz:

```
/* Özel CSS */
.chart-container {
    width: 80%;
    margin: 0 auto;
}
.chart-wrapper {
    height: 400px;
    position: relative;
}

<div class="chart-container">
    <div class="chart-wrapper">
        <canvas id="subjectNetChart"></canvas>
    </div>
</div>
```
Neden Çalışır?
mx-auto: Bootstrap'in otomatik margin sınıfı, bloğu yatayda ortalar

col-md-8: Orta genişlikte bir sütun oluşturur (12'lik grid sisteminde)

height: 400px: Grafik için sabit bir yükseklik belirler

maintainAspectRatio: false: Grafiğin oranını korumadan verilen alana sığmasını sağlar

Bu ayarlarla grafiğiniz sayfada tam ortada, düzgün boyutlarda ve responsive olarak çalışacaktır.


## Prompt 8

```
<?php
require_once 'config.php';

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    header('Location: login.php');
    exit;
}

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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top mb-4">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Öğrenci Deneme Takip Sistemi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link active" href="add_exam.php">Sınav Ekle</a></li>
                    <li class="nav-item"><a class="nav-link" href="list_exams.php">Sınavlarım</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>
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
                            <input type="text" class="form-control" id="exam_name" name="exam_name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="exam_date" class="form-label">Sınav Tarihi</label>
                            <input type="date" class="form-control" id="exam_date" name="exam_date" required>
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
                                           min="0" max="20" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="turkce_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="turkce_yanlis" name="turkce_yanlis" 
                                           min="0" max="20" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="turkce_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="turkce_bos" name="turkce_bos" 
                                           min="0" max="20" value="0">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count">0</span>/20
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: 0.00
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
                                           min="0" max="20" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="matematik_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="matematik_yanlis" name="matematik_yanlis" 
                                           min="0" max="20" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="matematik_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="matematik_bos" name="matematik_bos" 
                                           min="0" max="20" value="0">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count">0</span>/20
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: 0.00
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
                                           min="0" max="20" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="fen_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="fen_yanlis" name="fen_yanlis" 
                                           min="0" max="20" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="fen_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="fen_bos" name="fen_bos" 
                                           min="0" max="20" value="0">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count">0</span>/20
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: 0.00
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
                                           min="0" max="10" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="inkilap_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="inkilap_yanlis" name="inkilap_yanlis" 
                                           min="0" max="10" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="inkilap_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="inkilap_bos" name="inkilap_bos" 
                                           min="0" max="10" value="0">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count">0</span>/10
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: 0.00
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
                                           min="0" max="10" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="yabancidil_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="yabancidil_yanlis" name="yabancidil_yanlis" 
                                           min="0" max="10" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="yabancidil_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="yabancidil_bos" name="yabancidil_bos" 
                                           min="0" max="10" value="0">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count">0</span>/10
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: 0.00
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
                                           min="0" max="10" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="din_yanlis" class="form-label">Yanlış Sayısı</label>
                                    <input type="number" class="form-control question-input" id="din_yanlis" name="din_yanlis" 
                                           min="0" max="10" value="0">
                                </div>
                                <div class="mb-3">
                                    <label for="din_bos" class="form-label">Boş Sayısı</label>
                                    <input type="number" class="form-control question-input" id="din_bos" name="din_bos" 
                                           min="0" max="10" value="0">
                                </div>
                                <div class="total-questions mb-2">
                                    Toplam: <span class="total-count">0</span>/10
                                </div>
                                <div class="alert alert-info p-2">
                                    Net: 0.00
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
```

- burada  kullanıcı degerleri gırıp bi derste eksik soru bırakırsa guncelleye basılca uyarı verip tum doldurma alanları sıfırlanıyor ya oyle olmasın ıstıyorum aynı sekılde uyarı versin ama tum kutucukları sıfırlamasın bunun için nereyi değiştirmeliyim

---

Sorunu anladım. Şu anda form gönderildiğinde hata oluşursa tüm alanlar sıfırlanıyor. Bunu düzeltmek için form gönderildiğinde kullanıcının girdiği değerleri korumamız gerekiyor. İşte düzenlenmiş kod:

```
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
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top mb-4">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Öğrenci Deneme Takip Sistemi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link active" href="add_exam.php">Sınav Ekle</a></li>
                    <li class="nav-item"><a class="nav-link" href="list_exams.php">Sınavlarım</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>
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
```


Yaptığım değişiklikler:

1. Form verilerini saklamak için sayfanın başında değişkenler tanımladım:


```
$exam_name = '';
$exam_date = '';
$turkce_dogru = $turkce_yanlis = $turkce_bos = 0;
// Diğer dersler için de benzer şekilde
```
2. Form gönderildiğinde bu değişkenlere POST verilerini atadım.

3. HTML input alanlarında value attribute'larını bu değişkenlerle doldurdum:


```value="<?php echo $turkce_dogru; ?>"```

4. Toplam soru sayılarını ve netleri de bu değişkenlerle hesaplayıp gösterdim:

```<span class="total-count"><?php echo $turkce_dogru + $turkce_yanlis + $turkce_bos; ?></span>```

5. JavaScript kodu aynı kaldı çünkü bu sadece kullanıcı formu doldururken anlık hesaplamalar yapıyor.

Bu değişiklikler sayesinde form gönderildiğinde hata oluşursa, kullanıcının girdiği tüm değerler korunacak ve sadece hata mesajı gösterilecek. Kullanıcı sadece hatalı kısımları düzeltmek zorunda kalacak, tüm formu yeniden doldurmak zorunda kalmayacak.

## Prompt 9

```
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

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top mb-4">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Öğrenci Deneme Takip Sistemi</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="dashboard.php">Ana Sayfa</a></li>
                    <li class="nav-item"><a class="nav-link" href="add_exam.php">Sınav Ekle</a></li>
                    <li class="nav-item"><a class="nav-link" href="list_exams.php">Sınavlarım</a></li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="logout.php">Çıkış Yap</a></li>
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
```
- navbarı daha hos gorunsun istiyorum neler yapabılırm
---
Navbar'ı daha güzel ve modern görünmesi için aşağıdaki değişiklikleri yapabiliriz. İşte güncellenmiş navbar kodu ve stilleri:


```
<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="dashboard.php">
            <i class="bi bi-journal-bookmark-fill me-2"></i>
            <span class="fw-bold">Öğrenci Deneme Takip</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link active d-flex align-items-center" href="dashboard.php">
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
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i>Profil</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i>Ayarlar</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Çıkış Yap</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
```
Ve CSS stilleri:


```
<style>
    .navbar {
        padding: 0.7rem 1rem;
        transition: all 0.3s ease;
    }
    
    .navbar-brand {
        font-size: 1.2rem;
    }
    
    .nav-link {
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        transition: all 0.2s ease;
        margin: 0 0.2rem;
    }
    
    .nav-link:hover, .nav-link.active {
        background-color: rgba(255, 255, 255, 0.15);
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        margin: 0.1rem 0.5rem;
        width: auto;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
        color: #0d6efd;
    }
    
    /* Navbar'ın scroll ile küçülmesi efekti */
    .navbar.scrolled {
        padding: 0.5rem 1rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
</style>
```
JavaScript kısmı (scroll efekti için):

```
<script>
    // Navbar scroll efekti
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
```
Bu değişikliklerle:

- Navbar daha modern ve profesyonel görünecek

- İkonlarla birlikte daha anlaşılır bir menü

- Kullanıcı adıyla birlikte dropdown menü

- Hover efektleri ve daha yumuşak geçişler

- Scroll ile küçülen navbar efekti

- Daha belirgin ve erişilebilir butonlar

- Gölge efektleri ile derinlik hissi

- Renkleri kendi tema renklerinize göre ayarlayabilirsiniz (bg-primary yerine bg-dark vb. kullanabilirsiniz).

## Prompt 10

- bi de bu sisteme basit bi footer ekler mıısn tum sayfalarda en alta olsa iyi olur gibi


 İşte dashboard.php dosyanızın en altına ekleyebileceğiniz basit ama şık bir footer örneği:


```
<!-- Footer kısmı -->
<footer class="bg-dark text-white py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Öğrenci Deneme Takip Sistemi. Tüm hakları saklıdır.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
                <a href="#" class="text-white"><i class="bi bi-github"></i></a>
            </div>
        </div>
    </div>
</footer>

<!-- Scriptler -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik ve diğer scriptler burada
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('trendChart').getContext('2d');
        // ... Grafik kodu aynı şekilde kalacak ...
    });

    // Navbar scroll efekti
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>
</body>
</html>
```
Özellikler:
Responsive Tasarım: Mobil ve masaüstü uyumlu

Sosyal Medya İkonları: Bootstrap ikonlarıyla

Otomatik Yıl: <?php echo date('Y'); ?> ile her yıl otomatik güncellenir

Temiz Görünüm: Koyu arkaplan ile profesyonel duruş

Diğer Sayfalara Eklemek İçin:
Aynı footer kodunu diğer sayfalarınıza da (add_exam.php, list_exams.php vb.) en alta ekleyebilirsiniz. Tek fark, o sayfalara özel scriptler varsa onları da eklemeyi unutmayın.

Ekstra Stil İsterseniz:
CSS eklemek için ```<style>``` tagları arasına şunları ekleyebilirsiniz:

```
<style>
    footer a {
        transition: all 0.3s ease;
    }
    footer a:hover {
        color: var(--bs-primary) !important;
        transform: translateY(-2px);
    }
    .scrolled {
        padding: 0.5rem 1rem !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
</style>
```
