
# EEC TASK
this is a simple web app for product/pharmacy inventory, it doesn't require authentication. built using laravel, MySQL & Bootstrap CDN.



## Installation

To test this project firstly clone the repo then

```bash
  cd /eec-task
  composer install
```
configure your .env file by adding the Database identifiers required,

then 

```bash
    php artisan migrate
```

to fill out the Database a bit and see things a bit clear

```bash
    php artisan db:seed
```

to run the project either place it in your local server APACHE/NGINX or you can run 

``` bash
    php artisan serve
```
to upload the Images properly I'd like from you to run this command.

``` bash
    php artisan storage:link
```

### Note 
The Database seeders won't add image to products as i marked them a nullable "non-required field" 




## API Reference
### Products
#### Product Resource

```http
  /api/v1/products
```

#### Product search

```http
    POST /api/v1/products/search
```
| Parameter     | Type          | Description                       |
| :--------     | :-------      | :-------------------------------- |
| `query`       | `string`      | **Required**. peices of the Product to search for |

----------------
### Pharmacies
#### Pharmacies Resource

```http
  /api/v1/pharmacies
```

### Pharmacy Product add

```http
    POST /api/v1/pharmacies/{pharmacy}/add-product
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `product_id`      | `string` | **Required**. Id of product to add to the pharmacy |
| `price`      | `number` | **Required**. price of product to add to the pharmacy |

### Pharmacy remove Product

```http
    POST /api/v1/pharmacies/{pharmacy}/remove-product
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `product_id`      | `string` | **Required**. Id of product to remove from the pharmacy |


### Pharmacy Update Product's Price
```http
    PATCH /api/v1/pharmacies/{pharmacy}/products/{product}/update-price
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `price`      | `number` | **Required**. price of product to updated in the pharmacy |



### Pharmacy Available to add Products
Used to get The products that aren't linked to the pharmacy yet, so you can use IDs from the result and use it alongside the Pharmacy id to add it with a price

```http
    GET {pharmacy}/available-products
```



## Commands

### Get Cheapest 5 Pharmacies That sell a product
```bash
php artisan products:search-cheap {product_id}
```

replace the {product_id} with the id of the product you're searching for.
