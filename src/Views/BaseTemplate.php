<?php 
namespace App\Views;

class BaseTemplate 
{
    public static function getTemplate(): string {
        global $user_id, $username;

        $template = <<<HTML
        <!DOCTYPE html>
        <html lang="ru">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="Премиальный автосервис — диагностика, ремонт и обслуживание автомобилей.">
            <title>%s</title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
            <link rel="stylesheet" href="/avtoservis/assets/css/bootstrap.min.css">
            <link rel="stylesheet" href="/avtoservis/assets/css/style.css">
        </head>
        <body>
        <div class="bg-glow glow-1"></div>
        <div class="bg-glow glow-2"></div>
        <script src="/avtoservis/assets/js/wheel.js" defer></script>

        <header>
            <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
                <div class="container-modern d-flex align-items-center">
                    <a class="navbar-brand d-flex align-items-center gap-3" href="/avtoservis/">
                        <img src="/avtoservis/assets/images/logo.png" alt="Логотип компании" width="54" height="54">
                        <div>
                            <span class="brand-title">Автосервис</span>
                            <small class="brand-subtitle">Premium Garage</small>
                        </div>
                    </a>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav mx-auto">
                            <li class="nav-item"><a class="nav-link" href="/avtoservis/">Главная</a></li>
                            <li class="nav-item"><a class="nav-link" href="/avtoservis/products">Услуги</a></li>
                            <li class="nav-item"><a class="nav-link" href="/avtoservis/order">Запись</a></li>
                            <li class="nav-item"><a class="nav-link" href="/avtoservis/about">О компании</a></li>
                            <li class="nav-item"><a class="nav-link" href="/avtoservis/history">История</a></li>
                        </ul>

                        <div class="nav-actions d-flex align-items-center gap-3">
        HTML;

        if ($user_id > 0) {
            $template .= <<<HTML
                <div class="profile-chip dropdown">
                    <a class="dropdown-toggle text-decoration-none" href="#" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user"></i>
                        {$username}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                        <li><a class="dropdown-item" href="/avtoservis/profile">Профиль</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="/avtoservis/logout">Выход</a></li>
                    </ul>
                </div>
            HTML;
        } else {
            $template .= <<<HTML
                <a class="btn btn-outline-light login-btn" href="/avtoservis/login">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Вход
                </a>
                <a class="btn btn-primary main-cta" href="/avtoservis/register">Регистрация</a>
            HTML;
        }

        $template .= <<<HTML
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        HTML;

        if (isset($_SESSION['flash'])) {
            $template .= <<<END
                <div class="container-modern mt-4">
                    <div class="alert premium-alert alert-dismissible fade show" role="alert">
                        {$_SESSION['flash']}
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            END;
            unset($_SESSION['flash']);
        }

        $template .= <<<HTML
            <main>
                %s
            </main>

            <footer class="footer-modern">
                <div class="container-modern footer-grid">
                    <div>
                        <h4>Автосервис</h4>
                        <p>Профессиональное обслуживание автомобилей с современным оборудованием и гарантией качества.</p>
                    </div>

                    <div>
                        <h5>Контакты</h5>
                        <p><i class="fa-solid fa-phone"></i> +7 (999) 142‑42‑42</p>
                        <p><i class="fa-solid fa-location-dot"></i> Кемерово</p>
                    </div>

                    <div>
                        <h5>Навигация</h5>
                        <a href="/avtoservis/products">Услуги</a>
                        <a href="/avtoservis/order">Онлайн запись</a>
                        <a href="/avtoservis/about">О компании</a>
                    </div>
                </div>

                <div class="footer-bottom">
                    © 2026 Premium Garage. Все права защищены.
                </div>
            </footer>
        <script src="/avtoservis/assets/js/bootstrap.bundle.js" defer></script>
        </body>
        </html>
        HTML;

        return $template;
    }
}
