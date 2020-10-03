<?php include 'includes/session.php'; ?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Sales History
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Sales</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <div class="pull-right">
                <form method="POST" class="form-inline" action="sales_print.php">
                  <div class="input-group">
                    <div class="input-group-addon">
                 
                    </div>
                    <input type="text" class="form-control pull-right col-sm-8" id="reservation" name="date_range">
                  </div>
                  <button type="submit" class="btn btn-success btn-sm btn-flat" name="print"><span class="glyphicon glyphicon-print"></span> Print</button>
                </form>
              </div>
            </div>
            <div class="box-body">
              <table id="example1" class="table table-bordered">
                <thead>
                  <th class="hidden"></th>
                  <th>Date</th>
                  <th>client</th>
                  <th>etat</th>
                  <th>prix</th>
                  <th>Details facture</th>
                  <th>gérer</th>
                </thead>
                <tbody>
                  <?php
                    $conn = $pdo->open();

                    try{
                      $stmt = $conn->prepare("SELECT *, sales.id AS salesid FROM sales LEFT JOIN users ON users.id=sales.user_id ORDER BY sales_date DESC");
                      $stmt->execute();
                       

                       
                      foreach($stmt as $row){?>

                        
                            <?php
                        $stmt = $conn->prepare("SELECT * FROM details LEFT JOIN products ON products.id=details.product_id WHERE details.sales_id=:id");
                        $stmt->execute(['id'=>$row['salesid']]);
                        $total = 0;
                        foreach($stmt as $details){
                          $subtotal = $details['price']*$details['quantity'];
                          $total += $subtotal;
                        }
  
                        ?>
                          
                            <tr>
                            <td><?PHP echo date('M d, Y', strtotime($row['sales_date']))?></td>
                            <td><?PHP echo $row['firstname'].' '.$row['lastname']?></td>
                            <td><?PHP echo $row['pay_id']?></td>
                            <td><?PHP echo number_format($total, 2)?></td>
                            <td><button type='button' class='btn btn-info btn-sm btn-flat transact' data-id='<?PHP echo $row['salesid']?>'><i class='fa fa-search'></i> facture</button></td>

                          <td>
                            <form method="POST" action="validate.php">
                              <button name="valide" class='btn btn-info btn-sm btn-flat '>valider</button>
                              <input type="hidden" value="<?PHP echo $row['salesid'] ?>" name="id">
                               <input type="hidden" value="<?PHP echo $details['product_id'] ?>" name="idp">
                            </form></td>
                            <td>
                            <form method="POST" action="cancel.php">
                              <button name="cancel" class='btn btn-info btn-sm btn-flat '>rejeter</button>
                              <input type="hidden" value="<?PHP echo $row['salesid'] ?>" name="id">
                            
                            </form></td>
                              </tr>;
                           <?php
                      }
                    }
                    catch(PDOException $e){
                      echo $e->getMessage();
                    }

                    $pdo->close();
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
     
  </div>
    <?php include 'includes/footer.php'; ?>
    <?php include '../includes/profile_modal.php'; ?>

</div>
<!-- ./wrapper -->

<?php include 'includes/scripts.php'; ?>

<script>
$(function(){
  $(document).on('click', '.transact', function(e){
    e.preventDefault();
    $('#transaction').modal('show');
    var id = $(this).data('id');
    $.ajax({
      type: 'POST',
      url: 'transact.php',
      data: {id:id},
      dataType: 'json',
      success:function(response){
        $('#date').html(response.date);
        $('#transid').html(response.transaction);
        $('#detail').prepend(response.list);
        $('#total').html(response.total);
      }
    });
  });

  $("#transaction").on("hidden.bs.modal", function () {
      $('.prepend_items').remove();
  });
});


</script>
</body>
</html>

</script>
</body>
</html>
