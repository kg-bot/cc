# Online Currency Converter

Free online tool used to convert from one currency to another.

### Requirements

 1. [Phinx](https://github.com/robmorgan/phinx) for database migrations, **will be installed with composer**
 2. [Composer](https://getcomposer.org/) as package manager
 3. [GIT](https://git-scm.com/) - **optional** software

Before you begin please ensure that you have required technologies installed and ready to use.

### How to setup application

Use GIT to pull this repository into your desired server directory or if you don't have or don't know how to use GIT download this repo manually.

Second, open `/phinx.yml` and edit options for `development` entry, set them to reflect your MySQL settings.

After you have succesfully completed previous step open `/application/configs/application.ini` and change following entries
 ```
 resources.db.params.dbname = "blazing_boost"
 resources.db.params.username = "example_user"
 resources.db.params.password = "example_password"
```
use your database correct parameters.

Last step you need to do is open terminal and change working directory `cd {application_dir}` to your application directory, then type `php vendor/bin/phinx migrate && php vendor/bin/phinx seed:run`.

Congratulations, you have finished setting up your application and database.
You can start using it, point your browser to your application domain.

#### Additional setup

We'll assume that you use Apache web server.

For gzip compression and caching to work you must enable following Apache modules:
 * mod_expires
 * mod_gzip
 * mod_deflate
 * mod_headers

If you don't use Apache please consult your web server software provider documentation to how to enable those features.