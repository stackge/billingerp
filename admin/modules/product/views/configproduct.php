<?php 
require_once __DIR__ . '/includes/init.php';

?>

<?php
require_once __DIR__ . '/../vendor/autoload.php';
use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');
?>


<?php 

require 'db.php';

$action = $_GET['action'] ?? 'list';
$id = $_GET['id'] ?? null;

switch ($action) {
  case 'create':
    include __DIR__ . '/product/create.php';
    break;

  case 'edit':
    if ($id) {
      include __DIR__ . '/product/edit.php';
    } else {
      echo "<div class='container-xl mt-4'><div class='alert alert-danger'>ID ვერ მოიძებნა.</div></div>";
    }
    break;

  case 'list':
  default:
    include __DIR__ . '/product/list.php';
    break;
}

?>

<?php require_once Config::includePath('footer.php'); ?>