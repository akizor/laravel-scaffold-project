# Laravel Scaffold Project with TailwindCSS & VueJs

Base project structure generator for Laravel 8+ empty projects. Uses TailwindCSS and VueJs

## Installation

Install via composer
```bash
composer require akizor/scaffold
```

### Usage

```bash
php artisan scaffold:general
```

After everything is installed, you'll be prompted what steps needs to be done.

```bash
# Development mode
npm run watch

# Production mode
npm run prod
```

## Documentation

Packages scaffold a base project structure for an empty Laravel 8+ project.

### General project structure

**Carefull, the following files will be overwritten by the generator. Make sure you check them.**

* app
    * Providers
        * `FrontendServiceProvider.php`
    * Http
        * Controllers
            * Frontend 
                * `HomeController.php`
* resources
    * js
        * `app.js`
        * `boostrap.js`
    * scss
        * `app.scss`
        * tailwind
            * `base.scss`
            * `components.scss`
            * `utilities.scss`
    * views
        * site
            * layouts
                * `app.blade.php`
                * partials
                    * `age-gate.blade.php`
                    * `analytics.blade.php`
                    * `favicon.blade.php`
                    * `footer.blade.php`
                    * `header.blade.php`
                    * `meta.blade.php`
            * pages
                * `home.blade.php`
* routes
    * `frontend.php`
* `tailwind.config.js`
* `webpack.mix.js`

### Packages

Installs Laravel-Mix, TailwindCSS (JIT mode included), VueJS and the build tools & configuration required by Laravel Mix to build assets. 

`webpack.mix.js` and `tailwind.config.js` are preconfigured.

## Security

If you discover any security related issues, please email 
instead of using the issue tracker.

## Credits

Daniel Placinta
