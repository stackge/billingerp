<?php
// უსაფრთხო cleanup script install დირექტორიის წასაშლელად
if (!file_exists(__DIR__ . '/install.lock')) {
    http_response_code(403);
    die('ინსტალაცია არ არის დასრულებული.');
}

function deleteDirectory($dir) {
    if (!file_exists($dir)) return true;
    if (!is_dir($dir)) return unlink($dir);
    
    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') continue;
        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) return false;
    }
    return rmdir($dir);
}

if (deleteDirectory(__DIR__)) {
    echo json_encode(['success' => true, 'message' => 'Install დირექტორია წარმატებით წაიშალა']);
} else {
    echo json_encode(['success' => false, 'message' => 'შეცდომა დირექტორიის წაშლისას']);
}
?>
