# Рзвертывание

PHP 8.1

git clone https://github.com/DmitrijKunts/TestWork-533.git

cd TestWork-533

composer install

cp .env.example .env

В .env указываем свой ключ для авторизации API_KEY и настроить подключение к БД.

php artisan key:generate

php artisan migrate --seed

php artisan test

php artisan serv

Сервер должен запустится по адресу http://127.0.0.1:8000 для просмотра коллекции в Postman: "TestWork 533.postman_collection.json" - файл в репозитарии

## Предметная область 

Статьи с тегами с атрибутом приоритет


## API

  GET|HEAD   api/articles/list .................................. articles.list › Api\ArticleController@index

  GET|HEAD   api/articles/search ............................. articles.search › Api\ArticleController@search

  GET|HEAD   api/articles/{id} ................................. articles.get › Api\ArticleController@getById

  GET|HEAD   api/tags/list ....................................... tags.list › Api\ArticleTagController@index

  GET|HEAD   api/tags/search .................................. tags.search › Api\ArticleTagController@search

  GET|HEAD   api/tags/{id} ...................................... tags.get › Api\ArticleTagController@getById


  api/articles/list - список статей

  api/articles/search - поиск и сортировка разрезе статей. Параметры: field - поле в которм ищем, value - что ищем, sort - по какому полю сортруем

  api/articles/{id} - отобразить статью с заданным id

  api/tags/list - список тегов

  api/tags/search - поиск и сортировка в разрезе тегов. Параметры: field - поле в которм ищем, value - что ищем, sort - по какому полю сортруем 

  api/tags/{id} - отобразить тег с заданным id


