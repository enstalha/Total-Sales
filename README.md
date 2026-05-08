# Total Sales

A marketplace web app built with PHP and MySQL for a university course on Internet-Based Programming. Users can buy and sell items either at a fixed price or through live auctions.

---

## What It Is

Total Sales is a simple online marketplace. Sellers can list items and start auctions. Buyers can browse listings, place bids, and buy items directly. After a transaction, buyers can leave a star rating for the seller.

There are two roles: **seller** and **buyer**. You pick your role when you register. Passwords are hashed with SHA-256.

---

## Setup

You need XAMPP (or any local PHP + MySQL server).

### 1. Clone / copy the project

Put the project folder inside `C:/xampp/htdocs/`:

```
C:/xampp/htdocs/TotalSales/
```

### 2. Create the database

1. Start Apache and MySQL from the XAMPP Control Panel.
2. Open [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
3. Import `database/schema.sql`. This creates the `totalsales` database and all the tables.

### 3. Check the database config

Open `config/db.php` and make sure the credentials match your local setup:

```php
$host = 'localhost';
$db   = 'totalsales';
$user = 'root';
$pass = '';
```

### 4. Run it

Go to [http://localhost/TotalSales](http://localhost/TotalSales) in your browser.

---

## How to Use

### As a Seller

- Register with the **seller** role.
- Go to your dashboard and add a new item (title, description, price, category).
- Optionally, start an auction for any of your items. Set a starting price and an end time.
- View your sales history and see ratings buyers left for you.

### As a Buyer

- Register with the **buyer** role.
- Browse available items on the home page.
- Buy an item directly, or go to an active auction and place a bid.
- After a purchase, you can rate the seller (1–5 stars).

---

## Folder Structure

```
TotalSales/
├── index.php              # Entry point, handles routing
├── config/
│   └── db.php             # Database connection
├── database/
│   └── schema.sql         # SQL to create all tables
├── app/
│   ├── controllers/       # Request handling logic
│   │   ├── AuthController.php
│   │   ├── ItemController.php
│   │   ├── AuctionController.php
│   │   ├── TransactionController.php
│   │   └── RatingController.php
│   ├── models/            # Database queries
│   └── views/             # HTML templates
│       ├── auth/
│       ├── items/
│       ├── auctions/
│       ├── user/
│       └── layout/        # Shared header/footer
└── public/
    ├── css/               # Stylesheets
    └── js/                # JavaScript (AJAX for bidding, etc.)
```

---

## Notes

- No external frameworks or libraries are used on the backend.
- AJAX is used for live bidding so the page does not reload on every bid.
- This is a university project. It is not meant to be production-ready.
