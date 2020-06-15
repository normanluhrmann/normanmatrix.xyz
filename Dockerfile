FROM wordpress

COPY phpsettings.ini /usr/local/etc/php/conf.d/norman.ini
COPY dist.sh /tmp