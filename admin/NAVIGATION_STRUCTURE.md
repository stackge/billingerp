# ბმულების და ნავიგაციის სქემა - ლინკების მართვის რუქა

## მთავარი რუტები

### Dashboard-ის მთავარი გვერდი
- **URL**: `/admin/dashboard.php`
- **ფუნქცია**: მთავარი ადმინ პანელი

---

## ნავიგაციის მენიუ (სისტემის სექციები)

### 1. მთავარი
- **ლინკი**: `dashboard.php`
- **აღწერა**: მთავარი დაშბორდი

### 2. კლიენტები
- **მომხმარებლების სია**: `dashboard.php?module=clients&action=list`
- **ახალი კლიენტი**: `dashboard.php?module=clients&action=add`

### 3. პროდუქცია
- **პროდუქტების სია**: `dashboard.php?module=product&action=list`
- **ახალი პროდუქტი**: `dashboard.php?module=product&action=create`
- **პროდუქტის ტიპები**: `dashboard.php?module=product&action=types`

### 4. ბილინგი
- **ინვოისების სია**: `dashboard.php?module=billing&submodule=invoices&action=list`
- **ინვოისის შექმნა**: `dashboard.php?module=billing&submodule=invoices&action=create`
- **ტრანზაქციები**: `dashboard.php?module=billing&submodule=transactions&action=list`
- **ტრანზაქციის შექმნა**: `dashboard.php?module=billing&submodule=transactions&action=create`

### 5. სისტემა (ახალი)
- **მომხმარებლების მართვა**: `dashboard.php?module=users&action=management`
- **SMTP სეტინგები**: `modules/settings/controllers/smtp_settings.php`
- **განახლებები**: `update/`

### 6. მარკეტინგი
- **ელ.ფოსტის გაგზავნა**: `dashboard.php?module=marketing&action=broadcast`
- **ელ.ფოსტის ჩანაწერები**: `dashboard.php?module=marketing&action=email_logs`

---

## მომხმარებლების მართვის სისტემა

### ძირითადი გვერდი
- **URL**: `dashboard.php?module=users&action=management`
- **subaction პარამეტრები**:
  - `list` (default) - მომხმარებლების სია
  - `add` - ახალი მომხმარებლის დამატება
  - `edit&id=X` - მომხმარებლის რედაქტირება
  - `profile&id=X` - მომხმარებლის პროფილი

### მაგალითები:
- სია: `dashboard.php?module=users&action=management` (default subaction=list)
- დამატება: `dashboard.php?module=users&action=management&subaction=add`
- რედაქტირება: `dashboard.php?module=users&action=management&subaction=edit&id=2`
- პროფილი: `dashboard.php?module=users&action=management&subaction=profile&id=2`

---

## პროდუქტის ტიპების მართვის სისტემა

### ძირითადი გვერდი
- **URL**: `dashboard.php?module=product&action=types`
- **subaction პარამეტრები**:
  - `list` (default) - ტიპების სია
  - `add` - ახალი ტიპის დამატება
  - `edit&id=X` - ტიპის რედაქტირება

### მაგალითები:
- სია: `dashboard.php?module=product&action=types` (default subaction=list)
- დამატება: `dashboard.php?module=product&action=types&subaction=add`
- რედაქტირება: `dashboard.php?module=product&action=types&subaction=edit&id=3`

---

## მომხმარებლის dropdown მენიუ

### პროფილის ბმულები
- **პროფილი**: `profile.php` → redirects to current user's profile
- **მომხმარებლების მართვა**: `dashboard.php?module=users&action=management`
- **SMTP სეტინგები**: `modules/settings/controllers/smtp_settings.php`
- **გასვლა**: `logout.php`

---

## ნავიგაციის თავისებურებები

### Config::route() ფუნქცია
- ჩააბარებს `/admin/` prefix-ს რელატიური ბმულებისთვის
- აბსოლუტური ბმულები (http... ან /-ით დაწყებული) რჩება უცვლელად

### Router ლოგიკა
- იყენებს `$module`, `$submodule`, `$action`, `$subaction` პარამეტრებს
- სპეციალური შემთხვევები:
  - `product + types` → product_types.php controller
  - `users + management` → users_management.php controller
- სტანდარტული შემთხვევა: `modules/{module}/controllers/{submodule}/{action}.php`

### იკონები
- იყენებს მუხლებრივ SVG იკონებს
- ძირითადი იკონები: home, users, package, credit-card, settings, mail

---

## ფაილების სტრუქტურა

```
admin/
├── dashboard.php (მთავარი routing file)
├── profile.php (user profile redirect)
├── includes/
│   ├── router.php (მთავარი router)
│   ├── navbar.php (navigation menu)
│   └── Config.php (route helper)
└── modules/
    ├── users/
    │   └── controllers/
    │       ├── index.php → redirect to management
    │       └── users_management.php
    ├── product/
    │   └── controllers/
    │       ├── index.php → redirect to list
    │       └── product_types.php
    └── ...
```

---

## შემდგომი განვითარება

მოცემული სტრუქტურა მხარს უჭერს:
- ✅ მოდულარული არქიტექტურა
- ✅ SEO-friendly URL-ები
- ✅ მარტივი მავიგაცია
- ✅ როლზე დაფუძნებული access control
- ✅ CRUD ოპერაციები subaction-ების მეშვეობით
- ✅ უსაფრთხოება (input sanitization)
