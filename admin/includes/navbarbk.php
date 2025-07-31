
<ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="<?= App\Config::route('dashboard.php') ?>">
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/home -->
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-1"
                      >
                        <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                        <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                        <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                      </svg>
                    </span>
                    <span class="nav-link-title"> მთავარი </span>
                  </a>
                </li>

                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#navbar-addons"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    role="button"
                    aria-expanded="false"
                  >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-1"
                      >
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                      </svg>
                    </span>
                    <span class="nav-link-title"> კლიენტები </span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= App\Config::route('clients_list.php') ?>"> მომხმარებლების სია </a>
                    <a class="dropdown-item" href="<?= App\Config::route('add_client.php') ?>"> ახალი კლიენტი </a>
                    <a class="dropdown-item" href="./flags.html"> პროდუქტები & სერვისები </a>
                    <a class="dropdown-item" href="./illustrations.html"> დომენის რეგისტრაციები </a>
                    <a class="dropdown-item" href="./payment-providers.html"> კლიენტების ძებნა </a>
                  </div>
                </li>

                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#navbar-addons"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    role="button"
                    aria-expanded="false"
                  >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-1"
                      >
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                      </svg>
                    </span>
                    <span class="nav-link-title"> შეკვეთები </span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="configproduct.php"> პროდუქტების სია </a>
                    <a class="dropdown-item" href="./emails.html"> Emails </a>
                    <a class="dropdown-item" href="./flags.html"> Flags </a>
                    <a class="dropdown-item" href="./illustrations.html"> Illustrations </a>
                    <a class="dropdown-item" href="./payment-providers.html"> Payment providers </a>
                  </div>
                </li>

                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#navbar-addons"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    role="button"
                    aria-expanded="false"
                  >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-1"
                      >
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                      </svg>
                    </span>
                    <span class="nav-link-title"> ბილინგი </span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= App\Config::route('billing/invoices/list.php') ?>"> ინვოისების სია </a>
                    <a class="dropdown-item" href="<?= App\Config::route('billing/invoices/create.php') ?>"> ინვოისის შექმნა </a>
                    <a class="dropdown-item" href="<?= App\Config::route('billing/invoices/list.php') ?>"> გადაუხდელები </a>
                    <a class="dropdown-item" href="<?= App\Config::route('billing/invoices/list.php') ?>"> Illustrations </a>
                    <a class="dropdown-item" href="<?= App\Config::route('billing/invoices/list.php') ?>"> Payment providers </a>
                  </div>
                </li>

                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#navbar-addons"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    role="button"
                    aria-expanded="false"
                  >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-1"
                      >
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                      </svg>
                    </span>
                    <span class="nav-link-title"> მხარდაჭერა </span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="./icons.html"> Icons </a>
                    <a class="dropdown-item" href="./emails.html"> Emails </a>
                    <a class="dropdown-item" href="./flags.html"> Flags </a>
                    <a class="dropdown-item" href="./illustrations.html"> Illustrations </a>
                    <a class="dropdown-item" href="./payment-providers.html"> Payment providers </a>
                  </div>
                </li>

                <li class="nav-item dropdown">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#navbar-addons"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    role="button"
                    aria-expanded="false"
                  >
                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                      <!-- Download SVG icon from http://tabler.io/icons/icon/plus -->
                      <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="24"
                        height="24"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        class="icon icon-1"
                      >
                        <path d="M12 5l0 14" />
                        <path d="M5 12l14 0" />
                      </svg>
                    </span>
                    <span class="nav-link-title"> ელ-ფოსტები </span>
                  </a>
                  <div class="dropdown-menu">
                    <a class="dropdown-item" href="<?= App\Config::route('broadcast.php') ?>"> ელ.ფოსტის გაგზავნა </a>
                    <a class="dropdown-item" href="<?= App\Config::route('email_logs_list.php') ?>"> გაგზავნილები </a>
                    <a class="dropdown-item" href="./flags.html"> Flags </a>
                    <a class="dropdown-item" href="./illustrations.html"> Illustrations </a>
                    <a class="dropdown-item" href="./payment-providers.html"> Payment providers </a>
                  </div>
                </li>
              </ul>