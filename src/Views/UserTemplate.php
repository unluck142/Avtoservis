<?php 
namespace App\Views;

use App\Views\BaseTemplate;
use App\Configs\Config;

class UserTemplate extends BaseTemplate
{
    public static function getUserTemplate(): string {
        $template = parent::getTemplate();
        $title = 'Вход в аккаунт';

        $content = <<<HTML
        <div class="auth-page">
            <div class="auth-container">
                <div class="auth-card">
                    <h1 class="auth-title">Вход</h1>
        HTML;

        $content .= self::getFormLogin();
        $content .= '<p class="auth-alt-link mt-3 text-center">Нет аккаунта? <a href="/avtoservis/register">Зарегистрироваться</a></p>';
        $content .= '</div></div></div>';

        return sprintf($template, $title, $content);
    }

    public static function getFormLogin(): string {
        return <<<HTML
        <form action="/avtoservis/login" method="POST">
            <div class="mb-3">
                <label for="nameInput" class="form-label">Логин (имя или email)</label>
                <input type="text" name="username" class="form-control" id="nameInput" placeholder="Введите имя или email" required>
            </div>
            <div class="mb-4">
                <label for="passwordInput" class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Введите пароль" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Войти</button>
        </form>
        HTML;
    }

    public static function getHistoryTemplate(?array $data): string {
        $template = parent::getTemplate();
        $title = 'История заказов';

        $rows = '';
        if (!empty($data)) {
            foreach ($data as $row) {
                $orderDate  = date("d.m.Y H:i", strtotime($row['created']));
                $nameStatus = Config::getStatusName($row['status']);
                $colorStyle = Config::getStatusColor($row['status']);
                $orderId    = (int)$row['id'];
                $allSum     = htmlspecialchars($row['all_sum']);

                $rows .= <<<HTML
                <tr>
                    <td>Заказ #{$orderId}</td>
                    <td>{$orderDate}</td>
                    <td>{$allSum} ₽</td>
                    <td><span class="status-badge {$colorStyle}">{$nameStatus}</span></td>
                </tr>
                HTML;
            }
        } else {
            $rows = '<tr><td colspan="4" class="text-center text-muted py-4">Заказов пока нет</td></tr>';
        }

        $content = <<<HTML
        <section class="history-section py-5">
            <div class="container-modern">
                <div class="section-heading mb-5">
                    <span>Профиль</span>
                    <h2>История заказов</h2>
                </div>
                <div class="card p-4">
                    <div class="table-responsive">
                        <table class="table table-dark table-hover">
                            <thead>
                                <tr>
                                    <th>Номер заказа</th>
                                    <th>Дата</th>
                                    <th>Сумма</th>
                                    <th>Статус</th>
                                </tr>
                            </thead>
                            <tbody>{$rows}</tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        HTML;

        return sprintf($template, $title, $content);
    }

    public static function getProfileForm(array $userData = []): string {
        $template = parent::getTemplate();
        $title = 'Редактирование профиля';

        $username = htmlspecialchars($userData['username'] ?? '');
        $email    = htmlspecialchars($userData['email'] ?? '');
        $address  = htmlspecialchars($userData['address'] ?? '');
        $phone    = htmlspecialchars($userData['phone'] ?? '');
        $avatar   = htmlspecialchars($userData['avatar'] ?? '/avtoservis/assets/images/logo.png');

        $content = <<<HTML
        <section class="profile-section py-5">
            <div class="container-modern">
                <div class="section-heading mb-5">
                    <span>Профиль</span>
                    <h2>Редактирование профиля</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="card p-4">
                            <form action="/avtoservis/profile/update" method="POST" enctype="multipart/form-data">

                                <div class="avatar-wrapper text-center mb-4">
                                    <img src="{$avatar}" alt="Аватар" class="avatar-preview-form" id="avatarPreview">
                                    <label class="btn btn-outline-light mt-3 d-block upload-btn-label">
                                        <i class="fas fa-camera me-2"></i>Загрузить фото
                                        <input type="file" name="avatar" accept="image/*" id="avatarInput">
                                    </label>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-user me-2"></i>Имя пользователя</label>
                                    <input type="text" name="username" class="form-control" value="{$username}" placeholder="Имя пользователя" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-envelope me-2"></i>Email</label>
                                    <input type="email" name="email" class="form-control" value="{$email}" placeholder="Email" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label"><i class="fas fa-map-marker-alt me-2"></i>Адрес</label>
                                    <input type="text" name="address" class="form-control" value="{$address}" placeholder="Ваш адрес">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label"><i class="fas fa-phone me-2"></i>Телефон</label>
                                    <input type="text" name="phone" class="form-control" value="{$phone}" placeholder="+7 (900) 000-00-00">
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Сохранить изменения
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input   = document.getElementById('avatarInput');
            const preview = document.getElementById('avatarPreview');
            if (input && preview) {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(ev) { preview.src = ev.target.result; };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
        </script>
        HTML;

        return sprintf($template, $title, $content);
    }
}
