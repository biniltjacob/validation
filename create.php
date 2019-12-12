<?php

if (isset($_POST['submit'])) 
	{
		require "../config.php";
		require "../common.php";
		$fname ="";
		$lname ="";
		$email ="";
		$age ="";
		$loc ="";
	
		$fname_e ="";
		$lname_e ="";
		$email_e ="";
		$age_e ="";
		$loc_e ="";
	
	
		if (empty($_POST["firstname"])) 
		{
			$fname_e="First name is required";		
		}
		else 
		{
			$fname = $_POST["firstname"];
		}
		if (empty($_POST["lastname"])) 
		{
			?> <script> alert("Last Name is required"); </script> <?php
		}
		else 
		{
			$lname = $_POST["lastname"];
		}
		if (empty($_POST["email"])) 
		{
			?> <script> alert("email is required"); </script> <?php
		}
		else 
		{
			$email = $_POST["email"];
			if (!preg_match("/([w-]+@[w-]+.[w-]+)/",$email)) 
			{
				$email_e = "Invalid email format";
			}
		}
		if (empty($_POST["age"])) 
		{
			?> <script> alert("age is required"); </script> <?php
			
		}
		else 
		{
			$age =$_POST["age"];
		}
		if (empty($_POST["location"])) 
		{
			?> <script> alert("location is required"); </script> <?php
		}
		else 
		{
			$loc = $_POST["location"];
		}
	



if(($fname!="") and ($lname!="") and ($email!="") and ($age!="") and ($loc!="") )
	{
		

    try  {
        $connection = new PDO($dsn, $username, $password, $options);
        
        $new_user = array(
            "firstname" => $_POST['firstname'],
            "lastname"  => $_POST['lastname'],
            "email"     => $_POST['email'],
            "age"       => $_POST['age'],
            "location"  => $_POST['location']
        );

        $sql = sprintf(
                "INSERT INTO %s (%s) values (%s)",
                "users",
                implode(", ", array_keys($new_user)),
                ":" . implode(", :", array_keys($new_user))
        );
        
        $statement = $connection->prepare($sql);
        $statement->execute($new_user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
	}
	else{
			?> <blockquote> ERROR in Server Side . </blockquote> <?php
	}
}
?>

<?php require "templates/header.php"; ?>

<?php if (isset($_POST['submit']) && $statement) { ?>
    <blockquote><?php echo $_POST['firstname']; ?> successfully added.</blockquote>
<?php } ?>
<script>
function validate()
{
	
    var firstname =document.forms["index"]["firstname"].value;
	var lastname =document.forms["index"]["lastname"].value;
	var email =document.forms["index"]["email"].value;
	var atposition=email.indexOf("@");
	var dotposition=email.lastIndexOf(".");
	var age =document.forms["index"]["age"].value;
	
	var location =document.forms["index"]["location"].value;
	
	if (firstname=="")
	{
		alert("pls enter name");
		document.forms["index"]["firstname"].focus();
		return false;
	}
	else if (lastname=="")
	{
		alert("pls enter lastname");
		document.forms["index"]["lastname"].focus();
		return false;
	}
	else if(atposition<1||dotposition<atposition+2||dotposition+2>=email.length)
	{
		alert("pls enter email");
		document.forms["index"]["email"].focus();
		return false;
	}
	else if(location=="")
	{
		alert("pls enter location");
		document.forms["index"]["location"].focus();
		return false;
	}
	else if(age=="")
	{
		alert("pls enter age");
		document.forms["index"]["age"].focus();
		return false;
	}
	else 
	{
		alert("dear "+firstname.value);
		
	}
	
}
</script>

<h2>Add a user</h2>

<form method="post" name="index">
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
