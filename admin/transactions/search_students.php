<?php
include '../../config/oys_vt.php';

$page = $_GET['page'] ?? 1;
$size = $_GET['size'] ?? 10;
$query = $_GET['query'] ?? '';

$start = ($page - 1) * $size;

try {
    $sql = "SELECT * FROM students WHERE full_name LIKE ? ORDER BY id DESC LIMIT ?, ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(["%$query%", $start, $size]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalStmt = $pdo->prepare("SELECT COUNT(*) as total FROM students WHERE full_name LIKE ?");
    $totalStmt->execute(["%$query%"]);
    $totalRow = $totalStmt->fetch(PDO::FETCH_ASSOC);
    $total = $totalStmt->rowCount() ? $totalRow['total'] : 0;

    $html = "";
    foreach ($students as $student):
        $json = htmlspecialchars(json_encode($student), ENT_QUOTES, 'UTF-8');
        $html .= "<tr data-class='{$student['class']}' data-gender='{$student['gender']}'>
                    <td class='px-6 py-4 whitespace-nowrap'>{$student['full_name']}</td>
                    <td class='px-6 py-4 whitespace-nowrap'>{$student['tc_no']}</td>
                    <td class='px-6 py-4 whitespace-nowrap'>{$student['class']}</td>
                    <td class='px-6 py-4 whitespace-nowrap'>{$student['school_number']}</td>
                    <td class='px-6 py-4 whitespace-nowrap'>
                        <span class='px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full " . ($student['status'] == 'Aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') . "'>" . $student['status'] . "</span>
                    </td>
                    <td class='px-6 py-4 whitespace-nowrap space-x-2'>
                        <button onclick='showDetail(`$json`)' class='inline-flex items-center gap-1 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-xs'><i class='material-icons'>visibility</i> Detay</button>
                        <button onclick='editStudent({$student['id']})' class='inline-flex items-center gap-1 px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs'><i class='material-icons'>edit</i> Düzenle</button>
                        <button onclick='deleteStudent({$student['id']})' class='inline-flex items-center gap-1 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-xs'><i class='material-icons'>delete</i> Sil</button>
                        <a href='transactions/pdf_export.php?id={$student['id']}' target='_blank' class='inline-flex items-center gap-1 px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs' title='PDF olarak indir'>
                            <svg fill='currentColor' height='24' viewBox='0 0 24 24' width='16' style='display:inline;vertical-align:middle;'>
                                <path d='M19 2H8c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 18H8V4h11v16zm-4-2h-2v-2h2v2zm2-4H8v-2h9v2zm0-4H8V8h9v2z'/>
                            </svg>
                            PDF
                        </a>
                    </td>
                </tr>";
    endforeach;

    echo json_encode([
        'html' => $html,
        'total' => $total
    ]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Veritabanı hatası: ' . $e->getMessage()]);
}