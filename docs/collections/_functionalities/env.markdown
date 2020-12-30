---
# Feel free to add content and custom Front Matter to this file.
# To modify the layout, see https://jekyllrb.com/docs/themes/#overriding-theme-defaults

layout: home
parent: Functionalities
nav_order: 15
title: Env
---

You can use `cp .env.example .env` to initialize your local environment variable file. These are loaded at the very
beginning of the boot process of the application.

Both `.env.example` and `.env` files must follow the following structure:

```bash
DATABASE_URL = "<vendor>://<username>:<password>@<address>:<port>/<database>"
DEV_ENV = "production"
NODE_ENV = "${DEV_ENV}"
PHP_ENV = "${DEV_ENV}"
MAIL_USERNAME = ""
MAIL_PASSWORD = ""
```

## DATABASE_URL

The URL to use with [dbmate](https://github.com/turnitin/dbmate#usage) for migrations, you may replace variables between `<>`:
```bash
"<vendor>://<username>:<password>@<address>:<port>/<database>"
# for instance:
"mysql://root@localhost:3306/slim_vue_app"
```

## DEV_ENV

Must be one of :
* `development`
* `production`
* `test`

## NODE_ENV and PHP_ENV

Is already set to the value of `DEV_ENV` so do not modify.

## MAIL_USERNAME

The username for the mailing service (SMTP)

## MAIL_PASSWORD

The password for the mailing service (SMTP)
