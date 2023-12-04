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
All design & resources files are located in the `resources` directory.
- `resources/js` - all javascript files
- `resources/sass` - all sass files
- `resources/views` - all blade files


in each directory you should work structured and create logical subdirectories for each component.
E.g:
- For the authentication page you should create a directory `resources/sass/pages/auth` and put all sass files related to the authentication page in this directory.
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
use Illuminate\Support\Facades\Vite;

Vite::macro('asset', function ($path) {
    return asset(Vite::get($path));
});
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
