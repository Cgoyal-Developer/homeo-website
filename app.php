<html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Anand Homeo Clinic</title>

  <meta name="viewport" content="width=device-width, initial-scale =1.0">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="app.css">
  <script src="https://kit.fontawesome.com/a076d05399.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js">
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js">
  </script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js">
  </script>

</head>

<body>
<?php
  
  include 'header.php';
 
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "app";
if(isset($_POST['name'])){
$name= $_POST['name'];
$email= $_POST['email'];
$address= $_POST['address'];
$phone= $_POST['phone'];
$date= $_POST['date'];
$time= $_POST['time'];


$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
  $sql = "INSERT INTO app (name, email, address, phone, date, time)
  VALUES ('$name', '$email', '$address', '$phone', '$date', '$time')";
  // use exec() because no results are returned
  if (mysqli_query($conn, $sql)) {
    echo "<script>
    alert('Done Appointment ') </script>";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }


$conn = null;
}
?>

    <!--Appointment Section-->
    <section class="appointment-section">
      <div class="container">
          <div class="sec-title">
             
                <h2>Make an Appoinment</h2>
            </div>
            <div class="row clearfix">
            
              <!--Form Column-->
              <div class="form-column col-md-8 col-sm-12 col-xs-12">
                  <div class="inner-column">
                      
                        <!-- Default Form -->
                        <div class="default-form">
                                
                            <!--Contact Form-->
                            <form method="post" action="">
                                <div class="row clearfix">
                                
                                    <div class="column col-md-6 col-sm-6 col-xs-12">
                                        
                                        <div class="form-group">
                                            <input type="text" name="name" placeholder="Name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="address" placeholder="Address" required>
                                        </div>

                                        
                                        <div class="form-group">
                                            <input type="text" class="datepicker" name="date" placeholder="Schedule Date" required>
                                            <i class="far fa-calendar-alt" ></i>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="column col-md-6 col-sm-6 col-xs-12">
                                        
                                        <div class="form-group">
                                            <input type="email" name="email"  placeholder="Email" required>
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="text" name="phone" placeholder="Phone" required>
                                        </div>
                                        <div class="form-group">
                                            <select name="time" id="">
                                                
                                             <option value="default" default>Select Appoinment Time</option>
                                                <option value="8-9">8.00 AM- 9.00 AM</option>
                                                <option value="9-10">9.00 AM- 10.00 AM</option>
                                                <option value="9-10">10.00 AM- 11.00 AM</option>
                                                <option value="9-10">11.00 AM- 12.00 AM</option>
                                                <option value="9-10">12.00 AM- 1.00 PM</option>
                                                <option value="9-10">1.00 PM- 2.00 PM</option>
                                                <option value="9-10">2.00 PM- 3.00 PM</option>
                                                <option value="9-10">3.00 PM- 4.00 PM</option>
                                                <option value="9-10">4.00 PM- 5.00 PM</option>
                                                <option value="9-10">5.00 PM- 6.00 PM</option>
                                            
                                                
                                                
                                            </select>
                                        </div>
                                        
                                      
                                        
                                    </div>
                                
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                        <button class="theme-btn appointment-btn" type="submit" name="submit-form">Make An Appoinment</button>
                                    </div>
                                    
                                </div>
                            </form>
                                
                        </div>
                        <!--End Default Form -->
                        
                    </div>
                </div>
                
                <!--Form Column-->
              <div class="schedule-column col-md-4 col-sm-12 col-xs-12">
                  <div class="inner-outer">
                        <div class="inner-column">
                            <h2>Business Hours:</h2>
                            <ul class="time-list">
                                <li>Monday - Friday 9.30 AM - 2.30 PM</li>
                                <li>Night - 5.00 AM - 8.30 PM</li>
                                <li><strong>Sunday - 10.00am to 2.00pm</strong></li>
                              
                            </ul>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

  <?php
  
  include 'footer.php';
?>
</body>

</html>