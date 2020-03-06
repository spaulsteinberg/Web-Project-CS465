SELECT assessmentDescription, weight FROM Assessments
	WHERE outcomeId = 2
		AND sectionId = 3
		AND major = 'CS'
		ORDER BY weight DESC, assessmentDescription ASC;
