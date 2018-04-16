<?php require_once('../../private/initialize.php') ?>
<?php /*
  session_start();
  if(!isset($_SESSION['user'])) {
    // load user selection.
    echo 'choose';
  } else {
    echo 'hello you';
  }
  */
//  $_SESSION['user'] = 'hey';
?>
<?php $pageTitle = ': Times';?>
<?php include( SHARED_PATH . '/header.php') ?>
    <input id="page" name="page" type="hidden" value="events">
    </form>
	</nav>
<div class="container" id="main">
</div>
<?php include( SHARED_PATH . '/footer.php') ?>