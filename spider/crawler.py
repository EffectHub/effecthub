#!/usr/bin/env python
# -*- coding:utf-8 -*-

'''
Created on 2014-2-21

@author: zyx
'''
# author: zyx

from sgmllib import SGMLParser
import os
import urllib
import urllib2
import urlparse
from Queue import Queue
from threading import Thread

save_path = './zyxDowload'
passUrls = set()

qimg = Queue()
class URLLister(SGMLParser):
    def reset(self):
        SGMLParser.reset(self)
        self.urls = []
        self.imgs = []
    def start_a(self, attrs):
        href = [ v for k, v in attrs if k == "href" and v.startswith("http")]
        if href:
            self.urls.extend(href)
    def start_img(self, attrs):
        src = [ v for k, v in attrs if k == "src" and v.startswith("http") ]
        if src:
            self.imgs.extend(src)

def get_url_of_page(url, if_img=False):
    '''
    获取一个页面上的所有链接。
    if_img:如果为true，则获取的是页面上的所有图片的链接
    '''
    urls = []
    try:
        f = urllib2.urlopen(url, timeout=3).read()
        url_listen = URLLister()
        url_listen.feed(f)
        if if_img:
            urls.extend(url_listen.imgs)
        else:
            urls.extend(url_listen.urls)
    except urllib2.URLError, e:
        print e
    return urls

def get_page_html(begin_url, depth, main_site_domain):
    '''
    递归处理页面
    '''
    if depth <= 0:
        return
    print 'handle ' + begin_url
    passUrls.add(begin_url)
    #===========================================================================
    # 读取本页面上的图片
    #===========================================================================
    urls = get_url_of_page(begin_url, True)
    #===========================================================================
    # 添加图片到queue
    #===========================================================================
    for murl in urls:
        firstindex = murl.find('?')
        if firstindex != -1:
            print firstindex
            murl = murl[:firstindex]
        print 'add img url:' + murl
        qimg.put(murl)
    #===============================================================================
    # 读取本页面上的链接
    #===============================================================================
    urls = get_url_of_page(begin_url)
    if urls:
        for murl in urls:
            if not murl in passUrls:
                get_page_html(murl, depth - 1, main_site_domain)

class DPThread(Thread):
    '''
    下载线程
    '''
       
    def run(self):
        while True:
            murl = qimg.get()
            print 'one '+murl
            filename = murl.split("/")[-1]
            dist=os.path.join(save_path,filename) 
            connection = urllib2.build_opener().open(urllib2.Request(murl))  
            if int(connection.headers.dict['content-length']) < 512:  
                  continue  
            urllib.urlretrieve(murl,dist,None)
            qimg.task_done()

if __name__ == "__main__":
    #===========================================================================
    # 抓取图片首个页面
    #===========================================================================
    #url = "http://image.baidu.com"
    url='http://www.mayang.com/textures/'
    #===========================================================================
    # 图片保存路径
    #===========================================================================
    
    if not os.path.exists(save_path):
        os.mkdir(save_path)
    #===========================================================================
    # 遍历深度
    #===========================================================================
    max_depth = 3
    main_site_domain = urlparse.urlsplit(url).netloc
    get_page_html(url, max_depth, main_site_domain)
    
    for i in range(1):
        t = DPThread()
        t.setDaemon(True)
        t.start()
        qimg.join()
        print 'end'
