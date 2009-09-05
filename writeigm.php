<?php include('ingamehead.php'); ?>

<h1><?php echo $_SESSION['username'];?>'s town</h1>
<a href="igm.php">Inbox</a> | <a href="writeigm.php">Write</a> | <a href="igm.php?b=from">Sent</a><br/><br/>
<form action="sendigm.php" method="post">
To: <input type="text" value="<?php echo $_GET['to'];?>" name="to" /><br/><br/>
Subject: <input type="text" name="subject" /><br/><br/>
Message: <textarea name="content"></textarea><br/><br/>
<input type="submit" value="Send" /><br/><br/>
</form>
</div>

<div id="right">
<?php include('stat.php'); ?>

<?php include('foot.php'); ?>