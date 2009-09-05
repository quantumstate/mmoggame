<?php
header('Content-type: text/css');

session_start(); 

switch ($_SESSION['stylesheet']){
case 'blue':
	$menucolor="eeeeFF";
	$maincolor="3b3bff";
	$bgtop="images/bluebgtop.jpg";
	$textcolor="000000";
break;

case 'green':
	$menucolor="EFFFF1";
	$maincolor="0B8C1B";
	$bgtop="images/greenbgtop.jpg";
	$textcolor="000000";
break;

case 'red':
	$menucolor="ffe9e9";
	$maincolor="df0000";
	$bgtop="images/redbgtop.jpg";
	$textcolor="000000";
break;

case 'turq':
	$menucolor="deebf1";
	$maincolor="6599b7";
	$bgtop="images/turqbgtop.jpg";
	$textcolor="000000";
break;

default:
	$menucolor="deebf1";
	$maincolor="85b9c7";
	$bgtop="images/turqbgtop.jpg";
	$textcolor="000000";
break;
}
if ($textcolor==''){$textcolor=$maincolor;}
?>

body{
font-size:80%;
font-family: verdana, arial, sans-serif;
color:#<?php echo $textcolor;?>;
background-image:url("<?php echo $bgtop;?>");
background-repeat:repeat-x;
padding:0px;
}

#right{
margin-left:5px;
margin-top:180px;
float:left;
width:165px;
}

#main{
margin-top:125px;
float:left;
width:480px;
}

#menu{
margin-top:150px;
float:left;
width:125px;
}

#stylepicker{
position:absolute;
top:80px;
left:620px;
}

#topmenu{
position:absolute;
top:70px;
left:320px;
}

input.boxes{
border:1px solid #<?php echo $maincolor;?>;
}

u{
color:#<?php echo $maincolor;?>;
}

h1,h2{
color:#<?php echo $maincolor;?>;
}

th{
color:#<?php echo $maincolor;?>;
}

img{
border:0;
}

td,table{
border-color:#<?php echo $maincolor;?>;
}

tr.highlight{
background-color:#<?php echo $menucolor;?>;
}

tr.normal{
background-color:#FFFFFF;
}

ul
{
padding: 0;
margin: 10px;
margin-left:20px;
}

ul.mainmenu
{
list-style-type: none;
padding: 0;
margin: 0;
}

ul.mainmenu li{
margin-top:5px;
margin-bottom:5px;
border-style:solid none solid none;
border-width:1px;
border-color:transparent;
width:100px;
}

ul.mainmenu li a{
color:#<?php echo $maincolor;?>;
text-decoration:none;
}

a{
color:#<?php echo $maincolor;?>;
}

ul.mainmenu li:hover{
border-color:#<?php echo $maincolor;?>;
background-color:#<?php echo $menucolor;?>;
}



div.cover{
position:absolute;
top:0;
left:0;
width:100%;
height:5000px;
background-image:url("images/overlay.png");
display:none;
cursor:default;
}

div.middle{
-moz-border-radius:15px;
border-style: double;
border-color:#<?php echo $maincolor;?>;
margin-left:auto;
margin-right:auto;
position:relative;
padding:10px;
top:130px;
width:400px;
background-color:#FFFFFF;
}

a.pop:focus div.cover{
display:block;
}