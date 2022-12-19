# Rapidez Multiple Wishlist

## Installation
```
composer require rapidez/multiple-wishlists
```

If you haven't published the Rapidez views yet, publish them with:
```
php artisan vendor:publish --provider="Rapidez\MultipleWishlist\MultipleWishlistServiceProvider" --tag=views
```

## API endpoints
The API uses the apiResource endpoints as shown in the table below. Note that every request except for `GET /wishlists/shared/{token}` requires a bearer token header for authorization. This is the magento oauth token of the customer.

| Endpoint | Parameters | Description |
| --- | --- | --- |
| GET /wishlists/ | None | Gets a list of all the customer's wishlists |
| GET /wishlists/{id} | None | Gets a specific wishlist |
| POST /wishlists/ | title | Creates a new wishlist with the given title |
| PATCH /wishlists/{id} | title(str, max 255), description(str, max 65535), share(bool) | Updates the data of a wishlist |
| DELETE /wishlists/{id} | None | Deletes a wishlist |
| POST /wishlists/item | wishlistId(int), productId(int), qty(int) | Adds a new item to the given wishlist |
| PATCH /wishlists/item/{id} | wishlistId(int), description(str, max 255), qty(int) | Updates the data of an item |
| DELETE /wishlists/item/{id} | None | Deletes an item |
| GET /wishlists/shared/{token} | None | Gets a shared wishlist |