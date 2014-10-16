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

class Compiler:
        
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
                                
                if 'configFilePath' in pathList:
                        self.loadTheConfig(pathList['configFilePath'])
                else:
                #use the default path to find the config.xml
                        self.loadTheConfig(os.path.join(os.path.split(argv[0])[0],"config.xml"))
                #print(pathList)
                self.prepareToCompile(pathList)               
        #end of main        

        
        def loadTheConfig(self,configFile='config.xml'):
            
                root=et.parse(configFile).getroot()

                for child in root:
                        if child.tag in pathList:
                                pass
                        else:
                                pathList[child.tag]=child.text
                        
        def prepareToCompile(self,pathList):
                if 'filePath' in pathList:
                        if os.path.isfile(pathList['filePath']):
                                dirPath,filename=os.path.split(pathList['filePath'])
                                pathList['dirPath']=dirPath
                                logging.basicConfig(filename = os.path.join(pathList['dirPath'], 'log.txt'), level = logging.DEBUG,filemode = 'w', format = '%(asctime)s - %(levelname)s: %(message)s')
                                self.beforCompile(filename,pathList)
                        else:
                                self.logTofile("Not supported file,only .as file is supported")
                elif 'dirPath' in pathList:
                        if os.path.isdir(pathList['dirPath']):
                                logging.basicConfig(filename = os.path.join(pathList['dirPath'], 'log.txt'), level = logging.DEBUG,filemode = 'w', format = '%(asctime)s - %(levelname)s: %(message)s')
                                files=os.listdir(pathList['dirPath'])
                                for f in files:
                                        self.beforCompile(f,pathList)
                else:
                        self.logTofile("Error in file(Dir) path")
                                        
        #end of prepareToCompile                    
        def beforCompile(self,f,pathList):
                file=os.path.join(pathList['dirPath'],f)
                if (f.split('.')[-1]=='as'):
                        self.compileFile(file,pathList)
                else:
                        self.logTofile("Not supported file,only .as file is supported")
                        
	
        def compileFile(self,f,pathList):
		
                command = os.path.join(pathList["flexSDKPath"],"mxmlc ")+f
                #print command
                #print_command="mxmlc "+os.path.basename(f)
                if ("libraryPath" in pathList):
                        command =command + " -library-path+="+pathList["libraryPath"]
                        #print_command=print_command+" -library-path+="
                        #for libpath in pathList["libraryPath"].split(";"):
                            #print_command=print_command+os.path.basename(libpath)+";"
                        
                command =command + " -static-link-runtime-shared-libraries=" +pathList["staticLinkRuntimeSharedLibraries"]
                #print_command=print_command+" -static-link-runtime-shared-libraries=" +pathList["staticLinkRuntimeSharedLibraries"]
                
                #self.logTofile("Compile command:"+print_command)
                command =command +">/dev/null 2>"+os.path.join(pathList['dirPath'],"errlog.log")
                #result=commands.getstatus(command)
                result= os.popen(command).read()
                for line in result.split('\n'):
                        if line.split():
                                self.logTofile(line)
                                
                if ("outputPath" in pathList ):
                        if not os.path.exists(pathList["outputPath"]):
                                os.mkdir(pathList["outputPath"])
                        if 'nt'==os.name:
                                result=os.popen("move /y " +f.split('.')[0]+".swf "+ pathList["outputPath"]).read()
                        else:
                                result=os.popen("mv -f "+f.split('.')[0]+".swf "+ pathList["outputPath"]).read()
                        for line in result.split('\n'):
                                if line.split():
                                        self.logTofile(line,True)
                self.logTofile("Finish {} compilation".format(f))
	#end of compileFile
		
        def logTofile(self,msg='\n',toFile=True):
                if msg=='\n':
                        return
                if (toFile):
                        m=re.search('error',msg,re.IGNORECASE)
                        if bool(m):
                                logging.error(msg)
                        else:
                                logging.info(msg)
                #text=re.sub(r'C:\\',' ',msg)                
                print(msg)
	#End of logTofile
        def usage(self):
                print("""DBAutoCompiler [-h|-l|-f|-d]
        Options and arguments:
        -h : Help
        -l : Load the config file
        -f : The file which is need to compile
        -d : The direction of files to compile
        """)
        #End of usage
                
if __name__=='__main__':
        Compiler().main(sys.argv)
