<?php

if (isset($_POST['submit'])) 
	{
		require "../config.php";
		require "../common.php";
		$fname ="";
		$name ="";
		$email ="";
		$psw ="";
		$mob ="";
	
		$statement ="";
		
	
	
		if (empty($_POST["username"])) 
		{
			?> <script>$fname="user name is required";</script> <?php		
		}
		else 
		{
			$fname = $_POST["username"];
		}
		if (empty($_POST["name"])) 
		{
			?> <script> alert("Name is required"); </script> <?php
		}
		else 
		{
			$name = $_POST["name"];
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
		if (empty($_POST["password"])) 
		{
			?> <script> alert("password is required"); </script> <?php
			
		}
		else 
		{
			$psw =$_POST["password"];
		}
		if (empty($_POST["mobileno"])) 
		{
			?> <script> alert("mobileno is required"); </script> <?php
		}
		else 
		{
			$mob = $_POST["mobileno"];
		}
	
	


if(($fname!="") and ($name!="") and ($email!="") and ($psw!="") and ($mob!="") )
	{
		
	try 
	{
        $connection = new PDO($dsn, $username, $password, $options);
		
		
		
		
  
        $new_user = array(
            "username" => $_POST['username'],
            "name"  => $_POST['name'],
            "email"     => $_POST['email'],
	          "password"=> $_POST['password'],
            "mobileno"  => $_POST['mobileno']
		
        );
		$sql = "SELECT * FROM users WHERE username = :username or email= :email";
        $statement= $connection->prepare($sql);
        $statement->bindValue(':username',$_POST['username']);
		 $statement->bindValue(':email',$_POST['email']);
         $statement->execute();

if($row = $statement->fetch(PDO::FETCH_ASSOC)) 
{
$usernameExists = 1;
} 
else 
{
$usernameExists = 0;
}
$statement->closeCursor();
if ($usernameExists) 
{
  echo "username already Exist";
}
         else
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
	}

	catch(PDOException $error) 
	{
        echo $sql . "<br>" . $error->getMessage();
    }
	
	}
	else
	{
		?> <blockquote> ERROR in Server Side . </blockquote> <?php
	}
    
	}
?>

<?php require "templates/header.php"; ?>
<script>
    function check()
    {
        var fname=document.forms["form"]["username"].value;
        var lname=document.forms["form"]["name"].value;
        var email=document.forms["form"]["email"].value;
		var password=document.forms["form"]["password"].value;
		var mobileno=document.forms["form"]["mobileno"].value;
		
        if(fname.value=="")
        {
            alert("Enter a Valied First Name");
            document.forms["form"]["firstname"].focus();
				return false;
        }
        if(fname.length<4)
        {
            alert("Enter a Valied username");
            document.forms["form"]["username"].focus();
            return false;
        }
        if(lname.value=="")
        {
            alert("Enter a Valied Name");
            document.forms["form"]["name"].focus();
            return false;
        }
        if(lname.length<4)
        {
            alert("Enter a Valied Name");
            document.forms["form"]["name"].focus();
            return false;
        }
		
        var email=document.form.email.value;  
        var atposition=email.indexOf("@");  
        var dotposition=email.lastIndexOf(".");     
        if (atposition<1 || dotposition<atposition+2 || dotposition+2>=email.length)
        {  
            alert("Please enter a valid e-mail address "); 
			document.forms["form"]["email"].focus();			
            return false;  
        }  
		
		
	    if(password=="" )
		{
			alert("enter password ");
			document.forms["form"]["password"].focus();
			return false;
		}
		if(password.length<2 )
		{
			alert("enter a strong password ");
			document.forms["form"]["password"].focus();
			return false;
		}
		if(mobileno=="" )
		{
			alert("please enter ur mobileno ");
			document.forms["form"]["mobileno"].focus();
			return false;
		}
		if(mobileno.length<8 )
		{
			alert("please enter valid mobileno ");
			document.forms["form"]["mobileno"].focus();
			return false;
			
		}
        
    }
}
</script>

<?php if (isset($_POST['submit'])&&  $statement) { ?>
    <blockquote><?php echo $_POST['username']; ?> successfully added.</blockquote>
<?php } ?>


<h2>Add a user</h2>

<form name="form"  method="post" onsubmit="return check()" >
    <label for="username">User Name</label>
    <input type="text" name="username" id="username">
	
	
	
	
    <label for="name">Name</label>
   <input type="text" name="name" id="name">
    <label for="email">Email Address</label>
    <input type="text" name="email" id="email">
	
	
	
	
	<label for="password">password</label>
    <input type="text" name="password" id="password">
	<label for="mobilno">mobileno</label>
    <input type="text" name="mobileno" id="mobileno">
    
    
    
    
    <input type="submit" name="submit" value="Submit">
</form>

<a href="index.php">Back to home</a>

<?php require "templates/footer.php"; ?>