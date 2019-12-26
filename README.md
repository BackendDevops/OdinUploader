# OdinUploader
Php single file uploader class without any dependicies.

Usage
-----

Create an HTML form like this. 
```html
<form method="POST" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
  <input type="file" name="file" />
  <input type="submit" value="upload"/>
</form>
```
And copy & paste the following code to upload the image
```php 
require_once  "path/to/Uploader.php";



    $uploader=new Uploader($_FILES['file']);
    $uploader->setLocation(__DIR__.'/'.'uploads/');
    $result= $uploader->upload();
    
```

You can Allow Some other extentions inside class mimeTypes variable

Allowed Mimetypes
```php 
 $this->mimeTypes=array('image/png','image/jpeg','image/jpeg','image/gif','application/xml','application/pdf','application/vnd.ms-excel');
```

Roadmap
```html
Image-Resize
Image-Watermark
Image-Thumbs
...
```
Rest of these I am open to new ideas
At the end you can freely use this class
