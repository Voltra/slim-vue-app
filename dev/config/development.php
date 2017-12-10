<?php
return [
    "app" => [
        "url" => "http://localhost",
        "hash" => [
            "algo" => PASSWORD_BCRYPT,
            "cost" => 10,
            "secondary_algo" => "sha256"
        ]
    ],
    "db" => [
        "driver" => "mysql",
        "database" => "test",
        "host" => "127.0.0.1",
        "name" => "test",
        "username" => "root",
        "password" => "",
        "charset" => "utf8",
        "collation" => "utf8_unicode_ci",
        "prefix" => ""
    ],
    "auth" => [
        "session" => "user_id",
        "remember" => "user_remember",
        "remember_exp" => "+3 year",
        "cookie_separator" => "___"
    ],
    "email" => [
        "smtp_auth" => true,
        "smtp_secure" => "tls",
        "host" => "smtp.gmail.com",
        "username" => "adresse@ici.com",
        "password" => "mdp",
        "port" => 587,
        "html" => true
    ],
    "twig" => [
        "debug" => true,
        "cache" => false,
        "tags" => [
            "tag_comment" => ["{#", "#}"],
            "tag_block" => ["{%", "%}"],
            "tag_variable" => ["{@", "@}"],
            "interpolation" => ["#{", "}"]
        ]
    ],
    "crsf" => [
        "key" => "csrf_token"
    ],
    "validation" => [
        "register" => [
            "email" => "required|email|uniqueEmail",
            "username" => "required|alnumDash|max(60)|min(6)|uniqueUsername",//cf. db
            "password" => "required|min(6)",
            "password_confirm" => "required|matches(password)"
        ],
        "login" => [
            "identifier" => "required",
            "password" => "required"
        ],
        "change_password" => [
            "old_password" => "required|matchesCurrentPassword",
            "new_password" => "required|min(6)",//cf. validation.register.password
            "password_confirm" => "required|matches(new_password)"
        ],
        "recover_password" => [
            "email" => "required|email"
        ],
        "reset_password" => [
            "password" => "required|min(6)",//cf. validation.register.password
            "password_confirm" => "required|matches(password)"
        ],
        "profile" => [
            "email" => "required|email|uniqueEmail",
            "first_name" => "alpha|max(50)",//cf. db
            "last_name" => "alpha|max(60)"//cf. db
        ]
    ]
];
