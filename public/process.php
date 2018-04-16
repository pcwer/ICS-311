<?php require_once('../private/initialize.php') ?>
<?php
  if(isset($_POST['page'])) {
    switch ($_POST['page']) {
      case 'home':
        home();
        break;
      case 'events':
        events();
        break;
      case 'times':
        times();
        break;
      default:
        home();
        break;
    }
  }
?>

<?php
  /** 
  * home - populates home page with user data
  */
  function home() {
    if(isset($_POST['user']) && !empty($_POST['user'])){
      $_SESSION['user'] = $_POST['user'];
       // Fill values out for user page
      $daysDataset = getNextBirthday($_POST['user']);
      $name = $birthday = $days = NULL;
      
      if($daysDataset->num_rows > 0) {
        while($row = $daysDataset->fetch_assoc()) {
          $name = $row["name"];
          $birthday = $row["birthday"];
          $days = $row["days_until_bday"];
        }
      }
?>
  <hr>
  <div class="row">
    <h3>User Information</h3>
    <div><pre><?php //print_r($daysDataset); ?></pre></div>
    <table class="table">
      <thead>
      </thead>
      <tbody>
        <tr>
          <td width="300px">Name:</td>
          <td><?php echo $name ?></td>
        </tr>
        <tr>
          <td>Birthday:</td>
          <td><?php echo $birthday ?></td>
        </tr>
        <tr>
          <td>Days until birthday:</td>
          <td><?php echo $days ?></td>
        </tr>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
  </div>
<?php
    }
  }
  
  /**
  * events - populates event page with event data for chosen user
  */
  function events() {
    if(isset($_POST['user']) && !empty($_POST['user'])){
      $_SESSION['user'] = $_POST['user'];
      $eventsDataset = getEventInformation($_POST['user']);
?>
  <hr>
  <div class="row">
    <h3>Event Information for <?php echo $_POST['user']?></h3>
    <div><pre><?php// print_r($eventsDataset); ?></pre></div>
    <table class="table">
      <thead>
        <tr>
          <th>Event Name</th>
          <th>Event Description</th>
          <th>Goal Description</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Goal Minutes</th>
          <th>Used Minutes</th>
          <th>Location Name</th>
        </tr>
      </thead>
      <tbody>
      <?php 
        if($eventsDataset->num_rows > 0) {
          while($row = $eventsDataset->fetch_assoc()) {
            echo '<tr>';
            echo '<td>'. $row["event_name"] . '</td>';
            echo '<td>'. $row["event_description"] . '</td>';
            echo '<td>'. $row["goal_description"] . '</td>';
            echo '<td>'. $row["start_date"] . '</td>';
            echo '<td>'. $row["end_date"] . '</td>';
            echo '<td>'. $row["goal_minutes"] . '</td>';
            echo '<td>'. $row["used_minutes"] . '</td>';
            echo '<td>'. $row["location_name"] . '</td>';
            echo '</tr>';
          }
        }
      ?>        
      </tbody>
      <tfoot>
      </tfoot>
    </table>
  </div>
<?php
    }
  }
  /**
  * events - populates times page with event data for chosen user
  */
  function times() {
    $_SESSION['user'] = $_POST['user'];
?>
  <hr>
  <div class="row">
    <h3>This is a page of times.</h3>
    <table class="table">
      <thead>
        <th></th>
      </thead>
      <tbody>
        <tr>
        
        </tr>
      </tbody>
      <tfoot>
      </tfoot>
    </table>
  </div>
<?php
  }
?>
