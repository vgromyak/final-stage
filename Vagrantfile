# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  #config.vm.box = "ubuntu/trusty64"
  config.vm.box = "ubuntu/trusty32"
  config.vm.network "forwarded_port", guest: 80, host: 8888
  config.vm.synced_folder "source", "/var/www/final-stage"
  config.vm.synced_folder "config", "/home/vagrant/config"
  config.vm.provision :shell, path: "bootstrap.sh"
  #config.vm.provider "virtualbox" do |vb|
  #  vb.gui = true
  #  vb.memory = "1024"
  #end
end
