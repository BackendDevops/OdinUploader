<?php 
/**
 * Odin Uploader.
 * 
 * A single-class PHP library to upload images securely.
 * 
 * PHP support 5.3+
 * 
 * @version     1.0.0
 * @author      https://github.com/BackendDevops
 * @link        https://github.com/BackendDevops/uploader
 * @license     MIT
 */
class Uploader {
    /**
     * @var array storage for the global array
     */
    private $_files = array();
    /**
     * @var string storage for any errors
     */
    private $error = '';
    /**
     * @param array $_files represents the $_FILES array passed as dependency
     */
    /**
     * @var string The new image name, to be provided or will be generated
     */
    protected $name;
     /**
     * @var string The image mime type (extension)
     */
    protected $mime;
    /**
     * @var string The full image path (dir + image + mime)
     */
    protected $fullPath;
    /**
     * @var string The folder or image storage location
     */
    protected $location;
    /**
     * @var array The min and max image size allowed for upload (in bytes)
     */
    protected $size = array(100, 500000);
    
   

    public function __construct(array $_files = array())
    {
        $this->_files=$_files;
        $this->mimeTypes=array('image/png','image/jpeg','image/jpeg','image/gif','application/xml','application/pdf','application/vnd.ms-excel');
        $this->error="";
    }
    private function setName(){
        if (!$this->name) {
            $extention=$this->getExtention();
            $this->name = str_replace('.','',uniqid('', true).'_'.str_shuffle(implode(range('e', 'q'))));
            $this->name=$this->name.".".$extention;
          }
          return $this->name;
    }
    public function getExtention(){
        $ex=explode('.',$this->_files['name']);
        return end($ex);
    }
    public function getName(){
        if (!$this->name) {
            $this->name=$this->setName();
          }
          return $this->name;
    }
    public function setLocation($dir){
        if (!$this->location) {
            $this->location=$dir;
        }
        return $this->location;
    }
    private function checkMimeType(){
            $typeOfFile=$this->getMimeType();
            if(in_array($typeOfFile,$this->mimeTypes)){
                $is_valid=true;
            }else{
                $is_valid=false;
            }
            return $is_valid;
    }
    private function getMimeType(){
        if (function_exists('mime_content_type')) {
            $this->mimeType = mime_content_type($this->_files['tmp_name']);
            return $this->mimeType;
        }else if (function_exists('finfo_open') ) {
            $finfo = finfo_open(FILEINFO_MIME);
            $this->mimeType = finfo_file($finfo, $this->_files['tmp_name']);
            finfo_close($finfo);
            return $this->mimeType;
    
        } else {
           $info=getimagesize($this->_files['tmp_name']);
           $this->mimeType=$info['mime'];
           return $this->mimeType;
        }
        
    }
    private function isDirectoryValid($dir)
    {
    
      return !file_exists($dir) && !is_dir($dir) || is_writable($dir);
    }
    private function check(){
        //step 1
        $this->setName();
        $location_status=$this->isDirectoryValid($this->location);
        $validMime=$this->checkMimeType();
        if($location_status && $validMime){
           $this->isValid=true;
           $this->fullPath=$this->location.$this->name;

        }else{
            $this->isValid=false;
            $this->location_status=$location_status;
            $this->validMime=$validMime;
            $this->fullPath=$this->location.$this->name;

        }
        return $this;

    }
    public function upload(){

        if($this->check()->isValid){
            
            return move_uploaded_file($this->_files['tmp_name'], $this->location.$this->name);
        }else{
            $this->error="Geçersiz Dosya Gönderdiniz";
            return $this->error;
        }
    }


}
