## Laravel-Idempotent

基于 [Laravel](https://github.com/laravel/laravel) 的接口幂等组件

## 安装

```
$ composer require lidongyooo/laravel-idempotent -vvv
```

## 配置

1. 在 `config/app.php` 注册 ServiceProvider (Laravel 5.5 + 无需手动注册)

```php
'providers' => [
    // ...
    Lidongyooo\Idempotent\IdempotentServiceProvider::class,
],
```

2. 创建配置文件

```
php artisan vendor:publish --tag="laravel-idempotent"
```

3. 查看应用根目录下的 `config/idempotent.php`

## 使用

中间件 `Lidongyooo\Idempotent\IdempotentMiddleware`，别名 `idempotent`

```php
// ...
Route::post('/test', function () {
    return 'test';
})->middleware('idempotent');
```

## 返回值

- 重复请求将会返回异常

```php
abort(425, 'Your request is still being processed.');
```

- 已缓存的请求将添加响应头

```php
$response->header($this->config['back_header_name'], $idempotentKey);
```

更多详细介绍请查看 [配置文件](https://github.com/lidongyooo/Laravel-Idempotent/blob/main/config/idempotent.php)

