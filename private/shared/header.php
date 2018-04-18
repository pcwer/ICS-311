<?php
  if(!isset($pageTitle)) {
    $pageTitle = '';
  }
?>
<?php
  $namesSet = getUsers();
  $names = array();
  
  if($namesSet->num_rows > 0) {
    while($row = $namesSet->fetch_assoc()) {
      $names[] = $row["first_name"].' '.$row["last_name"];
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  
	<title>ICS 311<?php echo $pageTitle; ?></title>
</head>
<body>
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark justify-content-between">
		<a class="navbar-brand" href="<?php echo url_for('/') ?>">ICS 311</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
        <li class="nav-item">
					<a class="nav-link" href="<?php echo url_for('/'); ?>">Home</a>
				</li>
        <li class="nav-item">
					<a class="nav-link" href="<?php echo url_for('/events/'); ?> ">Events</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="<?php echo url_for('/times/'); ?>">Times</a>
				</li>
			</ul>    
		</div>
    <form class="form-inline" name="user" method="post">
      <select class="custom-select bg-secondary text-white" name="user" id="user">
        <option></option>
        <?php 
          foreach($names as $name) {
            if(isset($_SESSION['user']) && $name === $_SESSION['user']) {
              echo '<option value="'.$name.'" selected>'.$name.'</option>';
            } else {
              echo '<option value="'.$name.'">'.$name.'</option>';
            }
          }
          
          if(isset($_POST['user']) && !empty($_POST['user'])){
            $_SESSION['user'] = $_POST['user'];
          }
        ?>
      </select>
