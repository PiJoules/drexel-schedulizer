import json, re
from pprint import pprint

with open('results.json') as data_file:    
    quarters = json.load(data_file)

comments = {}

for quarter in quarters:
	for college in quarter["colleges"]:
		for subject in college["subjects"]:
			for course in subject["courses"]:
				comment = re.sub(r"\s+"," ",course["details"]["sectionComments"])
				comments[comment] = True

print json.dumps(comments, indent=4)