
-- Dumping data for table `Instructors`
--

INSERT INTO `Instructors` (`instructorId`, `firstname`, `lastname`, `email`, `password`) VALUES
(12, 'Brad', 'Vander Zanden', 'bvanderz@utk.edu', '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19'),
(13, 'Wily', 'Coyote', 'coyote@utk.edu', '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19'),
(14, 'Michael', 'Berry', 'mberry@utk.edu', '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19'),
(15, 'Mia', 'Test User', 'testuser@utk.edu', '*2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19');

-- --------------------------------------------------------

--
-- Dumping data for table `Courses`
--

INSERT INTO `Courses` (`courseId`, `courseTitle`) VALUES
('COSC365', 'Survey of Programming Languages and Systems'),
('COSC402', 'Senior Design II'),
('ECE336', 'Electronic Circuits'),
('ECE351', 'Computer Architecture');

-- --------------------------------------------------------

--
-- Dumping data for table `Outcomes`
--

INSERT INTO `Outcomes` (`outcomeId`, `outcomeDescription`, `major`) VALUES
(1, 'an ability to identify, formulate, and solve complex engineering problems by applying principles of engineering, science, and mathematics.', 'CpE'),
(1, 'Analyze a complex computing problem and to apply principles of computing and other relevant disciplines to identify solutions.', 'CS'),
(1, 'an ability to identify, formulate, and solve complex engineering problems by applying principles of engineering, science, and mathematics.', 'EE'),
(2, 'an ability to apply engineering design to produce solutions that meet specified needs with consideration of public health, safety, and welfare, as well as global, cultural, social, environmental, and economic factors.', 'CpE'),
(2, 'Design, implement, and evaluate a computing-based solution to meet a given set of computing requirements in the context of the program’s discipline.', 'CS'),
(2, 'an ability to apply engineering design to produce solutions that meet specified needs with consideration of public health, safety, and welfare, as well as global, cultural, social, environmental, and economic factors.', 'EE'),
(3, 'Function effectively as a member or leader of a team engaged in activities appropriate to the program’s discipline.', 'CS'),
(3, 'an ability to communicate effectively with a range of audiences.', 'CpE'),
(4, 'an ability to recognize ethical and professional responsibilities in engineering situations and make informed judgments, which must consider the impact of engineering solutions in global, economic, environmental, and societal contexts.', 'CpE');

-- --------------------------------------------------------
--
-- Dumping data for table `Sections`
--

INSERT INTO `Sections` (`sectionId`, `instructorId`, `courseId`, `semester`, `year`) VALUES
(1, 13, 'COSC402', 'spring', 2019),
(2, 13, 'COSC402', 'fall', 2019),
(3, 12, 'COSC365', 'spring', 2019),
(4, 14, 'COSC402', 'spring', 2019),
(5, 15, 'COSC402', 'spring', 2019),
(6, 12, 'ECE351', 'spring', 2019),
(7, 13, 'ECE336', 'spring', 2019),
(8, 12, 'COSC365', 'fall', 2019),
(9, 12, 'COSC402', 'spring', 2020);

-- --------------------------------------------------------

--
-- Dumping data for table `PerformanceLevels`
--

INSERT INTO `PerformanceLevels` (`performanceLevel`, `description`) VALUES
(1, 'Not Meets Expectations'),
(2, 'Meets Expectations'),
(3, 'Exceeds Expectations');

-- --------------------------------------------------------
--
-- Dumping data for table `AssessmentPlans`
--
--

INSERT INTO `Assessments` (`sectionId`, `assessmentDescription`, `weight`, `outcomeId`, `major`) VALUES
(2, 'Homeworks 1, 3 and 10', '20', 1, 'CS'),
(2, 'Midterm questions on functional languages.', '80', 1, 'CS'),
(3, '\'Evil \"use\" of quotes to mess up \'foo\" with <em>the italics</em>\"brad \'vander zanden\'\"', '15', 2, 'CS'),
(3, '<b>Don\'t allow</b> mis-placed \' quotes to \" mess you up', 10, 2, 'CS'),
(3, 'Labs 1 and 6', 60, 2, 'CS'),
(3, 'Project', 15, 2, 'CS'),
(4, 'Finals', 30, 1, 'CS'),
(4, 'Midterm 1 question', 10, 1, 'CS'),
(5, 'Homework assignments 1 - 6', 10, 1, 'CS'),
(5, 'Midterm 1', 30, 1, 'CS'),
(6, 'Final design document', 70, 2, 'CpE'),
(6, 'Initial design document', 30, 2, 'CpE'),
(6, 'Project Description', 50, 1, 'CpE'),
(6, 'Project Implementation', 50, 1, 'CpE'),
(7, 'Design of a circuit', 100, 2, 'EE'),
(7, 'midterm1', 20, 1, 'EE'),
(7, 'midterm3', 20, 1, 'EE'),
(7, 'midterm4', 30, 1, 'EE');

-- --------------------------------------------------------

--
-- Dumping data for table `CourseOutcomeMapping`
--

INSERT INTO `CourseOutcomeMapping` (`courseId`, `outcomeId`, `major`, `semester`, `year`) VALUES
('COSC402', 1, 'CS', 'spring', 2019),
('COSC402', 2, 'CS', 'spring', 2019),
('COSC365', 1, 'CS', 'spring', 2019),
('COSC365', 2, 'CS', 'spring', 2019),
('COSC365', 2, 'CpE', 'spring', 2019),
('COSC365', 3, 'CpE', 'spring', 2019),
('COSC365', 4, 'CpE', 'spring', 2019),
('COSC402', 3, 'CS', 'spring', 2019),
('ECE351', 1, 'CpE', 'spring', 2019),
('ECE351', 2, 'CpE', 'spring', 2019),
('ECE336', 1, 'EE', 'spring', 2019),
('ECE336', 2, 'EE', 'spring', 2019),
('COSC365', 3, 'CS', 'fall', 2019),
('COSC365', 1, 'CS', 'fall', 2019),
('COSC402', 1, 'CS', 'spring', 2020);

-- --------------------------------------------------------


--
-- Dumping data for table `Narratives`
--

INSERT INTO `Narratives` (`sectionId`, `major`, `outcomeId`, `strengths`, `weaknesses`, `actions`) VALUES
(3, 'CS', 2, 'Students love hands-on so there were quick to learn graphical methods (Smith Chart), with some help learned MATLAB use for transmission lines.  Students were eager to learn how to validate their answers, like MATLAB vs Smith Chart, use direct methods vs using auxiliary functions to calculate fields and get the same answers.\nMost of the students were able to find their errors and correct it and leave their answers in a pristine state that was a joy for the instructors and the TAs to read. The students also had exquisitely beautiful handwriting that made their equations stand out in a sea of writing.', 'A bit weak on functional languages.', 'Convert the course to functional languages.'),
(4, 'CS', 1, 'Students knocked it out of the ballpark', '', ''),
(5, 'CS', 1, 'Writing', 'Reading', 'Arithmetic'),
(5, 'CS', 2, 'Happy', 'Unhappy', 'Delighted'),
(6, 'CpE', 1, 'The project ideas were amazing.', 'The projects did not work.', 'Spend time with students to ensure that projects work.'),
(6, 'CpE', 2, 'Designs were creative and imaginative.', 'Designs were too expensive to implement.', 'Help students balance creative designs against cost.'),
(7, 'EE', 1, 'Amazing problem-solving skills for analog circuits', '\"some\" problems doing \"digital\" circuit work', 'Use \"Acme\'s\" breadboard for \"testing of digital\" circuits\'.'),
(7, 'EE', 2, 'brad\'s amazing intellect and thoughtful demeanor', '\"can\'t think of any with brad at the helm\"', 'Whoop\'s I \"need action\'s as well\"');

-- --------------------------------------------------------

--
-- Dumping data for table `OutcomeReports`
--

INSERT INTO `OutcomeResults` (`sectionId`, `outcomeId`, `major`, `performanceLevel`, `numberOfStudents`) VALUES
(1, 1, 'CS', 1, 10),
(1, 1, 'CS', 2, 30),
(1, 1, 'CS', 3, 40),
(1, 2, 'CS', 1, 40),
(1, 2, 'CS', 2, 30),
(1, 2, 'CS', 3, 10),
(1, 3, 'CS', 1, 16),
(1, 3, 'CS', 2, 54),
(1, 3, 'CS', 3, 10),
(2, 1, 'CS', 1, 10),
(2, 1, 'CS', 2, 20),
(2, 1, 'CS', 3, 30),
(2, 2, 'CS', 1, 20),
(2, 2, 'CS', 2, 30),
(2, 2, 'CS', 3, 20),
(3, 2, 'CS', 1, 80),
(3, 2, 'CS', 2, 30),
(3, 2, 'CS', 3, 60),
(4, 1, 'CS', 1, 20),
(4, 1, 'CS', 2, 50),
(4, 1, 'CS', 3, 70),
(4, 2, 'CS', 1, 30),
(4, 2, 'CS', 2, 60),
(4, 2, 'CS', 3, 50),
(4, 3, 'CS', 1, 10),
(4, 3, 'CS', 2, 80),
(4, 3, 'CS', 3, 50),
(5, 1, 'CS', 1, 20),
(5, 1, 'CS', 2, 40),
(5, 1, 'CS', 3, 30),
(5, 2, 'CS', 1, 30),
(5, 2, 'CS', 2, 40),
(5, 2, 'CS', 3, 30),
(5, 3, 'CS', 1, 10),
(5, 3, 'CS', 2, 20),
(5, 3, 'CS', 3, 30),
(6, 1, 'CpE', 1, 2),
(6, 1, 'CpE', 2, 10),
(6, 1, 'CpE', 3, 60),
(6, 2, 'CpE', 1, 35),
(6, 2, 'CpE', 2, 55),
(6, 2, 'CpE', 3, 10),
(7, 1, 'EE', 1, 40),
(7, 1, 'EE', 2, 50),
(7, 1, 'EE', 3, 60),
(7, 2, 'EE', 1, 10),
(7, 2, 'EE', 2, 80),
(7, 2, 'EE', 3, 60),
(9, 1, 'CS', 1, 10),
(9, 1, 'CS', 2, 40),
(9, 1, 'CS', 3, 80);

-- --------------------------------------------------------



-- --------------------------------------------------------


