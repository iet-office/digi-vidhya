SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: `db_eval`

-- Table: `atmpt_list`
CREATE TABLE IF NOT EXISTS `atmpt_list` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `exid` INT NOT NULL,
  `uname` VARCHAR(100) NOT NULL,
  `nq` INT NOT NULL,
  `cnq` INT NOT NULL,
  `ptg` INT NOT NULL,
  `status` INT NOT NULL,
  `certificate_id` VARCHAR(50), -- Added column for certificate ID
  `subtime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Table: `exm_list`
CREATE TABLE IF NOT EXISTS `exm_list` (
  `exid` INT NOT NULL AUTO_INCREMENT,
  `exname` VARCHAR(100) NOT NULL,
  `nq` INT NOT NULL,
  `desp` VARCHAR(100) NOT NULL,
  `subt` DATETIME NOT NULL,
  `extime` DATETIME NOT NULL,
  `duration` INT NOT NULL,
  `datetime` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subject` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`exid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Table: `message`
CREATE TABLE IF NOT EXISTS `message` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `fname` VARCHAR(100) NOT NULL,
  `date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `feedback` VARCHAR(10000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `message`
INSERT IGNORE INTO `message` (`id`, `fname`, `date`, `feedback`) VALUES
(5, 'Teacher Rosey', '2021-12-12 13:01:00', 'Please kindly complete all the homework and submit tomorrow'),
(6, 'Teacher Rosey', '2021-12-13 06:23:18', 'Hello this is an announcement');

-- Table: `qstn_list`
CREATE TABLE IF NOT EXISTS `qstn_list` (
  `exid` INT NOT NULL,
  `qid` INT NOT NULL AUTO_INCREMENT,
  `qstn` VARCHAR(200) NOT NULL,
  `qstn_o1` VARCHAR(100) NOT NULL,
  `qstn_o2` VARCHAR(100) NOT NULL,
  `qstn_o3` VARCHAR(100) NOT NULL,
  `qstn_o4` VARCHAR(100) NOT NULL,
  `qstn_ans` VARCHAR(100) NOT NULL,
  `sno` INT NOT NULL,
  PRIMARY KEY (`qid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: `student`
CREATE TABLE IF NOT EXISTS `student` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uname` VARCHAR(100) NOT NULL,
  `pword` VARCHAR(255) NOT NULL,
  `fname` CHAR(100) NOT NULL,
  `dob` DATE NOT NULL,
  `gender` CHAR(10) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: `user progress`


CREATE TABLE IF NOT EXISTS `user_progress` (     
  `id` INT NOT NULL AUTO_INCREMENT,     
  `uname` VARCHAR(20) NOT NULL,         
  `course_name` VARCHAR(30) NOT NULL,   
  `topics_done` TEXT,                   
  `topics_done_count` INT DEFAULT 0,    
  `topics_total_count` INT DEFAULT 0,    
  `percentage_course` DECIMAL(5, 2) DEFAULT 0.00,
  PRIMARY KEY (`id`), 
  UNIQUE KEY `unique_key` (`uname`, `course_name`) 
);

-- Insert data into `student`
INSERT IGNORE INTO `student` (`id`, `uname`, `pword`, `fname`, `dob`, `gender`, `email`) VALUES
(10, 'anniefrank', '1f9a884da469fdf263c098fc46891c04', 'Annie Frank', '1889-02-12', 'F', 'anniefrn@yahoo.com'),
(11, 'abraham', '1f9a884da469fdf263c098fc46891c04', 'Abraham Lincoln', '1998-02-12', 'M', 'abraham@usa.com'),
(12, 'mariealx', 'f6fdffe48c908deb0f4c3bd36c032e72', 'Marie Alex', '1790-12-12', 'F', 'mariealex@aol.com');

-- Table: `teacher`
CREATE TABLE IF NOT EXISTS `teacher` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `uname` VARCHAR(100) NOT NULL,
  `pword` VARCHAR(255) NOT NULL,
  `fname` CHAR(100) NOT NULL,
  `dob` DATE NOT NULL,
  `gender` CHAR(10) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `subject` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into `teacher`
INSERT IGNORE INTO `teacher` (`id`, `uname`, `pword`, `fname`, `dob`, `gender`, `email`, `subject`) VALUES
(1, 'teacher', '8d788385431273d11e8b43bb78f3aa41', 'Jack Rosso', '2021-12-01', 'M', 'teacher@teach.com', 'CHEMISTRY');



COMMIT;
