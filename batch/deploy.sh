#!/usr/bin/env bash

deploy_path='/var/www/public'
#git clone git@***/***.git $deploy_path
cd ${deploy_path}
#git config core.filemode false
sudo /usr/local/bin/git clean -f
sudo /usr/local/bin/git checkout .
sudo /usr/local/bin/git pull origin master
sudo chmod -R 0777 ${deploy_path}

exit 0