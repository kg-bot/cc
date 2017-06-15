# Online Currency Converter

Free online tool used to convert from one currency to another.

### Requirements

 1. [Composer](https://getcomposer.org/) as package manager
 2. [Redis](https://redis.io/) for cache operations
 3. [GIT](https://git-scm.com/) - **optional** software

Before you begin please ensure that you have required technologies installed and ready to use.

### How to setup application

Use GIT to pull this repository into your desired server directory or if you don't have or don't know how to use GIT download this repo manually.

Second, change working directory to application and use `composer install` to install project dependencies.

Before you can use application you must start Redis server with default parameters. 
Go to your terminal and type `redis-server`.   
NOTE! Please make sure you have `{redis_installation_path}/src` in your path.

Still in your application root folder execute `php application/cronjobs/UpdateRates.php`.   
Run `crontab -e` and add `0 * * * * php {path_to_application}/application/cronjobs/UpdateRates.php >/dev/null 2>&1` to it,
this will update rates every hour.

Congratulations, you have finished setting up your application and redis database.
You can start using it, point your browser to your application domain.

#### Additional setup

We'll assume that you use Apache web server.

For gzip compression and caching to work you must enable following Apache modules:
 - mod_expires
 - mod_gzip
 - mod_deflate
 - mod_headers

If you don't use Apache please consult your web server software provider documentation to how to enable those features.
  