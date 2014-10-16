#!/usr/bin/env python
# Filename:DBCompiler.py

# Edited by chow  2013.09.06
# ChangeList:
# fix a bug which may cause the script can't find the config.xml

import logging
import re
import os
import sys
import getopt
import xml.etree.ElementTree as et
pathList={}

class Test:
        
        def main(self,argv):
                        
                try:
                        opts,args=getopt.getopt(argv[1:],"hl:f:d:")
                except getopt.GetoptError:
                        sys.exit()
                #print(os.path.split(argv[0])[0]);
                for opt,arg in opts:
                        if opt=='-h':
                                self.usage()
                                sys.exit()
                        elif opt=='-l':
                                pathList['configFilePath']=arg
                        elif opt=='-f':
                                pathList['filePath']=arg
                        elif opt=='-d':
                                pathList['dirPath']=arg
                        else:
                                assert False,"unhandled option"
                                
                print 'aaaaaaaaaaaaaaaaaaaaaaa'
                                
        #end of main        

if __name__=='__main__':
        Test().main(sys.argv)
