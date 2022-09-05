--  database structure 
-- (phpmyadmin)

-- main structure
CREATE Database film_criticism;

CREATE TABLE `user`(
  id int(11) NOT NULL,
  name varchar(100) NOT NULL,
  email varchar(100) NOT NULL,
  username varchar(100) NOT NULL,
  password varchar(100) NOT NULL,
  comment_count int(11) NOT NULL
);

ALTER TABLE `user` ADD PRIMARY KEY (id);
ALTER TABLE `user` MODIFY id int(11) NOT NULL AUTO_INCREMENT;

-------

CREATE TABLE movie(
  id int(11) NOT NULL,
  name varchar(150) NOT NULL,
  director varchar(150) NOT NULL,
  writer varchar(150) NOT NULL,
  producer varchar(150) NOT NULL,
  cast varchar(400) NOT NULL,
  music_composer varchar(300) NOT NULL,
  year int(4) NOT NULL,
  genre varchar(150) NOT NULL,
  poster varchar(150) NOT NULL,
  synopsis varchar(800) NOT NULL
);

ALTER TABLE movie ADD PRIMARY KEY (id);
ALTER TABLE movie MODIFY id int(11) NOT NULL AUTO_INCREMENT;

-------

CREATE TABLE comment (
  id int(11) NOT NULL,
  movie_name varchar(150) NOT NULL,
  comment varchar(800) NOT NULL,
  date date NOT NULL DEFAULT current_timestamp(),
  user_id int(11) NOT NULL
);

ALTER TABLE comment ADD PRIMARY KEY (id);
ALTER TABLE comment MODIFY id int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE comment ADD CONSTRAINT user_comment_fk FOREIGN KEY (user_id) REFERENCES user(id);

------

-- insert some test value

INSERT INTO user(name, email, username, password, comment_count) 
VALUES ('admin', 'admin@gmail.com', 'admin_username', 'admin_password', 2), 
       ('userOne', 'userOne@gmail.com', 'userOne_username', 'userOne_password', 2), 
       ('userTwo', 'userTwo@gmail.com', 'userTwo_username', 'userTwo_password',2);

INSERT INTO movie(name, director, writer, producer, cast, music_composer, year, genre, poster, synopsis)
VALUES('The Shining', 'Stanley Kubrick', 'Stanley Kubrick,Diane Johnson ', 'Stanley Kubrick', 'Jack Nicholson,Shelley Duvall,Scatman Crothers,Danny Lloyd', 'Wendy Carlos,Rachel Elkind', 1980, 'Horror,Mystery', 'poster/The Shining.jpg', 'A family heads to an isolated hotel for the winter where a sinister presence influences the father into violence, while his psychic son sees horrific forebodings from both past and future.'),
      ('Interstellar', 'Christopher Nolan', 'Jonathan Nolan,Christopher Nolan', 'Emma Thomas,Christopher Nolan,Lynda Obst', 'Matthew McConaughey,Anne Hathaway,Jessica Chastain,Bill Irwin,Ellen Burstyn,Michael Caine', 'Hans Zimmer', 2014, 'Sci-fi,Adventure', 'poster/Interstellar.jpg', 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity s survival.' ),
      ('Shutter Island', 'Martin Scorsese', 'Laeta Kalogridis', 'Mike Medavoy,Arnold W. Messer,Bradley J. Fischer,Martin Scorsese', 'Leonardo DiCaprio,Mark Ruffalo,Ben Kingsley,Michelle Williams,Emily Mortimer,Patricia Clarkson,Max von Sydow', 'Rhino Records', 2010, 'Thriller,Mystery' ,'poster/Shutter Island.jpg', 'In 1954, a U.S. Marshal investigates the disappearance of a murderer who escaped from a hospital for the criminally insane.');

INSERT INTO comment(movie_name, comment, user_id)
VALUES('The Shining', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic aliquam vero sequi velit molestias .', 1 ),
      ('Interstellar', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic aliquam vero sequi velit molestias .', 2),
      ('Shutter Island', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic aliquam vero sequi velit molestias .', 3),
      ('The Shining', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic aliquam vero sequi velit molestias .', 3 ),
      ('Shutter Island', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic aliquam vero sequi velit molestias .', 2),
      ('Interstellar', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Accusamus numquam assumenda hic aliquam vero sequi velit molestias .', 1);