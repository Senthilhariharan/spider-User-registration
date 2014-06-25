<!doctype html>
<html>

<style>
body{
	font-family:Tahoma, Geneva, sans-serif;
	}
#container{
	width:450px;
	background-color:rgba(250,250,252,.9);
	margin:auto;
	margin-top:10px;
	margin-bottom:10px;
	box-shadow:0 0 3px #999;
	
	}
#container_body{
	padding:20px;

	}
input{
	width:375px;
	padding:5px;
	font-size:18px;
	}
#radio_button{
	padding:10px 0 0 0;
	}
#dateofb{
width:10px;
padding:5px;
font-size:18px;
}
#button{

font-size:14px;
	color:#FFF;
	text-align:center;
	background-color:#3B5998;
	padding:10px;
	margin-top:10px;
	cursor: pointer;
justify-content: center; 
}
#git{
width:200px;
}
</style>

<script>
function validateForm()
{
var uid = document.forms["form"]["user"].value;
var passid = document.forms["form"]["pass"].value;  
var ufname = document.forms["form"]["fname"].value; 
var ulname = document.forms["form"]["lname"].value; 
var rpass = document.forms["form"]["repass"].value;
var bar=document.forms["form"]["branch"].value;

if(bar=="")
{
alert("Enter your Branch");
}

var ck_id =  /^[A-Za-z0-9-]/;

            if(!ck_id.test(uid))
            {

                alert("UserID can only contain alphanumeric characters and hypehns(-)");
		return false;
            }
var lnam =  /^[A-Za-z]/;

            if(!lnam.test(ulname))
            {

                alert("Lastname can only contain alphabet characters");
		return false;
            }

if(rpass == passid)
{
    var x = document.forms["form"]["email"].value;
    var atpos = x.indexOf("@");
    var dotpos = x.lastIndexOf(".");
    if (atpos< 1 || dotpos<atpos+2 || dotpos+2>=x.length) {
        alert("Not a valid e-mail address");
        return false;
    }
var passid_len = passid.length;  
if (passid_len == 0 || passid_len < 6)  
{  
alert("Passsword should not be empty / length be more than 6 char");  

return false;  
}
 
var letters = /^[A-Za-z]+$/;  
if(ufname.match(letters))  
{  
return true;  
}  
else  
{  
alert('Firstname must have alphabet characters only');  
 return false;  
}

  
 
}

else
{
alert("Passsword and Retype password must be same");  

return false;
}

}
</script>
<head>
<title>Register</title>
</head>
<body>

<p><a href="register.php">Register</a> | <a href="login.php">Login</a></p>
<h3>Registration Form</h3>
<div id ="container">
<div id="container_body">
<form action="" method="POST" name="form" onsubmit="return validateForm();" enctype="multipart/form-data">
*<input type="text" name="fname" placeholder="Firstname"><br />
<input type="text" name="lname" placeholder="Lastname"><br />
*<input type="text" name="user" placeholder="Username"><br />
*<input type="text" name="email" placeholder="Email" ><br />
*<input type="password" name="pass" placeholder="Password"><br />
*<input type="password" name="repass" placeholder="Retype Password"><br />
*<input type="radio" name="gender" value="male" style="width:30px;" <?php if(@$gender=='male')echo 'checked="true"';?> 
                                                <?php if(!isset($gender))echo 'checked="true"';?>/> male 
                                                <input type="radio" name="gender" value="female" style="width:30px;"
                                                <?php if(@$gender=='female')echo 'checked="true"';?> /> female<br/>

*<input type="number" name="day" value="<?=@$day?>" size=2 style="width:50px;" id="day"/>/
                    <input type="number" name="month" value="<?=@$month?>" size=2 style="width:50px;" id="month"/>/
                    <input type="number" name="year" value="<?=@$year?>" size=4 style="width:80px;" id="year"/> (DD/MM/YYYY)<br/>
				
https://github.com/<input type="text" name="git" placeholder="GitHub Username" id="git"></br>

*<select name ="branch">
<option value="">Branch</option>
<option value="ICE">ICE</option>
<option value="ECE">ECE</option>
<option value="EEE">EEE</option>
<option value="MECH">MECH</option>
<option value="PROD">PROD</option>
<option value="CS">CS</option>
<option value="CHEM">CHEM</option>
<option value="META">META</option>
</select>												
<div><textarea name="bio" placeholder=" Your interests"  id><?=@$bio?></textarea></div>
<

<input type="file" name="image"><br>

<input type="submit" value="Register" name="submit" id="button" />
</div>
</div>
</form>


<?php

if(isset($_POST["submit"])){

if(!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['repass']) && !empty($_POST['fname']) && !empty($_POST['email']) && !empty($_POST['month']) && !empty($_POST['year']) && !empty($_POST['day']) && !empty($_POST['gender']) && !empty($_POST['branch'])) {
	$user=$_POST['user'];
	$pass=sha1($_POST['pass']);
	$fn=$_POST['fname'];
	$ln=$_POST['lname'];
	$em=$_POST['email'];
	$git=$_POST['git'];
	$gender = $_POST['gender'];
	 $day   = $_POST['day'];
        $month             = $_POST['month'];
        $year             = $_POST['year'];
        $dob            = "$year-$month-$day";
		$date = date("y-m-d",strtotime($dob));
		$branch        = $_POST['branch'];
		$bio                = $_POST['bio'];
		$file = $_FILE['image']['tmp_name'];
	$con=mysql_connect('localhost','root','') or die(mysql_error());
	mysql_select_db('user_registration') or die("cannot select DB");
	$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
	$image_name = addslashes($_FILES['image']['name']);
	$image_size = getimagesize($_FILES['image']['tmp_name']);
	
	$query=mysql_query("SELECT * FROM login WHERE username='".$user."'");
	$numrows=mysql_num_rows($query);
	if($numrows==0)
	{
	$sql="INSERT INTO login(username,password,fname,lname,email,gender,dob,branch,git,bio,profile) VALUES('$user','$pass','$fn','$ln','$em','$gender','$date','$branch','$git','$bio','$image')";

	$result=mysql_query($sql);


	if($result){
	echo "Account Successfully Created";
	echo $image_name;
	} else {
	echo "Failure!";
	}

	} else {
	echo "That username already exists! Please try again with another.";
	}

} else {
	echo "All fields are required!";
}
}
?>

</body>
</html>
