from flask import Flask, request, Response, jsonify
from cassandra.cluster import Cluster
import json

cluster = Cluster()
session = cluster.connect('rsmagz')
app = Flask(__name__)

#Create
@app.route('/', methods=['POST'])
def create():
        data = request.get_json(force=True)[0]
	# print data
	try:
		query = session.execute(
			"""
                        INSERT INTO album_list (id, album, artist, genre, number, subgenre, year) VALUES (%(id)s, %(album)s, %(artist)s, %(genre)s, %(number)s, %(subgenre)s, %(year)s)
                        """, data)
		# out_cleaned = json.dumps(query[0]).replace('"{', '{').replace('\\"', '"').replace('}"', '}')
		# return Response(out_cleaned, mimetype='application/json')
                return 'Inserted'
	except Exception:
		return 'Insert error'


#Update
@app.route('/<id>', methods=['PUT'])
def updateOne(id):
	data = request.get_json(force=True)[0]
	# print data
	try:
		query = session.execute(
			"""
			UPDATE album_list SET number = %(number)s, year = %(year)s, artist = %(artist)s, album = %(album)s, genre = %(genre)s, 
			subgenre = %(subgenre)s WHERE id = 
			"""+id, data)
		return 'Updated'
	except Exception:
		return 'Update error'


#Read All
@app.route('/', methods=['GET'])
def getAll():
	rows = session.execute('SELECT json * from album_list');
	output = []
	for row in rows:
		output.append(row[0])
        return Response(output, mimetype='application/json')
        # return json.dumps(output)

#Read One
@app.route('/<id>', methods=['GET'])
def getOne(id):
    try:
            row = session.execute('SELECT json * from album_list WHERE id = '+id)
            return Response(row[0], mimetype='application/json')
    except Exception:
            return 'Read Error'

#Delete
@app.route('/<id>', methods=['DELETE'])
def delete(id):
    row = session.execute('DELETE FROM album_list WHERE id = '+id);
    return 'Deleted'