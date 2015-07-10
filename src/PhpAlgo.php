<?php
namespace PhpAlgo{
   ####################################################CSS##########################################################
  /*
	----------------highlightMatches(str $searchFor ,str $searchIn ,str $class);--------------------
  
	role : search for the "$searchFor" pattern in the "$searchIn" subject than hlight theme all with the "$class" class
    param :
           -str RegExp $searchFor : the world that you want to hlight .
           -str $searchIn : the subject that contain the world that you want to hlight
           -str $class : the hilight style
           

    exmaple :
      $css = new Css();
      $css->highlightMatches("php","php and the php World, yahoo with php .",'yellow');
    result :
       <span class="yellow">php</span>  and the<span class="yellow">php</span>  World, yahoo with <span class="yellow">php</span> 
	*/
	   function CSS_highlightMatches($searchFor,$searchIn,$class){
	   	  
	   	   ///////////////////////////$searchIn is unique//////////////////////////////
	   	   //if the $searchIn is an array
	   	   if ( gettype($searchIn) == "array"){
                    //than walk through array
                    $arr =  array_map(function($val) use($searchFor,$class){
								           $subject	 = $val;
								            $pattern 	 = "/".$searchFor."/i";
			                                $replacement = "<span class='{$class}'>".$searchFor."</span>";
			                                //search in $subject for $pattern than repalce it with $replacement
					                      return preg_replace($pattern, $replacement, $subject );
					                     },$searchIn);

                    return $arr;
	   	     
	   	    }
           ////////////////////////////////////////////////////////////////////////////////////////

	   	    ///////////////////////$searchIn is string////////////////////////////////////////////
			else{
			$subject	 = $searchIn;
			$pattern 	 = "/".$searchFor."/i";
			$replacement = "<span class='{$class}'>".$searchFor."</span>";
             //search in $subject for $pattern than repalce it with $replacement
			return preg_replace($pattern, $replacement, $subject );
			}
			/////////////////////////////////////////////////////////////////////////////////////
	   }
	  ######################################################################################################################


   


   ###################################FILE##############################################################
   /**
   *return the file extension ex File->ext(file.t.jpg) will return .jpg
   *
   *
   *
   **/
	    function FILE_ext($fileName)
	   {
		  //1-split filename at the point anad stor result in $SplitedFileName array
		  $SplitedFileName = explode(".",$fileName);
		  //2-the file extension exist in the lastsplitted string ex image.php.jpg  ==> jpg
		  $FileExt  = $SplitedFileName[count($SplitedFileName)-1];
		  return $FileExt ;
		  
	   }
   
   
  
   /*
     *role        : remove fileNames that are not exist in a db is a specif field
	 *
	 *requirement : called after the config.php file and in tthe config.php 
	 *              a refernce to connection must be name $link ex $link  = mysqli_connect("localhost","root","1234","12");
	 *              and must use mysqli libtary and not msql
	 *
	 *return      :  a string with just one space between words.
	 *
	 *parm        :  
	 *     $_dir = the directory that contain the files that we will remove from them the filename that are not in db
	 *     $_table = the name of table that contain the field 
	 *     $_fieldName = the name  of field$_table that we will compare $_dir Filenams  against
	*/
		function FILE_Remove($_dir,$_table,$_fieldName)
		{
			///////////////////////GATHERING DATA//////////////////////////////////////////
			global $link;
			//1-the directory that contain the files that we will remove from them the filename that are not in db
			$dir =  $_dir;
			//the name of table and of field that we will compare $dir content against
			$table = $_table;$fieldName = $_fieldName;
			///////////////////////////////////////////////////////////////////////////////////////////////
			
			
			//2-open a directory an put it in a dirHanler;
			$dirHandler = opendir($dir);
			//here will be store the file name that ecxis t in both db and dir
			$existFile_array = array();
			//filename that exist just in the current directory
			$dirFiles_array = array();
			
			//2-read(Display) dir ciontent
			while( $Filename = readdir($dirHandler) )
			{
				//4- by default 2 filenaeme will be displayed . and .. so get rid of them with the if
				if($Filename != "." && $Filename != ".." )
				{
					 $dirFiles_array[] = $Filename;
					   
					   ////////////////////////5-put all moviepicture field in one array /////////////////////////////
						$MoviePicArray = array(); 
						$movies_table = mysqli_query($link,"SELECT * FROM $table");
						while($row  = mysqli_fetch_assoc($movies_table))
						{
							$MoviePicArray[] =   $row[$fieldName];
								
						}//while
						///////////////////////////////////////////////////////////////////////////////////////////	
						
						foreach($MoviePicArray as $moviePic)
						{
							//compare each filename in dir with all filename in database $field
							if( $this->allSpaces($Filename) == $this->allSpaces($moviePic) ){
								$existFile_array[]  = $Filename;
							}
						}
				}//if
			}//while( $Filename = readdir($dirHandler) )
			//Remove file that are not exit in db	
				//remove file that are in dir but not in db
				foreach( array_diff($dirFiles_array,$existFile_array ) as $ExceedFile)
				{
					unlink($dir."/".$ExceedFile);
				}
			
		}//Remocve()
    #######################################################################################################################
   
    
     #####################################################FOLDER##############################################################
		
		/*
			   ex : FOLDER_Content("img/MovieImg","folder")
			  role : 
			  return : an array Containig all file and/or folders in a directory
			
			  PARM
				  $_dir  : the directory that we want to display teh file and folders inside it
				  $_type :
				       file =>display just the files in the dir, 
					   folder =>display just the folders in the dir
		*/
		function FOLDER_Content($_dir,$_type=false)
		 {
			 
					////////////////////Gatering iormation/////////////
					$dir = $_dir;//dir that we will display it is content
					$_type;
					//////////////////////////////////////////////////////
					
					//1-open a directory an put it in a dirHanler
					$dirHandler = opendir($dir);
					$allFileOrFoldername_arr  = array();
					//2-read(Display) dir ciontent file and folder
					while( $FileOrFoldername = readdir($dirHandler) )
					{
						//3 by default 2 filenaeme will be displayed . and .. so get rid of them with the if
						if($FileOrFoldername != "." && $FileOrFoldername != ".." )
						{
							//if user pass file or folder arg to method
							if( $_type!=false )
							{
								switch ($_type)
								{
									 //check if the entry  is a  file and not a folder
									case "file"    :   if(is_file($dir."/".$FileOrFoldername))  { $allFileOrFoldername_arr[] = $FileOrFoldername ;  };break;
									//check if the entry  is a folder
									case "folder"  : if( is_dir($dir."/".$FileOrFoldername)){$allFileOrFoldername_arr[] = $FileOrFoldername;};break;
									 
								}//switch
							}//if
							
							//else if user doesn't pass any arg to method
							else
							{
							   $allFileOrFoldername_arr[] = $FileOrFoldername;	
							}//else 
							
						}//if
					}//while
			 return $allFileOrFoldername_arr;
		 }
		 
		 
	     /* ex : PhpAlgo\listFolderFiles('test');
			  role :  Output a folder and files in specific directory in ordered list
			  PARM
				  $_dir  : the directory that we want to display teh file and folders inside it	*/
		 
		 //1-init : from where the recurstion will start
		 function Folder_OutputContent($dir)
		 {			$dir_array = scandir($dir);
					echo '<ol>';
					foreach($dir_array as $fileORfodler)
					{
						if($fileORfodler != '.' && $fileORfodler != '..'){
						
							echo '<li>'.	
								 $fileORfodler;
								//2-Cond : when the recursion will be rpeated
								//if current directoroy is a fodler rpeat the function
								if(is_dir($dir.'/'.$fileORfodler)) Folder_OutputContent($dir.'/'.$fileORfodler);
							echo '</li>';
							
						}
					}
					echo '</ol>';
        }
		
		 /*
		  $path_prm = true | false => 
		          false will display onely the file name ex : Vandam.jpg
				  true will display the relative path to that file ex : test/imgs/Actors/Martial Arts/Vandam.jpg
		   $type_prm :
				       file =>display just the files in the dir, 
					   folder =>display just the folders in the dir
		 */
		 //1-RECURSION ==> init : from where the recurstion will start
		 function Folder_getNestedContent($dir,$path_prm=false)
		 {			
		    //1-Directory ==> read directory into array
			$dir_array = scandir($dir);
					
			$output  = array();
				//2-Directory ==> loop through all file and folders in a directory array ($dir_array)
				foreach($dir_array as $fileORfodler)
				{
				  //3-Directory ==> remove directory named . and ..
				  if($fileORfodler != '.' && $fileORfodler != '..'){
							//2-RECURSION ==> Cond : repeat the function if the current dir is a folder
							if(is_dir($dir.'/'.$fileORfodler)) 
							{
							   
								
								//3-RECURSION ==> Instruction: recall he fuction and send a dynamic directory name to it
								$output[$fileORfodler] =  Folder_getNestedContent($dir.'/'.$fileORfodler,$path_prm);
								
							}
							//4-RECURSION ==> Cond : Else if the directory is a file ando=not a folder
							else{	
											$output[] = ($path_prm==true) ?  $dir.'/'.$fileORfodler :  $fileORfodler;
									
							}
							
						}
					}
			return $output;
					
        }
	 ###########################################################################################################################


     #####################################################LANG(language)######################################################
	/**
	*role : check if a charcter,word or phrase contains latin character
	*return : true if $str contains Latin char
	*parms:
	*    string $str        ==> the string  that you'll check if it is wriiten in latin or not
	*    integer $accuracy  ==>how much latin words must be exist in the $str default is 1
	**/
	 function LANG_isLatin($str,$accuracy=1)
	{
		/*1-preg_match_all will use the pattern to search inside $str parm for  each english
		 word exist and put them all in the $matches[0]*/
		$pattern = '/
					[a-z-A-Z]+
					/x';
		preg_match_all($pattern,$str,$matches );
		/*2-return true if the number of elment in the $matches[0] >$accuracy*/
		 if(count($matches[0]) >=$accuracy ) return true;	
	}
	###########################################################################################################################
     
   
   #####################################################DB(database)######################################################	
  /*
	  Enum($table,$field)
	  role : 
	  return : an array containing all options inside the enumerate type feild
	  PARM
	  $table : the table name where the enumerate type array exist
	  $field :the name of field that hace an enumerate type
	*/
	function DB_Enum($table,$field)
	{
	  //provides information about the columns in a table
	   global $link;
	   $FieldStructure_query = mysqli_query($link,"DESCRIBE $table $field;"); //field=type Type=enum('كوميدي','رعب','رومانسي','مغامرات') Null NO
	   $FieldStructure =  mysqli_fetch_assoc($FieldStructure_query);
	   $type = $FieldStructure['Type'];//enum('كوميدي','رعب','رومانسي','مغامرات')
   
	//search for '(.*?)' in $type and put each match in the $matches[1] arrays
	preg_match('/(?<=\()   #check if there is ( before 
				  (.*)     #match 0 or more  of any  chaaracters
				   (?=\)$) # check if there is a ) at end
				  /x', $type, $matches);

	$movieTypeArray = explode(',',$matches[1]);
	//trim quoting mark from each keyword (') from each keyord
  $mtarray = array();//create an empty arrray
	foreach( $movieTypeArray   as $movieType)
	                    {
		                   $mtarray[]  =  trim($movieType,"'");//fill the array with movietype without (')
	                }//foreach
	
	return $mtarray ;
	}//Enum($table,$field)
   ########################################################################################################################

    ####################################################SEC(security)###################################"
      
	  /******************************encrypt your password***********************/
		function SEC_encrypt($string){
		
			$salt = "@xp2";
			$hash = sha1(md5($salt.$string)).md5($string).sha1(md5(md5($string)));
			return $hash;
		}
		/***************************************************************************/
	
	  function SEC_BlackList($Input,$BlackList,$replacement="")
      {
		   switch($BlackList){
		   	case "BW" : $BlackList = array("#Fuck#","#motherfucker#","#pussy#","#Whores#");break;
		   }

		    //search for all pattern($BlackList) occurrences in subject($Input) and replace them all with $replacement
		    $output       = preg_replace($BlackList,$replacement ,$Input );
		    
		    return $output ;

      }

    ##########################################################################################
	
	
	
	###########################################################BIN(Binary)################################################
	/**
	*role   : convert a character to binary format
	*param  :
	*         $_char : the character that you want to convert to binary format
	*return : string contains the binary number of 1 character
	*ex     : BIN_charTObin("O") = 01001111
	*/
	function BIN_charTObin($_char)
	{
		$bin = decbin(ord($_char));
		$bin = str_pad($bin, 8, 0, STR_PAD_LEFT);
		return $bin;
	}
	
	
	/**
	*role  : convert a string to  binary format
	*param  :
	*         $_str:the string  that you want to convert to binary format
			  $_array : false : return a string conains the binary numbers of each character (default)
						ex     :BIN_strTObin("Obc")= 010011110110001001100011
						true :return an array cotaind the binary number of each character
						ex     :BIN_strTObin("Obc",true) = unique ( [0] => 01001111 [1] => 01100010 [2] => 01100011 )
	*return : string or unique contains the binary number of a string
	*dependencies : depends on BIN_charTObin()
	*/
	function BIN_strTObin($_str,$_array=false)
	{
		  //return an array	 
		 if($_array == true)
		 {
			$table = array();
			 //acces to each character in string and convert it to binary
				for ( $rowIndex=0 ; $rowIndex<strlen($_str) ;$rowIndex++){
					
						   $char                 = $_str[$rowIndex];
						   $table[$rowIndex]['char']  = $char ;
						   $table[$rowIndex]['bin']  = BIN_charTObin($char );
						   $table[$rowIndex]['hex'] = bin2hex($char );
						   $table[$rowIndex]['dec'] = ord($char );
					  
				}
			return  $table;
		 }
		 
		 //return a string 
		 else{
			 $str = "";
				//acces to each character in string and convert it to binary
				for ( $cp=0 ; $cp<strlen($_str) ;$cp++){
					  $str .= BIN_charTObin($_str[$cp]);
				}
			return $str;
		 }
	}
	
	/**
	*role   : convert a  binary format to character
	*param  :
	*           $_bin : the binary number tht you want to convert to string
	*return : string contains the Character of each binary number
	*ex     : BIN_binTOstr("010011110110001001100011") = Obc
	*/
	function BIN_binTOstr($_bin){
		return pack('H*', base_convert($_bin, 2, 16));
	}

	#######################################################################################################################
	
	
	
}//namespace	



/**
 *this namespace will cotain a functions that will treat arrays 
 */
namespace PhpAlgo\Arr{	
    /**
     *  Array_isSameVal = Check if "all" Elments in array has the same values
     *  @param  array $array the array that you want to check if all it elments are equals or not
     *  @return boolean : true if all array elments are equals otherwise false
     */
    
    function isSameVal($array){
        //ARRAY  1- : create empty array
        $boolean_arr = array();
        for(  $cp=0;   $cp<count($array)  ; $cp++)
        {
        //2-get the  index of the elment before current elment
            $beforeIndex = $cp-1;
            //3-if there is no elment before current elment
            if($beforeIndex>=0)
                {
                //1-get the elment value before current value
                    $beforeVal = $array[$beforeIndex];
                    //2-get Current value
                    $currentVal = $array[$cp];
                    //ARRAY : 3- fill the array with true value or false value
                    ( $beforeVal ==  $currentVal ) ? $boolean_arr[] = true : $boolean_arr[] = false;
                }
                }
                 
                //array_sum() : will return number of elment that has only true value
                    //if all elments in array has a true value
                    $boolean = (array_sum( $boolean_arr) == count($boolean_arr) )  ? true : false;
                    return   $boolean;        
           }//issameVal()
           /**
            *RETURN : an array conaitn a unique values that exist only in $array1 but not
            *         in other arrays $array2,$array3,$arrayN...
            *
            *PAREMTERS :
            *    array unique($type_prm,$array1, $array2[,$arrayN])
            *    str $type_prm : "y" | "m" | "d"
            *                     y = return the unique year that exit only in $array1 but not in others $array2,$array3,$arrayN...
            *					 m = return the unique monththat exit only in $array1 but not in others $array2,$array3,$arrayN...
            *					 d = return the unique day that exit only in $array1 but not in others $array2,$array3,$arrayN...
            *   array $array1, $array2[,$arrayN] : each array must contain a vlues that have one of this fomrat:
            *                                       yyyy-mm-dd  mm-yyyy-dd
            *									   yyyy/mm/dd   mm/yyyy/dd
            */
           function unique($type_prm,$cmp_prm)
           {
               $Delimiter = "/|-";
           
               ///////////////////////////"create Closure///////////////////////////
               //1-use closure to acces to function parameters
               $compare_closure = function ($a, $b) use ($type_prm,$Delimiter )
               {
           
                   if($type_prm != "string")
                   {
                       //2-store the exploded array parts of ($a and $b string)each one in varaible
                       //=>format ==> mm-dd-yyyy
                       list($amonth,$aday,$ayear) = preg_split("#".$Delimiter."#",$a);
                       list($bmonth,$bday,$byear) = preg_split("#".$Delimiter."#",$b);
                       //=>format ==> yyyy-dd-mm
                       if ( strlen($ayear) != 4 ) {
                           list($ayear,$amonth,$aday) = preg_split("#".$Delimiter."#",$a);
                           list($byear,$bmonth,$bday) = preg_split("#".$Delimiter."#",$b);
                       }
                   }
           
                   /*3-remove elments from 1st array  if it meet the cond
                    ==> $a==$b means that the value is equls in all the arrays
                    and let just the diff ones*/
                   switch($type_prm){
                       case "y"   : if ($ayear===$byear){  return 0; } ; break;
                       case "m"   : if ($amonth===$bmonth){  return 0; } ; break;
                       case "d"   : if ($aday===$bday){  return 0; } ; break;
                       case "string" :if ($a===$b){  return 0; } ; break;
                   }
           
                   //4-this line must exist
                   return ($a>$b) ? 1:-1;
               };
               /////////////////////////////////////////////////////////////////////////////////
                
               ///////////////////////////CALL the closure///////////////////////////
               //1-get the all args send to the function
               $Args_arr = func_get_args();
               //2-remove 2 first elment form the array ($type_prm="y",$cmp_prm="value")
               array_shift($Args_arr);
               array_shift($Args_arr);
               //3-append an arg to the $Args_arr
               array_push( $Args_arr,$compare_closure  );
           
               //4-call array_udiff() function and send the $Args_arr to it parameters
               switch($cmp_prm){
                   case "value" : $uniqueValues =  call_user_func_array ('array_udiff', $Args_arr );break;
                   case "key"   : $uniqueValues =  call_user_func_array ('array_diff_ukey', $Args_arr );break;
                   case "kv"    : $uniqueValues =  call_user_func_array ('array_diff_uassoc', $Args_arr );break;
                   default : $uniqueValues =  call_user_func_array ('array_udiff', $Args_arr );break;
               }
                
               /////////////////////////////////////////////////////////////////////
           
               ///////////////////////////Reurn array/////////////////////////////////
               return  $uniqueValues;
               //////////////////////////////////////////////////////////////////////
           }//unique
           
           /**
            * multiply all the elmetns in the array together
            * @param int  $arr array hold the number that you want to mutiply together
            * @return number : the product of all array number elments
            * 
            * Ex: mult(array(2,6,5,5) //120
            */
           function mult($arr){
               $prod = 1;
               foreach($arr as $el){
                   $prod =$prod *$el;
               }
               return $prod;
           }
           /**
            * Extracting  a value from the array according to the $Select string
            * 
            * @param unknown $Array : the array that you want to extract value from
            * @param string  $Select : can be one od this :
            *    before='$key' ==>get the elment "before" the the elment that has a key = $key
            *    after='$key'  ==>get the elment "after" the the elment that has a key = $key
            *    jumpby='$key' before='$count' ==> get the elment "before" by $count elment the the elment that has a key = $key
            * @return mixed
            */
           function extractVal($Array , $Select ){
               /* echo "<pre>";print_r($Array);echo "</pre>";*/
               $Select = trim($Select);
           
               // 1- putting attribute and  Valus in serparate array
               preg_match_all("#(\w*)=('\w*')\s*#", $Select,$mathes);
               $attribute_arr =  $mathes[1];
               $Value_arr     =  $mathes[2];
           
               //remove the Quotaion mark '' from the Value_arr values
               $Value_arr = array_map(function($val){
                   return preg_replace("#'#", "", $val);
               }, $Value_arr);
           
           
                   //2-Combine attr and Value : store each Value  in its coresponding atribute
                   $attr = array_combine( $attribute_arr ,$Value_arr);
                   /*print_r( $attr);*/
           
                   //3.Execute orpations according to the attribute
                   switch($attr){
                       case array_key_exists("select", $attr ) :
                           $key =  $attr['after'] + $attr['jumpby'];
                           /**
                            *$Arrayname
                            *$offset   = the index from where the slicing will begins.
                            *$length  = the number of elements that will be sliced.
                            * $preserve_keys = whether to preserve value keys or to reindex the array.
                           */
                           $res = array_slice($Array, $key,$attr['select'] );
                          
                           break;
           
                       case array_key_exists("before", $attr ) :
                           if(array_key_exists("jumpby", $attr )  )  $key =  $attr['before'] - $attr['jumpby'];
                           else $key =  $attr['before'] - 1;
                           $res  =  $Array[$key];
                           break;
                            
                       case array_key_exists("after", $attr ) :
                           if(array_key_exists("jumpby", $attr )  )  $key =   $attr['after'] + $attr['jumpby'];
                           else $key =  $attr['after'] + 1;
                            $res  =  $Array[$key];
                           break;
                   }
                   return $res;
           }
            
}//phpAlgo\Arr



namespace PhpAlgo\Math{
    use PhpAlgo;
				/**
     *role   : check if the number is a prime number or not
     *param  :
     *           $numberItself : the number that you want to check
     *return : true if the number is a prime number otherwise false
     *ex     : isPrime(11)  ==> true
     */
    function isPrime($numberItself){
        //1- store all devision result in this arrray
        $Allresult = array();
        //2.start the loop from 2 -> $numberItself
        for ($cp=2;$cp<$numberItself  ;$cp++ ){
            	
            //3-fill the array value withe the devision result type
            if( is_float($numberItself/$cp )) $Allresult[$cp] = "FloatDevResult";
            else $Allresult[$cp] = "IntDevResult";
            	
        }
        /**
         if there is no "IntDevResult"  :
         that is mean all result are "FloatDevResult"
         Sothe number is divisible only by and 1and  it self  so it's a prime number :
         */
        if(  !in_array("IntDevResult",$Allresult)  ) return true;
        else return false;
    }
    
    
    /**
     *role   : factorization : get the factors of  specific number
     *param  :
     *           $numberItself : the number that you want to factorize
     *return : an array contain all the factor of a number parmeter
     *ex     : isPrime(11)  ==> true
     */
    //1-all factors will be stored in this array
    $factors = array();
    function Fact($numberItself){
        //2-a loop from 2 ->$numberItself-1
        for($cp = 2; $cp<$numberItself ; $cp++){
            //3- The number is a factor of $numberItself  if the Division result is integer :
            $DivisionResult = $numberItself/$cp;
            //4-fill the array with factors
            if( is_integer($DivisionResult) ) $factors[] = $cp;
            	
        }
        //5-add 1 and $numberItself to the factors list
        $factors[] = 1;
        $factors[] = $numberItself;
        //6-optionale step : sort array by Value
        sort($factors);
        //7- return the array of factors
        return $factors;
    }
     
    
    /**
     * Prime factorization  : getting the prime factors of a number
     * 
     * @param int  $numberItself   : the number that you want to prime factorize ex: 24
     * @param bool $rs_prm         : if set to true the resolving steps will display default false.
     * @param array $PrimeFactos   :
     * @return array:int           : return an array that contain the factors
     * 
     * depencies : PhphpAlgo\Math\isPrime()
     * Exmaple   :phpAlgo\Math\PrimeFact(24); ==> array(2,2,2,3);
     */
    function PrimeFact($numberItself , $rs_prm =false,$PrimeFactos = array())
    {
         
    
        /************************debug************************************/
        if($rs_prm   == true){
            echo "<h2 style='color:purple'>Get number that you want to  factorize :</h2>";
            echo " <b style='color:purple'>$numberItself</b>  <br />";
        }
        /*******************************************************************/
        //1-get all the factor of a numbers
        $factors = Fact($numberItself );
        /************************debug************************************/
        if($rs_prm  == true){
        echo "<h2 style='color:orange'>get all the factors of a number:</h2>";
        echo "1-find the factors of the number : <pre>"; print_r($factors ); echo "</pre>";
		   }
    		   /*******************************************************************/
    		   //2-SET THE LEFT NUBER
    	    /*choose first Prime factor  from facors array of step 1 that is not = 1 or number itslef and store it in var $leftn*/
    		   /************************debug************************************/
    		   if($rs_prm  == true){  echo "<h2 style='color:green'>Set left number in pyramid :</h2>";}
    	    /*****************************************************************/
    	    foreach( $factors  as $factor){
    	    /************************debug************************************/
    			  if($rs_prm  == true){   echo "2-Choose 1 and just 1 Prime Factor from the factors  :
    			  <b>is $factor a : ( Prime</b> and <b>!=1</b> and <b>!=numberitself)</b> <br />";}
    			  /*****************************************************************/
    			  if ( isPrime($factor) && $factor!= 1 && $factor!=$numberItself) {
    			  $leftn = $factor;
    				     /************************debug************************************/
    				     if($rs_prm  == true){    echo "Chosen prime factor is :
					   <b style='color:green'>".  $leftn."</b> and break loop when you find it;<br />";}
					/*****************************************************************/
    				     break;
    				     	
    		   }
    		    
    		   if( isPrime($numberItself) ){
    		   /************************debug************************************/
    		       if($rs_prm  == true){ 	  echo "Chosen prime factor is : <b style='color:purple'>$numberItself
    		       Note : the numberitself is a prime number</b>";}
    		       /****************************************************************/
    		       $leftn = $numberItself;
    		       break;
    		   }
    	    }
    	    /*3- SET RIGHT Number
    	    * remeber "LEFT NUBER*RIGHT Number"
    	    */
    	    $rightn = ($numberItself/$leftn  );
    	    /************************debug************************************/
    	    if($rs_prm  == true){  echo "<h2 style='color:red'>Set right numbe in pyramid</h2>";
    	    echo "right number is number/left number in pyramid :  = $numberItself/<b style='color:green'>$leftn</b> ))
    	    = <b style='color:red'>$rightn</b>  <br />";}
    		   /******************************************************************/
    		    	
    		    	 /*Check all number n the tree if right number or left number is a prime number
    		    	 than store it in the $PrimeFactos  array*/
    		    	 if(isPrime($rightn)){
    		    	 $PrimeFactos[] =  $rightn;
    }
    if(isPrime($leftn)){
    $PrimeFactos[] =  $leftn;
    }
    	
    	 /************************debug************************************/
    if($rs_prm  == true){ echo "<h2 style='color:yellow'>if right or left number in tree
			is a  prime factor than store it in array</h2>";
    echo "<pre>"; print_r($PrimeFactos); echo "</pre>";}
    /******************************************************************/
    /*recursion Constion : : Repeat the factoriezation until all factors are prime numbers
     **/
    /*************************************debug***************************************************************************/
    if($rs_prm  == true){echo "<h2 style='color:blue'>Repeat factorization of right number if it's not a prime number:</h2>"; }
    /*********************************************************************************************************************/
    if ( !isPrime($rightn )){
        /*************************************debgu***************************************************************************/
        if($rs_prm  == true){ echo "<b style='color:red' />".$rightn."</b> isn't
						 a prime number so repeat factorization <hr />";}
        /**********************************************************************************************************************/
        $PrimeFactos  = PrimeFact($rightn,$rs_prm ,$PrimeFactos);
        	
    
        	
    }else{
        /*************************************debug***************************************************************************/
        if($rs_prm  == true){
            echo "<b style='color:red' />".$rightn."</b> <b>is</b>
					a prime number so <b>stop</b> factorization <hr />";
            echo "<h1 style='color:aqua'>prime factoriezation of  $numberItself :</h1>";
            foreach ($PrimeFactos as $key=>$primefactor){
                echo "$primefactor *";
                	
    
        }
        echo " = <b>$numberItself</b>";
        }
        /**********************************************************************************************************************/
    }
    	
    //return the factorization result in array
    sort( $PrimeFactos );
    return  $PrimeFactos ;
    }
    
    /**
    *
    * @param int array $numbers an array contains the list of numbers that you want to get thei GCF
    * @param bool $debug  if set to true a reolving Steps explanation will display
    * @return int an integer represent the greatest common factor
    * @dependency phpAlgo\Math\Fact();
    */
    function GCF($numbers,$debug=false)
    {
        /************************debug**********************/
        if($debug == true) {
        echo "<h2 style='color:purple'>1-factorization of  all numbers(";
        foreach ($numbers as $n) {echo " $n and";}
              echo ")</h2>";
          }
      /*****************************************************/
                  
      ################################I -factorize each argument (number)######################
      $param_arr = array();
       
      //1-prime factorize all numbers
      $allfactors = array();
      foreach ($numbers as $arg)
      {
      $primefacts_arr = Fact($arg);
      /**********************debug******************/
      if($debug == true){ echo "factorization of ".$arg.": <br />"; print_r( $primefacts_arr );echo "<br />";}
          /****************************************/
      $param_arr[] =  $primefacts_arr;
     }
   ############################################################################
     
    ################################I -GCF : bgiest common factor######################
    $CommentFactors = call_user_func_array('array_intersect', $param_arr);
    /**********************debug***********************/
    if($debug == true) echo "<h2 style='color:orange'>2-extract the common factors</h2>";
             if($debug == true){ print_r($CommentFactors);}
      /********************************************/
                  
     /**********************debug***********************/
           if($debug == true) {
            echo "<h2 style='color:blue'>3-extract GCF(Greateast Common Factor)</h2>";
           echo max( $CommentFactors  );
                 }
       /**********************************************/
                  
      return max( $CommentFactors  );
     ####################################################################################
   }
     
   /**
    * 
    * @param int/int:array  $factors_arr the list of fractions that you want to check if they are eqauls
    * @return boolean true just if all fractions in the $factors_arr are equals
    * Ex: PhpAlgo\Math\isEqFraction( array(1/2,2/4,20/40))  ==> true
    */
   function isEqFraction($factors_arr){
       
       //if all fractions return the same Value
       //ex : 1/2= 0.5 and 2/4=0.5 and 20/40
       //then all this fractions are eqauls
      return PhpAlgo\Arr\isSameVal($factors_arr);
      
   }
   /**
    * Simplifying fraction: finding the smallest equivalent fraction. It means smallest numerator
    * and denominator without changing the value of the fraction.
    *
    * @param string  $fraction    : write a  fraction  in string like :  "4/8"
    * @param  boolean  $array    : if set to true it will return a array otherwise it will return an string
    * @return mixed : a return value will be the simple fraction form  in string ex "1/2" and if $array=true
    *                the function will return an array that hold fraction numertor and denomintor ARRAY(1,2)
    * Ex: 
    * echo  Simpfrac("4/8",true); ==> 1/2
    * print_r( Simpfrac("48/36")); ==> 
    */
   function Simpfrac($fraction,$array=false)
   {
       
       //remove all spaces from the $mixednumber string
       $fraction = trim($fraction);
       
       /*1-exploding the fraction to get this 2 parts :
        "whole number","fraction numerator" , "fraction denominator" */
       list($Numerator,$Denominator) = preg_split("#/#",$fraction) ;//"4/8"
       
       //1-get the GCF of the the numerator and denominator
       $GCF =  PhpAlgo\Math\GCF( array($Numerator ,$Denominator ))   ;
   
       /*2-6-Simplifying fraction: finding the smallest equivalent fraction
        * by deviding both numerator and denominator with the GCF
       */
       $Simplestform = ($array==false) ?  $Numerator/$GCF."/".$Denominator /$GCF : array("numertor "=>$Numerator/$GCF,"denomintor"=>$Denominator /$GCF) ;
       return $Simplestform ;
   }
   
   /**
    * Rewrite  mixed number as Improper fraction
    *
    * @param  $mixednumber : it must  be a mixed number "Wholenumber Numerator/Denominator"
    * @return array:int array : return improper faction in form of array el[0] =numerator el[1] = Denominator
    *                           and return a string rerpresent the fraction ex 7/2 if you set the $string parameter to true
    * Ex : mixedNumAsImpFrac("3 1/2 ")  = array([0]=>7,[1]=>2) so 7/2
    */
   function mixedNumAsImpFrac($mixednumber,$array=false){
   
       //remove all spaces from the $mixednumber string
       $mixednumber = trim($mixednumber);
        
       /*1-exploding the fraction to get this 2 parts :
        "whole number","fraction numerator" , "fraction denominator" */
       list($wholeNum,$FrNumerator,$FrDenominator) = preg_split("#/|\s+#",$mixednumber) ;
   
       /* 2.	To proper fraction top number Complex number fraction
        * bottom number  * whole number + fraction top number*/
       $Numerator   = $FrDenominator * $wholeNum + $FrNumerator;
       
      $Impfrac =  ($array==false) ? $Numerator."/".$FrDenominator : array("numerator"=>$Numerator,"denominator"=>$FrDenominator)   ;
      return $Impfrac ;
   }
   /**
    *Rewrite  Improper fraction as mixed number 
    * @param string $fraction : a fraction must have this format "numerator/denominator" ex "7/2"
    * @param bool   $array    : set to true if you want to return teh complex number in array instead of string
    * @return mixed           : return mixed number as string ex : "3 1/2" but if $array set to true
    *                           return mixed number as array
    */
   function ImproperFractionAsMixedNumer($fraction,$array=false){
       $fraction  = trim($fraction);
       /*1-exploding the fraction to get this 2 parts :
        "fraction numerator" , "fraction denominator" */
       list($numerator,$denominator) = preg_split("#/#",$fraction) ;
       $numerator;
        
       /*2-Divide top number by the bottom number :to get the whole number
        * use intval() function to return the integer value and no the float
        */
       $wholeNumber = intval($numerator/$denominator);
   
       /*
        * 3.The bottom number in the mixed number  will be the same as
        * the bottom number in the improper fraction
        * 4.The top number in the mixed number will be the same as the improper
        * fraction Devieion remainder
       */
       $remainder = $numerator%$denominator;
   
       $mixedNumber = ($array==false) ?  $wholeNumber." $remainder/$denominator" : array("Whole"=>$wholeNumber,"numerator"=>$remainder,"denominator"=>$denominator);
   
       return $mixedNumber;
   }
   /**
    * getting the  Common Multiple of just 2 numbers
    * using this rule LCM(a,b) = (a*b)/GCD(a,b).
    * @param int  $n1 : the first number
    * @param int  $n2 : the second number
    * @return int : the Common Mutiple
    * 
    * depends on : PhpAlgo\Math\GCF();
    * 
    * Exmaple :PhpAlgo\Math\TwoNumLCM(500, 200);//100
    */
   function TwoNumLCM($n1,$n2)
   {
       $GCF   = PhpAlgo\Math\GCF( array($n1,$n2)) ;
       //For example, find the LCM(6,10).  First find the GCD(6,10) = 2
   
       // Then calculate (6*10)/2 = 60/2 = 30.  Therefore, LCM(6,10) = 30.
       $LCM = ($n1*$n2)/$GCF ;
       return  $LCM;
   
   }
   /**
    * Getting the Least Common Denominator 
    * 
    * @param array $denominators : array contain the list of denominators numbers
    * @return int :  return the Least Common Denominator
    *
    * Example  : PhpAlgo\Math\lCD( array(5,3,2));//ouput : 30
    */
   
   function LCD($denominators)
   {
        
   
       $Array = array();
       for ($cp=0 ;  $cp<count($denominators)    ;$cp++ )
       {
           if ( isset($denominators[$cp+1]))
           {
               $n2 =isset($Array[$cp-1]) ? $Array[$cp-1] : $denominators[$cp];
               $LCD =TwoNumLCM($n2,$denominators[$cp+1]);
               $Array[] = $LCD ;
           }
       }
        
       return $LCD ;
   }

   /**
    * retrurn the type of Specific  number
    * @param string $num :teh number tha you want to get it type can be : fraction || mixednumber || integer
    * @return string     : 'propFrac' || 'imprFrac' || 'mixedNum' || 'int'
    *                      a string indicate the type of the type of the Number
    *Ex:
    *    PhpAlgo\Math\getType(" 2/4 ") //'propFrac'
    *    PhpAlgo\Math\getType("4/2"));//'imprFrac'
    *    PhpAlgo\Math\getType("1 4/2");//'mixedNum'
    *    PhpAlgo\Math\getType("5");//'int'
    *
    */
   function getType($num)
   {
       $num = trim($num);
      
       //mixed number
       if( preg_match("#\d+\s+\d+/\d+#", $num) )
       {
           $result = "mixedNum";
       }
   
       //proer Fraction And improper Fraction*
       else if(  preg_match("#^-*\s*\d+/\d+$#", $num) )
       {
           //suppose that $num = 2/4
           list($numerator,$denominator) = preg_split("#/#",$num);
           //$numerator = 2  -- $denominator = 4
           $result = ( $numerator<$denominator) ? "propFrac": "imprFrac";
       }
   
       //whole number
       else if(  preg_match("#^-*\d+$#", $num)){
           $result = "int";
       }
       else{
           $result = null;
       }
   
       return  $result;
   }
   
   /**
    * mutliply a list of fractions together(just fraction no Complex or Whole number)
    * @param  $Expression : a string with this  format "num/den.num/den"
    * @ return string : return the product fraction but wihout simplification
    * 
    * Ex:  
    *    PhpAlgo\Math\multFrac("1/3.5/2.2/2"); // "10/12"
    */
   function multFrac($Expression)
   {
       //1.Multiply the numerators together  .
           //a.getting each fraction
           $fractions = preg_split("#\.|\x#", $Expression);
           ///b.storing numerator in array  and donimators another array
           $num = array();
           $den = array();
           foreach($fractions as $frac){
               list($num[],$den[])  = preg_split("#/#", $frac);
           }
   
       //2.Multiply the numerators together  then denominators together.
       $nprod = PhpAlgo\Arr\mult($num);
         $dprod =PhpAlgo\Arr\mult($den);
       
       //3.	return a fraction whtout Simplification
      return  " $nprod/$dprod";
    
   
   }
   /**
    * get the reciprocal of a fraction or a Whole number
    * @param unknown $frac : a fraction or a whole number
    * @return string   : the reciprocal of a fraction or a Whole number
    * Ex:
    *   PhpAlgo\Math\reciprocal("12/7");//7/12
    *   PhpAlgo\Math\reciprocal("-7");//1/-7
    *   PhpAlgo\Math\reciprocal("-2/3");
    */
   function reciprocal($frac){
       $frac = trim($frac);
   
       switch($frac){
   
           case preg_match("#^-*\s*\d+/\d+$#", $frac) == 1:
               $arr = preg_split("#/#", $frac);
               return "$arr[1]/$arr[0]";
               break;
   
           case preg_match("#^-\s*\d+$#", $frac) == 1:
               return "1/$frac";
               break;
       }
   }
   /**
   * Divide 2 or more fraction and return result in form of fraction Or Integer
   * @param string  $fractions : list fo fraction sperate with  �(Alt+246) to get this expr :  n/d � n/d � -n/d
   * @param bool  $int :set it to true if you want to return the expression resolving result in integer
   * @return string || int :  return a fraction in string if $int = false and an integer if ,$int = true
   */
   function divFrac($fractions,$int=false){
       // 2.	Let the first fraction unchanged then Multiply  it with other fraction reciprocal
       //a .get fraction
       $arr = preg_split("#�#", $fractions);
   
       //b.seperate the first fraciton from other fractions
       $otherFrac ="";
       foreach( $arr as $key=>$val)
       {
            
           if($key == 0) $firstFrac = $val;
           if( $key>0 ) $otherFrac .= PhpAlgo\Math\reciprocal($val);
           if($key<count($arr)-1)   $otherFrac .= ".";
       }
       //c.mutlipley fractions together
   
       if($int == false)     return PhpAlgo\Math\multFrac($firstFrac . $otherFrac );
       else{
           $frac = PhpAlgo\Math\multFrac($firstFrac . $otherFrac );
           $arr = preg_split("#/(-)#",  $frac ,NULL,PREG_SPLIT_DELIM_CAPTURE);
            
           if(isset($arr[1])){
               $res = $arr[1].$arr[0]/$arr[2];
           }
            
           else{
               $arr = preg_split("#/#", $frac);
               $res = $arr[0]/$arr[1];
           }
           echo  $res;
       }
   }
}

namespace PhpAlgo\Str{
    /**
     * remove all spaces from the string $str
     * @param unknown $str string that we want to remove all spaces from
     * @return string :a string without space
     */
    function removeallSpaces($str)
    {
        //create an epty string  that will be filled with char that are not  space
        $ChaWithoutSpace = "";
        //make a loop from first char to  the last one
        for($cp=0;$cp<strlen($str);$cp++)
        {
            //acess to charecters one by one
            $oneChar = $str[$cp];
            //fill the  $ChaWithoutSpace width chacters in $str that is not conaitn spaces
            if($oneChar!= " "){
                $ChaWithoutSpace .= $str[$cp];}	//if
        }//for
        return $ChaWithoutSpace ;
    }//allSpaces()
    
    /**
     * this method will remove the spaces just if there e is more then 1 space between 2 words ex (to     be  ==> to be)
     * @param string $str :string that we want to remove Extra spaces from(more then 1 sapce between 2 words)
     * @return string     : a string with just one space between words.
     */
    function removeextraSpaces($str)
    {
    
        //create an empty
        $ChaWithoutSpace = "";
        //make allop from first cha to  the last one
        for($cp=0;$cp<strlen($str);$cp++)
        {
            
            //acess to charecters one by one
            $CurrentChar      = $str[$cp];
           
            //store char after current char in var
            if($cp+1<strlen($str)){ $AfterCurrentChar = $str[$cp+1];}
            
            //get tthe charcters that are not space  
            if( $CurrentChar != " " ){
                $ChaWithoutSpace .=  $CurrentChar;
                //get teh charater atre non psace char
               if(  $AfterCurrentChar == " " ){
                   $ChaWithoutSpace .= " ";
               }
            }
            
            
                        	
        }//for
      
       
        //remove the last space
        return   trim($ChaWithoutSpace)  ;
    }//extraSpaces
    
    ##############################################################################################################
    
}




