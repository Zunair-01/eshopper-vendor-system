```markdown
# Eshopper

"A vendor-oriented e-commerce management system designed for multi-seller environments. It enables vendors to list products, manage inventory, track orders, and monitor sales analytics efficiently. The admin panel provides complete control over vendors, payments, and system configurations. Integrated with secure payment gateways and real-time reporting, Eshopper ensures transparency, efficiency, and a professional experience for both sellers and customers."

---

## 🚀 Key Features

- **Multi-Vendor Management:** Dedicated seller dashboards for product management, stock updates, and order processing.
- **Admin Control Panel:** Complete oversight of vendor onboarding, commission structures, payout management, and system settings.
- **Sales Analytics & Reporting:** Real-time visual reports tracking revenue, orders, and inventory metrics.
- **Secure Payment Gateway:** Stripe API integration for reliable customer checkouts and multi-party payout handling.
- **Order & Inventory Tracking:** Live status management for orders from placement to delivery.

---

## 🛠️ Tech Stack

- **Backend:** Laravel / PHP
- **Database:** MySQL
- **Payment Processing:** Stripe API
- **Frontend:** HTML, CSS, Bootstrap, JavaScript, Blade Templating
- **Analytics & Visuals:** Chart.js / DataTables

---

## 💻 Local Setup Instructions

Follow these step-by-step instructions to set up and run the project in your local development environment:

### 1. **Clone the Repository**
Clone the project repository to your local machine and navigate into the project directory:

```bash
git clone [https://github.com/Zunair-01/eshopper-vendor-system.git](https://github.com/Zunair-01/eshopper-vendor-system.git)
cd eshopper-vendor-system

```

### 2. **Install PHP Dependencies**

Install all required Composer dependencies:

```bash
composer install

```

### 3. **Configure Environment File**

Create a copy of the default environment configuration file:

```bash
# On Windows (CMD / PowerShell):
copy .env.example .env

# On Linux / macOS / Git Bash:
cp .env.example .env

```

### 4. **Generate Application Key**

Generate the Laravel security and encryption key:

```bash
php artisan key:generate

```

### 5. **Configure Database & Credentials**

Start your MySQL server (via XAMPP, WAMP, or terminal), create a database named `eshopper_db`, and update the `.env` file:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=eshopper_db
DB_USERNAME=root
DB_PASSWORD=

# Stripe Payment Credentials
STRIPE_KEY=your_stripe_publishable_key
STRIPE_SECRET=your_stripe_secret_key

```

### 6. **Run Database Migrations & Seeders**

Set up the database tables and populate seed data (including default admin and vendor accounts):

```bash
php artisan migrate --seed

```

### 7. **Link Storage Directory**

Create the symbolic link to serve product images and uploaded assets:

```bash
php artisan storage:link

```

### 8. **Start the Application**

Launch the Laravel development server:

```bash
php artisan serve

```

Access the application in your browser at: **`http://127.0.0.1:8000`**

```

```
