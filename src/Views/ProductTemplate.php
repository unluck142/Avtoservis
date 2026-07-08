<?php

namespace App\Views;

use App\Views\BaseTemplate;

class ProductTemplate extends BaseTemplate {
    public static function getCardTemplate(?array $data) {
        $template = parent::getTemplate();
        if ($data) {
            $title = htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8');
            $description = htmlspecialchars($data['description'], ENT_QUOTES, 'UTF-8');
            $price = htmlspecialchars($data['price'], ENT_QUOTES, 'UTF-8');
            $image = htmlspecialchars($data['image'], ENT_QUOTES, 'UTF-8');
            $id = (int)$data['id'];

            $content = <<<HTML
            <section class="product-detail-section py-5">
                <div class="container-modern">
                    <a href="/avtoservis/products" class="btn btn-outline-light mb-4">
                        <i class="fa-solid fa-arrow-left me-2"></i>Назад к услугам
                    </a>
                    <div class="row g-5 align-items-center">
                        <div class="col-lg-5">
                            <div class="product-img-wrap">
                                <img src="{$image}" class="product-detail-img" alt="{$title}">
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <div class="product-detail-body">
                                <h1 class="product-detail-title">{$title}</h1>
                                <p class="product-detail-desc">{$description}</p>
                                <div class="product-detail-price">{$price} ₽</div>
                                <form action="/avtoservis/basket" method="POST" class="mt-4">
                                    <input type="hidden" name="id" value="{$id}">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fa-solid fa-cart-plus me-2"></i>Добавить в корзину
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            HTML;
        } else {
            $title = "404 — Страница не найдена";
            $content = <<<HTML
            <section class="py-5 text-center">
                <div class="container-modern">
                    <h1 style="font-size:80px;font-weight:900;color:#3b82f6;">404</h1>
                    <h2 class="mb-3">Страница не найдена</h2>
                    <p class="text-muted mb-4">Запрашиваемая услуга не существует или была удалена.</p>
                    <a href="/avtoservis/products" class="btn btn-primary">Все услуги</a>
                </div>
            </section>
            HTML;
        }
        return sprintf($template, $title, $content);
    }

    public static function getAllTemplate(array $arr): string {
        $template = parent::getTemplate();

        $cards = '';
        foreach ($arr as $item) {
            $itemName        = htmlspecialchars($item['name'],        ENT_QUOTES, 'UTF-8');
            $itemDescription = htmlspecialchars($item['description'], ENT_QUOTES, 'UTF-8');
            $itemPrice       = htmlspecialchars($item['price'],       ENT_QUOTES, 'UTF-8');
            $itemImage       = htmlspecialchars($item['image'],       ENT_QUOTES, 'UTF-8');
            $itemId          = (int)$item['id'];

            $cards .= <<<HTML
            <div class="col-sm-6 col-lg-4 mb-4">
                <div class="card service-card h-100">
                    <div class="service-card-img-wrap">
                        <img src="{$itemImage}" class="card-img-top service-card-img" alt="{$itemName}">
                    </div>
                    <div class="card-body d-flex flex-column p-4">
                        <h5 class="card-title service-card-title">
                            <a href="/avtoservis/products/{$itemId}">{$itemName}</a>
                        </h5>
                        <p class="card-text service-card-desc flex-grow-1">{$itemDescription}</p>
                        <div class="service-card-price">{$itemPrice} ₽</div>
                        <form action="/avtoservis/basket" method="POST" class="mt-3">
                            <input type="hidden" name="id" value="{$itemId}">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa-solid fa-cart-plus me-2"></i>В корзину
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            HTML;
        }

        $content = <<<HTML
        <section class="services-section py-5">
            <div class="container-modern">
                <div class="section-heading text-center mb-5">
                    <span>Каталог</span>
                    <h2>Наши услуги</h2>
                </div>
                <div class="row">{$cards}</div>
            </div>
        </section>
        HTML;

        return sprintf($template, 'Каталог услуг', $content);
    }
}
