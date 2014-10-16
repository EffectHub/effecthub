<?php
class Result extends CI_Controller
{
    
	function listDir($dirPath)
	{		
		if (is_dir($dirPath))
		{
			$dir=dir($dirPath);
			while ($file=$dir->read())
			{
				if ((!is_dir("$dirPath/$file")) AND ($file!=".") AND ($file!=".."))
				{
					if ($this->get_extension($file)=='as')
						return $file;
				}
			}
		}
	}
	
	function get_extension($file) 
	{ 
		return pathinfo($file, PATHINFO_EXTENSION); 
	}

	function get_basename($file)
	{
		return pathinfo($file);
	}
	
	public function __construct(){
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('compile_model');
        
		if($this->session->userdata('language')) {
			$lang = $this->session->userdata('language');
		} else {
			$language = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 4);
			if (preg_match("/zh-c/i", $language)||$language=='cn'){
				$lang = 2;
			} else {
				$lang = 1;
			}
			
		}
        if ($lang==2)
        {
        	$this->lang->load('header','chinese');
        	$this->lang->load('footer','chinese');
        }else{
        	$this->lang->load('header','english');
        	$this->lang->load('footer','english');
        }
        
    }
	
	public function index($id=-1)
	{
		$data =array();
        
        if ($id==-1)
        {
            $id=$this->compile_model->create();
            $data['src']['id']=$id;
            $data['src']['code']='';
        }
        else
            $data['src']=$this->compile_model->load($id);
            
		//$foldPath="./result/$id/src";
		///$compileFile=$this->listDir($foldPath);
		//$data['src']['fullfilename']=$compileFile;
		//$data['src']['filename']=$this->get_basename($compileFile);
		//echo $data['filename'];
		$this->load->view('editor',$data);
	}
	
	public function compile(){
		
		 //echo $src['fullfilename'].'\n';
		 //echo $src['filename'].'\n';
		 $pid=$_POST['pid'];
		 //$pname=$_POST['pname'];
		 $pcode=$_POST['pcode'];
          $data =array(
            'id'=>$pid,
            'code'=>$pcode
          );
          //$this->compile_model->update($data);
         
          
         preg_match("/public class \w+/i",$pcode,$matches);
         $keywords = preg_split("/[\s,]+/", $matches[0]);
         
         $className=$keywords[2];
         $this->load->helper('my_form');
         $dir = CompilePath($pid);
         
        // if (!file_exists('.\\result\\'.$pid.'\\src\\'))
        //    @mkdir ( '.\\result\\'.$pid.'\\src\\', 0777 ,true);
         
        // $filepath='.\\result\\'.$pid.'\\'.$className.'.as';
         
        // $file=fopen($filepath,"w");
         
       //  fwrite($file,$pcode);
         
       //  fclose($file);
       $file_name=$dir.'/'.$className.'.as';
       	 //@file_put_contents($file_name, $pcode);
       	 $file=fopen($file_name,"w");
         
         fwrite($file,$pcode);
         
         fclose($file);
         $root_dir = $_SERVER['DOCUMENT_ROOT'];
         //$root_dir = str_replace('/', '\\', $root_dir);
         $script_dir = $_SERVER['DOCUMENT_ROOT'] . '/scripts/DBCompiler.py';
		//$script_dir = str_replace('/', '\\', $script_dir);
		 $comm='python ' . $script_dir . '  -f '.$root_dir . '\\result\\'.$pid.'\\'.$className.'.as > '.$root_dir . '\\result\\'.$pid.'\\'.$className.'.log';
		 $comm = str_replace('\\', '/', $comm);
		// $comm = 'python '. $script_dir;
		 //echo $comm;
         
		 $pyresult = exec($comm);
		 //echo $pyresult;
         //$command='mxmlc '
         $compileResult = '';
         if (file_exists('./result/'.$pid.'/errlog.log'))
         {
            $compileResult =file_get_contents('./result/'.$pid.'/errlog.log');
            $compileResult =basename($compileResult);
         }           
         if ($compileResult!='')
         {
            $data['statue']=False;
            $data['content']=$compileResult;
         }
         else
         {
            $data['statue']=True;
            $data['key']=$pid;
            $data['content']=base_url("result/".$pid."/".$className.".swf");
            $data['source']=base_url("result/".$pid."/".$className.".as");
         }
		 echo json_encode($data);			
	}
}