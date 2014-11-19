Video AG Webseite
=====

# Setup

## Requirements
1. [Bower](http://bower.io/)
2. PHP >= 5.4

## Configure
### Application
1. Copy `config/autoload/local.php.dist` to `config/autoload/local.php`
2. Edit the new file and enter your MySQL data

### Server
The Document root is `public/`. Example Apache config:
```
<VirtualHost *:80>
        DocumentRoot "/var/www/fsmpivideo/public"
        ServerName fsmpivideo.localhost
        SetEnv APPLICATION_ENV "development"
        <Directory "/var/www/fsmpivideo/public">
                DirectoryIndex index.php
                AllowOverride All
                Order allow,deny
                Allow from all
        </Directory>
</VirtualHost>
```
Dont forget to enable `mod_rewrite`

## Setup
1. Open Commandline
2. Navigate to your cloned repository
3. run `bower install`
4. run `php composer.phar install`
5. run `php vendor/bin/doctrine-module orm:schema-tool:create`
6. rename `bower_components/iscroll/package.json` to `bower_components/iscroll/bower.json` (Yes, this is a bad fix until my pull request to bower-module is accepted)
7. run `php public/index.php bower prepare-packs`
