# Rapidez Multiple Wishlist

## Installation
```
composer require rapidez/multiple-wishlists
```

It's not recommended to publish every view, rather you should overwrite only the files necessary. However, you can still publish all of the views with the following command:
```
php artisan vendor:publish --provider="Rapidez\MultipleWishlist\MultipleWishlistServiceProvider" --tag=views
```

You also should probably add a new "wishlists" button to the Rapidez account menu, if you use it in your project (which is in `rapidez/account/resources/views/partials/menu.blade.php`)

## API endpoints
The API uses mostly Laravel apiResource endpoints. All of the exposed endpoints can be found below. Note that every request except for `GET /wishlists/shared/{token}` requires a bearer token header for authorization. This is the magento oauth token of the customer.

| Endpoint | Parameters | Description |
| --- | --- | --- |
| GET /wishlists/ | None | Gets a list of all the customer's wishlists |
| POST /wishlists/ | <ul><li>title</li></ul> | Creates a new wishlist with the given title |
| PATCH /wishlists/{id} | <ul><li>title(str, max 255)</li><li>description(str, max 65535)</li><li>share(bool)</li></ul> | Updates the data of a wishlist |
| DELETE /wishlists/{id} | None | Deletes a wishlist |
| GET /wishlists/shared/{token} | None | Gets a shared wishlist |

| Endpoint | Parameters | Description |
| --- | --- | --- |
| POST /wishlists/item | <ul><li>wishlist_id(int)</li><li>product_id(int)</li><li>qty(int)</li></ul> | Adds a new item to the given wishlist |
| PATCH /wishlists/item/{id} | <ul><li>description(str, max 255)</li><li>qty(int)</li></ul> | Updates the data of an item |
| DELETE /wishlists/item/{id} | None | Deletes an item |

## Colors
When you install Rapidez, the colors are already configured in your `tailwind.config.js`. This ensures that your colors are consistently applied across all elements.
Colors can be found in the [Rapidez docs](https://docs.rapidez.io/3.x/theming.html#colors).

## Components
In this package we use the [Rapidez blade-components](https://github.com/rapidez/blade-components). When you install Rapidez, the rapidez/blade-components package is already installed.
