<?php
require_once "controllers/Security.class.php";
require_once "utils/functions.php";
require_once "models/imageManager.php";
require_once "models/userManager.php";


class ImageController{
    private $imageManager;
    private $userManager;
    
    public function __construct()
    {
        $this->imageManager = new ImageManager();
        $this->userManager = new UserManager();
        
    }



   public function showImages(){

    if(Security::verifAccessSession()){
        $user_id = $_SESSION['id'];
      
        $tabImages = $this->imageManager->getImages($user_id);  

        // foreach($tabImages as $image){
        //           echo '<pre>';
        //    print_r($image);
        //    echo '</pre>';
        // }

        $user= $this->userManager->getUserById($_SESSION['id']);

    require_once "views/gallery.view.php";
        
    }else {
        throw new Exception("Access forbiden");
    }
   
}
 





   public function deleteImage(){
    if(Security::verifAccessSession()){
        $id_image = (int)Security::secureHTML($_POST['image_id']);
        $image = $this->imageManager->getImage($id_image);
        unlink("public/images/".$image);
        $this->imageManager->deleteDbImage($id_image);
        header('Location: '.URL.'gallery/show');
    
    }else {
        throw new Exception("Access forbiden");
    }
   }      

   public function addImageTemplate(){
    if(Security::verifAccessSession()){

        require_once "views/addImage.view.php";
    }else {
        throw new Exception("Access forbiden");
    }
   }
   public function addImage(){
    if(Security::verifAccessSession()){
        $id_user =  (int)Security::secureHTML($_POST['id']);
        $title = Security::secureHTML($_POST['title']);
        $image="";
        if($_FILES['image']['size'] > 0){
            $repertoire = "public/images/";
            $image = ajoutImage($_FILES['image'],$repertoire);
        }
        
      
      
        $id_image = $this->imageManager->addDbImage($image, $title, $id_user);


            header('Location: '.URL.'gallery/show'); 

     
        
       

}else {
throw new Exception("Access forbiden");
}
}

public function modification($id_image){
    if(Security::verifAccessSession()){
      
        $image= $this->imageManager->getImageInfo((int)Security::secureHTML($id_image));
        
        require_once "views/imageModification.view.php";
    } else {
        throw new Exception("Vous n'avez pas le droit d'être là ! ");
    }
}


    public function modificationValidation(){
        if(Security::verifAccessSession()){
            $id_image = (int)Security::secureHTML($_POST['image_id']);
            $imageName= $this->imageManager->getImage($id_image);
            if($_FILES['image']['size'] > 0){
            unlink("public/images/".$image);
            $repertoire = "public/images/";
            $imageName = ajoutImage($_FILES['image'],$repertoire);

        }
       
            $imageTitle = Security::secureHTML($_POST['title']);
         
            $this->imageManager->updateImage($id_image, $imageName, $imageTitle);

            

         
            header('Location: '.URL.'gallery/show');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }
    }
}