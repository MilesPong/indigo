
# Indigo

A blog built with [Laravel](https://laravel.com) and [Materialize](http://materializecss.com).

## Features

 - Base blog features like post, page, archives, search, etc.
 - Material UI (responsive layout)
 - Disqus comment integrated
 - Repositories pattern
 - Markdown editor
 - Trash support
 - Counter with multiple drivers support
 - Backup with Google Drive storage support
 - Multiple mix for building backend and frontend

More features can be discovery in [CHANGELOG.md](CHANGELOG.md)

## Server Requirements

Basic requirements are listed in official [document](https://laravel.com/docs/5.5#server-requirements).

Also additional services below may be used and **recommended**

- Redis
- Algolia
- Google Drive
- Slack
- Disqus
- Youdao Translate

## Installation

```bash
$ git clone https://github.com/MilesPong/indigo
$ cd indigo
$ php artisan key:generate
$ cp .env.example .env # Change your DB settings and other services' config
```

### Migration

*Default user(admin) info is in [InitializationSeeder](database/seeds/InitializationSeeder.php ), you can modify it before running the seed task.*

```bash
$ php artisan migrate --seed # Migration and seeding
```

### Others

You may also set up the [schedule](https://laravel.com/docs/5.5/scheduling) and [queue](https://laravel.com/docs/5.5/queues) according to official docs to enable **counter** and **auto backup**. (See [commands](app/Console/Kernel.php))

**Note: Code is open-sourced and you know what to do when "Something went wrong".**

## Changelog

Refer to the [Changelog](CHANGELOG.md) for a full history of the project.

## Links

- [Materialize](http://materializecss.com)
- [Vuejs](https://vuejs.org)
- [Laravel](https://laravel.com)

## About Indigo

Indigo is a project I mainly learn to how to develop a Laravel application **in the right way**, include using design patterns, modern coding tricks and other useful skills.

There is a full introduction about this project as well, you can access it [here](https://immiles.com/articles/indigo).

## License

The project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
