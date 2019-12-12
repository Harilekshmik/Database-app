<?php

/**
 * Use an HTML form to create a new entry in the
 * users table.
 *
 */


if (isset($_POST['submit'])) {
    require "../config.php";
    require "../common.php";

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
            "email"     => $_POST['email'],
            "age"       => $_POST['age'],
            "location"  => $_POST['location']
        );
		//Server side validation
		$a=0;
        if(preg_match("/^[a-zA-Z -]+$/", $_POST['firstname'])===0) //First Name
		     {
			   echo " <br>First Name is not valid";
			   $a++;
		     }
		if(preg_match("/^[a-zA-Z -]+$/", $_POST['lastname'])===0)
		     {
			   echo "<br>Last name is not valid";
			   $a++;
		     }
		
		$email = $_POST["email"];
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
		     {
               // echo("$email is a valid email address");
             }
		else 
		     {
               echo("<br> $email is not a valid email address");
			   $a++;
             }
		  
		$age= $_POST['age'];
        if (!is_numeric($age)) 
		     {
               echo "<br> Age should be in digits";
			   $a++;
             } 
		else if(strlen($age)>3)
		     {
				 echo "Not a valid age";
				 $a++;
			 }			 
		 if(preg_match("/^[a-zA-Z -]+$/", $_POST['location'])===0)
		     {
			    echo "<br>Not a valid place";
				$a++;
		     }
         if ($a<1)
		 {
        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "users",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
		 }
		 else{
			 echo "The form related details are incorrect";
		 }
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['firstname']; ?> successfully added.</blockquote>
<?php } ?>
<script>
    /* function validate()
	 {
		 var name=document.forms["register"]["firstname"].value;
		 if(name=="")
		 {
			 alert("Enter a valid name");
			 document.forms["register"]["firstname"].focus();
			 return false;
		 }
		 var lname=document.forms["register"]["lastname"].value;
		 if(lname=="")
		 {
			 alert("Enter a valid surname");
			 document.forms["register"]["lastname"].focus();
			 return false;
		 }
		 var age=document.forms["register"]["age"].value;
		
        var x=document.forms["register"]["email"].value;  
        var atposition=x.indexOf("@");  
        var dotposition=x.lastIndexOf(".");  
        if (atposition<1 || dotposition<atposition+2 || dotposition+2>=x.length)
		{  
         alert("Please enter a valid e-mail address \n atpostion:"+atposition+"\n dotposition:"+dotposition);  
         return false;  
        }  	
		 if(age=="")
		 {
			 alert("Enter a valid age");
			 document.forms["register"]["age"].focus();
			 return false;
		 } 
		  else if(isNaN(age))
		 {
			 alert("Age should be in digits");
			 document.forms["register"]["age"].focus();
			 return false;
		 }

        var location=document.forms["register"]["location"].value;
		 if(location=="")
		 {
			 alert("Enter a valid location");
			 document.forms["register"]["location"].focus();
			 return false;
		 }		
		 return true;
	 }*/
</script>
<h2>Add a user</h2>

<form method="post" name="register" onsubmit="return validate()">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname">
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
    <label for="age">Age</label>
    <input type="text" name="age" id="age">
    <label for="location">Location</label>
    <input type="text" name="location" id="location">
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>
