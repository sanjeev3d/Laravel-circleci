#### Docker file to build git-app docker container from scratch ####
FROM ubuntu:16.04
ENV DEBIAN_FRONTEND noninteractive

# Copy code inside container
ADD index.php /var/www/html/
ADD css/ /var/www/html/css/
ADD js/ /var/www/html/jss/
ADD myApp/public/* /var/www/html/public/
ADD myApp/ /var/myApp
ADD apache2.conf /etc/apache2/sites-enabled/000-default.conf
ADD gip-app-entrypoint.sh /
RUN chmod -R 777 /var/myApp

RUN apt-get update && \
    apt-get install -y python-software-properties software-properties-common && \
    LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php -y && \
    apt-get update -y && \
    apt-get install -y openssl git unzip curl php7.2 php7.2-cli php7.2-xml php7.2-mbstring \
                       php7.2-json php7.2-bcmath php7.2-mysql -y && \
    phpenmod pdo_mysql && \
    phpenmod mbstring && \
    a2enmod rewrite 
    
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && \
    php composer-setup.php --filename=composer --version=1.8.4 --install-dir=/usr/local/bin && \
    cd /var/myApp/ && \
    composer install && \
    chown -R www-data:www-data /var/www/html/ && \
    chmod 777 /gip-app-entrypoint.sh

# Expose container port
EXPOSE 80

ENTRYPOINT ["/gip-app-entrypoint.sh"]
