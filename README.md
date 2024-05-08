# iDrive Driver Feedback Dashboard Developer Documentation

## Table of Contents

1. [How to Use Design & Development](#how-to-use-design--development)
2. [How to Use Sentry (Error Tracking)](#how-to-use-sentry-error-tracking)
3. [How to Use Inspections in IDE](#how-to-use-inspections-in-ide)

## How to Use Design & Development

### 1. Install Node.js

- Run `npm install`
- For production (minifies the code), run `npm run build`
- For development (auto-refreshes the browser on code changes), run `npm run dev`

### 2. Working with Directory Structure

We follow a Domain Driven Design (DDD) approach with the following structure:

- `app/Domains` - Contains all domains within the application
    - `app/Domains/Shared` - Shared components between multiple domains
    - `app/Domains/{domain}` - Domain-specific files
        - `Model`, `Exception`, `ValueObject`, `Interface`, `Trait`, `Repository`, `Enum`
- `app/Infrastructure/{domain}` - Infrastructure required for the app (e.g., Laravel)
- `app/UserInterface/Domain/{domain}` - Controllers, requests, middleware, etc. specific to a domain
    - Subdirectories for `Controllers`, `Requests`, `Middlewares`, `Resources`, `Jobs`, `Listeners`, `Events`, `Notifications`, `Mails`

Generic design & resource files are located in the `resources` directory:

- `resources/js` - Generic JavaScript files
- `resources/sass` - Generic SASS files
- `resources/views` - Generic Blade files

For utilities like SweetAlert, create a directory e.g., `resources/js/utilities/sweetalert` for related JavaScript files.

### 3. Working with Blade Files

- Blade files shown should extend `base_clean.blade.php` for basic HTML structure.
- For authenticated pages, extend from `base.blade.php` containing navigation and sidebar structure.
- Running `npm run dev` auto-refreshes the browser on blade file changes.

### 4. Working with Assets (Images, Fonts, etc.)

- Image assets go in the `resources/{asset-type}` directory (e.g., `resources/images` or `resources/fonts`).
- Use the `View::asset()` helper function to generate the correct URL for the asset.

Example:
```php
<img src="{{ Vite::asset('resources/images/logo.png') }}">
```

#### Aliases

Define aliases using the macro method on the `Illuminate\Support\Facades\Vite` class within a service provider's `boot` method.

Example:
```php
Vite::macro('image', fn (string $asset) => $this->asset("resources/images/{$asset}"));
```

Usage:
```php
<img src="{{ Vite::image('logo.png') }}">
```

## How to Use Sentry (Error Tracking)

1. Create an account on [sentry.io](https://sentry.io)
2. Create a new project
3. Select Laravel as a framework
4. Configure SDK by copying the code from sentry.io to terminal
5. Run `php artisan sentry:test` to test if it works

## How to Use Inspections in IDE

1. In PhpStorm, go to `Preferences | Editor | Inspections`
2. Click the setting cog icon and select `Import Profile`
3. Select the `iDrive_inspections.xml` file from the root of the project

## License
This project, including all of its source code and documentation, is protected under the Joey Roeters GitHub Project License Agreement. The license strictly prohibits downloading, cloning, forking, modifying, using, or distributing any part of this project. Viewing the content on GitHub for personal or educational purposes is permitted within the constraints of the license agreement.

By accessing this repository, you agree to comply with all the terms and conditions outlined in the license. Any use of the project's content outside of the permissible viewing on GitHub is a violation of this agreement and may subject you to legal action.

For full license details, see the LICENSE file in this repository.

