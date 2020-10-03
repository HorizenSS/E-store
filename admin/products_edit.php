<?php
	include 'includes/session.php';


	if(isset($_POST['edit'])){
		$id = $_POST['id'];
		$name = $_POST['name'];
		
		$category = $_POST['category'];
		$price = $_POST['price'];
		$description = $_POST['description'];

		$conn = $pdo->open();

		try{
			$stmt = $conn->prepare("UPDATE products SET name=:name, category_id=:category, price=:price, description=:description WHERE id=:id");
			$stmt->execute(['name'=>$name, 'category'=>$category, 'price'=>$price, 'description'=>$description, 'id'=>$id]);
			$_SESSION['success'] = 'Produit modifié';
		}
		catch(PDOException $e){
			$_SESSION['error'] = $e->getMessage();
		}
		
		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'veuillre remlir le champs';
	}

	header('location: products.php');

?>