<?php
	include 'includes/session.php';

	if(isset($_POST['delete'])){
		$id = $_POST['id'];
		
		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("DELETE FROM products WHERE id=:id");
			$stmt->execute(['id'=>$id]);

			$_SESSION['success'] = 'Produit suprimé';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'choisissez un produit avant';
	}

	header('location: products.php');
	
?>