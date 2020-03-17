# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  # 以下のawslinuxは古いバージョンで開発する上で不都合であるため、centOS7を使用する
  # config.vm.box = "mvbcoding/awslinux"
  config.vm.box = "centos/7"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # vagrant plugin install vagrant-proxyconf
  if Vagrant.has_plugin?("vagrant-proxyconf")
    config.proxy.http     = ENV["HTTP_PROXY"] || ""
    config.proxy.https    = ENV["HTTPS_PROXY"] || ""
    config.proxy.no_proxy = ENV["NO_PROXY"] || "localhost,127.0.0.1"
  end

  # AWSLinuxの時は無効化しないとエラーになっていたが、CentOS7だと有効化しないと共有フォルダがエラーになる
  config.vbguest.auto_update = true

  config.ssh.forward_agent = true

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  config.vm.network "forwarded_port", guest: 80, host: 8005, host_ip: "127.0.0.1"
  config.vm.network "forwarded_port", guest: 8080, host: 8006, host_ip: "127.0.0.1"
  config.vm.network "forwarded_port", guest: 3306, host: 8007, host_ip: "127.0.0.1"

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
  config.vm.network "private_network", ip: "192.168.56.19"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  config.vm.synced_folder ".", "/vagrant", type: "virtualbox", :owner => 'vagrant', :group => 'vagrant', mount_options: ['dmode=777','fmode=777']

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
  config.vm.provider "virtualbox" do |vb|
      vb.customize ["modifyvm", :id, "--memory", "2048", "--cpus", "2", "--ioapic", "on"]
  end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  # config.vm.provision "shell", inline: <<-SHELL
  #   apt-get update
  #   apt-get install -y apache2
  # SHELL

  if !File.exist?(".ansible-vault-pass")
    puts "ERROR: .ansible-vault-passファイルを作成してください(ansible-vaultのパスワードを記載する必要があります)。"
    abort
  end
  # ローカルのパスワードファイルはパーミッションの都合で参照出来ないため/tmpに複製する
  config.vm.provision :shell, inline: "cp /vagrant/.ansible-vault-pass /tmp/vault_pass && chmod 644 /tmp/vault_pass"

  config.vm.provision "ansible_local" do |ansible|
    ansible.playbook = "/vagrant/ansible/playbook_vagrant.yml"
    ansible.vault_password_file = "/tmp/vault_pass"
  end

  # ansibleでapacheの自動起動設定はしたものの、毎回起動されていないため起動コマンドを実行する
  # 原因は不明だが、httpdのドキュメントルートを共有フォルダ(synced_folder)に設定していると、
  # httpdの起動時にフォルダが存在しなくて、Vagrant起動時にhttpdの起動に失敗する時があるらしい
  config.vm.provision "shell", run: "always", :inline => <<-COMMAND
     sudo systemctl start httpd.service
  COMMAND
end
