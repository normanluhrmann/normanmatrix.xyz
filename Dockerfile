FROM wordpress

COPY phpsettings.ini /usr/local/etc/php/conf.d/norman.ini
RUN usermod -aG www-data myname