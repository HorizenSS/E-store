<?php include 'includes/session.php'; ?>
<?php
	$conn = $pdo->open();

	$name = $_GET['product'];

	try{
		 		
	    $stmt = $conn->prepare("SELECT *, products.name AS prodname, products.id AS prodid FROM products WHERE name = :name");
	    $stmt->execute(['name' => $name]);
	    $product = $stmt->fetch();
		
	}
	catch(PDOException $e){
		echo "Thprobleme de connexion: " . $e->getMessage();
	}

	//page view
	
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue layout-top-nav">

<div class="wrapper">

	<?php include 'includes/navbar.php'; ?>
	 
	  <div class="content-wrapper">
	    <div class="container">

	      <!-- Main content -->
	      <section class="content">
	        <div class="row">
	        	<div class="col-sm-9">
	        		<div class="callout" id="callout" style="display:none">
	        			<button type="button" class="close"><span aria-hidden="true">&times;</span></button>
	        			<span class="message"></span>
	        		</div>
		            <div class="row">
		            	<div class="col-sm-6">
		            		<img src="<?php echo (!empty($product['photo'])) ? 'images/'.$product['photo'] : 'images/noimage.jpg'; ?>" width="100%" class="zoom" data-magnify-src="images/large-<?php echo $product['photo']; ?>">
		            		<br><br>
		            		<form class="form-inline" id="productForm">
		            			<div class="form-group">
			            			<div class="input-group col-sm-5">
			            				
			            				<span class="input-group-btn">
			            					
			            				</span>
			            	
							          	<input type="number" name="quantity" id="quantity" class="form-control input-lg" value="1" min="1" max="<?php echo $product['quantite']; ?>">
							            <span class="input-group-btn">
							               
							            </span>
							            <input type="hidden" value="<?php echo $product['prodid']; ?>" name="id">

							            <input type="hidden" value="<?php echo $product['quantite']; ?>" id="stock" name="stock">
							        </div>
							       
							          <?php if( $product['quantite']>0 ){ 
                                      echo '<button type="submit" class="btn btn-primary btn-lg btn-flat"><i class="fa fa-shopping-cart"></i> ajouter au panier</button>';
										 }else{ 
										echo '<span class="message">stock épuisé!</span>';
									 } ?>
                                        

			            			
			            		</div>
		            		</form>
		            	</div>
		            	<div class="col-sm-6">
		            		<h1 class="page-header"><?php echo $product['prodname']; ?></h1>
		            		<h3><b> <?php echo $product['price'] ?> dt</b></h3>
		            
		            		<p><b>Description:</b></p>
		            		<p><?php echo $product['description']; ?></p>
		            		<p><?php echo $product['quantite']; ?> article(s) disponible(s)</p>
		            	</div>
		            </div>
		            <br>
				   
	        	<div class="col-sm-3">
	        		<?php include 'includes/sidebar.php'; ?>
	        	</div>
	        </div>
	      </section>
	     
	    </div>
	  </div>
  	<?php $pdo->close(); ?>
  	<?php include 'includes/footer.php'; ?>
</div>

<?php include 'includes/scripts.php'; ?>

</body>
</html>