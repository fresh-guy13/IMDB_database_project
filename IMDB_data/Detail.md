## Table!!

mysql> describe Directors;
+-------------+-------------+------+-----+---------+-------+
| Field       | Type        | Null | Key | Default | Extra |
+-------------+-------------+------+-----+---------+-------+
| CrewID      | varchar(64) | NO   | PRI | NULL    |       |
| PrimaryName | varchar(64) | YES  |     | NULL    |       |
| BirthYear   | varchar(64) | YES  |     | NULL    |       |
| DeathYear   | varchar(64) | YES  | MUL | NULL    |       |
+-------------+-------------+------+-----+---------+-------+

mysql> describe Movie_genres

+----------+-------------+------+-----+---------+-------+
| Field    | Type        | Null | Key | Default | Extra |
+----------+-------------+------+-----+---------+-------+
| Movie_id | varchar(64) | YES  | MUL | NULL    |       |
| genre    | varchar(45) | YES  |     | NULL    |       |
+----------+-------------+------+-----+---------+-------+

mysql> describe Movies;
+---------------+--------------+------+-----+---------+-------+
| Field         | Type         | Null | Key | Default | Extra |
+---------------+--------------+------+-----+---------+-------+
| Movie_id      | varchar(64)  | NO   | PRI | NULL    |       |
| Runtime       | varchar(128) | YES  |     | NULL    |       |
| Title         | varchar(128) | YES  |     | NULL    |       |
| StartDate     | varchar(45)  | YES  |     | NULL    |       |
| EndDate       | varchar(45)  | YES  |     | NULL    |       |
| NumVotes      | float        | YES  |     | NULL    |       |
| AverageRating | float        | YES  |     | NULL    |       |
+---------------+--------------+------+-----+---------+-------+

mysql> describe NewMovie;
+--------------+--------------+------+-----+---------+-------+
| Field        | Type         | Null | Key | Default | Extra |
+--------------+--------------+------+-----+---------+-------+
| Username     | varchar(128) | NO   | MUL | NULL    |       |
| Movid_id     | varchar(64)  | NO   | MUL | NULL    |       |
| PrimaryTitle | varchar(64)  | YES  |     | NULL    |       |


mysql> describe director_movie;
+----------+-------------+------+-----+---------+-------+
| Field    | Type        | Null | Key | Default | Extra |
+----------+-------------+------+-----+---------+-------+
| CrewID   | varchar(64) | YES  |     | NULL    |       |
| Movie_id | varchar(64) | YES  |     | NULL    |       |
+----------+-------------+------+-----+---------+-------+


mysql> describe fav_genres;
+----------+--------------+------+-----+---------+-------+
| Field    | Type         | Null | Key | Default | Extra |
+----------+--------------+------+-----+---------+-------+
| Username | varchar(128) | NO   | MUL | NULL    |       |
| genre    | varchar(32)  | YES  |     | NULL    |       |
+----------+--------------+------+-----+---------+-------+


mysql> describe user;
+------------+--------------+------+-----+---------+-------+
| Field      | Type         | Null | Key | Default | Extra |
+------------+--------------+------+-----+---------+-------+
| Username   | varchar(128) | NO   | PRI | NULL    |       |
| password   | varchar(128) | YES  |     | NULL    |       |
| FirstName  | varchar(64)  | YES  |     | NULL    |       |
| LastName   | varchar(64)  | YES  |     | NULL    |       |
| IsDirector | tinyint(1)   | YES  |     | NULL    |       |
| birthday   | varchar(32)  | YES  |     | NULL    |       |
| email      | varchar(128) | YES  |     | NULL    |       |
+------------+--------------+------+-----+---------+-------+

mysql> describe watched_movies;
+-------------+--------------+------+-----+---------+-------+
| Field       | Type         | Null | Key | Default | Extra |
+-------------+--------------+------+-----+---------+-------+
| Movie_id    | varchar(64)  | NO   |     | NULL    |       |
| Username    | varchar(128) | YES  | MUL | NULL    |       |
| Rating      | float        | YES  |     | NULL    |       |
| primaryName | varchar(128) | YES  |     | NULL    |       |
