---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 16
title: Database
---

This project template uses [dbmate](https://github.com/turnitin/dbmate#usage) as a framework-agnostic database migration
tool. It allows writing migrations in plain SQL as well as generating them, rollbacks, etc...

Migrations are stored in `db/migrations/` and a dump of the schema in `db/schema.sql`.

[Laravel's Eloquent](https://laravel.com/docs/8.x/eloquent) is used as the ORM and as such models are store under
the namespace `App\Models`. Models may either extend from `App\Models\Model` or `App\Models\PivotTable`
(both are abstract classes that inherit from Eloquent classes).

These are the already defined models:
* `App\Models\Admin` a model tied to users to know whether they are admin or not
* `App\Models\Permission` a model that holds information about a granular permission
* `App\Models\Role` a model that holds information about a specific role
* `App\Models\RolePermission` the pivot model between roles and permissions
* `App\Models\TwoFactor` a model holding two factor authentication data about a specific user
* `App\Models\User` a model holding information about a user
* `App\Models\Remember` a model holding information about remember tokens for a specific user
* `App\Models\UserRole` the pivot model between users and roles
