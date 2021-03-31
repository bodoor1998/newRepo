
CREATE TABLE `quiz` (
  `quiz_id` INT(11) NOT NULL,
  `quiz_title` VARCHAR(50),
  `lesson_id` INT(11) NOT NULL,
  PRIMARY KEY(`quiz_id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

INSERT INTO `quiz` (`quiz_id`, `quiz_title`,`lesson_id`) VALUES
(1,'Print Function',1),
(2,'Error Types',2);



CREATE TABLE `quiz_question` (
  `question_id` INT(11) NOT NULL,
  `question_description` VARCHAR(200),
  `quiz_id` INT(11) NOT NULL,
  PRIMARY KEY(`question_id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

INSERT INTO `quiz_question` (`question_id`, `question_description`,`quiz_id`) VALUES
(1,'Which of the following is a correct print sentence?',1),
(2,'What is wrong with this statement: Print("Welcome to Python")?',1),
(3,'What type of error in; print(python)?',2),
(4,'What type of error in; print(1/0)?',2);



CREATE TABLE `question_option` (
  `question_id` INT(11) NOT NULL,
  `op1` varchar(100) DEFAULT NULL,
  `op2` varchar(100) DEFAULT NULL,
  `op3` varchar(100) DEFAULT NULL,
  `true_op` int(1) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

INSERT INTO `question_option` (`question_id`,`op1`,`op2`,`op3`,`true_op`) VALUES
(1,'Print("Hello")','print("Hello")','print("Hello").',2),
(2,'It is a correct statement','The mistake is punctuation','The mistake is not observing the case sensitive',3),
(3,'Runtime Error','Logic Error','Syntax Error',3),
(4,'Runtime Error','Logic Error','Syntax Error',1);