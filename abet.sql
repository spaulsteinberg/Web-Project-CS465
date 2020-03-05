create table Instructors(
	instructorId int(5) NOT NULL PRIMARY KEY,
	firstname varchar(50),
	lastname varchar(50),
	email varchar(50) DEFAULT NULL,
	password varchar(60) DEFAULT NULL);

create table Courses(
	courseId varchar(8) NOT NULL PRIMARY KEY,
	courseTitle varchar(50));

create table PerformanceLevels(
	performanceLevel int(2) NOT NULL PRIMARY KEY,
	description ENUM("Not Meets Expectations", "Meets Expectations", "Exceeds Expectations"));

create table Outcomes(
	outcomeId int(3),
	outcomeDescription varchar(200),
	major ENUM("CS", "EE", "CpE")
	PRIMARY KEY (outcomeId, major));

create table Sections(
	sectionId int(3) NOT NULL PRIMARY KEY,
	courseId int(3),
	instructorId int(5),
	semester varchar(8),
	year int(4),
	FOREIGN KEY (courseId) REFERENCES Courses (courseId));


create table OutcomeResults(
	sectionId int(3),
	outcomeId int(3),
	major ENUM("CS", "EE", "CpE"),
	performanceLevel int(2),
	numberOfStudents int(3),
	FOREIGN KEY (sectionId) REFERENCES Sections (sectionId),
	FOREIGN KEY (outcomeId) REFERENCES Outcomes (outcomeId),
	FOREIGN KEY (performanceLevel) REFERENCES PerformanceLevels (performanceLevel));

create table Assessments(
	sectionId int(3),
	assessmentDescription varchar(100),
	weight decimal(3,2),
	outcomeId int(3),
	major ENUM("CS", "EE", "CpE"),
	FOREIGN KEY (sectionId) REFERENCES Sections (sectionId),
	FOREIGN KEY (outcomeId) REFERENCES Outcomes (outcomeId));

create table Narratives(
	sectionId int(3),
	major ENUM("CS", "EE", "CpE"),
	outcomeId int(3),
	strengths varchar(200),
	weaknesses varchar(200),
	actions varchar(50),
	FOREIGN KEY (sectionId) REFERENCES Sections (sectionId),
	FOREIGN KEY (outcomeId) REFERENCES Outcomes (outcomeId));

create table CourseOutcomeMapping(
	courseId varchar(8),
	outcomeId int(3),
	major ENUM("CS", "EE", "CpE"),
	semester varchar(8),
	year int(4),
	FOREIGN KEY (courseId) REFERENCES Courses (courseId),
	FOREIGN KEY (outcomeId) REFERENCES Outcomes (outcomeId));