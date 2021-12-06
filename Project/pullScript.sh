#!/bin/bash
echo "Script pull started"
composer install
read -p "Do you want to refresh ALL your database ? (/!\ data inserted will be remove /!\) : y / N " -n 1 -r
echo    # (optional) move to a new line
if [[ $REPLY =~ ^[Yy]$ ]]
then
    # do dangerous stuff
    php bin/console doctrine:fixtures:load --force
fi
php bin/console cache:pool:clear cache.global_clearer
npm install
npm run dev
echo "Script pull finished"
