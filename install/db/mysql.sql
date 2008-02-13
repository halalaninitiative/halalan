CREATE TABLE abstains (
  position_id integer NOT NULL,
  voter_id integer NOT NULL,
  timestamp timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (position_id,voter_id)
);

CREATE TABLE admins (
  id integer NOT NULL auto_increment,
  email varchar(63) NOT NULL,
  username varchar(63) NOT NULL,
  password char(40) NOT NULL,
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE candidates (
  id integer NOT NULL auto_increment,
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  party_id integer NOT NULL,
  position_id integer NOT NULL,
  description text,
  picture char(40),
  PRIMARY KEY  (id)
);

CREATE TABLE parties (
  id integer NOT NULL auto_increment,
  party varchar(63) NOT NULL,
  description text,
  logo char(40),
  PRIMARY KEY  (id)
);

CREATE TABLE positions (
  id integer NOT NULL auto_increment,
  position varchar(63) NOT NULL,
  description text,
  maximum smallint NOT NULL,
  ordinality smallint NOT NULL,
  abstain tinyint(1) NOT NULL,
  unit tinyint(1) NOT NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE positions_voters (
  position_id integer NOT NULL,
  voter_id integer NOT NULL,
  PRIMARY KEY  (position_id,voter_id)
);

CREATE TABLE voters (
  id integer NOT NULL auto_increment,
  username varchar(63) NOT NULL,
  password char(40) NOT NULL,
  pin char(40) NOT NULL,
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  voted tinyint(1) NOT NULL,
  login timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  logout timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (id)
);

CREATE TABLE votes (
  candidate_id integer NOT NULL,
  voter_id integer NOT NULL,
  timestamp timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY  (candidate_id,voter_id)
);

CREATE TABLE options (
  id smallint NOT NULL,
  status tinyint(1) NOT NULL,
  result tinyint(1) NOT NULL,
  PRIMARY KEY  (id)
);

INSERT INTO options (id, status, result) VALUES (1, 0, 0);