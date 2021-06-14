# Project setup with Vagrant (Laravel Homestead)

### Execute the project using Vagrant
1. Download and install Virtualbox:
    ```
    https://www.virtualbox.org/wiki/Downloads
    ```

2. Download and install Vagrant:
    ```
    https://www.vagrantup.com/downloads.html
    ```
3. Install the box laravel/homestead:
    ```
    vagrant box add laravel/homestead
    ```
4. Clone the homestead cli
    ```
    git clone https://github.com/laravel/homestead.git ~/Homestead
    cd ~/Homestead
    bash init.sh
    ```
5. Change the file configuration ~/Homestead/Homestead.yaml to:
    ```
    ---
    ip: "192.168.10.10"
    memory: 2048
    cpus: 2
    provider: virtualbox
    
    authorize: ~/.ssh/id_rsa.pub
    
    keys:
        - ~/.ssh/id_rsa
    
    folders:
        - map: ~/workspace/meveto-backend
          to: /home/vagrant/code/meveto-backend
    
    sites:
        - map: meveto.test
          to: /home/vagrant/code/meveto-backend/public
    
    databases:
        - meveto
    
    features:
        - mariadb: false
        - ohmyzsh: false
        - webdriver: false
    
    ports:
        - send: 80
          to: 80
        - send: 8000
          to: 8000
        - send: 7700
          to: 7700
        - send: 3306
          to: 3306
    
    # ports:
    #     - send: 50000
    #       to: 5000
    #     - send: 7777
    #       to: 777
    #       protocol: udp

    ```
   5.1. Obs: Change folders -> map to the folder where your project is located

6. Add this line in file etc/hosts:
    ```
    192.168.10.10  meveto
    ```
7. Change the database configuration in .env
    ```
    DB_CONNECTION=mysql
    DB_HOST=192.168.10.10
    DB_PORT=3306
    DB_DATABASE=meveto
    DB_USERNAME=homestead
    DB_PASSWORD=secret
    ```

8. To run, execute:
    ```
    cd ~/Homestead
    vagrant up
    ```

9. To stop vagrant:
    ```
    vagrant halt
    ```

10. Connect in VM
    ```
     vagrant ssh
    ```
    
11. Copy the env.example to env to get the database and keys configuration

12. To unit and feature test the app please delete the env params PUBLIC and PRIVATE KEY from env file.
