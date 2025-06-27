<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../config/oys_vt.php';

// Formdan gelen verileri al
$full_name      = $_POST['full_name']      ?? '';
$tc_no          = $_POST['tc_no']          ?? '';
$start_date     = $_POST['start_date']     ?? '';
$phone          = $_POST['phone']          ?? '';
$email          = $_POST['email']          ?? '';
$username       = $_POST['username']       ?? ''; // Formdan gelen username
$salary         = isset($_POST['salary']) && $_POST['salary'] !== '' ? $_POST['salary'] : null;
$branch         = $_POST['branch']         ?? '';
$address        = $_POST['address']        ?? '';
$gender         = $_POST['gender']         ?? '';
$marital_status = $_POST['marital_status'] ?? '';
$birth_place    = $_POST['birth_place']    ?? '';
$birth_date     = $_POST['birth_date']     ?? '';
$children_count = $_POST['children_count'] ?? '';
$education_status = $_POST['education_status'] ?? '';
$created_at     = date('Y-m-d H:i:s');

// Şifreyi hashle
$password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);

// Fotoğraf yükleme
$photo = null;
if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = __DIR__ . '../uploads/';
    if (!is_dir($uploadDir)) {
        @mkdir($uploadDir, 0777, true);
    }
    $fileTmpPath = $_FILES['photo']['tmp_name'];
    $fileName = uniqid('teacher_') . '_' . basename($_FILES['photo']['name']);
    $destPath = $uploadDir . $fileName;
    if (move_uploaded_file($fileTmpPath, $destPath)) {
        $photo = $fileName;
    }
}
$check = $pdo->prepare("SELECT COUNT(*) FROM teachers WHERE tc_no = ?");
$check->execute([$tc_no]);
if ($check->fetchColumn() > 0) {
    echo json_encode(['success' => false, 'message' => 'Bu TC Kimlik No ile zaten bir kayıt var!']);
    exit;
}
// Veritabanına kaydet
$stmt = $pdo->prepare("INSERT INTO teachers 
    (full_name, tc_no, start_date, phone, email, branch, salary, photo, address, gender, marital_status, birth_place, birth_date, children_count, education_status, created_at, username, password)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$ok = $stmt->execute([
    $full_name, $tc_no, $start_date, $phone, $email, $branch,
    $salary, // burada artık null veya sayı olacak
    $photo, $address, $gender, $marital_status,
    $birth_place, $birth_date, $children_count, $education_status,
    $created_at, $username, $password
]);

if ($ok) {
    echo json_encode(['success' => true, 'message' => 'Öğretmen başarıyla kaydedildi.']);
} else {
    $error = $stmt->errorInfo();
    echo json_encode(['success' => false, 'message' => 'Kayıt sırasında hata oluştu: ' . $error[2]]);
}
exit;
?>
