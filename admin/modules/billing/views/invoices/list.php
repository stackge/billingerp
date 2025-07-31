<!-- ინვოისების სია + ფილტრები -->
<?php require_once __DIR__ . '/../../models/invoicesmodel.php'; ?>
<?php
use App\Config;

InvoicesModel::setDb($pdo);
$invoices = InvoicesModel::getAllInvoicesWithClientNames();

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');
?>

<div class="container-xl mt-4">
    <div class="d-flex justify-content-between mb-3">
        <h2>ინვოისების სია</h2>
        <a href="dashboard.php?module=billing&submodule=invoices&action=create" class="btn btn-primary">+ ახალი ინვოისი</a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>კლიენტი</th>
                        <th>თანხა</th>
                        <th>სტატუსი</th>
                        <th>თარიღი</th>
                        <th>ვადა</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                        <tr>
                            <td><?= $invoice['id'] ?></td>
                            <td><?= htmlspecialchars($invoice['client_name']) ?></td>
                            <td><?= number_format($invoice['total_amount'], 2) ?> ₾</td>
                            <td>
                                <span class="badge bg-light">
                                <?= htmlspecialchars($invoice['status']) ?>
                                </span>
                            </td>
                            <td><?= $invoice['issue_date'] ?></td>
                            <td><?= $invoice['due_date'] ?></td>
                            <td>
                                <a href="dashboard.php?module=billing&submodule=invoices&action=view&id=<?= $invoice['id'] ?>" class="btn btn-sm btn-info">ნახვა</a>
                                <a href="dashboard.php?module=billing&submodule=invoices&action=edit&id=<?= $invoice['id'] ?>" class="btn btn-sm btn-warning">რედაქტირება</a>
                                <a href="dashboard.php?module=billing&submodule=invoices&action=delete&id=<?= $invoice['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('ნამდვილად გსურს წაშლა?')">წაშლა</a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

       <!-- Content END -->
       </div>
        </div>
<?php require_once Config::includePath('footer.php'); ?>