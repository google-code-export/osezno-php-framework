<div id="message_box" style="overflow: hidden;{div_height}{tabla_display}{tabla_opacity}">
	<table border="0" width="{width_msg_box}" height="{height_msg_box}" cellspacing="0" cellpadding="0">
		<tr height="27">
			<td width="7" class="top_left">&nbsp;</td>
			<td class="top_center" onMouseDown="js_drag(event)" onMouseOver="this.style.cursor='move'">
				<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td width="5%">&nbsp;</td>
						<td width="90%" class="tit_msg_box">{titl_msg}</td>
						<td width="5%"><a href="javascript:;" onclick="closeModalWindow()"><div class="buttom_close"></div></a></td>
					</tr>
				</table>
			</td>
			<td width="14" class="top_right">&nbsp;</td>
		</tr>
		<tr height="{height_main}">
			<td class="center_left">&nbsp;</td>
			<td class="center_middle" valign="top" align="left">
			
				<div id="message_box_work" style="WIDTH:{width_area}px;HEIGHT:{height_area}px;overflow: auto;" class="cont_mw">			
				<table height="100%" width="100%" border="0" cellpadign="0" cellspacing="0">
					<tr>
						<td valign="top" height="90%">
							<table width="100%" height="100%" border="0" cellpadign="0" cellspacing="0" border="0">
								<tr>
									<td width="15%" align="center" valign="middle"><div class="{class_div_img}"></div></td>
		   							<td width="85%" valign="top"><div class="cont_msg_box">{cont_msg_box}</div></td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" valign="middle">
							<form id="message_box_buttons" name="message_box_buttons">{cont_form}</form>
						</td>
					</tr>
				</table>			
				</div>			
				
			</td>
			<td class="center_right">&nbsp;</td>
		</tr>
		<tr height="27">
			<td class="bottom_left">&nbsp;</td>
			<td class="bottom_center">&nbsp;</td>
			<td class="bottom_right">&nbsp;</td>
		</tr>
	</table>
</div>