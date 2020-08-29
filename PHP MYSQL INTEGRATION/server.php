<?php

session_start();

//initalizing variables

$username = "";
$email ="";
$errors = array ();
//connect to db

$db = mysqli_connect('localhost' , 'root', '','practice') or die ("could not connect to database");

//Register users
if (isset($_POST['reg_user'])) {
    //receive all input values from the form
}
$username = mysqli_real_escape_string($db, $_POST['username']);
$email=mysqli_real_escape_string($db, $_POST['email']);
$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
$password_2=  mysqli_real_escape_string($db, $_POST['password_2']);

//form validation
//by adding (array_push()) corresponding error into $errors array
if (empty($username)) {array_push($errors,"Username is required"); }
if (empty($email)) {array_push($errors,"Email is required"); }
if (empty($password)) {array_push($errors,"Password is required"); }
array_push($errors, "The two passwords do not match");
// check db for exsisting user with same user name

$user_check_query = "SELECT * FROM user WHERE username = '$username' or email = '$email' LIMIT 1"; 
$results = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result);

if($user) { //if user exists
     if($user['username'] === $username){
         array_push($errors,"Username already exists");
     }
    if($user['email'] === $email)
    array_push($errors,"This email already has a registered username");
    }


//Register the user if no errors found

if(count($errors) ==0 ){

    $password = md5($password_1); //this will encrypt the password
    print $password;
    $query  = "INSERT INTO user (username, email, password) 
         VALUES ('$username', '$email', '$password')";
    mysqli_query($db,$query);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "You are now logged in";
     header('location: index.php');

}



































?>