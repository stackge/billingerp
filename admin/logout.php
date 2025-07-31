<?php
session_start();
session_unset(); // ყველა სესიის ცვლადის წაშლა
session_destroy(); // სესიის დასრულება

header("Location: login.php");
exit;
