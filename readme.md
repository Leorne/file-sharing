## About
A project created to study the Laravel framework.




## Requirements
1. [PHP] >= 7.2 support.
2. [MySQL] database.
3. [Apache 2.4]


## Used technologies
1. [Laravel]  
2. [Vue.js]
3. [Twitter Bootstrap]


## Installation

-Clone project
`git clone https://github.com/Leorne/file-sharing.git`

- Install components
```shell
composer install
npm install
```
- Rename .env.example to .env and change DB settings

- Generate project key

`php artisan key:generate`

- Create link to file storage

`php artisan storage:link`

- Migrate database

`php artisan migrate`

- To generate fake data

`php artisan db:seed` 



[PHP]: <https://secure.php.net/>
[Apache 2.4]: <http://httpd.apache.org/docs/2.4/>
[Twitter Bootstrap]: <http://getbootstrap.com/>
[MySQL]: <https://www.mysql.com/>
[Vue.js]: <https://vuejs.org/>
[Laravel]: <https://laravel.com/>
