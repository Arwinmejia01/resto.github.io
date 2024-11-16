<?php 
include_once 'config/Database.php';
include_once 'class/Customer.php';
include_once 'class/MenuItem.php';

$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);
$food = new Food($db);

if(!$customer->loggedIn()) {	
	header("Location: login.php");	
}
include('inc/header.php');
?>

<link rel="stylesheet" type = "text/css" href ="css/foods.css">
<?php include('inc/container.php');?>
<div class="content">
	<div class="container-fluid">		
		<div class='row'>		
        <?php include('top_menu.php'); ?> 
		</div>
			<div class='row my-3'>
			<?php 
			$result = $food->itemsList();
			$count=0;
			while ($item = $result->fetch_assoc()) { 
			if ($count == 0) {
				echo "<div class='row'>";
			}
			?>	
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-3 food-item">
					<form method="post" action="cart.php?action=add&id=<?php echo $item["id"]; ?>">
						<input type="hidden" name="item_name" value="<?php echo $item["name"]; ?>">
						<input type="hidden" name="item_price" value="<?php echo $item["price"]; ?>">
						<input type="hidden" name="item_id" value="<?php echo $item["id"]; ?>">
						<div class="card rounded-0" align="center";>
							<div class="food-img-holder position-relative overflow-hidden">
							<img src="<?php echo $item["images"]; ?>" class="img-top">
							</div>
							<div class="card-body">
								<div class="lh-1 ">
									<div class="card-title fw-bold h5 mb-0"><?php echo $item["name"]; ?></div>
									<div class="card-description text-muted"><small><?php echo $item["description"]; ?></small></div>
									<div><small class="card-description text-success h6 mb-0">₱ <?php echo $item["price"]; ?></small></div>
									<div class="d-grid">
									<div class="input-group input-sm">
										<span class="input-group-text rounded-0">Quantity</span>
										<input type="number" class="form-control rounded-0 text-center" id="quantity" name="quantity" value="1" required="required">
									</div>
									<input type="submit" name="add" style="margin-top:5px;" class="btn btn-primary btn-sm rounded-0" value="Add to Cart">
									</div>
								</div>
							</div>
							
						</div>
					</form>    
				</div>

			<?php 
			$count++;
			if($count==4)
			{
			  echo "</div>";
			  $count=0;
			}
			} 
			?>
			</div>
		   
    </div>        
		
<?php include('inc/footer.php');?>
