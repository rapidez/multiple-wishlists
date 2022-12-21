# Rapidez Multiple Wishlist

## Installation
```
composer require rapidez/multiple-wishlists
```

If you haven't published the Rapidez views yet, publish them with:
```
php artisan vendor:publish --provider="Rapidez\MultipleWishlist\MultipleWishlistServiceProvider" --tag=views
```

You also have to add a new button to the Rapidez account menu (Which is in `rapidez/account/resources/views/partials/menu.blade.php`)

## API endpoints
The API uses the Laravel apiResource endpoints as shown in the table below. Note that every request except for `GET /wishlists/shared/{token}` requires a bearer token header for authorization. This is the magento oauth token of the customer.

| Endpoint | Parameters | Description |
| --- | --- | --- |
| GET /wishlists/ | None | Gets a list of all the customer's wishlists |
| GET /wishlists/{id} | None | Gets a specific wishlist |
| POST /wishlists/ | <ul><li>title</li></ul> | Creates a new wishlist with the given title |
| PATCH /wishlists/{id} | <ul><li>title(str, max 255)</li><li>description(str, max 65535)</li><li>share(bool)</li></ul> | Updates the data of a wishlist |
| DELETE /wishlists/{id} | None | Deletes a wishlist |
| POST /wishlists/item | <ul><li>wishlistId(int)</li><li>productId(int)</li><li>qty(int)</li></ul> | Adds a new item to the given wishlist |
| PATCH /wishlists/item/{id} | <ul><li>wishlistId(int)</li><li>description(str, max 255)</li><li>qty(int)</li></ul> | Updates the data of an item |
| DELETE /wishlists/item/{id} | None | Deletes an item |
| GET /wishlists/shared/{token} | None | Gets a shared wishlist |