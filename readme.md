# OkkAuth

## Installation

Via Composer

add to composer.json

```
"repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/MrGeseR/OkkAuth"
        }
    ]
```
terminal
``` bash
$ composer require jdev/okkauth
```

add to .env file

```
KYIV_ID_CLIENT=
KYIV_ID_SECRET=
KYIV_ID_ATTEMPT_URI=
KYIV_ID_REDIRECT_URI=
KYIV_ID_HOST=
KYIV_ID_HOST_API=
KYIV_ID_FORCE_LOGIN_URI=
KYIV_ID_LOGOUT_URI=
KYIV_ID_CREATE_ORDER=
``` 

add to User.php
```
    use CanRegisterThrowOkk;
```