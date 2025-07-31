<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');
?>

<!-- CONTENT START -->


          <h2 class="mb-4">კლიენტების სია</h2>

    <table class="table table-striped">
    <thead>
        <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>კომპანია</th>
        <th>ელ.ფოსტა</th>
        <th>ტელეფონი</th>
        <th>შექმნის თარიღი</th>
        <th>სტატუს</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
        <tr>
            <td><?= htmlspecialchars($client['id']) ?></td>
            <td><?= htmlspecialchars($client['first_name']) ?></td>
            <td><?= htmlspecialchars($client['last_name']) ?></td>
            <td><?= htmlspecialchars($client['company_name']) ?></td>
            <td><?= htmlspecialchars($client['email']) ?></td>
            <td><?= htmlspecialchars($client['phone']) ?></td>
            <td><?= date('d/m/Y', strtotime($client['created_at'])) ?></td>
            <td>
            <span class="badge bg-light">
                <?= strtoupper($client['status']) ?>
            </span>
            </td>
            <td>
                <a href="dashboard.php?module=clients&action=profile&id=<?= $client['id'] ?>" class="btn btn-sm btn-info">პროფილი</a>
              <a href="dashboard.php?module=clients&action=edit&id=<?= $client['id'] ?>" class="btn btn-sm btn-warning">რედ.</a>
              <a href="dashboard.php?module=clients&action=delete&id=<?= $client['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('ნამდვილად გსურს წაშლა?');">წაშლა</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>

    

    </div>

    <?php require_once Config::includePath('footer.php'); ?>