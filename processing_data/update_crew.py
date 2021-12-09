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
if not os.path.exists(data_path + 'chunk_title_crew'):
    os.makedirs(data_path + 'chunk_title_crew')
# title basic
#(Movie_id, Runtime, Title, StartDate, EndDate, NumVotes, AverageRating)
data_path + 'chunk_title_crew'
for i in os.listdir(data_path + 'chunk_title_crew'):
    df = pd.read_csv(data_path + 'chunk_title_crew/'+i, encoding='ISO-8859-1')
    print('chunk {} start'.format(i))
    for idx, row in df.iterrows():
        #print("INSERT INTO Movies VALUES(%s, %f, %s, %s, %s, '0', '0');" %(row['tconst'], float(row['runtimeMinutes']), row['primaryTitle'], row['startYear'], row['endYear']))
        if row['directors'] == '\\N': continue
        for l in row['directors'].split(','):
            temp_data = (l, row['tconst'])
            try:
                cursor.execute("Insert INTO director_movie VALUES(%s, %s);", temp_data)
            except:
                continue
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

