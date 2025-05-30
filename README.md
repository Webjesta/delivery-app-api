````markdown
# Delivery App API

A Laravel-powered RESTful API backend for a delivery application. Supports:

- **User Authentication** (register/login/logout) via Laravel Sanctum  
- **Roles**: Seller & Customer  
- **Seller Features**  
  - CRUD **Products**  
  - View & update **Orders** placed on their products  
- **Customer Features**  
  - **Browse** available products  
  - **Place** new orders  
  - **View** own orders  
- **Notifications** (in-app & email)  
  - Sellers notified of new orders  
  - Customers notified of order status changes  

---

## Table of Contents

1. [Prerequisites](#prerequisites)  
2. [Installation & Setup](#installation--setup)  
3. [Environment Configuration](#environment-configuration)  
4. [Database Migrations & Seeding](#database-migrations--seeding)  
5. [Running the App](#running-the-app)  
6. [API Endpoints](#api-endpoints)  
7. [Notifications](#notifications)  
8. [Testing with Postman](#testing-with-postman)  
9. [Contributing](#contributing)  
10. [License](#license)

---

## Prerequisites

- PHP ≥ 8.1  
- Composer  
- MySQL  
- Node.js & NPM (for future front-end, optional)  

---

## Installation & Setup

```bash
# 1. Clone the repo
git clone https://github.com/<your-username>/delivery-app-api.git
cd delivery-app-api

# 2. Install PHP dependencies
composer install

# 3. Copy & configure .env
cp .env.example .env
# edit .env → set DB_* and SANCTUM stateful domains if needed

# 4. Generate app key
php artisan key:generate

# 5. (Optional) Install NPM deps
npm install

# 6. Build front-end assets (if you have any)
npm run dev
````

---

## Environment Configuration

Open `.env` and set at minimum:

```ini
APP_NAME="Delivery App API"
APP_ENV=local
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=delivery_app
DB_USERNAME=your_mysql_user
DB_PASSWORD=your_mysql_password

SANCTUM_STATEFUL_DOMAINS=127.0.0.1:8000
```

---

## Database Migrations & Seeding

```bash
# Run all migrations
php artisan migrate

# (Optional) Seed sample data
php artisan db:seed
```

---

## Running the App

```bash
# Start the built-in dev server
php artisan serve
# The API is now available at http://127.0.0.1:8000/api
```

---

## API Endpoints

All routes are prefixed with `/api`. Use **Bearer** token for protected routes.

### Authentication

| Method | URI         | Body Params                                                                                                        | Description                      |
| ------ | ----------- | ------------------------------------------------------------------------------------------------------------------ | -------------------------------- |
| POST   | `/register` | `name`, `email`, `password`,<br>`password_confirmation`, `role` (`seller`/`customer`),<br>`shop_name` or `address` | Register as seller or customer   |
| POST   | `/login`    | `email`, `password`                                                                                                | Login and receive `access_token` |
| POST   | `/logout`   | *none* (Bearer token header)                                                                                       | Revoke current token             |

### Seller Routes *(role = seller)*

| Method | URI                     | Body Params                                               | Description                         |
| ------ | ----------------------- | --------------------------------------------------------- | ----------------------------------- |
| GET    | `/seller/products`      | *none*                                                    | List all your products              |
| POST   | `/seller/products`      | `name`, `description`, `price`, `stock`                   | Create a new product                |
| GET    | `/seller/products/{id}` | *none*                                                    | Get a single product by ID          |
| PUT    | `/seller/products/{id}` | `name`, `description`, `price`, `stock`                   | Update your product by ID           |
| DELETE | `/seller/products/{id}` | *none*                                                    | Delete your product by ID           |
| GET    | `/seller/orders`        | *none*                                                    | List orders placed on your products |
| PATCH  | `/seller/orders/{id}`   | `status` (`pending`,`processing`,`completed`,`cancelled`) | Update order status                 |

### Customer Routes *(role = customer)*

| Method | URI                     | Body Params              | Description                |
| ------ | ----------------------- | ------------------------ | -------------------------- |
| GET    | `/customer/browse`      | *none*                   | List all in-stock products |
| POST   | `/customer/orders`      | `product_id`, `quantity` | Place a new order          |
| GET    | `/customer/orders`      | *none*                   | List your orders           |
| GET    | `/customer/orders/{id}` | *none*                   | Get a single order by ID   |

### Notifications

| Method | URI                        | Description                      |
| ------ | -------------------------- | -------------------------------- |
| GET    | `/notifications`           | Get current user’s notifications |
| PATCH  | `/notifications/{id}/read` | Mark a notification as read      |

---

## Notifications

* **Stored** in the `notifications` table.
* **Fired** when:

  * Customer places an order → Seller receives `NewOrderNotification`.
  * Seller updates status → Customer receives `OrderStatusChangedNotification`.
* **Access** via `/api/notifications` (with token).

---

## Testing with Postman

1. **Register** seller & customer.
2. **Login** both and store their tokens.
3. **Test**:

   * Seller: CRUD products, view/update orders.
   * Customer: browse products, place orders, view orders.
   * Notifications endpoint.
4. **Headers** for protected routes:

   ```
   Authorization: Bearer <token>
   Accept: application/json
   ```

---

## Contributing

Feel free to open issues or PRs! Suggested workflow:

1. Fork & clone.
2. Create a feature branch (`git checkout -b feat/awesome`).
3. Commit your changes (`git commit -m "Add awesome feature"`).
4. Push (`git push origin feat/awesome`) & open a PR.

---

## License

This project is open-source, released under the [MIT License](LICENSE).

```

Feel free to adjust any sections (e.g. database seeders, mail setup) as your project evolves!
```
