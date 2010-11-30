@CHARSET "ISO-8859-1";

#div_tab {
  float:left;
  width:100%;
  background:#DAE0D2 url("<?php echo $_GET['path_img']; ?>bg.gif") repeat-x bottom;
  font-size:93%;
  line-height:normal;
}

#div_tab ul {
  margin:0;
  padding:0px 0px 0;
  list-style:none;
 }

#div_tab li {
  float:left;
  background:url("<?php echo $_GET['path_img']; ?>left.gif") no-repeat left top;
  margin:0;
  padding:0 0 0 9px;
  }

#div_tab span {
  float:left;
  display:block;
  background:url("<?php echo $_GET['path_img']; ?>right.gif") no-repeat right top;
  padding:2px 15px 5px 6px;
  text-decoration:none;
  font-weight:normal;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12px;
  color:#FFFFFF;
  cursor:pointer;
  }

/* Commented Backslash Hack
   hides rule from IE5-Mac \*/

#div_tab span {float:none;}

/* End IE5-Mac hack */

#div_tab span:hover {
  color:#000;
  font-family: Arial, Helvetica, sans-serif;
  font-size: 12px;
}

#div_tab .current {
  background-image:url("<?php echo $_GET['path_img']; ?>left_on.gif");
}

#div_tab .current span {
  background-image:url("<?php echo $_GET['path_img']; ?>right_on.gif");
  color:#333;
  padding-bottom:5px;
}

#content_tab {
  text-align: justify;
  padding: 5px;
}