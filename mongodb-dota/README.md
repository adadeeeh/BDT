# **CRUD PyMongo with MongoDb Atlas**

## **Index**
- [Requirements] (#requitements)
- [Installation] (#installation)
- [API] (#api)

## **Requirements**
- MongoDB Atlas
- Python 2.7
- Flask
- PyMongo
- Virtualenv

## **Installation**
1. Create virtual environment
   
   Windows
   ```sh
   virtualenv venv
   ```
2. Activate Virutal Environment
   ```sh
   venv\Scripts\activate
   ```
3. Install Dependencies
   ```sh
   pip install -r requirements.txt
   ```
4. Run Server
   ```sh
   set FLASK_ENV=development
   flask run
   ```
## **API**
1. Create Heroes
   ```text
   /api/heroes
   #methods POST
   ```
2. Get All Heroes
   ```text
   /api/heroes
   #methods GET
   ```
3. Get Heroes by Name
   ```text
   /api/heroes/<name>
   #methods GET
   ```
4. Update by ID
   ```text
   /api/heroes/<id>
   #methods PUT
   ```
5. Delete by ID
   ```text
   /api/heroes/<id>
   #methods DELETE
   ```