<?php 
$username = $_POST['username'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$email = $_POST['email'];
$phonecode = $_POST['phonecode'];
$phone = $_POST['phone'];

if (!empty($username) || !empty($password) || !empty($gender) || !empty($email) || !empty($phonecode) || !empty($phone) )
{
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "try";

    //create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if (mysqli_connect_error())
    {
        die('Connect Error('. mysqli_connect_error().')'. mysqli_connect_error());
    }
    else
    {
        $SELECT = "SELECT email from try1 where email = ? Limit 1";
        $INSERT = "INSERT Into try1 (username, password, gender, email, phonecode, phone) values(?, ?, ?, ?, ?, ?)";

        //Prepare statement
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($email);
        $stmt->store_result();
        $rnum = $stmt->num_rows;

        if ($rnum==0)
        {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);
            $stmt->bind_param("ssssii", $username, $password, $gender, $email, $phonecode, $phone);
            $stmt->execute();
            echo "New record inserted successfully";
        }
        else
        {
            echo "Someone already has registered using this email";
        }
        $stmt->close();
        $conn->close();
    }
}
else
{
    echo "All fields are required.";
    die();
}
?>