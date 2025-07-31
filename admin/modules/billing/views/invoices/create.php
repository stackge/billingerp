<?php
require_once __DIR__ . '/../../models/invoicesmodel.php';

use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');
?>

           
          <!-- CONTENT START -->

          <div class="container-xl mt-4">
    <h2 class="mb-4">ახალი ინვოისის დამატება</h2>

    <form action="dashboard.php?module=billing&submodule=invoices&action=store" method="POST">
        <div class="mb-3">
            <label class="form-label">კლიენტი</label>
            <select name="client_id" class="form-select" required>
                <option value="">აირჩიე კლიენტი</option>
                <?php foreach ($clients as $client): ?>
                    <option value="<?= $client['id'] ?>">
                        <?= htmlspecialchars($client['first_name'] . ' ' . $client['last_name']) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label">პროდუქტები</label>

            <div id="product-container">
                <div class="row product-item mb-2">
                    <div class="col-md-5">
                        <select name="products[]" class="form-select" required>
                            <option value="">აირჩიე პროდუქტი</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product['id'] ?>">
                                    <?= htmlspecialchars($product['name']) ?> (<?= $product['price'] ?> ₾)
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="amounts[]" step="0.01" class="form-control" placeholder="თანხა ₾" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="descriptions[]" class="form-control" placeholder="აღწერა (არასავალდებულო)">
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-remove">-</button>
                    </div>
                </div>
            </div>

            <button type="button" id="add-product" class="btn btn-secondary btn-sm mt-2">+ პროდუქტის დამატება</button>
        </div>

        <div class="mb-3">
            <label class="form-label">ინვოისის ნომერი (არასავალდებულო)</label>
            <input type="text" name="invoice_number" class="form-control"
            placeholder="მაგ: INV-2025-001"
            value="<?= htmlspecialchars($generatedInvoiceNumber) ?>" />
        </div>

        <div class="mb-3">
            <label class="form-label">ინვოისის აღწერა</label>
            <textarea name="description" class="form-control" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">გადასახდელი თანხა (₾)</label>
            <input type="number" step="0.01" name="total_amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">გადახდის მეთოდი</label>
            <input type="text" name="payment_method" class="form-control" value="საბანკო გადმორიცხვა" required>
        </div>

        <div class="mb-3">
            <label class="form-label">სტატუსი</label>
            <select name="status" class="form-select" required>
                <option value="დრაფტი">დრაფტი</option>
                <option value="გადაუხდელი">გადაუხდელი</option>
                <option value="გადასახდელი">გადასახდელი</option>
                <option value="გადახდილი">გადახდილი</option>
                <option value="გაუქმებული">გაუქმებული</option>
            </select>
        </div>

        <div class="mb-3 row">
            <div class="col">
                <label class="form-label">ინვოისის თარიღი</label>
                <input type="date" name="issue_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
            </div>
            <div class="col">
                <label class="form-label">გადახდის ბოლო ვადა</label>
                <input type="date" name="due_date" class="form-control" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-check">
                <input type="checkbox" name="recurring" value="1" class="form-check-input">
                <span class="form-check-label">გადახდა განმეორებით (ყოველთვიურად)</span>
            </label>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">ინვოისის შექმნა</button>
            <a href="list.php" class="btn btn-secondary">გაუქმება</a>
        </div>
    </form>

    </div></div>


<?php require_once Config::includePath('footer.php'); ?>

          <script>
document.getElementById('add-product').addEventListener('click', function () {
    const container = document.getElementById('product-container');
    const item = container.querySelector('.product-item');
    const clone = item.cloneNode(true);

    // reset values
    clone.querySelectorAll('input, select').forEach(el => el.value = '');
    container.appendChild(clone);
});

// remove button
document.addEventListener('click', function (e) {
    if (e.target.classList.contains('btn-remove')) {
        const allItems = document.querySelectorAll('.product-item');
        if (allItems.length > 1) {
            e.target.closest('.product-item').remove();
        }
    }
});
</script>