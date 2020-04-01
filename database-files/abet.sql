create table Instructors(
	instructorId int(5) PRIMARY KEY,
	firstname varchar(50),
	lastname varchar(50),
	email varchar(50),
	password varchar(60));

create table Courses(
	courseId varchar(8) PRIMARY KEY,
	courseTitle varchar(50));

create table PerformanceLevels(
	performanceLevel int(1) PRIMARY KEY,
	description ENUM("Not Meets Expectations", "Meets Expectations", "Exceeds Expectations"));

create table Outcomes(
	outcomeId int(3),
	outcomeDescription varchar(200),
	major ENUM("CS", "EE", "CpE"),
	PRIMARY KEY (outcomeId, major));

create table Sections(
	sectionId int(3) PRIMARY KEY,
	courseId varchar(8),
	instructorId int(5),
	semester varchar(8),
	year int(4),
	FOREIGN KEY (courseId) REFERENCES Courses (courseId),
	FOREIGN KEY (instructorId) REFERENCES Instructors (instructorId));


create table OutcomeResults(
	sectionId int(3),
	outcomeId int(3),
	major ENUM("CS", "EE", "CpE"),
	performanceLevel int(1),
	numberOfStudents int(3),
	PRIMARY KEY (sectionId, outcomeId, major, performanceLevel),
	FOREIGN KEY (sectionId) REFERENCES Sections (sectionId),
	FOREIGN KEY (outcomeId, major) REFERENCES Outcomes (outcomeId, major),
	FOREIGN KEY (performanceLevel) REFERENCES PerformanceLevels (performanceLevel));

create table Assessments(
	assessmentId int NOT NULL PRIMARY KEY AUTO_INCREMENT,
	sectionId int(3),
	assessmentDescription varchar(100),
	weight int(3),
	outcomeId int(3),
	major ENUM("CS", "EE", "CpE"),
	FOREIGN KEY (sectionId) REFERENCES Sections (sectionId),
	FOREIGN KEY (outcomeId, major) REFERENCES Outcomes (outcomeId, major));

create table Narratives(
	sectionId int(3),
	major ENUM("CS", "EE", "CpE"),
	outcomeId int(3),
	strengths varchar(200),
	weaknesses varchar(200),
	actions varchar(50),
	PRIMARY KEY (sectionId, major, outcomeId),
	FOREIGN KEY (sectionId) REFERENCES Sections (sectionId),
	FOREIGN KEY (outcomeId, major) REFERENCES Outcomes (outcomeId, major));

create table CourseOutcomeMapping(
	courseId varchar(8),
	outcomeId int(3),
	major ENUM("CS", "EE", "CpE"),
	semester varchar(8),
	year int(4),
	FOREIGN KEY (courseId) REFERENCES Courses (courseId),
	FOREIGN KEY (outcomeId, major) REFERENCES Outcomes (outcomeId, major));
