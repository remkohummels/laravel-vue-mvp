FROM 		debian:jessie
ENV 		HOME /root
ENV 		DEBIAN_FRONTEND	noninteractive
ENV 		LC_ALL          C.UTF-8
ENV 		LANG            en_US.UTF-8
ENV 		LANGUAGE        en_US.UTF-8
RUN 		useradd -ms /bin/bash churchs
RUN 		apt-get update && \
    		apt-get -y install git nano curl apt-transport-https software-properties-common python3-software-properties gnupg2
RUN 		echo 'deb http://packages.dotdeb.org jessie all' >> /etc/apt/sources.list
RUN 		curl https://www.dotdeb.org/dotdeb.gpg | apt-key add - && apt-get update
RUN 		apt-get -y install mc php7.0-fpm php7.0-dom php7.0-intl php7.0-mbstring php7.0-xml php7.0-mysql php7.0-curl php7.0-mcrypt php7.0-cli php7.0-dev php7.0-zip php7.0-gd php-pear libsasl2-dev nginx supervisor
RUN 		curl -sL https://deb.nodesource.com/setup_6.x | bash - && \
    		apt-get install -y nodejs
RUN 		rm -f /etc/nginx/nginx.conf /etc/nginx/sites-available/default
RUN 		curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/bin/composer
COPY		deploy/nginx.conf /etc/nginx/nginx.conf
COPY		deploy/default /etc/nginx/sites-available/default
COPY		deploy/churchs.conf /etc/php/7.0/fpm/pool.d/churchs.conf
COPY		deploy/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Share the volume with the changes of resource
RUN 		mkdir -p /var/www/ccpp-app
COPY		. /var/www/ccpp-app
COPY		.env.dev /var/www/ccpp-app/.env
RUN 		chown churchs:churchs -R /var/www/ccpp-app
RUN 		chmod -R 775 /var/www/ccpp-app
RUN 		chmod -R 777 /var/www/ccpp-app/storage /var/www/ccpp-app/bootstrap

# Install dependencies with Composer.
# --prefer-source fixes issues with download limits on Github.
# --no-interaction makes sure composer can run fully automated
USER		churchs
ENV 		HOME /var/www/ccpp-app
RUN 		cd /var/www/ccpp-app && \
    		composer dump-autoload && php artisan config:cache && \
    		php artisan cache:clear && php artisan view:clear

USER		root
CMD 		["/usr/bin/supervisord","-c","/etc/supervisor/conf.d/supervisord.conf"]
