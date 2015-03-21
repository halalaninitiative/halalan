-- -----------------------------------------------------
-- CodeIgniter tables
-- -----------------------------------------------------
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

-- -----------------------------------------------------
-- Table `admins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `type` ENUM('super','event','election') NOT NULL DEFAULT 'election',
  PRIMARY KEY (`id`),
  UNIQUE INDEX (`username` ASC),
  INDEX (`admin_id` ASC),
  CONSTRAINT `fk_admins_admins`
    FOREIGN KEY (`admin_id`)
    REFERENCES `admins` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `events`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `events` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `admin_id` INT UNSIGNED NOT NULL,
  `event` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `config` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX (`slug` ASC),
  INDEX (`admin_id` ASC),
  CONSTRAINT `fk_events_admins`
    FOREIGN KEY (`admin_id`)
    REFERENCES `admins` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `elections`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `elections` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` INT UNSIGNED NOT NULL,
  `election` VARCHAR(255) NOT NULL,
  `admin_id` INT UNSIGNED NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  INDEX (`event_id` ASC),
  INDEX (`admin_id` ASC),
  CONSTRAINT `fk_elections_events`
    FOREIGN KEY (`event_id`)
    REFERENCES `events` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_elections_admins`
    FOREIGN KEY (`admin_id`)
    REFERENCES `admins` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `positions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `positions` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `election_id` INT UNSIGNED NOT NULL,
  `position` VARCHAR(255) NOT NULL,
  `maximum` INT UNSIGNED NOT NULL,
  `abstain` TINYINT(1) UNSIGNED NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  INDEX (`election_id` ASC),
  CONSTRAINT `fk_positions_elections`
    FOREIGN KEY (`election_id`)
    REFERENCES `elections` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `parties`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `parties` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `event_id` INT UNSIGNED NOT NULL,
  `party` VARCHAR(255) NOT NULL,
  `alias` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `logo` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX (`event_id` ASC),
  CONSTRAINT `fk_events_parties`
    FOREIGN KEY (`event_id`)
    REFERENCES `events` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `candidates`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `candidates` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `election_id` INT UNSIGNED NOT NULL,
  `position_id` INT UNSIGNED NOT NULL,
  `party_id` INT UNSIGNED NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  `alias` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `picture` VARCHAR(255) NULL,
  PRIMARY KEY (`id`),
  INDEX (`election_id` ASC),
  INDEX (`position_id` ASC),
  INDEX (`party_id` ASC),
  CONSTRAINT `fk_candidates_elections`
    FOREIGN KEY (`election_id`)
    REFERENCES `elections` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_candidates_positions`
    FOREIGN KEY (`position_id`)
    REFERENCES `positions` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_candidates_parties`
    FOREIGN KEY (`party_id`)
    REFERENCES `parties` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `blocks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `blocks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `election_id` INT UNSIGNED NOT NULL,
  `block` VARCHAR(255) NOT NULL,
  `description` TEXT NULL,
  PRIMARY KEY (`id`),
  INDEX (`election_id` ASC),
  CONSTRAINT `fk_blocks_elections`
    FOREIGN KEY (`election_id`)
    REFERENCES `elections` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `voters`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `voters` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `block_id` INT UNSIGNED NOT NULL,
  `username` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `pin` VARCHAR(255) NULL,
  `last_name` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX (`username` ASC),
  INDEX (`block_id` ASC),
  CONSTRAINT `fk_voters_blocks`
    FOREIGN KEY (`block_id`)
    REFERENCES `blocks` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `votes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `votes` (
  `candidate_id` INT UNSIGNED NOT NULL,
  `voter_id` INT UNSIGNED NOT NULL,
  `timestamp` DATETIME NOT NULL,
  PRIMARY KEY (`candidate_id`, `voter_id`),
  INDEX (`voter_id` ASC),
  INDEX (`candidate_id` ASC),
  CONSTRAINT `fk_votes_candidates`
    FOREIGN KEY (`candidate_id`)
    REFERENCES `candidates` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_votes_voters`
    FOREIGN KEY (`voter_id`)
    REFERENCES `voters` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `abstains`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `abstains` (
  `position_id` INT UNSIGNED NOT NULL,
  `voter_id` INT UNSIGNED NOT NULL,
  `timestamp` DATETIME NOT NULL,
  PRIMARY KEY (`position_id`, `voter_id`),
  INDEX (`voter_id` ASC),
  INDEX (`position_id` ASC),
  CONSTRAINT `fk_abstains_positions`
    FOREIGN KEY (`position_id`)
    REFERENCES `positions` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_abstains_voters`
    FOREIGN KEY (`voter_id`)
    REFERENCES `voters` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `voted`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `voted` (
  `event_id` INT UNSIGNED NOT NULL,
  `voter_id` INT UNSIGNED NOT NULL,
  `image_trail_hash` VARCHAR(255) NULL,
  `timestamp` DATETIME NOT NULL,
  PRIMARY KEY (`event_id`, `voter_id`),
  INDEX (`voter_id` ASC),
  INDEX (`event_id` ASC),
  CONSTRAINT `fk_voted_events`
    FOREIGN KEY (`event_id`)
    REFERENCES `events` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE,
  CONSTRAINT `fk_voted_voters`
    FOREIGN KEY (`voter_id`)
    REFERENCES `voters` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


-- -----------------------------------------------------
-- Table `ballots`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `ballots` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `block_id` INT UNSIGNED NOT NULL,
  `ballot` VARCHAR(255) NOT NULL,
  `format` TEXT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX (`block_id` ASC),
  CONSTRAINT `fk_ballots_blocks`
    FOREIGN KEY (`block_id`)
    REFERENCES `blocks` (`id`)
    ON DELETE RESTRICT
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

