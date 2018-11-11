from flask import Flask, request, jsonify
from pymongo import MongoClient
import json
from bson.json_util import dumps, ObjectId

app = Flask(__name__)

client = MongoClient('mongodb+srv://dbUser:dbPass@cluster0-ehnwq.mongodb.net/test?retryWrites=true')
db = client.dota
collection = db.heroes

@app.route('/')
def initial_response():
    message = {
        'apiVersion': '1.0',
        'status': '200',
        'message': 'Welcome to Flask API'
    }
    resp = jsonify(message)
    return resp

#create
@app.route('/api/heroes', methods=['POST'])
def create_heroes():
    data = request.get_json(force=True)
    insert = collection.insert_one(data)
    insert_id = insert.inserted_id
    return dumps(insert_id)

#read all
@app.route('/api/heroes', methods=['GET'])
def get_all():
    heroes = []
    for i in collection.find({}):
        heroes.append(i)
    return dumps(heroes)

#read by name
@app.route('/api/heroes/<name>', methods=['GET'])
def get_one(name):
    heroes = collection.find_one({'localized_name': name})
    return dumps(heroes)

#update by id
@app.route('/api/heroes/<id>', methods=['PUT'])
def update(id):
    data = request.get_json(force=True)
    new_values = {'$set': data}
    try:
        result = collection.update_one({'_id': ObjectId(id)}, new_values)
        if result.modified_count > 0:
            return ('Updated')
        else:
            return ('Not Updated')
    except Exception:
        return ('Not Updated')    

#delete by id
@app.route('/api/heroes/<id>', methods=['DELETE'])
def delete(id):
    try:
        result = collection.delete_one({'_id': ObjectId(id)})
        if result.deleted_count > 0:
            return ('Deleted')
        else:
            return ('Not Deleted')
    except Exception:
        return ('Not Deleted')
    # if collection.count_documents({'_id': ObjectId(id)}) > 0:
    #     hapus = collection.delete_one({'_id': ObjectId(id)})
    #     return dumps(hapus.deleted_count)
    # else:
    #     return ('id not found')


if __name__ == '__main__':
    app.run(debug=True)