<?php
class persona {
    public $servername = "localhost";
    public $username = "root";
    public $password = "";
    public $dbname = "bdhorario";
    //public $password = "HrLACunh";
    //public $dbname = "id7662813_bdhorario";

    public function registrar(){
        try {
            $this -> conn = new PDO( "mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $matricula=$_POST['user'];
            $name=$_POST['name'];
            $last_name=$_POST['last_name'];
            $email=$_POST['email'];
            $pass=$_POST['pass'];
            
            $buscar = $this->conn->prepare("SELECT * FROM alumno WHERE matricula='$matricula'");//buscar si el usuario existe
            $buscar->execute();
            $resultado = $buscar->fetch(PDO::FETCH_ASSOC);
            if($resultado!=null){//Si se encuentran los datos
                echo"<script>alert('la matrícula ya está en uso :\'v')</script>";
            }
            else{//No se deja entrar si los datos son incorrectos
            $sql = $this->conn->prepare( "INSERT INTO alumno (matricula,name,last_name, email, password) VALUES (:matricula, :name, :last_name,  :email, :password);");
            $values = ["matricula" => $matricula, "name" => $name, "last_name" => $last_name, "email" => $email ,"password"=>$pass];
            $sql->execute( $values );
    
            //echo '<script>alert("Registrado! :\'v");parent.location = "Entro.html"</script>';
            echo '<script>alert("Registrado! :\'v")</script>';
            sleep(3);
            exit();
            }            
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
            }
        $conn = null;
    }
    
    public function login(){
        try{
        $matricula=$_POST['user1']; /// recibo los datos de login (matrícula)
        $pass=$_POST['pass1']; // recibo los datos de la contraseña

        $basededatos = new PDO('mysql:host=localhost;dbname=bdhorario', 'root', '');
        $consulta = $basededatos->prepare("SELECT * FROM alumno WHERE matricula='$matricula' and password='$pass'");//buscar usuario y contraseña en la base de datos
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
        if($resultado!=null){//Si se encuentran los datos
        $ns=$resultado['matricula']; // guardar la matricula del usuario
        $us=$resultado['name'];//guardar el nombre de usuario
            echo "Hola ".$us."<br>";
            echo "Tu matrícula es: ".$ns;
            header("refresh:0.1 ;../mapa-grafico-ITI-FCC.html");
        }
    else{//No se deja entrar si los datos son incorrectos
        echo"<script>alert('Esta cuenta de usuario no existe :\'v')</script>";
        header("refresh:0.1 ;../index.html");
    }
   }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
  }
}
$p1 = new persona();
if(isset($_POST['login'])){
    $p1->login();
}
elseif(isset($_POST['registro'])){
    $p1->registrar();
} 
?>