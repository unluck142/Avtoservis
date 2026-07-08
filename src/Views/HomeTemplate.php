<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class HomeTemplate extends BaseTemplate
{
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title= 'Премиальный автосервис';

        $content = <<<HTML

<section class="hero-section">
    <div class="container-modern">
        <div class="hero-wrapper row align-items-center g-5">
            <div class="col-lg-6">
                <span class="hero-badge">
                    <i class="fa-solid fa-star"></i>
                    Рейтинг 4.9 / 5
                </span>

                <h1 class="hero-title">Премиальный автосервис для вашего автомобиля</h1>

                <p class="hero-description">
                    Диагностика, ремонт и техническое обслуживание автомобилей любой сложности с гарантией качества и современным оборудованием.
                </p>

                <div class="hero-buttons d-flex flex-wrap gap-3">
                    <a href="/avtoservis/order" class="btn btn-primary main-cta">Записаться</a>
                    <a href="/avtoservis/products" class="btn btn-outline-light secondary-btn">Все услуги</a>
                </div>

                <div class="hero-stats">
                    <div class="stat-card">
                        <strong>10+</strong>
                        <span>лет опыта</span>
                    </div>

                    <div class="stat-card">
                        <strong>5000+</strong>
                        <span>клиентов</span>
                    </div>

                    <div class="stat-card">
                        <strong>24/7</strong>
                        <span>поддержка</span>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="hero-image-wrapper">
                    <img src="/avtoservis/assets/images/image1.png" class="hero-image" alt="Автосервис">
                    <div class="floating-card">
                        <i class="fa-solid fa-shield"></i>
                        Гарантия на все работы
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="features-section">
    <div class="container-modern">
        <div class="section-heading text-center">
            <span>Преимущества</span>
            <h2>Почему выбирают нас</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div>
                    <h3>Профессиональный ремонт</h3>
                    <p>Современное оборудование и мастера с большим опытом работы.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="fa-solid fa-clock"></i></div>
                    <h3>Быстрое обслуживание</h3>
                    <p>Минимальные сроки ремонта без потери качества работ.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="feature-card h-100">
                    <div class="feature-icon"><i class="fa-solid fa-award"></i></div>
                    <h3>Гарантия качества</h3>
                    <p>Предоставляем гарантию на все виды ремонта и обслуживания.</p>
                </div>
            </div>
        </div>
    </div>
</section>
HTML;

        return sprintf($template, $title, $content);
    }
}
