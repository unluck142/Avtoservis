<?php 
namespace App\Views;

use App\Views\BaseTemplate;

class RegisterTemplate extends BaseTemplate
{
    public static function getRegisterTemplate(): string {
        $template = parent::getTemplate();
        $title = 'Регистрация нового пользователя';

        $content = <<<HTML
        <div class="auth-page">
            <div class="auth-container">
                <div class="auth-card">
                    <h1 class="auth-title">Регистрация</h1>
        HTML;

        $content .= self::getFormRegister();
        $content .= '<p class="auth-alt-link mt-3 text-center">Уже есть аккаунт? <a href="/avtoservis/login">Войти</a></p>';
        $content .= '</div></div></div>';

        return sprintf($template, $title, $content);
    }

    public static function getVerifyTemplate(): string {
        $template = parent::getTemplate();
        $title = 'Подтверждение email';

        $content = <<<HTML
        <div class="auth-page">
            <div class="auth-container">
                <div class="auth-card text-center">
                    <div class="verify-icon mb-4">
                        <i class="fa-solid fa-circle-check fa-4x" style="color:#22c55e;"></i>
                    </div>
                    <h1 class="auth-title">Email подтверждён!</h1>
                    <p class="text-muted mb-4">Ваш адрес электронной почты успешно подтверждён. Теперь вы можете войти на сайт.</p>
                    <a href="/avtoservis/login" class="btn btn-primary">Войти</a>
                </div>
            </div>
        </div>
        HTML;

        return sprintf($template, $title, $content);
    }

    public static function getFormRegister(): string {
        return <<<HTML
        <form action="/avtoservis/register" method="POST">
            <div class="mb-3">
                <label for="nameInput" class="form-label">Имя пользователя</label>
                <input type="text" name="username" class="form-control" id="nameInput" placeholder="Ваше имя" required>
            </div>
            <div class="mb-3">
                <label for="emailInput" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" id="emailInput" placeholder="example@mail.ru">
            </div>
            <div class="mb-3">
                <label for="passwordInput" class="form-label">Пароль</label>
                <input type="password" name="password" class="form-control" id="passwordInput" placeholder="Минимум 6 символов">
            </div>
            <div class="mb-4">
                <label for="confirm_passwordInput" class="form-label">Подтверждение пароля</label>
                <input type="password" name="confirm_password" class="form-control" id="confirm_passwordInput" placeholder="Повторите пароль">
            </div>
            <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
        </form>
        HTML;
    }
}
