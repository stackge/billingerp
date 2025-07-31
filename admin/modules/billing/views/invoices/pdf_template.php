<!DOCTYPE html>
<html lang="ka">
<head>
  <meta charset="UTF-8">
  <title>ინვოისი</title>
  <style>
    @font-face {
      font-family: DejaVu Sans;
    }
    body {
      font-family: DejaVu Sans;
      font-size: 14px;
      color: #333;
    }
    .invoice-box {
      max-width: 800px;
      margin: auto;
      padding: 30px;
      border: 1px solid #eee;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
    }
    .top-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
    }
    .top-header img {
      max-width: 250px;
    }
    .bank-info {
      text-align: right;
      font-size: 13px;
      line-height: 1.6;
    }
    .green-banner {
      position: absolute;
      top: 0;
      right: 0;
      background: #4CAF50;
      color: white;
      padding: 5px 20px;
      transform: rotate(45deg);
      transform-origin: top right;
      font-size: 16px;
    }
    .section {
      margin-top: 20px;
    }
    .gray-box {
      background: #eee;
      padding: 10px;
      font-weight: bold;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 15px;
    }
    table, th, td {
      border: 1px solid #ccc;
    }
    th, td {
      padding: 10px;
      text-align: left;
    }
    th {
      background: #f9f9f9;
    }
    .footer {
      margin-top: 30px;
      font-size: 12px;
      text-align: center;
      color: #777;
    }
  </style>
</head>
<body>
  <div class="invoice-box">
    <!-- <div class="green-banner">გადახდილია</div> -->
    <div class="top-header">
      <div>
        <h3>SELFHOSTING.GE</h3>
      </div>
      <div class="bank-info">
        ი/მ ლევან არაბული<br>
        პ/ნ: 01001080490<br><br>
        ბანკი: თიბისი ბანკი<br>
        ა/ნ: GE79TB7902736010100047<br><br>
        ბანკი: საქართველოს ბანკი<br>
        ა/ნ: GE85BG0000000534211842<br>
        იდენტიფიკატორი: 01001080490
      </div>
    </div>

    <div class="section gray-box">
      ინვოისი #: <?= htmlspecialchars($invoice['invoice_number']) ?><br>
      ინვოისის თარიღი: <?= htmlspecialchars($invoice['issue_date']) ?><br>
      გადახდის თარიღი: <?= htmlspecialchars($invoice['due_date']) ?>
    </div>

    <div class="section">
      <strong>მიმღები:</strong><br>
      <?= htmlspecialchars($invoice['first_name'] . ' ' . $invoice['last_name']) ?><br>
      <?php if (!empty($invoice['company_name'])): ?>
      <?= htmlspecialchars($invoice['company_name']) ?><br>
      <?php endif; ?>
      <?php if (!empty($invoice['address1'])): ?>
        <?= htmlspecialchars($invoice['address1']) ?><br>
      <?php endif; ?>
      <?php if (!empty($invoice['vat_number'])): ?>
        VAT: <?= htmlspecialchars($invoice['vat_number']) ?>
      <?php endif; ?>
    </div>

    <div class="section">
      <table>
        <thead>
          <tr>
            <th>დასახელება</th>
            <th>აღწერა</th>
            <th>თანხა</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($invoice['items'] as $item): ?>
          <tr>
            <td><?= htmlspecialchars($item['name']) ?></td>
            <td><?= htmlspecialchars($item['description']) ?></td>
            <td><?= number_format($item['amount'], 2) ?> ლარი</td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <div class="section">
      <h3>ტრანზაქციები</h3>
      <table>
        <thead>
          <tr>
            <th>ინვოისის ნომერი</th>
            <th>გადახდის მეთოდი</th>
            <th>ტრანზაქციის ID</th>
            <th>თანხა</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td># <?= htmlspecialchars($invoice['invoice_number']) ?></td>
            <td><?= htmlspecialchars($invoice['payment_method']) ?></td>
            <td>-</td>
            <td><?= number_format($invoice['total_amount'], 2) ?></td>
          </tr>
          <tr>
            <td colspan="3">ბალანსი</td>
            <td>0.00 GEL</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="footer">
    Powered By Stack.ge | შექმნილია Stack.ge-ს მიერ
    </div>
  </div>
</body>
</html>
