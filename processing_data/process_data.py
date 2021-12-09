import mysql.connector
import pandas as pd
import os
#conn = mysql.connector.connect(user='admin', password='1234', host='localhost', database='movie')

data_path = '../IMDB_data/'
data_l = os.listdir(data_path)
chunk_size=500000
if not os.path.exists(data_path + 'chunk_title_basic'):
    os.makedirs(data_path + 'chunk_title_basic')
if not os.path.exists(data_path + 'chunk_title_crew'):
    os.makedirs(data_path + 'chunk_title_crew')
if not os.path.exists(data_path + 'chunk_name_basic'):
    os.makedirs(data_path + 'chunk_name_basic')
if not os.path.exists(data_path + 'chunk_ratings'):
    os.makedirs(data_path + 'chunk_ratings')
for i in data_l:
    if i[-3:] != 'csv': continue
    batch_no=1
    for chunk in pd.read_csv(data_path + i,chunksize=chunk_size):
        chunk.to_csv(data_path + '{}_'.format(batch_no) + i,index=False)
        batch_no+=1


