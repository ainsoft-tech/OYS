<?php
ini_set('display_errors', 0);
error_reporting(0);

include '../../config/oys_vt.php';

try {
    $full_name = $_POST['full_name'];
    $school_number = $_POST['school_number'];
    $tc_no = $_POST['tc_no'];
    $birth_date = $_POST['birth_date'] ?? null;
    $birth_place = $_POST['birth_place'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $class = $_POST['class'];
    $lesson_room = $_POST['lesson_room'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $parent_name = $_POST['parent_name'] ?? null;
    $parent_phone = $_POST['parent_phone'] ?? null;
    $address = $_POST['address'] ?? null;
    $education_period = $_POST['education_period'] ?? null;
    $registration_date = $_POST['registration_date'] ?? date('Y-m-d');
    $status = $_POST['status'] ?? 'Aktif';

    $photo = $_POST['photo'] ?? null;

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileTmpPath = $_FILES['photo']['tmp_name'];
        $fileName = uniqid('student_') . '_' . basename($_FILES['photo']['name']);
        $destPath = $uploadDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $destPath)) {
            $photo = $fileName;
        } else {
            $photo = null;
        }
    } else {
        $photo = isset($_POST['photo_old']) ? $_POST['photo_old'] : null;
    }

    if ($_POST['id']) {
        $stmt = $pdo->prepare("UPDATE students SET full_name=?, school_number=?, tc_no=?, birth_date=?, birth_place=?, gender=?, class=?, lesson_room=?, email=?, phone=?, parent_name=?, parent_phone=?, address=?, education_period=?, registration_date=?, status=?, photo=? WHERE id=?");
        $stmt->execute([$full_name, $school_number, $tc_no, $birth_date, $birth_place, $gender, $class, $lesson_room, $email, $phone, $parent_name, $parent_phone, $address, $education_period, $registration_date, $status, $photo, $_POST['id']]);
        echo json_encode(['success' => true, 'message' => 'Güncellendi']);
    } else {
        $stmt = $pdo->prepare("INSERT INTO students (
            full_name, school_number, tc_no, birth_date, birth_place, gender, class, lesson_room, email, phone, parent_name, parent_phone, address, education_period, registration_date, status, photo
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$full_name, $school_number, $tc_no, $birth_date, $birth_place, $gender, $class, $lesson_room, $email, $phone, $parent_name, $parent_phone, $address, $education_period, $registration_date, $status, $photo]);
        echo json_encode(['success' => true, 'message' => 'Eklendi']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Hata: ' . $e->getMessage()]);
}