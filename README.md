# Introduction
Developer docs iDrive Driver Feedback Dashboard.

# Contents
1. [How to use design & development](#how-to-use-design--development)
2. [How to use Sentry (error tracking)](#how-to-use-sentry-error-tracking)

# How to use design & development
## 1. Install Node.js
- npm install
- npm run build (production, minifies the code)
- npm run dev (development, makes browser refresh automatically when you change something in the code)

## 2. How to work with the directory structure
We follow a Domain Driven Design (DDD) approach. This means that we have a directory for each domain within the application. E.g. `resources/feedback` or `resources/vehicle`.
In our project the structure is as follows:
- `app/Domains` - contains all the domains within the application
  - `app/Domains/Shared` - contains all that is not specific to a domain but is shared between multiple domains
  - `app/Domains/{domain}` - contains all the files that are specific to a domain
    - `app/Domains/{domain}/Model` - contains all the models that are specific to a domain
    - `app/Domains/{domain}/Exception` - contains all the exceptions that are specific to a domain
    - `app/Domains/{domain}/ValueObject` - contains all the value objects (DTOs) that are specific to a domain
    - `app/Domains/{domain}/Interface` - contains all the interfaces that are specific to a domain
    - `app/Domains/{domain}/Trait` - contains all the traits that are specific to a domain
    - `app/Domains/{domain}/Repository` - contains all the repositories that are specific to a domain
    - `app/Domains/{domain}/Enum` - contains all the enums that are specific to a domain
- `app/Intrastructure/{domain}` - contains infrastructure required for the app. Like laravel.
- `app/UserInterface/Domain/{domain}` - contains all the controllers, requests, middleware, etc. that are specific to a domain
  - `app/UserInterface/Domain/{domain}/Controllers` - contains all the controllers that are specific to a domain
  - `app/UserInterface/Domain/{domain}/Requests` - contains all the requests that are specific to a domain
  - `app/UserInterface/Domain/{domain}/Middlewares` - contains all the middleware that are specific to a domain
  - `app/UserInterface/Domain/{domain}/Resources` - contains all the resources that are specific to a domain
  - `app/UserInterface/Domain/{domain}/Jobs` - contains all the jobs that are specific to a domain
  - `app/UserInterface/Domain/{domain}/Listeners` - contains all the listeners that are specific to a domain
  - `app/UserInterface/Domain/{domain}/Events` - contains all the events that are specific to a domain
  - `app/UserInterface/Domain/{domain}/Notifications` - contains all the notifications that are specific to a domain
  - `app/UserInterface/Domain/{domain}/Mails` - contains all the mails that are specific to a domain

Generic design & resources files are located in the `resources` directory.
- `resources/js` - generic javascript files
- `resources/sass` - generic sass files
- `resources/views` - generic blade files


in each directory you should work structured and create logical subdirectories for each component.
E.g:
- For an utility like sweetalert you should create a directory `resources/js/utilities/sweetalert` and put all javascript files related to sweetalert in this directory.

## 3. How to work with the blade files
Each blade file that will be shown should extend from the `base_clean.blade.php` file. This file contains the basic html structure and the basic css & js files that are needed for the application to work.
For authenticated pages within the application you should extend from the `base.blade.php` file. This file contains the basic html structure and the basic css & js files that are needed for the application to work. It also contains the basic navigation and sidebar structure.

When running the `npm run dev` command, and you change something in the blade files, the browser will automatically refresh and show the changes.

## 4. How to work with assets (images, fonts, etc.)
All image assets should be put in the `resources/{asset-type}` directory. E.g. `resources/images` or `resources/fonts`.

When you want to use an asset you can use the `View::asset()` helper function. This function will automatically generate the correct url to the asset. E.g. `View::asset('images/logo.png')` will generate the url `/images/logo.png`.

E.g:
```php
<img src="{{ Vite::asset('resources/images/logo.png') }}">
```

### Aliases
It is common in JavaScript applications to create aliases to regularly referenced directories. But, you may also create aliases to use in Blade by using the macro method on the Illuminate\Support\Facades\Vite class. Typically, "macros" should be defined within the boot method of a service provider:
```php
/**
 * Bootstrap any application services.
 */
public function boot(): void
{
    Vite::macro('image', fn (string $asset) => $this->asset("resources/images/{$asset}"));
}
```

Once a macro has been defined, it can be invoked within your templates. For example, we can use the image macro defined above to reference an asset located at `resources/images/logo.png`:
```php
<img src="{{ Vite::asset('resources/images/logo.png') }}">
```


# How to use Sentry (error tracking)
1. Create an account on sentry.io
2. Create a new project
3. Select Laravel as a framework
4. Configure SDK by copying the code from the sentry.io website to terminal
5. Run `php artisan sentry:test` to test if it works
