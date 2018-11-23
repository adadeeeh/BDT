# **Tugas MongoDB**

## **Index**
- [Requirements](#Requirements)
- [Installation](#Installation)

## **Requirements**
- MongoDB
- Python 2.7
- Flask
- PyMongo
- Virtualenv

## **Installation**
1. Create Virtual Environment
   ```sh
    virtualenv venv
    ```
2. Activate Virtual Environment
   ```sh
    . venv/bin/activate
   ```
3. Install Requirements
   ```sh
    pip install -r requirements.txt
   ```
4. Vagrant Up Vagrantfile
   ```sh
    vagrant up
   ```
5. Edit /etc/mongod.conf pada setiap node seperti ini
   ```sh
    net:
        port: 27017
        bindIp: ip masing-masing node

    replication:
        replSetName: rs0
   ``` 
   Kemudian restart mongo
   ```sh
    sudo systemctl restart mongod
   ```
6. Masuk ke db-manager dan melakukan replika
   ```sh
    $ mongo 192.168.33.10
    > rs.initiate()
    output
    {
    "info2" : "no configuration specified. Using a default configuration for the set",
    "me" : "db-manager:27017",
    "ok" : 1
    }

    rs0:SECONDARY> rs.add('db-node1:27017')
    { "ok" : 1 }

    rs0:PRIMARY> rs.add('db-node2:27017')
    { "ok" : 1 }
   ```
7. Cek status replika apakah sudah benar atau belum
   ```sh
    rs0:PRIMARY> rs.status()
   ```