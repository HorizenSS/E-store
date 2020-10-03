<?php
	include 'includes/session.php';
//	include 'includes/slugify.php';

	if(isset($_POST['add'])){
		$name = $_POST['name'];
	
		$category = $_POST['category'];
		$price = $_POST['price'];
		$description = $_POST['description'];
		$filename = $_FILES['photo']['name'];

		$conn = $pdo->open();

		$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM products WHERE name=:name");
		$stmt->execute(['name'=>$name]);
		$row = $stmt->fetch();

		if($row['numrows'] > 0){
			$_SESSION['error'] = 'Produit  existant';
		}
		else{
			if(!empty($filename)){
				$ext = pathinfo($filename, PATHINFO_EXTENSION);
				$new_filename = $name.'.'.$ext;
				move_uploaded_file($_FILES['photo']['tmp_name'], '../images/'.$new_filename);	
			}
			else{
				$new_filename = '';
			}

			try{
				$stmt = $conn->prepare("INSERT INTO products (category_id, name, description, price, photo) VALUES (:category, :name, :description, :price, :photo)");
				$stmt->execute(['category'=>$category, 'name'=>$name, 'description'=>$description, 'price'=>$price, 'photo'=>$new_filename]);
				$_SESSION['success'] = 'produit ajouté';

			}
			catch(PDOException $e){
				$_SESSION['error'] = $e->getMessage();
			}
		}

		$pdo->close();
	}
	else{
		$_SESSION['error'] = 'remplir les champs';
	}

	header('location: products.php');

?>