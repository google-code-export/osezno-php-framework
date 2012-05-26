<?php header ('Content-type: text/javascript'); ?> 

call_bar_info ();

function call_bar_info (){
	
	document.write('<div id="taskbar"><div id="container" align="right"><table width="800px"><tr><th>Memory used:</th><td><div id="memory_usage">'+'<?php echo $_GET['memory']; ?>'+' Mb</div></td><th>Files included:</th><td><div id="get_included_files">'+<?php echo $_GET['get_included_files']; ?>+' Files</div></td><th>Execution time:</th><td><div id="time_exescuted"><?php echo $_GET['time_executed']; ?> Seconds</div></td></tr></table></div></div>');
	
}