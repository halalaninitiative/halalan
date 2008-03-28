CREATE TABLE abstains (
  position_id integer NOT NULL,
  voter_id integer NOT NULL,
  timestamp datetime NOT NULL,
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
  alias varchar(15),
  party_id integer NOT NULL,
  position_id integer NOT NULL,
  description text,
  picture char(40),
  PRIMARY KEY  (id)
);

CREATE TABLE parties (
  id integer NOT NULL auto_increment,
  party varchar(63) NOT NULL,
  alias varchar(15),
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
  abstain varchar(1) NOT NULL,
  unit varchar(1) NOT NULL,
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
  pin char(40),
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  voted varchar(1) NOT NULL,
  login datetime,
  logout datetime,
  ip_address integer,
  PRIMARY KEY  (id)
);

CREATE TABLE votes (
  candidate_id integer NOT NULL,
  voter_id integer NOT NULL,
  timestamp datetime NOT NULL,
  PRIMARY KEY  (candidate_id,voter_id)
);

CREATE TABLE options (
  id smallint NOT NULL,
  status varchar(1) NOT NULL,
  result varchar(1) NOT NULL,
  PRIMARY KEY  (id)
);

INSERT INTO options (id, status, result) VALUES (1, '0', '0');