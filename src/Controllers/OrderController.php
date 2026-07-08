<?php 
namespace App\Controllers;

use App\Views\OrderTemplate;
use App\Services\ProductFactory;
use App\Services\ValidateOrderData;
use App\Services\UserDBStorage;
use Exception;
use PDO;

class OrderController {
    private UserDBStorage $storage;

    public function __construct() {
        $this->storage = new UserDBStorage();
    }

    public function get(): string {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            return $this->create();
        }

        $model = ProductFactory::createProduct();
        $data = $model->getBasketData();
        $all_sum = $model->getAllSum($data);
        
        return OrderTemplate::getOrderTemplate($data, $all_sum);
    }

    public function create(): string {
        $arr = [];
        $arr['fio'] = strip_tags($_POST['fio']??'');
        $arr['address'] = strip_tags($_POST['address']??'');
        $arr['phone'] = strip_tags($_POST['phone']??'');
        $arr['email'] = strip_tags($_POST['email']??'');
        $arr['created_at'] = date("d-m-Y H:i:s");

        if (!ValidateOrderData::validate($arr)) {
            header("Location: /avtoservis/order");
            exit;
        }

        $_SESSION['order_data'] = $arr;
        $_SESSION['user_data'] = $arr;
        $_SESSION['flash'] = "Запись успешно создана!";
        header("Location: /avtoservis/select_time");
        exit;
    }

    public function selectTime(): string {
        if (!isset($_SESSION['order_data'])) {
            header("Location: /avtoservis/order");
            exit;
        }

        $fio     = htmlspecialchars($_SESSION['order_data']['fio']     ?? '');
        $address = htmlspecialchars($_SESSION['order_data']['address'] ?? '');
        $phone   = htmlspecialchars($_SESSION['order_data']['phone']   ?? '');
        $email   = htmlspecialchars($_SESSION['order_data']['email']   ?? '');
        $minDate = date('Y-m-d', strtotime('+1 day'));

        $template = \App\Views\BaseTemplate::getTemplate();

        $content = <<<HTML
        <section class="py-5">
            <div class="container-modern">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-8">
                        <div class="section-heading mb-4">
                            <span>Запись</span>
                            <h2>Выберите дату и время</h2>
                        </div>
                        <div class="card p-4">
                            <form action="/avtoservis/confirm_booking" method="POST">
                                <input type="hidden" name="fio"     value="{$fio}">
                                <input type="hidden" name="address" value="{$address}">
                                <input type="hidden" name="phone"   value="{$phone}">
                                <input type="hidden" name="email"   value="{$email}">

                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fa-solid fa-calendar me-2"></i>Дата
                                    </label>
                                    <input type="date" name="date" class="form-control"
                                           min="{$minDate}" required>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">
                                        <i class="fa-solid fa-clock me-2"></i>Время
                                    </label>
                                    <select name="time" class="form-select" required>
                                        <option value="" disabled selected>Выберите время</option>
                                        <option value="09:00">09:00</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="12:00">12:00</option>
                                        <option value="13:00">13:00</option>
                                        <option value="14:00">14:00</option>
                                        <option value="15:00">15:00</option>
                                        <option value="16:00">16:00</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fa-solid fa-check me-2"></i>Подтвердить запись
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        HTML;

        return sprintf($template, 'Выбор времени', $content);
    }
    
    public function confirmBooking(): void {
        try {
            if (!isset($_SESSION['user_id'])) {
                throw new Exception("Требуется авторизация");
            }
    
            if (empty($_SESSION['basket'])) {
                throw new Exception("Корзина пуста");
            }
    
            // Восстановление данных товаров
            $db = new PDO('mysql:host=localhost;dbname=is2211', 'root', '');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $original_sum = 0;
            foreach ($_SESSION['basket'] as $productId => &$item) {
                if (!isset($item['price']) || !isset($item['id'])) {
                    $stmt = $db->prepare("SELECT id, price FROM products WHERE id = ?");
                    $stmt->execute([$productId]);
                    $product = $stmt->fetch(PDO::FETCH_ASSOC);
                    
                    if ($product) {
                        $item['id'] = (int)$product['id'];
                        $item['price'] = (float)$product['price'];
                    }
                }
                
                if (!isset($item['quantity'])) {
                    $item['quantity'] = 1;
                }
                
                $original_sum += $item['price'] * $item['quantity'];
            }
            unset($item);
    
            // Применяем скидку
            $discounted_sum = $original_sum;
            if (isset($_SESSION['discount'])) {
                $discountText = $_SESSION['discount'];
                if (strpos($discountText, '%') !== false) {
                    $percent = (float)str_replace('% скидки', '', $discountText);
                    $discounted_sum *= (1 - $percent/100);
                } elseif ($discountText === "Бесплатная доставка") {
                    // Если у вас есть стоимость доставки, вычтите её здесь
                    // $discounted_sum -= DELIVERY_COST;
                }
            }
    
            $sessionData = $_SESSION['order_data'] ?? [];
            $orderData = [
                'user_id' => $_SESSION['user_id'],
                'fio'     => $_POST['fio']     ?: ($sessionData['fio']     ?? ''),
                'address' => $_POST['address'] ?: ($sessionData['address'] ?? ''),
                'phone'   => $_POST['phone']   ?: ($sessionData['phone']   ?? ''),
                'email'   => $_POST['email']   ?: ($sessionData['email']   ?? ''),
                'original_sum' => $original_sum,
                'discounted_sum' => $discounted_sum,
                'discount' => $_SESSION['discount'] ?? null,
                'products' => []
            ];
    
            foreach ($_SESSION['basket'] as $item) {
                $orderData['products'][] = [
                    'id' => (int)$item['id'],
                    'price' => (float)$item['price'],
                    'quantity' => (int)$item['quantity']
                ];
            }
    
            if (empty($orderData['products'])) {
                throw new Exception("Невозможно оформить заказ. Корзина пуста или содержит ошибки.");
            }
    
            $orderId = $this->storage->saveOrder($orderData);

            // Сохраняем запись на ТО в appointments (дата и время из формы select_time)
            $date = $_POST['date'] ?? null;
            $time = $_POST['time'] ?? null;
            if ($date && $time && isset($_SESSION['user_id'])) {
                $this->storage->saveAppointment([
                    'user_id'      => $_SESSION['user_id'],
                    'date'         => $date,
                    'time'         => $time,
                    'service_type' => implode(', ', array_column($orderData['products'], 'id')),
                    'comments'     => null,
                ]);
            }
            
            $_SESSION['flash'] = "Заказ #$orderId успешно оформлен!";
            unset($_SESSION['basket'], $_SESSION['discount'], $_SESSION['order_data']);
            header("Location: /avtoservis/history");
            exit;
        } catch (Exception $e) {
            $_SESSION['flash'] = $e->getMessage();
            error_log("Order confirmation failed: " . $e->getMessage());
            header("Location: /avtoservis/order");
            exit;
        }
    }


    public function history(): string {
        if (!isset($_SESSION['user_id'])) {
            header("Location: /avtoservis/login");
            exit;
        }
        
        try {
            $orders = $this->storage->getOrderHistory($_SESSION['user_id']);
            return \App\Views\UserTemplate::getHistoryTemplate($orders);
        } catch (Exception $e) {
            error_log("Error fetching order history: " . $e->getMessage());
            $_SESSION['flash'] = "Ошибка при загрузке истории заказов";
            header("Location: /avtoservis/");
            exit;
        }
    }
    public function applyDiscount() {
        if (isset($_POST['discount'])) {
            $_SESSION['discount'] = $_POST['discount'];
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    }
}