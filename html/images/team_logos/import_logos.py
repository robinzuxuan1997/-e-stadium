#!/usr/bin/python
import urllib
import os

def chunk(line,open,close):
	start = line.find(open)
	end = line.find(close,start) #look for the end AFTER the start
	return line[start+len(open):end]

teampage = urllib.urlopen("http://espn.go.com/college-football/teams")

for line in teampage:
	if 'clubhouse' in line:
		teamId = chunk(line,'?teamId=','"')
		#Grab logo
		os.system('wget http://assets.espn.go.com/i/teamlogos/ncaa/sml/trans/'+teamId+'.gif')
		
teampage.close()