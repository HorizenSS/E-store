<?php
	include 'includes/session.php';
if(isset($_POST['valide']))
	{	
		$pay_id ='confirmed';
		$id= $_POST['id'];
		$idp=$_POST['idp'];
		$conn = $pdo->open();
		try{
			//echo $id;
		
			$stmt = $conn->prepare("UPDATE sales SET pay_id =:pay_id WHERE id=:id");
			$stmt->execute([':pay_id'=>$pay_id,':id'=>$id]);

		 $qu = $conn->prepare("SELECT quantity from details WHERE sales_id=:id");
			$qu->execute([':id'=>$id]);
			$quantiteActuelle = 0;
                        foreach($qu as $details){
                          $subtotal = $details['quantity'];
                          $quantiteActuelle += $subtotal;
                        }
			//echo $quantiteActuelle;

		$qp=$conn->prepare("SELECT quantite from products where id=:idp");
			$qp->execute([':idp'=>$idp]);
			$quantiteCommande = 0;
                        foreach($qp as $detailss){
                          $subtotal = $detailss['quantite'];
                          $quantiteCommande += $subtotal;
                        }
                    
			//echo "hello world";
			//echo $quantiteCommande;
			$nq=$quantiteCommande-$quantiteActuelle;
			//echo $nq;


			$stmt2 = $conn->prepare("UPDATE products p SET quantite=:nq WHERE id=:idp ");
			$stmt2->execute([':nq'=>$nq, ':idp'=>$idp]);
			
			}
		catch(PDOException $e){
		
		}
		
		$pdo->close();

	header('location: sales.php');
}
?>