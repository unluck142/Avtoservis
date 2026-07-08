<?php
namespace App\Views;

use App\Views\BaseTemplate;

class OrderTemplate extends BaseTemplate {
    public static function getOrderTemplate(array $arr, float $all_sum): string {
        $template = parent::getTemplate();
        $title = 'Оформление заказа';

        $cartRows = '';
        $all_sum  = 0.0;

        if (empty($arr)) {
            $cartRows = '<div class="empty-cart-msg"><i class="fa-solid fa-cart-xmark fa-2x mb-3"></i><p>Корзина пуста. <a href="/avtoservis/products">Перейти к услугам</a></p></div>';
        } else {
            foreach ($arr as $product) {
                $name     = htmlspecialchars($product['name'] ?? '');
                $price    = (float)($product['price'] ?? 0);
                $quantity = (int)($product['quantity'] ?? 0);
                $sum      = (float)($product['sum'] ?? 0);
                $all_sum += $sum;

                $cartRows .= <<<HTML
                <div class="cart-row d-flex justify-content-between align-items-center">
                    <div>
                        <div class="cart-row-name">{$name}</div>
                        <div class="cart-row-meta">{$quantity} × {$price} ₽</div>
                    </div>
                    <div class="cart-row-sum">{$sum} ₽</div>
                </div>
                HTML;
            }

            $cartRows .= <<<HTML
            <div class="cart-total d-flex justify-content-between mt-4">
                <span>Итого:</span>
                <strong>{$all_sum} ₽</strong>
            </div>
            HTML;
        }

        $content = <<<HTML
        <section class="order-section py-5">
            <div class="container-modern">
                <div class="section-heading mb-5">
                    <span>Запись</span>
                    <h2>Оформление заказа</h2>
                </div>
                <div class="row g-5">
                    <div class="col-lg-5">
                        <div class="order-cart-card card p-4">
                            <h4 class="mb-4"><i class="fa-solid fa-cart-shopping me-2"></i>Ваша корзина</h4>
                            {$cartRows}
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card p-4">
                            <h4 class="mb-4"><i class="fa-solid fa-pen-to-square me-2"></i>Данные для заказа</h4>
        HTML;

        $content .= self::getOrderForm();
        $content .= '</div></div></div></div></section>';

        return sprintf($template, $title, $content);
    }

    private static function getOrderForm(): string {
        $fio = htmlspecialchars($_SESSION['user_data']['username'] ?? '');

        return <<<HTML
        <form action="/avtoservis/order" method="POST">
            <div class="mb-4">
                <label class="form-label">Ваше ФИО</label>
                <input type="text" name="fio" class="form-control" value="{$fio}" placeholder="Иванов Иван Иванович" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Адрес</label>
                <input type="text" name="address" class="form-control" placeholder="Ваш адрес" required>
            </div>
            <div class="mb-4">
                <label class="form-label">Телефон</label>
                <input type="tel" name="phone" class="form-control" placeholder="+7 (900) 000-00-00" required>
            </div>
            <div class="mb-4">
                <label class="form-label">E-mail</label>
                <input type="email" name="email" class="form-control" placeholder="example@mail.ru" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fa-solid fa-check me-2"></i>Оформить заказ
            </button>
        </form>
        HTML;
    }
}
