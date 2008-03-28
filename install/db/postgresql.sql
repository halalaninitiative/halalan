CREATE TABLE abstains (
  position_id integer NOT NULL,
  voter_id integer NOT NULL,
  timestamp timestamp NOT NULL,
  PRIMARY KEY  (position_id,voter_id)
);

CREATE TABLE admins (
  id SERIAL NOT NULL,
  email varchar(63) NOT NULL,
  username varchar(63) NOT NULL,
  password char(40) NOT NULL,
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE candidates (
  id SERIAL NOT NULL,
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  alias varchar(15),
  party_id integer,
  position_id integer NOT NULL,
  description text,
  picture char(40),
  PRIMARY KEY  (id)
);

CREATE TABLE parties (
  id SERIAL NOT NULL,
  party varchar(63) NOT NULL,
  alias varchar(15),
  description text,
  logo char(40),
  PRIMARY KEY  (id)
);

CREATE TABLE positions (
  id SERIAL NOT NULL,
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
  id SERIAL NOT NULL,
  username varchar(63) NOT NULL,
  password char(40) NOT NULL,
  pin char(40),
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  voted varchar(1) NOT NULL,
  login timestamp,
  logout timestamp,
  ip_address integer,
  PRIMARY KEY  (id)
);

CREATE TABLE votes (
  candidate_id integer NOT NULL,
  voter_id integer NOT NULL,
  timestamp timestamp NOT NULL,
  PRIMARY KEY  (candidate_id,voter_id)
);

CREATE TABLE options (
  id smallint NOT NULL,
  status varchar(1) NOT NULL,
  result varchar(1) NOT NULL,
  PRIMARY KEY  (id)
);

INSERT INTO options (id, status, result) VALUES (1, '0', '0');