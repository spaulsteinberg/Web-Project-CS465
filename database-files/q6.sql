SELECT s.sectionId, i.email, a.outcomeId, a.major, SUM(a.weight) AS `weightTotal`
	FROM Sections s, Instructors i, Assessments a, OutcomeResults o
	WHERE o.outcomeId = a.outcomeId /*first two statements match the outcomes and majors */
		AND o.major = a.major
		AND o.sectionId = a.sectionId /*these two lines key to section id's*/
		AND s.sectionId = o.sectionId
		AND s.instructorId = i.instructorId /* key into instructors */
	HAVING SUM(a.weight) != 100
	ORDER BY i.email ASC, a.major ASC, a.outcomeId ASC;
