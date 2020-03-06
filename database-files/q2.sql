SELECT o.outcomeId, o.outcomeDescription 
	FROM Outcomes o, OutcomeResults r
	WHERE (o.major = r.major AND o.outcomeId = r.outcomeId)
		  AND r.sectionId = 3
		  AND o.major = 'CS'
		  ORDER BY o.outcomeId;
