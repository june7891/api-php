<?php
require "controllers/Security.class.php";
require "models/UserManager.php";
require_once "utils/functions.php";

class UserController{
    private $userManager;
    
    public function __construct()
    {
        $this->userManager = new UserManager();
    }


    // création compte utilisateur/inscription


    public function registerUser() {

        
        $user = json_decode( file_get_contents('php://input') );
     
        $email = $user->email;
        $username = $user->username;
        $password = password_hash($user->password, PASSWORD_DEFAULT);

        
        //  vérifie si user existe déjà
        if($this->userManager->findUserByEmailOrUsername($email, $username)) {
            echo "utilisateur existe déja";
        } else {
            $user = $this->userManager->registerUserDb($username, $email, $password); 
        }
                 
    }


    public function login(){

        $user = json_decode( file_get_contents('php://input') );

    
        $email = Security::secureHTML($user->email);
        $password = Security::secureHTML($user->password);

        //vérifie si user existe
    
            $user= $this->userManager->login($email, $password);
        
       
           
        
    }




    //Mettre à jour le profil utilisateur

    public function getUserAccount(){

        if(Security::verifAccessSession()){
            $user= $this->userManager->getUserById($_SESSION['id']);
            require "views/account.view.php";
        }else {
         
            header('Location: '.URL."login");
        }
        
        
    }

    public function getUpdateAccountTemplate() {
        if(Security::verifAccessSession()){
            $user= $this->userManager->getUserById($_SESSION['id']);
            require "views/modify-account.view.php";
        }else {
         
            header('Location: '.URL."login");
        }
    }


    public function updateAccount($id_user){

        if(Security::verifAccessSession()){
            $id_user = (int)Security::secureHTML($_POST['id_user']);
            $firstname = Security::secureHTML($_POST['firstname']);
            $lastname = Security::secureHTML($_POST['lastname']);
            $phoneNumber = Security::secureHTML($_POST['phoneNumber']);
            $dateOfBirth = Security::secureHTML($_POST['dateOfBirth']);
            $address = Security::secureHTML($_POST['address']);
            $gender = Security::secureHTML($_POST['gender']);


            $profilePhoto=$this->userManager->getProfilePhoto($id_user);
            if($_FILES['image']['size'] > 0){
                $repertoire = "public/images/";
                $profilePhoto = ajoutImage($_FILES['image'],$repertoire);
            }
         
            $this->userManager->updateDbAccount($id_user, $firstname, $lastname, $phoneNumber, $dateOfBirth, $address, $gender, $profilePhoto);
          

            $user= $this->userManager->getUserById($id_user);

            
            require "views/account.view.php";
        
            //header('Location: '.URL.'account/show');
        } else {
            throw new Exception("Vous n'avez pas le droit d'être là ! ");
        }

    }




    public function updateUsernameEmail() {
        echo "modifier le pseudo ou mot de passe";
    }
   



    // connexion/login

    

   
    




 
    

}


