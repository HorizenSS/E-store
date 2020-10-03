<?php
	include 'includes/session.php';
if(isset($_POST['id']))
	{	
		$pay_id ='confirmed';
		$id= $_POST['id'];
		
		$conn = $pdo->open();
		try{
			echo $id;
		
			$stmt = $conn->prepare("DELETE from sales WHERE id=:id");
			$stmt->execute([':id'=>$id]);

		
			}
		catch(PDOException $e){
		
		}
		
		$pdo->close();

	header('location: sales.php');
}
?>