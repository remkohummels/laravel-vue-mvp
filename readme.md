# About Fready Application
***

Someone can write a general description briefly.

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

![Command Break Down](https://bytebucket.org/snippets/dmatt522/pX9BM/raw/e004038c2c248005a894e9b5dd02bfa2f5181196/1-XtLoc1ZwMLm1XRVY1ifQuA.png)

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

## See the below DB diagrams with different layouts

[Circular](https://bytebucket.org/oibitbucket/ccpp-app/raw/60566cacfcb11c9d33347036fd4fe704b1676ee6/diagram/diagram_circular.png?token=19cd53ef41dc8e7682ab44e7961139ac7908619e), 
[Hierarchic Group](https://bytebucket.org/oibitbucket/ccpp-app/raw/60566cacfcb11c9d33347036fd4fe704b1676ee6/diagram/diagram_hierarchic_group.png?token=f4136a48036a99d9a7e5f7d67f94f3f60457976d), 
[Organic](https://bytebucket.org/oibitbucket/ccpp-app/raw/60566cacfcb11c9d33347036fd4fe704b1676ee6/diagram/diagram_organic.png?token=326e9b7ff72179a97dead4ba4a6f8b4d986aa724), 
[Orthogonal](https://bytebucket.org/oibitbucket/ccpp-app/raw/60566cacfcb11c9d33347036fd4fe704b1676ee6/diagram/diagram_orthogonal.png?token=479aea52fed9c26fbc0edb1d81566436fc5c13c4), 
[Directed Orthogonal](https://bytebucket.org/oibitbucket/ccpp-app/raw/60566cacfcb11c9d33347036fd4fe704b1676ee6/diagram/diagram_directed_orthogonal.png?token=7d147be4b4d70b09961060cb774509a32e22b20b)

The diagram resources are stored in [./diagram](https://bitbucket.org/oibitbucket/ccpp-app/src/60566cacfcb11c9d33347036fd4fe704b1676ee6/diagram/?at=staging) folder.

## Tips for VueJS

- Vue.js can be written in the recommended ECMAScript 6.

- This command `$ npm run watch` can help you with compiling the Vue/JS/SCSS/Images changes immediately. 
After you write/change some code, please hit `CTRL + S` in your IDE. Then you can see the compiling process via terminal.

- See the [Laravel <-> Vue & Vuex in our SPA](https://bitbucket.org/oibitbucket/ccpp-app/wiki/Laravel-Vue-Vuex)
