
# 🎫 vhelpdesk - Ticket Help Desk

Help Desk based ticket activity with multiple user departments. Powered by laravel 10 and volt template. 


## 📸 Showcase

<p align="center">
<img src="./public/assets/demo.gif" width="600"><br>
</p>


## ⚡ Features

- Ticket Request
- Ticket Restriction (by user Department)
- User, Ticket Category and Department Management


## 🚀 Ship vhelpdesk

vhelpdesk require PHP >= 8.1.

Simply you can clone this repository:

```bash
git clone https://github.com/vantanto/vhelpdesk.git
cd vhelpdesk
```

Install dependencies using composer

```bash
composer install
```

Copy and Setup database in `.env` file

```bash
cp .env.example .env
```

Generate key & Run migration, seeding & Storage link public folder & Start local developement

```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan serve
```

You can now access the server at http://localhost:8000

> **📃**
> View more documentation in <a href="https://vantanto.github.io/pages/documentation/vhelpdesk.html" target="_blank">here</a>.

## 📝 Credit

#### Special Thanks
- [Laravel](https://laravel.com/)
- [Volt](https://github.com/themesberg/volt-bootstrap-5-dashboard)

This project is [MIT](https://github.com/vantanto/vhelpdesk/blob/master/LICENSE) licensed.