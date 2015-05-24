#!/bin/sh

apt-get update
apt-get install -y apache2 php5 libapache2-mod-php5 php5-dev php5-curl php5-gd sendmail phpunit git lame
a2enmod rewrite headers expiresWellcome2Ciklum

a2dissite 000-default.conf
cp /home/vagrant/config/final-stage.conf /etc/apache2/sites-available/final-stage.conf
a2ensite final-stage.conf
service apache2 restart
cp -f config/rc.local /etc/rc.local
mkdir /tmp/storage_income
chmod 777 /tmp/storage_income
mkdir /tmp/storage_outcome
chmod 777 /tmp/storage_outcome
mkdir /tmp/storage_tests
chmod 777 /tmp/storage_tests

sudo pecl install --force -Z id3
cd /build/buildd/php5-5.5.9+dfsg/pear-build-download/
sudo tar -xvf id3-0.2.tar
cd id3-0.2/
yes | sudo cp /home/vagrant/config/id3.c /build/buildd/php5-5.5.9+dfsg/pear-build-download/id3-0.2/id3.c
sudo phpize
sudo ./configure
sudo make
sudo make test
sudo make install


sudo cp /home/vagrant/config/id3.ini /etc/php5/mods-available/id3.ini
sudo php5enmod id3
sudo service apache2 restart














