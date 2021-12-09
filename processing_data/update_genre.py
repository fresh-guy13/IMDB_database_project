import mysql.connector
from mysql.connector import errorcode
import pandas as pd
import os
import csv
try:
    conn = mysql.connector.connect(user='admin', password='1234', host='localhost', database='movie')
except mysql.connector.Error as err:
    if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
        print("Something is wrong with your user name or password")
    elif err.errno == errorcode.ER_BAD_DB_ERROR:
        print("Database does not exist")
    else:
        print(err)
print('Connection successful')
cursor = conn.cursor()
data_path = '../IMDB_data/'

# title basic
#(Movie_id, Runtime, Title, StartDate, EndDate, NumVotes, AverageRating)
if not os.path.exists(data_path + 'chunk_title_basic'):
    os.makedirs(data_path + 'chunk_title_basic')
    
for i in os.listdir(data_path + 'chunk_title_basic'):
    if (i == '16_title_basic.csv') : continue
    df = pd.read_csv(data_path + 'chunk_title_basic/'+i, encoding='ISO-8859-1')
    print('chunk {} start'.format(i))
    for idx, row in df.iterrows():
        #print("INSERT INTO Movies VALUES(%s, %f, %s, %s, %s, '0', '0');" %(row['tconst'], float(row['runtimeMinutes']), row['primaryTitle'], row['startYear'], row['endYear']))
        if type(row['genres']) == float: continue
        for l in row['genres'].split(','):
            temp_data = (row['tconst'], l)        
            try:
                cursor.execute("Insert INTO Movie_genres VALUES(%s, %s);", temp_data)
            except:
                break
    conn.commit()
    
        
print("END")



#name_basic.csv
# temp_data = (row['nconst'], row['primaryName'], row['birthYear'], row['deathYear'])
# cursor.execute("INSERT INTO Directors VALUES(%s, %s, %s, %s);", temp_data)

# #ratings.csv
# temp_data = (row['nconst'], row['primaryName'], row['birthYear'], row['deathYear'])
# cursor.execute("INSERT INTO Directors VALUES(%s, %s, %s, %s);", temp_data)

# #title_akas.csv

# #title_crew.csv
# temp_data = (row['tconst'], row['primaryName'], row['birthYear'], row['deathYear'])
# cursor.execute("INSERT INTO Directors VALUES(%s, %s, %s, %s);", temp_data)

#close the connection to the database.
conn.commit()
cursor.close()

