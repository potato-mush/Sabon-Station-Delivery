<div class="container-fluid" style="margin-top: 98px">
	<div class="col-lg-12">
		<div class="row">
			<!-- FORM Panel -->
			<div class="col-md-4">
				<form action="partials/_menuManage.php" method="post" enctype="multipart/form-data">
					<div class="card mb=3">
						<div class="card-header" style="background-color: rgb(111, 202, 203);">
							Create New Item
						</div>
						<div class="card-body">
							<div class="form-group text-center">
								<label for="image" class="control-label d-block">Image</label>
								<input type="file" name="image" id="image" accept=".jpg" style="display: none;" required>
								<img id="imagePreview" src="../img/default.jpg" alt="Image Preview"
									style="border-radius: 50%; width: 120px; height: 120px; cursor: pointer; margin-top: 10px;"
									onclick="document.getElementById('image').click();">
								<small class="form-text text-muted mx-3">Choose an image file.</small>
							</div>
							<div class="form-group">
								<label class="control-label">Name: </label>
								<input type="text" class="form-control" name="name" required>
							</div>
							<div class="form-group">
								<label class="control-label">Description: </label>
								<textarea cols="30" rows="3" class="form-control" name="description" required></textarea>
							</div>
							<div class="form-group">
								<label class="control-label">Price</label>
								<input type="number" class="form-control" name="price" required min="1">
							</div>
							<div class="form-group">
								<label class="control-label">Stock</label>
								<input type="number" class="form-control" name="stock" required min="0">
							</div>
							<div class="form-group">
								<label class="control-label">Discount (%)</label>
								<input type="number" class="form-control" name="discount" required min="0" max="100" value="0">
							</div>
							<div class="form-group">
								<label class="control-label">Category: </label>
								<select name="categoryId" id="categoryId" class="custom-select browser-default" required>
									<option hidden disabled selected value>None</option>
									<?php
									$catsql = "SELECT * FROM `categories`";
									$catresult = mysqli_query($conn, $catsql);
									while ($row = mysqli_fetch_assoc($catresult)) {
										$catId = $row['categorieId'];
										$catName = $row['categorieName'];
										echo '<option value="' . $catId . '">' . $catName . '</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="card-footer">
							<div class="row">
								<div class="mx-auto">
									<button type="submit" name="createItem" class="btn btn-sm btn-primary"> Create </button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-8">
				<div class="card">
					<div class="card-body">
						<table class="table table-bordered table-hover mb=0">
							<thead style="background-color: rgb(111, 202, 203);">
								<tr>
									<th class="text-center" style="width: 7%;">ID</th>
									<th class="text-center">Image</th>
									<th class="text-center" style="width: 58%;">Item Detail</th>
									<th class="text-center" style="width: 18%;">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
								// SQL query to join products and categories
								$sql = "SELECT p.*, c.categorieName FROM `products` p
								JOIN `categories` c ON p.productCategorieId = c.categorieId";
								$result = mysqli_query($conn, $sql);

								if ($result) {
									while ($row = mysqli_fetch_assoc($result)) {
										$productId = $row['productId'];
										$productName = $row['productName'];
										$productPrice = $row['productPrice'];
										$productDesc = $row['productDesc'];
										$productCategorieId = $row['productCategorieId'];
										$productImage = $row['image']; // Assume this is a BLOB
										$categoryName = $row['categorieName']; // Fetch category name

										 // Use file path for image display
										$src = '../img/' . $row['image'];

										// Display product details
										echo '<tr>
											<td class="text-center">' . htmlspecialchars($productId) . '</td>
											<td>
												<img src="' . $src . '" alt="Image for ' . htmlspecialchars($productName) . '" width="150px" height="150px">
											</td>
											<td>
												<p>Name: <b>' . htmlspecialchars($productName) . '</b></p>
												<p>Description: <b class="truncate">' . htmlspecialchars($productDesc) . '</b></p>
												<p>Price: <b>' . htmlspecialchars($productPrice) . '</b></p>';
												
								if ($row['discount'] > 0) {
									$discountedPrice = $productPrice - ($productPrice * ($row['discount'] / 100));
									echo '<p>Discounted Price: <b>' . number_format($discountedPrice, 2) . ' (' . $row['discount'] . '% OFF)</b></p>';
								}
								
								echo '<p>Stock: <b>' . htmlspecialchars($row['stock']) . '</b></p>
									  <p>Category: <b>' . htmlspecialchars($categoryName) . '</b></p>
											</td>
											<td class="text-center">
												<div class="row mx-auto" style="width: 112px">
													<button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#updateItem' . $productId . '">Edit</button>
													<form action="partials/_menuManage.php" method="POST" style="display:inline;">
														<button name="removeItem" class="btn btn-sm btn-danger" style="margin-left: 9px;">Delete</button>
														<input type="hidden" name="productId" value="' . $productId . '">
													</form>
												</div>
											</td>
										</tr>';
									}
								} else {
									echo "<tr><td colspan='4'>Error retrieving products: " . mysqli_error($conn) . "</td></tr>";
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>
</div>

<?php
$productsql = "SELECT * FROM `products`";
$productResult = mysqli_query($conn, $productsql);
while ($productRow = mysqli_fetch_assoc($productResult)) {
	$productId = $productRow['productId'];
	$productName = $productRow['productName'];
	$productPrice = $productRow['productPrice'];
	$productCategorieId = $productRow['productCategorieId'];
	$productDesc = $productRow['productDesc'];
	$productImage = $productRow['image']; // Fetch image path for modal
?>

	<!-- Modal -->
	<div class="modal fade" id="updateItem<?php echo $productId; ?>" tabindex="-1" role="dialog" aria-labelledby="updateItem<?php echo $productId; ?>" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header" style="background-color: rgb(111, 202, 203);">
					<h5 class="modal-title" id="updateItem<?php echo $productId; ?>">Item Id: <?php echo $productId; ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form action="partials/_menuManage.php" method="post" enctype="multipart/form-data">
						<div class="text-left my-2 row" style="border-bottom: 2px solid #dee2e6;">
							<div class="form-group col-md-12 text-center">
								<div class="form-group text-center">
									<input type="file" name="image" id="itemImage<?php echo $productId; ?>" accept=".jpg" style="display: none;"
										onchange="document.getElementById('itemPhoto<?php echo $productId; ?>').src = window.URL.createObjectURL(this.files[0])">
									<img id="itemPhoto<?php echo $productId; ?>" src="../img/<?php echo $productRow['image']; ?>" alt="Item image"
										style="border-radius: 50%; width: 120px; height: 120px; cursor: pointer; margin-top: 10px;"
										onclick="document.getElementById('itemImage<?php echo $productId; ?>').click();">
									<small class="form-text text-muted mx-3">Click to change image (optional)</small>
								</div>
							</div>
						</div>
						<div class="text-left my-2">
							<b><label for="name">Name</label></b>
							<input class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($productRow['productName']); ?>" type="text" required>
						</div>
						<div class="text-left my-2 row">
							<div class="form-group col-md-4">
								<b><label for="price">Price</label></b>
								<input class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($productRow['productPrice']); ?>" type="number" min="1" required>
							</div>
							<div class="form-group col-md-4">
								<b><label for="stock">Stock</label></b>
								<input class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($productRow['stock']); ?>" type="number" min="0" required>
							</div>
							<div class="form-group col-md-4">
								<b><label for="discount">Discount (%)</label></b>
								<input class="form-control" id="discount" name="discount" value="<?php echo htmlspecialchars($productRow['discount']); ?>" type="number" min="0" max="100" required>
							</div>
						</div>
						<div class="text-left my-2">
							<b><label for="desc">Description</label></b>
							<textarea class="form-control" id="desc" name="desc" rows="2" required minlength="6"><?php echo htmlspecialchars($productRow['productDesc']); ?></textarea>
						</div>
						<div class="text-left my-2">
							<b><label for="categoryId">Category</label></b>
							<select name="categoryId" id="categoryId" class="form-control" required>
								<?php
								$catsql = "SELECT * FROM `categories`";
								$catresult = mysqli_query($conn, $catsql);
								while($row = mysqli_fetch_assoc($catresult)) {
									$catId = $row['categorieId'];
									$catName = $row['categorieName'];
									$selected = ($catId == $productRow['productCategorieId']) ? 'selected' : '';
									echo '<option value="'.$catId.'" '.$selected.'>'.$catName.'</option>';
								}
								?>
							</select>
						</div>
						<button type="submit" class="btn btn-success" name="updateItem">Update</button>
						<input type="hidden" name="productId" value="<?php echo $productId; ?>">
					</form>
				</div>
			</div>
		</div>
	</div>

<?php
}
?>

<script>
	document.getElementById('image').addEventListener('change', function(event) {
		const file = event.target.files[0];
		if (file) {
			const reader = new FileReader();
			reader.onload = function(e) {
				document.getElementById('imagePreview').src = e.target.result;
			}
			reader.readAsDataURL(file);
		}
	});
</script>