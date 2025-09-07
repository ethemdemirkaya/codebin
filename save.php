<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'] ?? '';

    if (empty(trim($code))) {
        die("Hata: Kod alanı boş olamaz.");
    }
    $filename = bin2hex(random_bytes(12));

    $pastes_dir = 'pastes';
    if (!is_dir($pastes_dir)) {
        mkdir($pastes_dir, 0755, true);
    }

    $filepath = $pastes_dir . '/' . $filename;

    if (file_put_contents($filepath, $code) === false) {
        die("Hata: Dosya kaydedilemedi. Klasör yazma izinlerini kontrol edin.");
    }
    header("Location: /" . $filename);
    exit();
}

header("Location: /");
exit();
