import re
import StringIO
import urllib,urllib2,cookielib
import json
import os
import MySQLdb
import datetime
import sys
import logging


logging.basicConfig(filename='spiderlog.log',level=logging.DEBUG)
# cj = cookielib.LWPCookieJar()
# cookie_support = urllib2.HTTPCookieProcessor(cj)
# opener = urllib2.build_opener(cookie_support, urllib2.HTTPHandler)
# urllib2.install_opener(opener)
PrintDebugInformation =True
uiURL = 'http://huaban.com/boards/2553805/'
uiURL2 = 'http://huaban.com/boards/13943851/'
picUrl='http://www.effecthub.com/uploads/item/'
author_id=123456
downloadPath = 'uploads\\item\\'
dburl='localhost'
dbuser='root'
dbpasswd='123456'
dbname='game'

if os.path.isdir(downloadPath): 
	pass 
else: 
	os.makedirs(downloadPath) 

def request_ajax_data(url,data,referer=None,**headers):
    req = urllib2.Request(url)
    req.add_header('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
    req.add_header('X-Requested-With','XMLHttpRequest')
    req.add_header('User-Agent','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116')
    if referer:
        req.add_header('Referer',referer)
    if headers:
        for k in headers.keys():
            req.add_header(k,headers[k])

    params = urllib.urlencode(data)
    response = urllib2.urlopen(req, params)
    jsonText = response.read()
    return jsonText
    # return json.loads(jsonText)
def request_html_data(url,data=None,referer=None,**headers):
	req = urllib2.Request(url)
	req.add_header('Content-Type', 'application/x-www-form-urlencoded; charset=UTF-8')
	req.add_header('User-Agent','Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.116')
	if referer:
		req.add_header('Referer',referer)
	if headers:
		for k in headers.keys():
			req.add_header(k,headers[k])
	params = None
	if data:
		params = urllib.urlencode(data)
	response = urllib2.urlopen(req, params)
	htmlText = response.read()
	return htmlText

def getBoard(url):
	httpResponse = request_html_data(url)
	startStr = 'app.page["board"] = '
	endStr = 'app._csr = true'
	startIdx = httpResponse.index(startStr)+len(startStr)
	httpResponse = httpResponse[startIdx:]
	endIdx = httpResponse.index(endStr)
	httpResponse = httpResponse[:endIdx-2]
#	print type(httpResponse)
#	dataDict = json.dumps(httpResponse, ensure_ascii=False); 
#	print dataDict
	return json.loads(httpResponse)

def getPin(id):

	httpResponse = request_html_data('http://huaban.com/pins/'+str(id))
	startStr = 'app["page"] = '
	endStr = 'app["timestamp"]'
	startIdx = httpResponse.index(startStr)+len(startStr)
	httpResponse = httpResponse[startIdx:]
	endIdx = httpResponse.index(endStr)
	httpResponse = httpResponse[:endIdx-2]
	page = json.dumps(httpResponse,ensure_ascii=False)
	return page['pin']

def downloadPic(key):
	url = 'http://img.hb.aicdn.com/'+key

	data = urllib.urlopen(url).read()
	f = file(downloadPath+key+'.png','wb')
	f.write(data)
	f.close()

def insert(title,desc,littlePic,pic,key):
	dbID=getInsertId(title,desc)
	logToFile('InsertId:'+str(dbID),PrintDebugInformation)
	changeFileName(key,dbID)
	logToFile('changeFileName to '+str(dbID),PrintDebugInformation)
	updateDatabase(dbID,littlePic,pic)
	logToFile('updateDatabase:'+str(dbID),PrintDebugInformation)
	
def getInsertId(title,desc):
	cursor=db.cursor()
	inserStr="""insert into game_item(title,`desc`,author_id,create_date,update_date,last_comment_date) Values(%s,%s,%s,%s,%s,%s);"""
	current_time=datetime.datetime.now()
	timeStr=current_time.strftime('%Y-%m-%d %H:%M:%S')
	cursor.execute(inserStr,(title,desc,author_id,timeStr,timeStr,timeStr))
	db.commit()
	dbId=cursor.lastrowid
	cursor.close()
	return dbId

def changeFileName(key,dbID):
	os.rename(downloadPath+key+'.png',downloadPath+str(dbID)+'.png')

def updateDatabase(dbID,littlePic,pic):
	cursor=db.cursor()
	updateStr="""update game_item set pic_url=%s,thumb_url=%s where id=%s;"""
	cursor.execute(updateStr,(picUrl+str(dbID)+'.png',picUrl+str(dbID)+'.png',dbID))
	db.commit()
	cursor.close()
def logToFile(msg,tofile):
	print msg
	if tofile==True:
		logging.debug(msg)
		
logToFile("Spider Start",PrintDebugInformation)	
db = MySQLdb.connect(dburl,dbuser,dbpasswd,dbname,charset="utf8")
logToFile("Db connected",PrintDebugInformation)
board = getBoard(uiURL)
logToFile("getBoard",PrintDebugInformation)
pins = board['pins']
#print pins
for pin in pins:
	logToFile(pin,PrintDebugInformation)
	pinid = pin['pin_id']
	print "getImagePinId:"+str(pinid)
	littlePic = pin['file']['key']
	#print littlePic
	# detail = getPin(pinid)
	key = pin['file']['key']
	tp = pin['file']['type']
	desc = pin['raw_text'].replace("\n"," ")
	if(desc==""):
		desc = 'Game UI'
	tag = board['title'].replace("\n"," ")
	link=pin['link']
	if(tag==""):
		tag='Game Title'
	try:
#		print pinid
#		print tp
#		print desc
#		print tag
		downloadPic(key)
		insert(tag,desc+' '+link,key,key,key)
	except Exception, e: 
		logToFile(repr(e))
logToFile("Seach finished",PrintDebugInformation)		





