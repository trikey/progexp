#install

```
composer install
```
```
npm install
```
```
cp .env.example .env
```
```
php artisan key:generate
```
```
php artisan migrate
```
```
php artisan db:seed
```
```
npm run watch
```

#docs

```
composer update
```

```
php artisan migrate
```
```
php artisan db:seed
```

В .env прописать токен для любого юзера в параметр DOCS_TOKEN.
Пример есть в .env.example

```php artisan apidoc:generate``` - сгенерировать доки

Доки генерятся в ```public/docs/index.html```

#tests

```vendor\bin\phpunit.bat``` - запустить тесты для бэкенда.

Это нужно делать всегда перед работой, чтобы быть уверенным, что апи в порядке
