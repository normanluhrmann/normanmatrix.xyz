#!/bin/bash -e

DB_SRC_USER=exampleuser
DB_SRC_PASS=examplepass
DB_SRC_DB=exampledb
DB_SRC_HOST=localhost

DB_DST_USER=awsusr
DB_DST_PASS=awspass
DB_DST_DB=wordpress
DB_DST_HOST=localhost

###################

apt-get update && apt-get install -y default-mysql-client

cd /var/www/html

D=$(date +"%Y%m%d")
R=$RANDOM
FILENAME_DB="/dist/wordpress-$D-$R.sql.gz"
FILENAME_WP="/dist/wordpress-$D-$R.tar.gz"

mysqldump -u $DB_SRC_USER --password=$DB_SRC_PASS -h $DB_SRC_HOST $DB_SRC_DB | gzip > 

tar czf /dist/wordpress-$D.tar.gz ./

# FIXME

DB_MIGRATE_CMD=<<EOT
UPDATE wp_options SET option_value = replace(option_value, 'http://www.oldurl', 'http://www.newurl') WHERE option_name = 'home' OR option_name = 'siteurl';

UPDATE wp_posts SET guid = replace(guid, 'http://www.oldurl','http://www.newurl');

UPDATE wp_posts SET post_content = replace(post_content, 'http://www.oldurl', 'http://www.newurl');

UPDATE wp_postmeta SET meta_value = replace(meta_value,'http://www.oldurl','http://www.newurl');
EOT

mysql -u 