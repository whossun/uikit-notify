# uikit-notify

### install

Using Composer

    composer require whossun/uikit-notify

Add the service provider to `config/app.php`

```php
Whossun\Notify\NotifyServiceProvider::class,
```

Optionally include the Facade in config/app.php if you'd like.

```php
'Notify'  => Whossun\Notify\Facades\Notify::class,
```


### Options

You can set custom options for Reminder. Run:

    php artisan vendor:publish

to publish the config file for notify.


### Basic

* Notify::info('message', ['options']);

* Notify::success('message', ['options']);

* Notify::warning('message', ['options']);

* Notify::danger('message', ['options']);

* Notify()->info('message', ['options']);

```php
<?php

Route::get('/', function () {
    Notify::success('Messages in here', ['pos' => 'top-center']);

    return view('welcome');
});
```

Then

You should add `{!! Notify::render() !!}` to your html.


### MIT

