## Installation Instructions
1. Run `git clone https://github.com/git-Ringnet/UI-Ringnet.git`
2. Create a MySQL database for the project
    * ```create database vangxa;```
3. From the projects root run `cp .env.example .env`
4. Configure your `.env` file (VERY IMPORTANT)
5. Run `composer install` from the projects root folder
6. From the projects root folder run `php artisan key:generate`
7. From the projects root folder run `php artisan migrate`
8. From the projects root folder run `composer dump-autoload`
9. From the projects root folder run `php artisan db:seed`
10. Compile the front end assets with [npm steps](#using-npm)

#### Build the Front End Assets with ViteJs
##### Using NPM:
1. From the projects root folder run `npm install`
2. From the projects root folder run `npm run dev` or `npm run build`

#### Start server local
1. From the projects root folder run `composer run dev`

#### Optionally Build Cache
1. From the projects root folder run `php artisan config:cache`

## Seeds
##### Seeded Users

|Email|Password|
|:------------|:------------|
|admin@ringnet.vn|Admin@123|
