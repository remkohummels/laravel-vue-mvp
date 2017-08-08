# Laravel + Vue.js MVP
***

The beta version for restaurant management system.

Key Technologies:

- Laravel v5.4

- Vue.js v2.3.3

- Vue-Resource v1.3.4

- Vuex v2.3.1

- Vue-Router v2.5.3

- Moment.js v2.18.1

- Bootstrap-Sass v3.3.7

- Dockerize the DEV/Staging environments (compatible with Linux/Debian, MacOS, Windows 7)


## Prerequisites for Dev Environment

Clone repository git@bitbucket.org:oichurchs/dev-infrastructure.git. 
Then go to ./volumes/datavol folder and clone git@bitbucket.org:oichurchs/ccpp-app.git repository to ccpp-app folder, checkout your dev branch (or staging branch)

In the ./volumes/datavol/ccpp-app folder,

1) Create a .env file copying from .env.dev.

2) Run `$ composer install` to install the necessary dependencies.

3) Run `$ npm install --force` to install the node modules & libraries by NPM. 

4) Run `$ npm run dev` to compile the JS/SCSS into a single files by Laravel Mix + Webpack.

5) Run `$ php artisan config:cache` to reflect the .env configuration.

6) To start the scheduler itself, we only need to add one cron job on the server (using the `crontab -e` command), which executes `php /path/to/artisan schedule:run` every minute in the day. 
To discard the cron output we put `/dev/null 2>&1` at the end of the cronjob expression.

`* * * * * php /path/to/artisan schedule:run 1>> /dev/null 2>&1`

## Running the application with docker on localhost

In the root folder of dev-infrastructure, 

- Fresh-build and rebuild the docker containers: `$ docker-compose -f docker-compose.dev.yml up --build`.

- Run the prebuilt containers: `$ docker-compose -f docker-compose.dev.yml up`. 

- Run the containers in background: `$ docker-compose -f docker-compose.dev.yml up -d`. 

- Stop the running all containers: `$ docker-compose kill`.

After running all services of containers, go to the http://localhost.

## Artisan commands for laravel development process

In the ./volumes/datavol/ccpp-app folder,

- After changing the conf parameters of .env file or modifying the setting of ./config directory: `$ php artisan config:cache`.

- If some controller changes are not reflected after modifying them: `$ php artisan cache:clear`.

- If some views changes are not working immediately: `$ php artisan view:clear`.

- After changing the JS/SCSS/Vue files, `$ npm run dev`. 

## Docker + Artisan/Composer commands for local development process

NOTE__: In the root folder of dev-infrastructure,

After running all services with docker-compose, you can run all artisan commands with docker-compose. 

For example, run `$ docker-compose exec web php /var/www/ccpp-app/artisan key:generate`.

- If some database migration or seeder was changed by some commits, run `$ docker-compose exec web php /var/www/ccpp-app/artisan migrate:reset`. 
Then you can run `$ docker-compose exec web php /var/www/ccpp-app/artisan migrate --seed` to make all migrations and seeding again in the fresh database. 

- If you are encountering with DB rollback, run `$ docker-compose exec web php /var/www/ccpp-app/artisan migrate:droptables` to drop all tables in the current database. 
Then you can run `$ docker-compose exec web php /var/www/ccpp-app/artisan migrate --seed` again.

## Command Line Tools

- nodejs: v6.10.3

- NPM: v5.0.0

- vue-cli: v2.8.1

- git: v2.13.0

## Coding Style

- Use [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md) and [PSR-4](http://www.php-fig.org/psr/psr-4/) coding standards.

- PHP tab size is 4.

- Blade/HTML tab size is 2.

- SCSS/JavaScript tab size is 4.

- Translate tabs to spaces.

- Ensure newline at end of file.

- Trim trailing white space.

## Tips for VueJS

- Vue.js can be written in the recommended ECMAScript 6.

- This command `$ npm run watch` can help you with compiling the Vue/JS/SCSS/Images changes immediately. 
After you write/change some code, please hit `CTRL + S` in your IDE. Then you can see the compiling process via terminal.

- See the [Laravel <-> Vue & Vuex in our SPA]
