<?php

	/**
	 * Exportar datos
	 */
	define('MYEXPORT_ERROR_INVALID_FORMAT','El formato a exportar no es valido.');
	define('MYEXPORT_ERROR_CREATE_FILE','No es posible crear el archivo especifico.');

	/**
	 * Listas dinamicas
	 */
	define('GOTO_LAST_PAGE','Ir a la ultima p&aacute;gina encontrada'); 	
	define('GOTO_FIRST_PAGE','Ir a la primera p&aacute;gina');
	define('GOTO_NEXT_PAGE','Ir a la siguiente p&aacute;gina');
	define('GOTO_BACK_PAGE','Ir a la anterior p&aacute;gina');
	
	define('LABEL_FIELDSET_ADD_RULE_FORM','Parametros de la regla');
	define('LABEL_RELATION_SELECT_OPT_EQUAL','Igual');
	define('LABEL_RELATION_SELECT_OPT_DIFERENT','Diferente');
	define('LABEL_RELATION_SELECT_OPT_GRE_THEN','Mayor');
	define('LABEL_RELATION_SELECT_OPT_GRE_EQUAL_THEN','Mayor igual');
	define('LABEL_RELATION_SELECT_OPT_LSS_THEN','Menor');
	define('LABEL_RELATION_SELECT_OPT_LSS_EQUAL_THEN','Menor igual');
	
	define('LABEL_STATUS_RULE_FORM','Estado');
	define('LABEL_LOGIC_FIELD_ADD_RULE_FORM','Uni&oacute;n l&oacute;gica');
	define('LABEL_RELATION_FIELD_ADD_RULE_FORM','Operador');
	define('LABEL_RELATION_OPTAND_ADD_RULE_FORM','Y');
	define('LABEL_RELATION_OPTOR_ADD_RULE_FORM','O');
	define('LABEL_FIELD_LIST_ADD_RULE_FORM','Campo');
	define('LABEL_CASE_SENSITIVE_LIST_ADD_RULE_FORM','Sensible a May&uacute;sculas y Min&uacute;sculas');
	define('LABEL_FIELD_VALUE_ADD_RULE_FORM','Valor');
	define('LABEL_HELP_RELOAD_LIST_FORM','Actualizar datos');
	define('LABEL_HELP_APPLY_RULE_FORM','Aplicar filtros');
	define('LABEL_HELP_REM_RULE_FORM','Remover este filtro');
	define('LABEL_USELIMIT_RULE_FORM','Límite');
	define('LABEL_BUTTON_DOWNLOAD_FILE_EXPORT','Exportar');
	define('LABEL_FIRST_OPT_SELECT_GLOBAL_ACTION','Seleccione...');
	define('TITLE_WINDOW_HELP_MYLIST','Ayuda listas din&aacute;micas');
	define('TITLE_MWINDOW_FILEDS_TO_SHOW','Campos a exportar');
	
	define('LABEL_HELP_SELECT_GLOBAL_ACTION','Seleccione una opci&oacute;n');
	define('LABEL_HELP_ADD_RULE_QUERY_BUTTON_FORM','Agregar filtro');
	define('LABEL_HELP_EXCEL_BUTTON_FORM','Exportar a Excel.');
	define('LABEL_HELP_HTML_BUTTON_FORM','Exportar a Html.');
	define('LABEL_HELP_PDF_BUTTON_FORM','Exportar a Pdf.');
	define('LABEL_HELP_PAGACT_FORM','P&aacute;gina actual:');
	define('LABEL_HELP_CHPAG_SELECT_FORM','Registros por p&aacute;gina.');
	define('LABEL_HELP_USELIMIT_RULE_FORM','Aplicar limite de registros');
	define('LABEL_HELP_SELECT_FILEDS_TOSHOW','Seleccione (<b>Ctrl + Click</b>) los campos que desea mostrar en el archivo.');
	
	define('MSG_FAILED_MAKE_ACTIVE_TAB','Debe especificar un <a href="http://www.osezno-framework.org/doc/OPF/OPF_myController.html#methodMYTAB_makeActive" target="_blank"><font style="font-size: 14px;">ID de grupo</font></a>.');
	define('MSG_FAILED_SHOW_FILTER_MUST_PROVIDE_REAL_NAME','Debe especificar al menos un campo con <a href="http://www.osezno-framework.org/doc/OPF/OPF_myList.html#methodsetRealNameInQuery" target="_blank"><font style="font-size: 14px;">alias</font></a>.');
	define('MSG_FAILED_SHOW_FILTER_NO_RECORDS_FOUND','No es posible agregar filtros pues no se encontraron registros.');
	define('MSG_FAILED_ORDER_BY_FIELD_MUST_PROVIDE_REAL_NAME','Debe especificar un <a href="http://www.osezno-framework.org/doc/OPF/OPF_myList.html#methodsetRealNameInQuery"><font style="font-size: 14px;">alias</font></a> para este campo.');
	define('MSG_FAILED_SELECT_FIELD_TO_SHOW','Debe seleccionar al menos un campo a mostrar.');
	define('MSG_SELECT_FIELD_TO_SHOW','Seleccione (<b>Ctrl + Click</b>) los campos que desea mostrar en el archivo.');
	define('MSG_APPLY_RULES_ALL_VALUES_NULL','Debe escribir al menos un valor.');
	define('MSG_RESTART_QUERY_LIST','La consulta ha sido reiniciada');
	define('MSG_QUERY_FORM_OK','Filtro aplicado.');
	define('MSG_QUERY_FORM_BAD','Error al ejecutar la consulta');
	define('MSG_QUERY_FORM_NULL','El valor es requerido.');
	define('MSG_QUERY_FORM_NOROWS','No hay registros que mostrar.');
	
	define('MSG_ERROR_IDLIST_NOTDEFINED','La lista din&aacute;mica no esta definida.');
	
	/**
	 * Uso y manejo de palntillas
	 */	
	define('MSG_TEMPLATE_NO_FOUND','Al intentar usar la plantilla');
	define('MSG_TEMPLATE_NO_FOUND_DET','La ruta del archivo no existe o no es accesible');

	/**
	 * Message box / Errores
	 */
	define('MSGBOX_TITLE','Informaci&oacute;n del sistema');
	define('MSGBOX_TITLE_CRITICAL','Error critico del sistema');
	define('MSGBOX_TITLE_ERROR','Error del sistema');
	define('MSGBOX_TITLE_HELP','Ayuda del sistema');
	define('MSGBOX_TITLE_LIST','Informaci&oacute;n de registros');
	define('MSGBOX_TITLE_USER','Informaci&oacute;n de usuarios');
	define('MSGBOX_TITLE_WARNING','Alerta del sistema');
	
	define('MSGBOX_STR_UNI_BUTTON','Aceptar');
	
	define('ERROR_DET_LABEL','Detalle del error');
	define('ERROR_LABEL','Error en');
	
	/**
	 * Reportes generados de Listas dinamicas
	 */
	define('REPORT_TITLE','Reporte de consulta parametrizada desde: ');
	
	/**
	 * Calendario
	 */
	define('CAL_MONTH1_LABEL','Enero');
	define('CAL_MONTH2_LABEL','Febrero');
	define('CAL_MONTH3_LABEL','Marzo');
	define('CAL_MONTH4_LABEL','Abril');
	define('CAL_MONTH5_LABEL','Mayo');
	define('CAL_MONTH6_LABEL','Junio');
	define('CAL_MONTH7_LABEL','Julio');
	define('CAL_MONTH8_LABEL','Agosto');
	define('CAL_MONTH9_LABEL','Septiembre');
	define('CAL_MONTH10_LABEL','Octubre');
	define('CAL_MONTH11_LABEL','Noviembre');
	define('CAL_MONTH12_LABEL','Diciembre');
	
	define('CAL_WK_LABEL','SM');
	
	define('CAL_DAY1_LABEL','L');
	define('CAL_DAY2_LABEL','M');
	define('CAL_DAY3_LABEL','M');
	define('CAL_DAY4_LABEL','J');
	define('CAL_DAY5_LABEL','V');
	define('CAL_DAY6_LABEL','S');
	define('CAL_DAY7_LABEL','D');
?>