<div id="{div_name}" style="overflow: hidden;{div_height}{tabla_display}{tabla_opacity}">
	<table border="0" width="{tabla_width}" height="{tabla_height}" cellspacing="0" cellpadding="0">
		<tr height="27">
			<td width="7" class="mw_top_left">&nbsp;</td>
			<td class="mw_top_center" onMouseDown="js_drag(event)" onMouseOver="this.style.cursor='move'">
				<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0">
					<tr>
						<td width="16"><img src="../../../common/icon.gif"></td>
						<td width="96%" class="tit_mw">&nbsp;{html_title}</td>
						<td width="4%" align="left"><a href="javascript:;" onclick="closeModalWindow()"><div class="buttom_close_mw"></div></a></td>
					</tr>
				</table>
			</td>
			<td width="14" class="mw_top_right">&nbsp;</td>
		</tr>
		<tr height="{height_main}">
			<td class="mw_center_left">&nbsp;</td>
			<td class="mw_center_middle" valign="top" align="center"><div id="{div_name}_work" style="WIDTH:{width_area}px;HEIGHT:{height_area}px;overflow: auto;" class="cont_mw">{html_content}</div></td>
			<td class="mw_center_right">&nbsp;</td>
		</tr>
		<tr height="27">
			<td class="mw_bottom_left">&nbsp;</td>
			<td class="mw_bottom_center">&nbsp;</td>
			<td class="mw_bottom_right">&nbsp;</td>
		</tr>
	</table>
</div>