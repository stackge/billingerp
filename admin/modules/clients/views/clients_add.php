
<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Config;

require_once Config::includePath('head.php');
require_once Config::includePath('navbar.php');
require_once Config::includePath('pageheader.php');
require_once Config::includePath('pagebodystart.php');

?>

           
          <!-- CONTENT START -->

          <h2 class="mb-4">ახალი კლიენტის დამატება</h2>
      <form action="dashboard.php?module=clients&action=add" method="post">
        <div class="row">
          <!-- მარცხენა სვეტი -->
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">სახელი</label>
              <input type="text" class="form-control" name="first_name" required>
            </div>
            <div class="mb-3">
              <label class="form-label">გვარი</label>
              <input type="text" class="form-control" name="last_name" required>
            </div>
            <div class="mb-3">
              <label class="form-label">კომპანიის სახელი <span class="text-muted">(სურვილისამებრ)</span></label>
              <input type="text" class="form-control" name="company">
            </div>
            <div class="mb-3">
              <label class="form-label">საიდ. ნომ <span class="text-muted">(სურვილისამებრ)</span></label>
              <input type="text" class="form-control" name="vat_number">
            </div>
            <div class="mb-3">
              <label class="form-label">ელ-ფოსტა</label>
              <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">პაროლი</label>
              <div class="input-group">
                <input type="text" class="form-control" id="password" name="password" required>
                <button class="btn btn-outline-secondary" type="button" onclick="generatePassword()">გენერირება</button>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">ენა</label>
              <select class="form-select" name="language">
                <option value="default">ნაგულისხმევი</option>
                <option value="en">English</option>
                <option value="ka">Georgian</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">სტატუსი</label>
              <select class="form-select" name="status">
                <option value="active">აქტიური</option>
                <option value="inactive">გაუქმებული</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">ჯგუფი</label>
              <select class="form-select" name="client_group">
                <option value="none">ცარიელი</option>
                <option value="vip">VIP</option>
                <option value="reseller">Reseller</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Email შეტყობინებები</label>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="emails[]" value="general" checked>
                <label class="form-check-label">General Emails</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="emails[]" value="invoice" checked>
                <label class="form-check-label">Invoice Emails</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" name="emails[]" value="support">
                <label class="form-check-label">Support Emails</label>
              </div>
              <!-- სხვა Checkbox-ები შეგიძლია დაამატო ასე -->
            </div>
          </div>

          <!-- მარჯვენა სვეტი -->
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">მისამართი 1</label>
              <input type="text" class="form-control" name="address1">
            </div>
            <div class="mb-3">
              <label class="form-label">მისამართი 2</label>
              <input type="text" class="form-control" name="address2">
            </div>
            <div class="mb-3">
              <label class="form-label">ქალაქი</label>
              <input type="text" class="form-control" name="city">
            </div>
            <div class="mb-3">
              <label class="form-label">შტატი/რეგიონი</label>
              <input type="text" class="form-control" name="state">
            </div>
            <div class="mb-3">
              <label class="form-label">საფოსტო ინდექსი</label>
              <input type="text" class="form-control" name="postcode">
            </div>
            <div class="mb-3">
              <label class="form-label">ქვეყანა</label>
              <select class="form-select" name="country">
                <option value="US">United States</option>
                <option value="GE">საქართველო</option>
                <!-- სხვა ქვეყნები -->
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">ტელეფონი</label>
              <input type="text" class="form-control" name="phone">
            </div>
            <div class="mb-3">
              <label class="form-label">გადახდის მეთოდი</label>
              <select class="form-select" name="payment_method">
                <option value="default">Default</option>
                <option value="paypal">PayPal</option>
                <option value="bank">საბანკო გადმორიცხვა</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Billing Contact</label>
              <select class="form-select" name="billing_contact">
                <option value="default">Default</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">ვალუტა</label>
              <select class="form-select" name="currency">
                <option value="USD">USD</option>
                <option value="GEL">GEL</option>
              </select>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Admin ჩანაწერი</label>
          <textarea class="form-control" name="admin_notes" rows="3"></textarea>
        </div>

        <div class="form-footer">
          <button type="submit" class="btn btn-primary">დამატება</button>
        </div>
      </form>
    </div>
  </div>

  <?php require_once Config::includePath('footer.php'); ?>



    <script>
    function generatePassword(length = 10) {
      const charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
      let password = "";
      for (let i = 0; i < length; i++) {
        const randomIndex = Math.floor(Math.random() * charset.length);
        password += charset[randomIndex];
      }
      document.getElementById('password').value = password;
    }
  </script>