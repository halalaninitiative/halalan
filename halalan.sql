CREATE TABLE elections (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  election varchar(63) NOT NULL,
  parent_id integer UNSIGNED,
  status boolean NOT NULL,
  results boolean NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (parent_id) REFERENCES elections(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE positions (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  election_id integer UNSIGNED NOT NULL,
  position varchar(63) NOT NULL,
  description text,
  maximum smallint NOT NULL,
  ordinality smallint NOT NULL,
  abstain boolean NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (election_id) REFERENCES elections(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  KEY (position)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE parties (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  election_id integer UNSIGNED NOT NULL,
  party varchar(63) NOT NULL,
  alias varchar(15),
  description text,
  logo varchar(255),
  PRIMARY KEY (id),
  FOREIGN KEY (election_id) REFERENCES elections(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  KEY (party)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE candidates (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  alias varchar(15),
  party_id integer UNSIGNED,
  election_id integer UNSIGNED NOT NULL,
  position_id integer UNSIGNED NOT NULL,
  description text,
  picture varchar(255),
  PRIMARY KEY (id),
  FOREIGN KEY (election_id) REFERENCES elections(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (position_id) REFERENCES positions(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (party_id) REFERENCES parties(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  KEY (election_id, position_id),
  KEY (first_name, last_name),
  KEY (first_name, last_name, alias)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE blocks (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  block varchar(63) NOT NULL,
  description text,
  PRIMARY KEY (id),
  KEY (block)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE blocks_elections_positions (
  block_id integer UNSIGNED NOT NULL,
  election_id integer UNSIGNED NOT NULL,
  position_id integer UNSIGNED NOT NULL,
  PRIMARY KEY (block_id,election_id,position_id),
  FOREIGN KEY (block_id) REFERENCES blocks(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (election_id) REFERENCES elections(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (position_id) REFERENCES positions(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE voters (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  username varchar(63) NOT NULL,
  password varchar(255) NOT NULL,
  pin varchar(255),
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  block_id integer UNSIGNED NOT NULL,
  login datetime,
  logout datetime,
  ip_address integer,
  PRIMARY KEY (id),
  FOREIGN KEY (block_id) REFERENCES blocks(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  UNIQUE KEY (username),
  KEY (first_name, last_name)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE votes (
  candidate_id integer UNSIGNED NOT NULL,
  voter_id integer UNSIGNED NOT NULL,
  timestamp datetime NOT NULL,
  PRIMARY KEY (candidate_id,voter_id),
  FOREIGN KEY (candidate_id) REFERENCES candidates(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (voter_id) REFERENCES voters(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE abstains (
  election_id integer UNSIGNED NOT NULL,
  position_id integer UNSIGNED NOT NULL,
  voter_id integer UNSIGNED NOT NULL,
  timestamp datetime NOT NULL,
  PRIMARY KEY (election_id,position_id,voter_id),
  FOREIGN KEY (election_id) REFERENCES elections(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (position_id) REFERENCES positions(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (voter_id) REFERENCES voters(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE voted (
  election_id integer UNSIGNED NOT NULL,
  voter_id integer UNSIGNED NOT NULL,
  image_trail_hash varchar(255),
  timestamp datetime NOT NULL,
  PRIMARY KEY (election_id,voter_id),
  FOREIGN KEY (election_id) REFERENCES elections(id) ON UPDATE CASCADE ON DELETE RESTRICT,
  FOREIGN KEY (voter_id) REFERENCES voters(id) ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE admins (
  id integer UNSIGNED NOT NULL AUTO_INCREMENT,
  email varchar(63) NOT NULL,
  username varchar(63) NOT NULL,
  password varchar(255) NOT NULL,
  first_name varchar(63) NOT NULL,
  last_name varchar(31) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (username)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

CREATE TABLE sessions (
    session_id varchar(40) DEFAULT '0' NOT NULL,
    ip_address varchar(45) DEFAULT '0' NOT NULL,
    user_agent varchar(120) NOT NULL,
    last_activity int(10) unsigned DEFAULT 0 NOT NULL,
    user_data text NOT NULL,
    PRIMARY KEY (session_id),
    KEY (last_activity)
);

CREATE TABLE captchas (
    captcha_id bigint(13) unsigned NOT NULL AUTO_INCREMENT,
    captcha_time int(10) unsigned NOT NULL,
    ip_address varchar(45) DEFAULT '0' NOT NULL,
    word varchar(20) NOT NULL,
    PRIMARY KEY (captcha_id),
    KEY (word)
);