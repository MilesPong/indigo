
# Indigo

A blog application built with [Laravel](https://laravel.com), [Materialize](http://materializecss.com) and [Vue.js](https://vuejs.org/).

Indigo is a project I mainly learn to how to develop a Laravel application **in the right way**, include using design patterns, modern coding tricks, and other useful skills.

There is an introduction(Chinese) about this project as well, you can access it [here](https://immiles.com/articles/indigo).

## Screenshot

![screenshot](https://user-images.githubusercontent.com/5867628/37555740-48334dc4-2a27-11e8-973f-f54f96d9e912.png)

## Features

 - Basic blog features like post, page, archives, search, etc.
 - Material UI (responsive layout)
 - Disqus comment integrated
 - Repositories pattern
 - Markdown editor
 - Trash support
 - Counter with multiple drivers support
 - Backup with Google Drive storage support
 - Multiple Mix for compiling backend and frontend

More features can be found in [CHANGELOG.md](CHANGELOG.md)

## Server Requirements

Basic requirements are listed in the official [document](https://laravel.com/docs/5.5#server-requirements).

Also, additional services below may be used and **recommended**

- Redis
- Algolia
- Google Drive
- Slack
- Disqus
- Youdao Translate

## Installation

### Use Docker

> **To avoid some deployment issues, you can run this application in [Docker](https://www.docker.com/) as well.
> Please check this [document](https://github.com/MilesPong/docker-lnmp/blob/indigo/README.md) for more details.**

### Configration

```bash
$ git clone https://github.com/MilesPong/indigo.git
$ cd indigo
$ cp .env.example .env
$ composer install
$ php artisan key:generate
```

Change your DB settings and other services' configurations

```
# For Chinese translation in slug
YOUDAO_APP_KEY=
YOUDAO_APP_SECRET=

# Google Analytics
GOOGLE_ANALYTICS_ID=

# Visitor log
ENABLE_VISITOR_LOG=false

# Comment
COMMENT_DRIVER=
DISQUS_SHORT_NAME=

FILESYSTEM_DRIVER=public

# For receiving feedback while failed in backup
ADMIN_EMAIL=

MAIL_FROM_ADDRESS=
MAIL_FROM_NAME=

# Search
SCOUT_QUEUE=false
SCOUT_DRIVER=null
```

**Schedule** are required by default, set it up as follow

```bash
$ crontab -e
# Append this to the end
# * * * * * php /path/to/project/artisan schedule:run >> /dev/null 2>&1
```

**Auto backup** is enabled by default, you may have a look about the configuration under [config/backup.php](config/backup.php)

### Migration

*Default user(admin) info is in [InitializationSeeder](database/seeds/InitializationSeeder.php ), you can modify it before running the seed task.*

```bash
$ php artisan migrate --seed # Migration and seeding
```

### Compiling Assets

```bash
$ npm install
$ npm run dev # Frontend
$ npm run admin-dev # Backend
```

**Note: Code is open-sourced and you know what to do when "Something went wrong".**

## Changelog

Refer to the [CHANGELOG.md](CHANGELOG.md) for a full history of the project.

## TODO

Check this out in [Gist](https://gist.github.com/MilesPong/7529f9586fb7070a7f4c56360cdf9475).

## Links

- [Materialize](http://materializecss.com)
- [Vuejs](https://vuejs.org)
- [Laravel](https://laravel.com)

## Contributing

Any bug report or pull request is welcome.

## License

The project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).