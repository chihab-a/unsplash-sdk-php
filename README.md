Unsplash SDK for PHP
================

Open source SDK for integrating [Unsplash](https://unsplash.com/)'s OAuth2 API into your PHP application. Please note that Unsplash's API is still on an early stage and this implementation is not final. Breaking changes will happen. This SDK is unofficial. Unsplash's API documentation can be found [here](https://unsplash.com/documentation).

## Installation
```bash
composer install
```

## Authentication
Initialize the SDK with your client credentials:
```php
    use Chihab\UnsplashSdk\Api\Unsplash;

    $credentials = [
        'client-id' => 'CLIENT-ID',
        'client-secret' => 'CLIENT-SECRET',
        'redirect-url' => 'http://example.com/callback',
        'scopes' => 'scope1,scope2',
    ];

    $unsplash = new Unsplash($credentials);
```

You can also use the `connect` method.
```php
    use Chihab\UnsplashSdk\Api\Unsplash;

    $unsplash = new Unsplash();
    $unsplash->connect($credentials);
```

#### Authenticating with a self-issued access token
You can make requests to the API using a self-issued access token generated from your Unsplash [settings page](https://unsplash.com/documentation#creating-a-developer-account). These types of tokens never expire. Once you have it you can authenticate using this access token.
```php
    $unsplash = new Unsplash('SELF-ISSUED-ACCESS-TOKEN');
```

You can also use the `connect` method.
```php
    $unsplash = new Unsplash();
    $unsplash->connect('SELF-ISSUED-ACCESS-TOKEN');
```

Now you should be ready to start making requests to the API using your self issued access token.

## Users
#### Get the authenticated user details.
This will return an object with the user's details:
```php
    use Chihab\UnsplashSdk\Api\Resources\User

    $userApi = new User();
    $user = $userApi->getAuthenticatedUser();

    echo 'Authenticated user name is: ' . $user->data->name;
```

## Photos
#### Get all photos.
This will return an array of objects with the photo's details:
```php
    use Chihab\UnsplashSdk\Api\Resources\Photos

    $photosApi = new Photos();
    $photos = $photosApi->getPhotos();
```

## Collections
#### Get all collections.
This will return an array of objects with the collection's details:
```php
    use Chihab\UnsplashSdk\Api\Resources\Collections

    $collectionsApi = new Collections();
    $collections = $collectionsApi->getCollections();
```

## Run tests
Tests are written with [PHPUnit](http://phpunit.de).

After cloning your repo:
```bash
git clone git@github.com:chihab-a/unsplash-sdk-php.git
```

Generate a self-issued access token from your Unsplash [settings page](https://unsplash.com/documentation#creating-a-developer-account). You need this to run the integration tests. Then, just run `composer test` on the project's root directory:
```bash
cd unsplash-sdk-php
composer test
```

### Changelog
to do

### Contributing
to do

### License
Licensed under the MIT license. Please see [License file](LICENSE.md) for more information.