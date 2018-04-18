<?php

  function getUsers() {
    global $db;
    
    $query = "SELECT first_name, last_name FROM users";
    $result = $db->query($query);
    return $result;
  }
  /**
  * getNextBirthday: queries database to calculate days until next birthday.
  * @param - $name: first and last name of person
  * @return - mysqli_result object with fields: name, birthday, days_until_bday
  */
  function getNextBirthday($name) {
    global $db;
    
    $nameParts = explode(' ', $name);
    $first = "%".$nameParts[0]."%";
    $last = "%".$nameParts[1]."%";
    
    $query = "SELECT CONCAT( first_name, ' ', last_name) name,
      birthday,
      CASE WHEN TO_DAYS(CONCAT('0000-', MONTH(birthday), '-', DAY(birthday))) -
          TO_DAYS(CONCAT('0000-', MONTH(CURDATE()), '-', DAY(CURDATE()))) < 0
        THEN 
          TO_DAYS(CONCAT('0001-', MONTH(birthday), '-', DAY(birthday))) -
          TO_DAYS(CONCAT('0000-', MONTH(CURDATE()), '-', DAY(CURDATE())))
        ELSE 
          TO_DAYS(CONCAT('0000-', MONTH(birthday), '-', DAY(birthday))) -
          TO_DAYS(CONCAT('0000-', MONTH(CURDATE()), '-', DAY(CURDATE())))
      END days_until_bday
    FROM users
    WHERE first_name LIKE ?
    AND last_name LIKE ?;";
    
    // Prepared statement ceremony
    $statement = $db->prepare($query);
    $statement->bind_param("ss", $first, $last);
    $statement->execute();
    $result = $statement->get_result();
    return $result;
  }
  
  /**
  * getEventInformation: query database to get event information
  * @param - $name: first and last name of person
  * @return - mysqli_result object with fields: event_name, event_description, goal_description,
  *   start_date, end_date, goal_minutes, used_minutes, location_name
  */
  function getEventInformation($name) {
    global $db;
    
    $nameParts = explode(' ', $name);
    $first = "%".$nameParts[0]."%";
    $last = "%".$nameParts[1]."%";
    
    $query = "SELECT e.event_name,
      e.event_description,
      g.goal_description,
      g.start_date,
      g.end_date,
      g.duration AS goal_minutes,
      ut.duration AS used_minutes,
      l.location_name
    FROM events e
    LEFT OUTER JOIN goals g ON e.event_id = g.event_id
    LEFT OUTER JOIN locations l ON e.location_id = l.location_id
    LEFT OUTER JOIN used_time ut ON e.event_id = ut.event_id
    JOIN users u ON u.user_id = e.user_id
    WHERE u.first_name LIKE ?
    AND u.last_name LIKE ?;";
    
    // Prepared statement ceremony
    if($statement = $db->prepare($query)) {
      $statement->bind_param("ss", $first, $last);
      $statement->execute();
      $result = $statement->get_result();
      return $result;
    } else {
      $error = $db->errno . ' ' . $db->error;
      echo $error;
    }
  }
  
  /**
  * getEventList: query database to get an event list for a user
  * @param - $name: first and last name of person
  * @return - mysqli_result object with  fields: event_name
  */
  function getEventList($name) {
    global $db;
    
    $nameParts = explode(' ', $name);
    
    // Check if name is empty
    if(!empty($nameParts) && $nameParts[0] !== ''){
      $first = "%".$nameParts[0]."%";
      $last = "%".$nameParts[1]."%";
    } else {
      return;
    }
    
    $query = "SELECT event_name 
      FROM events
      WHERE user_id IN (
        SELECT user_id 
        FROM users
        WHERE first_name LIKE ?
        AND last_name LIKE ?
       )";
     
     // Prepared statement ceremony
    if($statement = $db->prepare($query)) {
      $statement->bind_param("ss", $first, $last);
      $statement->execute();
      $result = $statement->get_result();
      return $result;
    } else {
      $error = $db->errno . ' ' . $db->error;
      echo $error;
    }
  }
  
  function getTimeByEvent($event) {
    global $db;
    
    $eventName = '%'.$event.'%';
    
    $query = "SELECT time_in, time_out
    FROM times
    WHERE event_id IN (
      SELECT event_id
      FROM events
      WHERE event_name LIKE ?
     )";
     
      // Prepared statement ceremony
    if($statement = $db->prepare($query)) {
      $statement->bind_param("s", $eventName);
      $statement->execute();
      $result = $statement->get_result();
      return $result;
    } else {
      $error = $db->errno . ' ' . $db->error;
      echo $error;
    }
  }
  
  function getMinutesSpent($event) {
    global $db;
    
    $eventName = '%'.$event.'%';
    
    $query = "SELECT CONCAT(
      FLOOR(u.duration / 60),
      ':',
      LPAD(u.duration % 60, 2, 0)
      ) actual,
    CONCAT(
      FLOOR(g.duration / 60),
      ':',
      LPAD(g.duration % 60, 2 , 0)
      ) goal
    FROM used_time u 
    JOIN goals g ON g.event_id = u.event_id
    WHERE g.event_id IN (
      SELECT event_id
      FROM events
      WHERE event_name LIKE ?
      )";
     
      // Prepared statement ceremony
    if($statement = $db->prepare($query)) {
      $statement->bind_param("s", $eventName);
      $statement->execute();
      $result = $statement->get_result();
      return $result;
    } else {
      $error = $db->errno . ' ' . $db->error;
      echo $error;
    }
  }
?>