SELECT a.sectionId, i.email, a.outcomeId, a.major, SUM(a.weight) AS `weightTotal`
	FROM Sections s, Instructors i, Assessments a
	WHERE s.sectionId = a.sectionId AND s.instructorId=i.instructorId
	GROUP BY a.outcomeId, a.sectionId
	HAVING SUM(a.weight) != 100
	ORDER BY i.email ASC, a.major ASC, a.outcomeId ASC;
