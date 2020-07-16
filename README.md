# Adeoweb (Back End Task)

> Demo API service url: https://secure-wave-65543.herokuapp.com

## Table of contents

-   [General info](#general-info)
-   [Technologies](#technologies)
-   [Quick start](#quick-start)
-   [Endpoints](#endpoints)

## General info

Service which returns product recommendations depending on current weather.

> For current weather used LHMT https://api.meteo.lt/

## Technologies

Created with:

-   PHP 7.3+
-   MySQL 5.7.26
-   Laravel 7

## Quick start

```bash
# Download GitHub project or clone
git clone https://github.com/manaxi/adeoweb_backend_task

# Install Dependencies
composer install

# Create database and edit .env file

# Migrate database
php artisan migrate

# Import Products, Categories and Cities
php artisan db:seed

# Add virtual host if using Apache

# If you get an error about an encryption key
php artisan key:generate

```

## Endpoints

### Get product recommendations depending on current weather

```bash
GET api/products/recommended/{city}
```

### List all products

```bash
GET api/products
```

### Get single product

```bash
GET api/product/{id}
```

### Delete product

```bash
DELETE api/product/{id}
```

### Add product

```bash
POST api/product
name/sku/price/status/[categories]
JSON exmple
{
    "name": "Product name",
    "sku": "5464545555",
    "price": "15",
    "status": "1",
    "categories": [
        "1", "2"
    ]

}
```

### Update product

```bash
PUT api/product
product_id/sku/price/status/categories:[category_ids]
JSON exmple
{
    "name": "Product name",
    "sku": "5464545555",
    "price": "15",
    "status": "1",
    "categories": [
        "1", "2"
    ]

}
```

### List all categories

```bash
GET api/categories
```

### Get single category

```bash
GET api/categories/{id}
```

### Add category

```bash
POST api/categories
name/weather/slug
JSON exmple
{
    "name": "category name",
    "weather": "clear",
    "slug": "test-from"

}
```

### Update category

```bash
PUT api/categories
category_id/name/weather/slug
JSON exmple
{
    "category_id": '2',
    "name": "category name",
    "weather": "clear",
    "slug": "test-from"

}
```

### Delete category

```bash
DELETE api/categories/{id}
```

### Show category products

```bash
GET api/categories/{id}/products
```

### List all cities

```bash
GET api/cities
```

## Author
> Mantas Pečiulis
