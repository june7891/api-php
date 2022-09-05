<?php
require_once "models/Model.php";

class ImageManager extends Model{
    
// public function getImageIdbyUserId($id_user){
//     $req = "SELECT image_id FROM user_images WHERE user_id = :id_user";
//     $statement = $this->getConnexion()->prepare($req);
//     $statement->bindValue(":id_user",$id_user,PDO::PARAM_INT);
//     $statement->execute();


//     $tabImage=$statement->fetchAll(PDO::FETCH_COLUMN);
//     $statement->closeCursor();    
//     return $tabImage;
   
    
// }



public function getImages($user_id){

    $req = "SELECT * FROM images WHERE user_id = :user_id";
    $statement = $this->getConnexion()->prepare($req);
    $statement->bindValue(":user_id",$user_id,PDO::PARAM_INT);
    $statement->execute();
    
    $images=$statement->fetchAll(PDO::FETCH_ASSOC);
    // echo '<pre>';
    // print_r($images);
    // echo '</pre>';

  
   
    return $images;
}



    public function deleteDbImage($id_image){
        $req = "DELETE FROM images WHERE image_id = :id_image";
        $statement = $this->getConnexion()->prepare($req);
        $statement->bindValue(":id_image",$id_image,PDO::PARAM_INT);
        $statement->execute();
        $statement->closeCursor(); 
        
    }
    
   

    public function addDbImage($image,$title, $user_id){
        $req = "INSERT INTO images (image_name, image_title, user_id) VALUES (:image_name, :image_title, :user_id)";
        $statement = $this->getConnexion()->prepare($req);

        $statement->bindValue(":image_name",$image,PDO::PARAM_STR);
        $statement->bindValue(":image_title",$title,PDO::PARAM_STR);    
     

        $statement->bindValue(":user_id",$user_id,PDO::PARAM_INT);     
        $statement->execute();
        $statement->closeCursor(); 

        return $this->getConnexion()->lastInsertId();
    }


  

    public function updateImage($id_image,$imageName,$imageTitle){
        $req ="UPDATE images SET image_name = :image_name, image_title = :image_title WHERE image_id= :id_image";
        $stmt = $this->getConnexion()->prepare($req);
        $stmt->bindValue(":id_image",$id_image,PDO::PARAM_INT);
        $stmt->bindValue(":image_name",$imageName,PDO::PARAM_STR);
        $stmt->bindValue(":image_title",$imageTitle,PDO::PARAM_STR);
        $stmt->execute();
        $stmt->closeCursor();
    }

   

    public function getImage($id_image){
        $req = "SELECT * from images WHERE image_id = :id_image";
        $stmt = $this->getConnexion()->prepare($req);
        $stmt->bindValue(":id_image",$id_image,PDO::PARAM_INT);
        $stmt->execute();
        $image= $stmt->fetch(PDO::FETCH_ASSOC);
        $imageName = $image['image_name'];
        $stmt->closeCursor();
      
        return $imageName;
    }
    public function getImageInfo($id_image){
        $req = "SELECT * from images WHERE image_id = :id_image";
        $stmt = $this->getConnexion()->prepare($req);
        $stmt->bindValue(":id_image",$id_image,PDO::PARAM_INT);
        $stmt->execute();
        $image= $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $image;
    }


    

}