# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/).

## [Unreleased]
### Added

### Changed

### Fixed

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