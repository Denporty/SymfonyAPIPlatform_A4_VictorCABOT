#!/bin/bash
echo "Script pull started"
composer install
read -p "Do you want to refresh ALL your database ? (/!\ data inserted will be remove /!\) : y / N " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    # do dangerous stuff
    php bin/console doctrine:fixtures:load
fi

rm -rf ./bootstrap/cache/config.php
php bin/console clear-compiled
php bin/console view:clear
php bin/console config:clear
php bin/console route:cache
php bin/console optimize:clear
npm install
npm run dev
echo "Script pull finished"
