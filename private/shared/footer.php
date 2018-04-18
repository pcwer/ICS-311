<!-- JQuery, Popper, Bootstrap -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>

<script>
  $(document).ready(function() {
    $('#data').DataTable();
  });
</script>
<script>
  $(document).ready(function() {
    var file = location.pathname;
    if(file.length !== 17) {
      file += "../process.php";
    } else {
      file += "/process.php";
    }
    
    $.ajax({
      type: "POST",
      url: file,
      data: {'user': $('#user option:selected').val(), 'page':$('#page').val()},
      success: function(value) {
        $('#main').html(value);
      }
    });
  });

  $('#user').change(function() {
    var file = location.pathname;
    if(file.length !== 17) {
      file += "../process.php";
    } else {
      file += "/process.php";
    }
    
    $.ajax({
      type: "POST",
      url: file,
      data: {'user': $(this).val(), 'page':$('#page').val()},
      success: function(value) {
        $('#main').html(value);
      }
    });
  });
  
  $('#main').click(function() {
    $('#events').change(function() {
      var file = location.pathname;
      if(file.length !== 17) {
        file += "../process.php";
      } else {
        file += "/process.php";
      }
      
      $.ajax({
        type: "POST",
        url: file,
        data: {'event': $(this).val()},
        success: function(value) {
          $('#timeTable').html(value);
        }
      });
    });
 });
</script>
</body>
</html>

<?php
  db_disconnect($db);
?>