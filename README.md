# Strikeball Shop (Laravel 11 MVP)

Готовый MVP интернет-магазина на Laravel 11/Blade + Docker (nginx + php-fpm + MySQL + Redis). Реализованы каталог, фильтры, корзина, checkout с Новой Почтой (mock/реал), оплата Monobank (sandbox/demo), CRM /admin, сиды с 40 товарами, промокоды, upsell на чек-ауте.

## Запуск
1. Скопируйте `.env.example` в `.env` и задайте ключи/доступы:
   - `APP_KEY` (после установки зависимостей: `php artisan key:generate`)
   - БД: `DB_HOST=mysql`, `DB_DATABASE=strikeball`, `DB_USERNAME=strikeball`, `DB_PASSWORD=secret`
   - Новая Почта: `NOVAPOSHTA_API_KEY` (пусто => mock), `NOVAPOSHTA_CACHE_HOURS`
   - Monobank: `MONO_TOKEN`, `MONO_WEBHOOK_SECRET`, `MONO_MODE=sandbox|live`
   - Админ: `ADMIN_EMAIL`, `ADMIN_PASSWORD`
2. Запустите контейнеры: `docker compose up --build`
3. Выполните в контейнере `app`:
   ```bash
   composer install
   php artisan key:generate
   php artisan migrate --seed
   ```
4. Откройте `http://localhost:8080`.

## Функциональность (Laravel версия)
- Главная: хиты, новинки, подборки, блок “Помочь с подбором” (хранится в `pickup_leads`).
- Категория `/category/{slug}`: поиск, сортировки по цене/новизне.
- Товар `/product/{slug}`: тюнинг-киты, рекомендации, upsell количественный.
- Корзина/checkout: промокоды START10/BBS50, доставка (НП/курьер/самовывоз), upsell магазинов (0–10).
- Новая Почта: `NovaPoshtaService::searchCities/getWarehouses` с кешем; mock при пустом ключе.
- Monobank: `MonobankService::createInvoice`, демо-оплата кнопкой на `/pay/monobank/{order}`; вебхук `/payment/monobank/webhook` меняет статус платежа/заказа.
- CRM `/admin` (middleware admin): dashboard, заказы, CRUD товаров, лиды “помочь с подбором”.

## Чистый PHP вариант (папка `php/`)
Параллельно добавлен минимальный клон без фреймворков:
- Каталог, поиск, карточка товара, рекомендации и тюнинг-киты из статического массива.
- Корзина и checkout на сессиях, промокоды START10/BBS50, upsell магазинов.
- Mock API: `/php/api/nova-poshta.php` (города/отделения), `/php/api/monobank.php` (invoice demo).
- Demo оплата: `/php/pay.php?order=ORD-XXX` с кнопкой “Оплачено (demo)”.
- CRM-страницы: `/php/admin/orders.php` (файл `php/data/orders.json`), `/php/admin/leads.php` (`php/data/leads.json`).

Запуск PHP-версии:
```bash
php -S localhost:8001 -t php
# открыть http://localhost:8001/index.php
```

## Тестовые данные
`php artisan migrate --seed` создаст категории (Приводы, Магазины, Шары, АКБ, Зарядки, Защита, Тюнинг), бренды и ~40 товаров с атрибутами и связями (recommended, tuning_kit). Admin: `admin@example.com` / `password` (если не переопределить в `.env`).

## Mock режимы
- **Новая Почта**: пустой `NOVAPOSHTA_API_KEY` → возвращаются тестовые города/отделения.
- **Monobank**: `MONO_MODE=sandbox` или пустой токен → invoice mock, кнопка “Оплачено (demo)” обновляет платеж.

## Полезные команды
- Миграции/сиды: `php artisan migrate --seed`
- Очистка кеша: `php artisan cache:clear`
- Тесты: `phpunit`

## Структура
- `app/Services` — Monobank, NovaPoshta
- `app/Http/Controllers` — публичные страницы, корзина/checkout, API, admin
- `database/migrations` — схема из ТЗ
- `database/seeders` — категории/товары/админ
- `resources/views/pages` — Blade-страницы из шаблонов
- `docker-compose.yml`, `docker/nginx/default.conf`, `docker/php/Dockerfile` — инфраструктура
