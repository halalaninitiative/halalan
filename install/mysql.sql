CREATE TABLE abstains (
  election_id integer NOT NULL,
  position_id integer NOT NULL,
  voter_id integer NOT NULL,
  timestamp datetime NOT NULL,
  PRIMARY KEY  (election_id,position_id,voter_id)
);

CREATE TABLE admins (
  id integer NOT NULL auto_increment,
  email varchar(63) NOT NULL,
  username varchar(63) NOT NULL,
  password char(40) NOT NULL,
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  UNIQUE KEY (username),
  PRIMARY KEY  (id)
);

CREATE TABLE blocks (
  id integer NOT NULL auto_increment,
  block varchar(63) NOT NULL,
  description text,
  PRIMARY KEY  (id)
);

CREATE TABLE blocks_elections_positions (
  block_id integer NOT NULL,
  election_id integer NOT NULL,
  position_id integer NOT NULL,
  KEY (block_id),
  KEY (election_id),
  PRIMARY KEY  (block_id,election_id,position_id)
);

CREATE TABLE candidates (
  id integer NOT NULL auto_increment,
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  alias varchar(15),
  party_id integer,
  election_id integer NOT NULL,
  position_id integer NOT NULL,
  description text,
  picture char(40),
  KEY (election_id, position_id),
  KEY (first_name, last_name),
  KEY (first_name, last_name, alias),
  PRIMARY KEY  (id)
);

CREATE TABLE elections (
  id integer NOT NULL auto_increment,
  election varchar(63) NOT NULL,
  parent_id integer NOT NULL,
  status boolean NOT NULL,
  results boolean NOT NULL,
  KEY (parent_id),
  PRIMARY KEY  (id)
);

CREATE TABLE elections_parties (
  election_id integer NOT NULL,
  party_id integer NOT NULL,
  PRIMARY KEY  (election_id,party_id)
);

CREATE TABLE elections_positions (
  election_id integer NOT NULL,
  position_id integer NOT NULL,
  PRIMARY KEY  (election_id,position_id)
);

CREATE TABLE parties (
  id integer NOT NULL auto_increment,
  party varchar(63) NOT NULL,
  alias varchar(15),
  description text,
  logo char(40),
  KEY (party),
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
  KEY (position),
  PRIMARY KEY  (id)
);

CREATE TABLE voted (
  election_id integer NOT NULL,
  voter_id integer NOT NULL,
  image_trail_hash char(40),
  timestamp datetime NOT NULL,
  KEY (voter_id),
  PRIMARY KEY  (election_id,voter_id)
);

CREATE TABLE voters (
  id integer NOT NULL auto_increment,
  username varchar(63) NOT NULL,
  password char(40) NOT NULL,
  pin char(40),
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  block_id integer NOT NULL,
  login datetime,
  logout datetime,
  ip_address integer,
  UNIQUE KEY (username),
  KEY (first_name, last_name),
  KEY (block_id),
  PRIMARY KEY  (id)
);

CREATE TABLE votes (
  candidate_id integer NOT NULL,
  voter_id integer NOT NULL,
  timestamp datetime NOT NULL,
  KEY (voter_id),
  KEY (candidate_id),
  PRIMARY KEY  (candidate_id,voter_id)
);

CREATE TABLE sessions (
    session_id varchar(40) DEFAULT '0' NOT NULL,
    ip_address varchar(16) DEFAULT '0' NOT NULL,
    user_agent varchar(50) NOT NULL,
    last_activity int(10) unsigned DEFAULT 0 NOT NULL,
    user_data text NOT NULL,
    PRIMARY KEY (session_id)
);
