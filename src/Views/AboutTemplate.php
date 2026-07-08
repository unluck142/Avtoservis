<?php
namespace App\Views;
use App\Views\BaseTemplate;

class AboutTemplate extends BaseTemplate {
    public static function getTemplate(): string {
        $template = parent::getTemplate();
        $title = 'О нас';
        $content = <<<HTML
        <section class="about-section">
            <div class="container-modern py-5">

                <div class="section-heading mb-5">
                    <span>Кто мы</span>
                    <h2>О нашем автосервисе</h2>
                </div>

                <div class="row g-5 align-items-center mb-5">
                    <div class="col-lg-6">
                        <p class="about-lead">Кемеровский кооперативный техникум — это учебное заведение, которое готовит специалистов в области экономики, управления и сервиса. Мы предлагаем качественное образование, которое сочетает теорию и практику.</p>
                        <p class="about-text">Наши студенты участвуют в различных конкурсах и мероприятиях, что позволяет им развивать свои способности и получать ценный опыт.</p>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-stats-grid">
                            <div class="about-stat-card">
                                <strong>10+</strong>
                                <span>лет работы</span>
                            </div>
                            <div class="about-stat-card">
                                <strong>5000+</strong>
                                <span>клиентов</span>
                            </div>
                            <div class="about-stat-card">
                                <strong>50+</strong>
                                <span>мастеров</span>
                            </div>
                            <div class="about-stat-card">
                                <strong>4.9★</strong>
                                <span>рейтинг</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-12">
                        <div class="section-heading">
                            <span>Преимущества</span>
                            <h2>Почему нам доверяют</h2>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-card h-100 text-center">
                            <div class="feature-icon mx-auto"><i class="fas fa-chalkboard-teacher"></i></div>
                            <h5>Квалифицированные мастера</h5>
                            <p>Команда сертифицированных специалистов с многолетним опытом.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-card h-100 text-center">
                            <div class="feature-icon mx-auto"><i class="fas fa-book-open"></i></div>
                            <h5>Современные технологии</h5>
                            <p>Используем только актуальное диагностическое оборудование.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-card h-100 text-center">
                            <div class="feature-icon mx-auto"><i class="fas fa-tools"></i></div>
                            <h5>Практический подход</h5>
                            <p>Каждый ремонт выполняется с полным контролем качества.</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <div class="feature-card h-100 text-center">
                            <div class="feature-icon mx-auto"><i class="fas fa-trophy"></i></div>
                            <h5>Награды и признание</h5>
                            <p>Победители региональных и всероссийских конкурсов.</p>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-12">
                        <div class="section-heading">
                            <span>Контакты</span>
                            <h2>Как нас найти</h2>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-info-card feature-card">
                            <div class="feature-icon mb-3"><i class="fas fa-phone"></i></div>
                            <h5>Телефон</h5>
                            <p>+7 (999) 123-45-67</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-info-card feature-card">
                            <div class="feature-icon mb-3"><i class="fas fa-envelope"></i></div>
                            <h5>Email</h5>
                            <p>info@kuzbass-tech.ru</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="contact-info-card feature-card">
                            <div class="feature-icon mb-3"><i class="fas fa-map-marker-alt"></i></div>
                            <h5>Адрес</h5>
                            <p>ул. Тухачевского, 32, Кемерово</p>
                        </div>
                    </div>
                </div>

                <div class="map-wrapper mb-5">
                    <div class="section-heading">
                        <span>Карта</span>
                        <h2>Наше местоположение</h2>
                    </div>
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2269.376008805229!2d86.13175397728548!3d55.33398167293205!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x42d80ece310b9bf3%3A0xc7432657230c1b7e!2z0YPQuy4g0KLRg9GF0LDRh9C10LLRgdC60L7Qs9C-LCAzMiwg0JrQtdC80LXRgNC-0LLQviwg0JrQtdC80LXRgNC-0LLRgdC60LDRjyDQvtCx0LsuLCA2NTAwNzA!5e0!3m2!1sru!2sru!4v1745877454418!5m2!1sru!2sru" width="100%" height="420" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>

                <p class="about-footer-note">(*) Сайт разработан в рамках обучения в «Кузбасском кооперативном техникуме» по специальности «Специалист по информационным технологиям».</p>

            </div>
        </section>
HTML;
        $resultTemplate = sprintf($template, $title, $content);
        return $resultTemplate;
    }
}
