<div id="message_box">
<table border="0" cellspacing="0" cellpadding="0" height="{height_msg_box}" width="{width_msg_box}">
		<tr>
			<td class="top_left" width="5">&nbsp;</td>
			<td class="top_center" onMouseDown="js_drag(event)" onMouseOver="this.style.cursor='move'">
			
				<table border="0" cellpadign="0" cellspacing="0" align="center" width="100%">
					<tr>
						<td width="5%">&nbsp;</td>
						<td width="90%" class="tit_msg_box">{titl_msg}</td>
						<td width="5%"><a href="javascript:;" onclick="closeModalWindow()"><div class="buttom_close"></div></a></td>
					</tr>
				</table>
				
			</td>
			<td width="10" class="top_right">&nbsp;</td>
		</tr>
		<tr>
			<td class="center_left">&nbsp;</td>
			<td class="center_middle">
				<table height="100%" width="100%" border="0" cellpadign="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td valign="top">
							<table height="100%" border="0" cellpadign="0" cellspacing="0" border="0">
								<tr>
									<td width="15%" align="center" valign="middle"><div class="{class_div_img}"></div></td>
		   							<td width="85%" valign="top"><div class="cont_msg_box">{cont_msg_box}</div></td>
								</tr>
							</table>
						</td>
						<td>&nbsp;</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td align="center"><br><form id="message_box_buttons" name="message_box_buttons">{cont_form}</form></td>
						<td>&nbsp;</td>
					</tr>
				</table>
			</td>
			<td class="center_right">&nbsp;</td>
		</tr>
		<tr>
			<td class="bottom_left">&nbsp;</td>
			<td class="bottom_center">&nbsp;</td>
			<td class="bottom_right">&nbsp;</td>
		</tr>
</table>
</div>