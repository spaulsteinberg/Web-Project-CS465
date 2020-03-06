SELECT p.description, o.numberOfStudents 
	FROM PerformanceLevels p, OutcomeResults o
	WHERE o.outcomeId = 2
		AND o.major = 'CS'
		AND o.sectionId = 3
		AND o.performanceLevel = p.performanceLevel;
