<?php

	/**
	 * Export data
	 */
	define('MYEXPORT_ERROR_INVALID_FORMAT','The export format is invalid.');
	define('MYEXPORT_ERROR_CREATE_FILE','Unable to create the specific file.');

	/**
	 * Dynamic list
	 */
	define('GOTO_LAST_PAGE','Go to the last page'); 	
	define('GOTO_FIRST_PAGE','Go to first page');
	define('GOTO_NEXT_PAGE','Go to next page');
	define('GOTO_BACK_PAGE','Go to previous page');
	
	define('LABEL_FIELDSET_ADD_RULE_FORM','Filter parameters');
	define('LABEL_RELATION_SELECT_OPT_EQUAL','Equal');
	define('LABEL_RELATION_SELECT_OPT_DIFERENT','Different');
	define('LABEL_RELATION_SELECT_OPT_GRE_THEN','Greater than to');
	define('LABEL_RELATION_SELECT_OPT_GRE_EQUAL_THEN','Greater than or equal to');
	define('LABEL_RELATION_SELECT_OPT_LSS_THEN','Less than to');
	define('LABEL_RELATION_SELECT_OPT_LSS_EQUAL_THEN','Less than or equal to');
	
	define('LABEL_STATUS_RULE_FORM','Status');
	define('LABEL_LOGIC_FIELD_ADD_RULE_FORM','logic Union');
	define('LABEL_RELATION_FIELD_ADD_RULE_FORM','Operator');
	define('LABEL_RELATION_OPTAND_ADD_RULE_FORM','AND');
	define('LABEL_RELATION_OPTOR_ADD_RULE_FORM','OR');
	define('LABEL_FIELD_LIST_ADD_RULE_FORM','Field');
	define('LABEL_CASE_SENSITIVE_LIST_ADD_RULE_FORM','Upper and Lower Case Sensitive');
	define('LABEL_FIELD_VALUE_ADD_RULE_FORM','Value');
	define('LABEL_HELP_RELOAD_LIST_FORM','Update');
	define('LABEL_HELP_APPLY_RULE_FORM','Apply filters');
	define('LABEL_HELP_REM_RULE_FORM','Remove this filter');
	define('LABEL_USELIMIT_RULE_FORM','Limit');
	define('LABEL_BUTTON_DOWNLOAD_FILE_EXPORT','Export');
	define('LABEL_FIRST_OPT_SELECT_GLOBAL_ACTION','Select...');
	define('TITLE_WINDOW_HELP_MYLIST','Help Dynamic list');
	define('TITLE_MWINDOW_FILEDS_TO_SHOW','Fields to export');
	
	define('LABEL_HELP_SELECT_GLOBAL_ACTION','Select an option');
	define('LABEL_HELP_ADD_RULE_QUERY_BUTTON_FORM','Add filter');
	define('LABEL_HELP_EXCEL_BUTTON_FORM','Export to Excel.');
	define('LABEL_HELP_HTML_BUTTON_FORM','Export to Html.');
	define('LABEL_HELP_PDF_BUTTON_FORM','Export to Pdf.');
	define('LABEL_HELP_PAGACT_FORM','Current page:');
	define('LABEL_HELP_CHPAG_SELECT_FORM','Records per page.');
	define('LABEL_HELP_USELIMIT_RULE_FORM','Apply limit records');
	define('LABEL_HELP_SELECT_FILEDS_TOSHOW','Select (<b>Ctrl + Click</b>) the fields you want displayed in the file.');
	
	define('MSG_FAILED_MAKE_ACTIVE_TAB','You must specify a <a href="http://www.osezno-framework.org/doc/OPF/OPF_myController.html#methodMYTAB_makeActive" target="_blank"><font style="font-size: 14px;">group Id</font></a>.');
	define('MSG_FAILED_SHOW_FILTER_MUST_PROVIDE_REAL_NAME','You must specify at least one field with a <a href="http://www.osezno-framework.org/doc/OPF/OPF_myList.html#methodsetRealNameInQuery" target="_blank"><font style="font-size: 14px;">alias</font></a>.');
	define('MSG_FAILED_SHOW_FILTER_NO_RECORDS_FOUND','You can not add filters because no records were found.');
	define('MSG_FAILED_ORDER_BY_FIELD_MUST_PROVIDE_REAL_NAME','You must specify an <a href="http://www.osezno-framework.org/doc/OPF/OPF_myList.html#methodsetRealNameInQuery"><font style="font-size: 14px;">alias</font></a> for this field.');
	define('MSG_FAILED_SELECT_FIELD_TO_SHOW','You must select at least one field to show.');
	define('MSG_SELECT_FIELD_TO_SHOW','Select (<b>Ctrl + Click</b>) the fields you want displayed in the file.');
	define('MSG_APPLY_RULES_ALL_VALUES_NULL','You should write at least one value.');
	define('MSG_RESTART_QUERY_LIST','The query has been reset');
	define('MSG_QUERY_FORM_OK','Filter applied.');
	define('MSG_QUERY_FORM_BAD','Failed to execute query');
	define('MSG_QUERY_FORM_NULL','The value is required.');
	define('MSG_QUERY_FORM_NOROWS','No records to show.');
	
	define('MSG_ERROR_IDLIST_NOTDEFINED','The dynamic list is not defined.');
	
	/**
	 *Templates
	 */	
	define('MSG_TEMPLATE_NO_FOUND','When trying to use the template.');
	define('MSG_TEMPLATE_NO_FOUND_DET','The file path does not exist or is not accessible');

	/**
	 * Message box / Errors
	 */
	define('MSGBOX_TITLE','System Information');
	define('MSGBOX_TITLE_CRITICAL','Critical System Error');
	define('MSGBOX_TITLE_ERROR','System Error');
	define('MSGBOX_TITLE_HELP','Help System');
	define('MSGBOX_TITLE_LIST','Record Information');
	define('MSGBOX_TITLE_USER','User Information');
	define('MSGBOX_TITLE_WARNING','Alert System');
	
	define('MSGBOX_STR_UNI_BUTTON','Ok');
	
	define('ERROR_DET_LABEL','Details of the error');
	define('ERROR_LABEL','Error in');
	
	/**
	 * Reportes generados de Listas dinamicas
	 */
	define('REPORT_TITLE','Report parameterized query from: ');
	
	/**
	 * Calendar
	 */
	define('CAL_MONTH1_LABEL','January');
	define('CAL_MONTH2_LABEL','February');
	define('CAL_MONTH3_LABEL','March');
	define('CAL_MONTH4_LABEL','April');
	define('CAL_MONTH5_LABEL','May');
	define('CAL_MONTH6_LABEL','June');
	define('CAL_MONTH7_LABEL','July');
	define('CAL_MONTH8_LABEL','August');
	define('CAL_MONTH9_LABEL','September');
	define('CAL_MONTH10_LABEL','October');
	define('CAL_MONTH11_LABEL','November');
	define('CAL_MONTH12_LABEL','December');
	
	define('CAL_WK_LABEL','WK');
	
	define('CAL_DAY1_LABEL','M');
	define('CAL_DAY2_LABEL','T');
	define('CAL_DAY3_LABEL','W');
	define('CAL_DAY4_LABEL','T');
	define('CAL_DAY5_LABEL','F');
	define('CAL_DAY6_LABEL','S');
	define('CAL_DAY7_LABEL','S');
?>