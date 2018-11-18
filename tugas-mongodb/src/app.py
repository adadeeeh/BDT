from flask import Flask, request, jsonify
from pymongo import MongoClient
import json
from bson.json_util import dumps, ObjectId

app = Flask(__name__)

client = MongoClient('192.168.33.10', 27017)
db = client.rsgoat
collection = db.albumlist

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
@app.route('/api/album/create', methods=['POST'])
def create_wordscharacter():
    data = request.get_json(force=True)
    insert = collection.insert_one(data)
    insert_id = insert.inserted_id
    return dumps(insert_id)

#read all
@app.route('/api/album/read', methods=['GET'])
def get_all():
    album = []
    for i in collection.find({}):
        album.append(i)
    return dumps(album)

#read by id
@app.route('/api/album/read/one/<id>', methods=['GET'])
def get_one_id(id):
    album = collection.find_one({"_id": ObjectId(id)})
    return dumps(album)

# #read by year all
# @app.route('/api/album/read/all/<year>', methods=['GET'])
# def get_all_year(year):
#     album = collection.find({"Year": year})
#     return dumps(album)

# #read by year one
# @app.route('/api/album/read/one/<year>', methods=['GET'])
# def get_one(year):
#     album = collection.find_one({'Character': name})
#     return dumps(album)    

#update by id
@app.route('/api/album/update/<id>', methods=['PUT'])
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
@app.route('/api/album/delete/<id>', methods=['DELETE'])
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