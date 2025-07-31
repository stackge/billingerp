<?php
if (file_exists(__DIR__ . '/install.lock')) {
    die("პროექტი უკვე დაყენებულია.");
}
header("Location: step1_check.php");
exit;
