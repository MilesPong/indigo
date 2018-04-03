# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Added

### Changed

### Fixed

## 1.2.2 - 2018-04-01
### Added
- Webhook event and listener ([f5288a6](https://github.com/MilesPong/indigo/commit/f5288a6eeae7740ccf2ddf85535a79f960b3cc1e), [c95a83c](https://github.com/MilesPong/indigo/commit/c95a83cd9af096e5d6ca939000be94106c649809))
- Feature **Deployer** integration
- Migration for failed queue job

### Changed
- Update package-lock.json

### Fixed
- Some namespaces
- Missing HOME environment variable for composer in deployer submodule ([ceb7ac8](https://github.com/MilesPong/indigo/commit/ceb7ac8ce8959608a53800d6db012a81ff62e8ee))

### Removed
- Default closure in `routes/api.php`

## 1.1.0 - 2018-03-26
### Added
- Docker support ([defe382](https://github.com/MilesPong/indigo/commit/defe3824d538163e5ad0cb52838963d7d03bc359), [4730e0f](https://github.com/MilesPong/indigo/commit/4730e0fc6480ebfcad3b73a5bb29a48a07c3a0c8))
- `user:add` command
- Show Algolia logo when using `algolia` driver
- Localization support

### Changed
- Upgrade npm packages
- Seeder and ModelFactory ([da69855](https://github.com/MilesPong/indigo/commit/da698558b3f13e66e14e29645e21019c37fc9266))
- Upgrade to Laravel 5.6

### Fixed
- Bug of updating `updated_at` after saving counter

### Removed
- Column `user_id` on Page model

## 1.0.4 - 2018-03-19
### Added
- [README.md](README.md)
- License

### Changed
- Update composer packages
- Latest Google Analytics js code
- Default configurations

### Fixed
- Fix error while versioning copied files ([82ba259](https://github.com/MilesPong/indigo/commit/82ba25917cd87e1754fdc7309b2c7ae3d90d6995))
- Fix shedule bug
- Fix search bar height in chrome

## 1.0.0 - 2018-03-12
### Added
- Package spatie/laravel-backup and related schedule
- Google Drive storage support ([0ce91e0](https://github.com/MilesPong/indigo/commit/0ce91e02a96b054920259c7a2364512359327867), [9d1169b](https://github.com/MilesPong/indigo/commit/9d1169b1f1227b68a7d8d28b5118604f3544e7d2), [7a98e08](https://github.com/MilesPong/indigo/commit/7a98e0842d18bd00e6995dd562aba03107058aa4))
- New feature **page** support ([37b43f1](https://github.com/MilesPong/indigo/commit/37b43f188a4679cef5adf987e5aca5a902ee9c02))
- Add proper right in viewing unpublished-post from admin ([32cd8a2](https://github.com/MilesPong/indigo/commit/32cd8a28c947607018495f4c019fcd36c6096f04))
- Feature force-delete and restore
- Support of viewing original markdown content ([0281bdf](https://github.com/MilesPong/indigo/commit/0281bdffb65903f38ce316d4709e996ee4988450))
- New feature **search** support ([62e5c62](https://github.com/MilesPong/indigo/commit/62e5c6259ebee4ead12869c54c0dd84bac001c6d))
- New feature **feed** support ([0563cd9](https://github.com/MilesPong/indigo/commit/0563cd9d86e5b863816a7f1f42ad6b723deabd37))
- New feature **archives** support ([73c0aee](https://github.com/MilesPong/indigo/commit/73c0aee6d16478738444f213424d0505a88eae9d))

### Changed
- Refactor counter ([6aa01f3](https://github.com/MilesPong/indigo/commit/6aa01f339faac085ba21ed8ed24cc156d5c59c29))
- Union app's config to indigo.php ([b51efba](https://github.com/MilesPong/indigo/commit/b51efbacb8db3adabe9d4a4999c81f8644b994f9))
- Update `route:logs` with http basic auth
- Make ViewedEventListener run in queue
- Update materialize-css to `alpha4`
- Adjust container's width for small screen

### Removed
- Immature cache ([7b6dbc4](https://github.com/MilesPong/indigo/commit/7b6dbc4e81354e34865627b86ced0fd168e1d244))
- Old Counter
- File `TODO.md`
- File `package-lock.json`

### Fixed
- Sidenav trigger menu ([d105d02](https://github.com/MilesPong/indigo/commit/d105d02c43bea9a1c1c52937d2b7e6100ee8d607))
- Field `is_draft` input
- Query string in table's pagination ([dc1054c](https://github.com/MilesPong/indigo/commit/dc1054ce38aaa7e0f43b43e19d57ae1926a0a232))

## 0.4.0 - 2018-01-29
### Added
- Multiple mix support
- Materialize-css views in dashboard
- Vue support
- BackendController
- API resources(new feature in L5.5)
- Criteria support of Repository

### Changed
- Upgrade to L5.5
- Update materialize-css to latest 'next' version
- NPM packages
- Route names
- PHPDoc with full qualified namespace
- Refactor Repository and concrete
- FormRequest
- Refactor Repository(`4c87f6e`)
- MarkDownParser
- Upgrade composer packages

### Removed
- AdminLTE views
- Unnecessary fields of Post

### Fixed
- Fix previous and next post bug

## 0.3.0 - 2017-12-10
### Added
- Visitor history and base counter. See branch `counter` and `visitor`
- Cache support. See branch `cacheable`
- Auto slug in ajax and Chinese support
- Base implement of disqus. See branch `comment`
- Hot posts widget
- Base feature image support
- Model `Setting` and base SEO support 

### Changed
- Various CSS styles changes
- BaseRepository
- Side navigation bar style

### Fixed
- Fix HasPost retrieve data bug (`890c082`)

## 0.2.0 - 2017-06-15
### Added
- Backend
    - Post publish status and draft status
    - Soft delete support of models
    - Active menu support
    - Flash session in route redirection
    - Function str_slug compitable with Chinese
- Frontend
    - Materialize css support
    - materialize pagination blade
    - Multi widgets
    - Home page
    - Article detail page

### Changed
- Backend
    - Use dismissible alert component in alerts partial
    - Route name with prefix
    - Auto-generated slug could be repeated bug
    - Repository concrete with adding method scopeBoot
    - Default post scope with published status
    - Rename multi views name
    - Repository Contract&Concrete with adding withCount method
    - Post table columns
- Refactor assets folder structure 

### Fixed
- Backend
    - Post editor full screen bug
    - Post missing input fields
    - Password is not required in user-update action
    - Repository delete bug

## 0.1.0 - 2017-05-29
### Added
- Integrated dashboard with AdminLTE and used [webpack.mix.js](webpack.mix.js)
- Repository mode
- Base CRUD of Permission, Role, User, Category, Tag, Post
- Migrations and Seeder of Permission, Role, User, Category, Tag, Post