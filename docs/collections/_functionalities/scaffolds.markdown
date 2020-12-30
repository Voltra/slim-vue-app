---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 17
title: Scaffolds
---

Parts of your application are already implemented, these are what they are:

## Demo
A very basic scaffold that showcases a few of the functionalities this starter project has.

The list of added files:
* `dev/Controllers/DemoController.php`
* `dev/Events/User/UserLogListener.php`
* `dev/js/demo.js`
* `dev/js/mainDemo.js`
* `dev/routes/demo.php`
* `dev/routes/demo2.php`
* `dev/routes/demo3.php`
* `dev/routes/redir.php`
* `dev/views/.partials/modules/demo.twig`
* `dev/views/mails/demo.mjml.twig`
* `dev/views/2fa.twig`
* `dev/views/demo.twig`
* `dev/views/demo2.twig`
* `dev/views/demo3.twig`
* `dev/vue/components/Demo.vue`
* `dev/vue/store/modules/counter/`

The list of modified files:
* `dev/Controllers/TwoFactorController.php` for simple 2FA interactions
* `dev/js/2fa.js` for simple 2FA front-end
* `dev/routes/2fa.php` for sample names for the simple 2FA interactions
* `dev/routes/auth.php` for registering the `/auth/force-login/{__user}` endpoint
* `dev/vue/store/index.js` for registering the `counter` module
* `dev/events.php` for registering listeners from `App\Events\User\UserLogListener`

## Auth
The default authentication workflow. It provides the ability to :
* register
* login
* logout
* use 2FA
* manage permissions
* manage roles
* manage admins

The list of added files:
* `db/migrations/20190119184642_create_users.sql`
* `db/migrations/20190119184740_create_user_remember.sql`
* `db/migrations/20190119184757_create_user_permissions.sql`
* `db/migrations/20201027162730_2fa.sql`
* `dev/Controllers/AuthController.php`
* `dev/Actions/Auth.php`
* `dev/Actions/TwoFactor.php`
* `dev/Filters/AdminFilter.php`
* `dev/Filters/Can.php`
* `dev/Filters/Filter.php`
* `dev/Filters/LogoutFilter.php`
* `dev/Filters/UserFilter.php`
* `dev/Filters/VisitorFilter.php`
* `dev/Middlewares/Auth.php`
* `dev/Middlewares/Requires2FA.php`
* `dev/Models/Admin.php`
* `dev/Models/Permission.php`
* `dev/Models/Role.php`
* `dev/Models/RolePermission.php`
* `dev/Models/TwoFactor.php`
* `dev/Models/User.php`
* `dev/Models/UserRemember.php`
* `dev/Models/UserRole.php`
* `dev/Requests/Auth/LoginRequest.php`
* `dev/Requests/Auth/RegisterRequest.php`
* `dev/routes/auth.php`
* `dev/views/auth/login.twig`
* `dev/views/auth/register.twig`

## API
Depends on:
* Auth scaffold

//TODO: Document after implementation

The list of added files:
* //TODO: list files

The list of modified files:
* //TODO: list modified files
