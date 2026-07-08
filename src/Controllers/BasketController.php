<?php

namespace App\Controllers;

class BasketController
{
    public function add(): void
    {

        if (isset($_POST['id'])) {
            $product_id = $_POST['id'];
            if (!isset($_SESSION['basket'])) {
                $_SESSION['basket'] = [];
            }

            if (isset($_SESSION['basket'][$product_id])) {
                $_SESSION['basket'][$product_id]['quantity']++;
            } else {
                $_SESSION['basket'][$product_id] = [
                'quantity' => 1
                ];
            }
            //var_dump($_SESSION);
            //exit();
            $_SESSION['flash'] = "Товар успешно добавлен в корзину!";
        }
    }
    /*
    Очистка корзины
    */
    public function clear(): void
    {
        $_SESSION['basket'] = [];
        $_SESSION['flash'] = "Корзина успешно очищена.";
    }
    public function getTotal(): float {
        $total = 0.0;
        if (empty($_SESSION['basket'])) {
            return $total;
        }

        // Получаем цены из БД для товаров у которых цена не закэширована в сессии
        $pdo = new \PDO('mysql:host=localhost;dbname=is2211', 'root', '');
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        foreach ($_SESSION['basket'] as $productId => &$item) {
            if (!isset($item['price'])) {
                $stmt = $pdo->prepare('SELECT price FROM products WHERE id = ?');
                $stmt->execute([$productId]);
                $row = $stmt->fetch(\PDO::FETCH_ASSOC);
                $item['price'] = $row ? (float)$row['price'] : 0.0;
            }
            $total += (float)$item['price'] * (int)($item['quantity'] ?? 1);
        }
        unset($item);

        // Применяем скидку если есть
        if (isset($_SESSION['discount'])) {
            $discountText = $_SESSION['discount'];
            if (strpos($discountText, '%') !== false) {
                $percent = (float)str_replace('% скидки', '', $discountText);
                $total *= (1 - $percent / 100);
            } elseif ($discountText === "Бесплатная доставка") {
                $total = max(0, $total - 500);
            }
        }

        return round($total, 2);
    }
    public function showDiscountButton(): string{
        return '<button id="show-wheel">Получить скидку!</button>';
    }
    
}