<?php

/**
 * Function to query information based on 
 * a parameter: in this case, location.
 *
 */

if (isset($_POST['submit'])) {
    try  {
        
        require "../config.php";
        require "../common.php";

        $connection = new PDO($dsn, $username, $password, $options);

        $sql = "SELECT * 
                        FROM users
                        WHERE username = :username and password =:password";

        $username = $_POST['username'];
		$password =$_POST['password'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':username', $username, PDO::PARAM_STR);
		$statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->execute();

        $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
?>
<?php require "templates/header.php"; ?>
        
<?php  
if (isset($_POST['submit'])) {
    if ($result && $statement->rowCount() > 0) { ?>
        <h2>Results</h2>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Name</th>
                    <th>Email Address</th>
                    <th>password</th>
                    <th>mobileno</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
        <?php foreach ($result as $row) { ?>
            <tr>
                <td><?php echo escape($row["id"]); ?></td>
                <td><?php echo escape($row["username"]); ?></td>
                <td><?php echo escape($row["name"]); ?></td>
                <td><?php echo escape($row["email"]); ?></td>
                <td><?php echo escape($row["password"]); ?></td>
                <td><?php echo escape($row["mobileno"]); ?></td>
                <td><?php echo escape($row["date"]); ?> </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <blockquote>incorrect username  <?php echo escape($_POST['username']); ?>.</blockquote>
		<blockquote>incorrect password  <?php echo escape($_POST['password']); ?>.</blockquote>
    <?php } 
} ?> 
	
	
	
	
	