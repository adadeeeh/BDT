# **Tugas Cassandra**

## **Index**
- [Requirements](#Requirements)
- [Dataset](#Dataset)
- [Installation](#Installation)
  
## **Requirements**
- Cassandra
- Python 2.7
- Flask
- Virutalenv
- Cassandra Driver
- Vagrant

## **Dataset**
Dataset yang digunakan adalah [Rolling Stones's 500 Greatest Albums of All Time](https://www.kaggle.com/notgibs/500-greatest-albums-of-all-time-rolling-stone)

Dataset diedit agar mempunyai primary key

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
5. Masuk ke Cassandra Shell
   ```sh
   cqls
   ```
6. Membuat Keyspace
   ```SQL
   CREATE KEYSPACE rsmagz
   WITH replication = {
       'class' : 'SimpleStrategy',
       'replication_factor' : 1
       };
   ```
7. Membuat Table
   ```SQL
   CREATE TABLE rsmagz.album_list(id int,number text, year text, album text, artist text, genre text, subgenre text, PRIMARY KEY(id));
   ```
8. Import Data albumlist.csv
   ```SQL
   COPY rsmagz.album_list(number,year,album,artist,genre,subgenre,id) FROM 'albumlist.csv' WITH HEADER = TRUE;
   ```

## **API**
1. Create
   ```sh
   192.168.33.200:5000/
   #methods POST
   ```
   ![create](images/create.png)
2. Read All
   ```sh
   192.168.33.200:5000/
   #methods GET
   ```
   ![read](images/readall.png)
3. Search by ID
   ```sh
   192.168.33.200:5000/<id>
   #methods GET
   ```
   ![search](images/search.png)
4. Update
   ```sh
   192.168.33.200:5000/<id>
   #methods PUT
   ```
   ![update](images/update.png)
   Cek Update
   ![cek update](images/cekupdate.png)
5. Delete
   ```sh
   192.168.33.200:5000/<id>
   #methods DELETE
   ```
   ![Delete](images/delete.png)
   Cek Delete
   ![cek delete](images/cekdelete.png)
