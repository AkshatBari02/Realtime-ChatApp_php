<?php
  session_start();
  if(isset($_SESSION['unique_id'])){
    header("location: users.php");
  }
?>

<?php include_once "header.php";?>
  <body>
    <div class="wrapper">
      <section class="form signup">
        <header>Realtime Chat App</header>
        <form action="#" method="POST" enctype="multipart/form-data">
          <div class="error-txt"></div>
          <div class="name-details">
            <div class="field input">
              <label>First Name</label>
              <input type="text" placeholder="First Name" name="fname" required />
            </div>
            <div class="field input">
              <label>Lasst Name</label>
              <input type="text" placeholder="Last Name" name="lname" required />
            </div>
          </div>
          <div class="field input">
            <label>Email Address</label>
            <input type="email" placeholder="Enter your email" name="email" required />
          </div>
          <div class="field input">
            <label>Password</label>
            <input type="password" placeholder="Enter new password" name="password" required />
            <i class="fas fa-eye"></i>
          </div>
          <div class="field input image">
            <label>Select Image</label>
            <input type="file" name="image" required/>
          </div>
          <div class="field input button">
            <input type="submit" name="submit" value="Continue to Chat" />
          </div>
        </form>
        <div class="link">Already signed up? <a href="login.php">Login now</a></div>
      </section>
    </div>

    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/signup.js"></script>
  </body>
</html>



<!-- DataBase--(chat)
    Tables--(messages,users)

    table--messages--{
      msg_id:type(int(255)),Extra(auto_increment),
      outgoing_msg_id:type(int(255)),
      incoming_msg_id:type(int(255)),
      msg:varchar(1000)
    },

    table--users--{
      user_id:type(int(11)),Extra(auto_increment),
      unique_id:type(int(200)),
      fname:type(varchar(255)),
      lname:type(varchar(255)),
      email:type(varchar(255)),
      password:type(varchar(255)),
      img:type(varchar(400)),
      status:type(varchar(255))
    }
-->