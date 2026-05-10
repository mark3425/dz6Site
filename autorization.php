<?php 
    header('Content-Type: text/html; charset=UTF-8');
    session_start();
    
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!empty($_SESSION['uLogin'])) {
        header('Location: ./redakt.php');
        exit();
        } 
        header('Location: ./autorizationForm.php');
        exit();
    }
    $login = $_POST['login'];
    $password = $_POST['password'];

    $user ='u82468';
    $pass ='3747530';
    $db = new PDO('mysql:host=localhost;dbname=u82468', $user, $pass,
        [PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    try{

    $stmt = $db->prepare("SELECT userPass FROM users WHERE userLogin = :login");
    $stmt->execute([':login' => $login]);
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);
        if($userData){
        $hashedPassword = $userData['userPass'];
            if (password_verify($password, $hashedPassword)) {
                $_SESSION['uLogin'] = $login;
    
                header('Location: ./redakt.php');
                exit();
            }
            }
            header('Location: ./autorizationForm.php?error=1');
            exit();
    }
    catch(PDOException $e){
        print('Error : ' . $e->getMessage());
        exit();
    }
?>