#!/usr/bin/python
# read in.csv adding one column for UUID

import csv
import uuid

fin = open('/home/pedro/Documents/Kuliah/BDT/tugas-cassandra/dataset/albumlist.csv', 'rb')
fout = open('/home/pedro/Documents/Kuliah/BDT/tugas-cassandra/dataset/albumout.csv', 'w')

reader = csv.reader(fin, delimiter=',', quotechar='"')
writer = csv.writer(fout, delimiter=',', quotechar='"')

firstrow = True
for row in reader:
    if firstrow:
        row.append('UUID')
        firstrow = False
    else:
        row.append(uuid.uuid1())
    writer.writerow(row)