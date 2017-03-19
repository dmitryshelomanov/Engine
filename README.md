# Engine
## Роутинг
> Параметры {id} - int {string} - str Контроллер@метод
```php
Router::get('/test/{id}', 'App\Controllers\IndexController@index');
Router::post('/post', 'App\Controllers\IndexController@add');
```
## Алиасы
```php
'aliases'  => [
    'Router' => \Engine\routers\Router::class,
    'Auth' => \Engine\helpers\Auth::class,
]
```
## Посредники
```php
"middleware" => [
    "auth" => App\Middleware\Auth::class
],
```
## Валидатор
> Базовое использование. через **.** пишется имя инпута.имя выдаваемое валидатором. **Настройки валидатора в папке config**
```php
$validator = new Validator();
$validator->make((new Request())->all(), [
    'login.логин' => 'required|min:6',
    'password.пароль' => 'required|min:6'
]);
```
## Редирект
> Базовое использвование
```php
redirect();
// с сообщением
redirect()->with('test', []);
// со старым вводом
redirect()->withInput()->back();
```
## Хелперы
```php
function old ($key) // вернет старый вод
function message ($key) // вернет сообщение при редиректе назад
function redirect () // редирект
function view ($path, $data = []) // шаблон
function dd() // симфони дампер
function request () // вернет обьект Request
function config () // получение к доступам файлов конфига
```
## ORM
```php
// indexController
$test = new Test;

$test->get($field = *)  // получить все из таблицы

$test->where('id', '=', 1)->andWhere()->orWhere()->get() // получить по условию

$test-join($table, $column, $operator, $column2) // присоеденение

$test->insert([
  'name' => 'dima'
]); // ввод

$test->update([
  'name' => 'dima'
]); /изменение

$test->where()->delete(); // удаление

$test-find($id); // поиск записи по id
```
## Авторизация (сессии)
```php
Auth::attempt($login, $password); // проверит данные в бд
Auth::check(); // проверка авторизироан ли юзер
Auth::logout() // выход
Auth::user()->name // получение инфы о юзере
```
## Пример посредника
```php
namespace App\Middleware;

use Engine\request\Request;

class Auth
{
    public function handle ()
    {
        $request = new Request();
        if ($request->user()->role !== 2) {
            redirect('/home')->with('message', 'вы не администратор');
        }
    }
}
```



