<?php

/**
* Errores de acceso de clases
*/
define ('ROUTER_CLASS_NOT_FOUND','Al intentar encontrar la clase: ');
define ('ROUTER_METHOD_NOT_FOUND','Al intentar acceder al evento: ');


/**
 * Essentials OPF
 */

// Botones comunes
define('LABEL_BTN_SAVE', 'Save');
define('LABEL_BTN_ADD', 'Add');
define('LABEL_BTN_CANCEL', 'Cancel');

// Access error
define('OPF_ACCESS_NOT_VERIFY_ERROR','Security Code.');
define('OPF_ACCESS_NOT_VERIFY_DETAIL','Can not verify access, are you accessing from the menu?');
define('OPF_ACCESS_NOT_PERMITED_ERROR','Access not allowed.');
define('OPF_ACCESS_NOT_PERMITED_DETAIL','It does not have sufficient system privileges to access this module.');

//OPF_bit
define('OPF_BIT_TITLE','Essentials - System logs');
define('OPF_BIT_DESC','Event Log on the system users');

//EOPF General
define('MSG_CAMBIOS_GUARDADOS','Changes saved');
define('MSG_CAMPOS_REQUERIDOS','Required fields');
define('YES','Yes');
define('NO','No');

// Listas dinamicas
define('OPF_FIELD_ID','Id');
define('OPF_FIELD_DATETIME','Date Hour');
define('OPF_FIELD_IP','Ip');
define('OPF_FIELD_URL','Url');
define('OPF_FIELD_TABLA','Table');
define('OPF_FIELD_USUARIO','User');
define('OPF_FIELD_ACTUALIZADO','Updated');
define('OPF_FIELD_MODIFICAR','Edit');
define('OPF_FIELD_ELIMINAR','Delete');
define('OPF_FIELD_DETALLE','Detail');
define('OPF_FIELD_CODIGO','Code');
define('OPF_FIELD_DESCRIPCION','Description');
define('OPF_FIELD_NOMBRE','Name');
define('OPF_FIELD_APELLIDO','Surname');
define('OPF_FIELD_PERFIL','Profile');
define('OPF_FIELD_ESTADO','Status');
define('OPF_FIELD_PADRE','Father');
define('OPF_FIELD_ORDEN','Ord');
define('OPF_FIELD_MENU','Menu');
define('OPF_FIELD_INGRESO','Entry');
define('OPF_FIELD_FILE','File');
define('OPF_FIELD_PESO','Size');
define('OPF_FIELD_SESSNAME','Session');
define('OPF_FIELD_CERRAR','Close');
define('OPF_FIELD_ICON', 'Icon');
define('OPF_FIELD_CONFIRM_ELIMINAR','Do you want to delete the record?');
define('OPF_FIELD_CONFIRM_ELIMINAR_VARIOS','Do you want to delete these record?');

// OPF_scaffold
define('OPF_SCAFF_TITLE','Essentials - Scaffolding');
define('OPF_SCAFF_DESC','Assisted generation of modules on tables form DB');
define('OPF_SCAFF_1','Table name [Step 1]');
define('OPF_SCAFF_2','Form fields [Step 2]');
define('OPF_SCAFF_3','Realtion fields type select [Step 3]');
define('OPF_SCAFF_4','Attributes and fields of grid [Step 4]');
define('OPF_SCAFF_5','Name and description of the module [Step 5]');
define('OPF_SCAFF_6','You can not create directory:');
define('OPF_SCAFF_7_A','The directory');
define('OPF_SCAFF_7_B','already exists,');
define('OPF_SCAFF_7_C','do you want to overwrite the files?');
define('OPF_SCAFF_8_A','Failed to delete directory to overwrite the same');
define('OPF_SCAFF_8_B','Please delete it manually.');
define('OPF_SCAFF_9','La suma total de anchos de columnas debe ser igual al ancho total de la grilla.');
define('OPF_SCAFF_10','Por favor verifique que la tabla exista y que tenga al menos 1 registro en ella.');
define('OPF_SCAFF_11','Name of module:');
define('OPF_SCAFF_12','Description:');
define('OPF_SCAFF_13','Previous');
define('OPF_SCAFF_14','Next');
define('OPF_SCAFF_15','Finalize');
define('OPF_SCAFF_16','Field');
define('OPF_SCAFF_17','Label');
define('OPF_SCAFF_18','Width (Px)');
define('OPF_SCAFF_19','Total width:');
define('OPF_SCAFF_20','Form filter:');
define('OPF_SCAFF_21','Export data:');
define('OPF_SCAFF_22','Pagination:');
define('OPF_SCAFF_23','Ordering:');
define('OPF_SCAFF_24','Edit:');
define('OPF_SCAFF_25','Delete:');
define('OPF_SCAFF_26','Multiple delete:');
define('OPF_SCAFF_27','Attributes');
define('OPF_SCAFF_28','Fields');
define('OPF_SCAFF_29','Table');
define('OPF_SCAFF_30','Text');
define('OPF_SCAFF_31','Numeric');
define('OPF_SCAFF_32','Select');
define('OPF_SCAFF_33','Date');
define('OPF_SCAFF_34','Text area');
define('OPF_SCAFF_35','Boolean');
define('OPF_SCAFF_36','Type');
define('OPF_SCAFF_37','PK');
define('OPF_SCAFF_38','Table name:');
define('OPF_SCAFF_39','Write here the table name');
define('OPF_SCAFF_40','Required');
define('OPF_SCAFF_41','Show');
define('OPF_SCAFF_42','folder name:');
define('OPF_SCAFF_43','Download zip:');
define('OPF_SCAFF_44','Unable to write to the directory');
define('OPF_SCAFF_45','The scaffold was set up correctly on the path: ');
define('OPF_SCAFF_46','Desea eliminar permanentemente este(os) registro(s)?');
define('OPF_SCAFF_47','Registro(s) eliminado(s)');
define('OPF_SCAFF_48','Tabla independiente');
define('OPF_SCAFF_49','Relación tabla');
define('OPF_SCAFF_50','Valor oculto');
define('OPF_SCAFF_51','Valor mostrado');

// OPF_useronline
define('OPF_USRONLINE_TITLE','Essentials - Users online');
define('OPF_USRONLINE_DESC','Administration and online user view');
define('OPF_USRONLINE_1','The session was closed.');
define('OPF_USRONLINE_2','Error closing the session.');
define('OPF_USRONLINE_3','Close this session?');

// OPF_profiles
define('OPF_PROFILES_TITLE','Essentials - Profile Management');
define('OPF_PROFILES_DESC','Administration of user access profiles');
define('OPF_PROFILES_1','do you want cancel the process?');
define('OPF_PROFILES_2','Deleted record');
define('OPF_PROFILES_3','Profiles');
define('OPF_PROFILES_4','Permissions');
define('OPF_PROFILES_5','Profile name:');
define('OPF_PROFILES_6','Description:');

// OPF_passwd
define('OPF_PASSWD_TITLE','Essentials - Change password');
define('OPF_PASSWD_DESC','Change your password from here');
define('OPF_PASSWD_1','Passwords do not match.');
define('OPF_PASSWD_2','The current password is not valid.');
define('OPF_PASSWD_3','Invalid Username');
define('OPF_PASSWD_4','User:');
define('OPF_PASSWD_5','Current password:');
define('OPF_PASSWD_6','New password:');
define('OPF_PASSWD_7','Repeat password:');

// OPF_options
define('OPF_OPTIONS_1','Open all');
define('OPF_OPTIONS_2','Close all');

// OPF_menu
define('OPF_MENU_TITLE','Essentials - Administration menu');
define('OPF_MENU_DESC','Manage menu options');
define('OPF_MENU_1','Deleted record');
define('OPF_MENU_2','Menu option');
define('OPF_MENU_3','The father can not be the same');
define('OPF_MENU_4','Description:');
define('OPF_MENU_5','Location:');
define('OPF_MENU_6','Num ord:');
define('OPF_MENU_7','URL:');
define('OPF_MENU_8','Explore');

//OPF_logout
define('OPF_LOGOUT_1','Please wait...');

//OPF_login
define('OPF_LOGIN_1','Username or password invalid');
define('OPF_LOGIN_2','User:');
define('OPF_LOGIN_3','Password:');
define('OPF_LOGIN_4','Sing in');
define('OPF_LOGIN_5','Remember me');
define('OPF_LOGIN_6','Unable to connect to the data base.');
define('OPF_LOGIN_7','Instalation');
define('OPF_LOGIN_8','Select engine:');
define('OPF_LOGIN_9','User:');
define('OPF_LOGIN_10','Password:');
define('OPF_LOGIN_11','Server:');
define('OPF_LOGIN_12','Data base:');
define('OPF_LOGIN_12A','Enconding:');
define('OPF_LOGIN_13','Port:');
define('OPF_LOGIN_14','Create tables');
define('OPF_LOGIN_15','The database tables was installed. Osezno Essentials PHP Framework was installed. Do you want to save these variables by default to connect to database?');
define('OPF_LOGIN_16','Ok');
define('OPF_LOGIN_17','Create database');
define('OPF_LOGIN_18','Unable to create the database.');
define('OPF_LOGIN_19','The database was created.');
define('OPF_LOGIN_20','Unable to create the database.');
define('OPF_LOGIN_21','Unable to select the database.');
define('OPF_LOGIN_22','Please complete the required fields.');
define('OPF_LOGIN_23','Unable to connect to server.');
define('OPF_LOGIN_24','Connecting to the database.');
define('OPF_LOGIN_25','Configuration');
define('OPF_LOGIN_26','Before you start please make sure to configure the connection variables the database as follows. Remember that the username and password by default is root');
define('OPF_LOGIN_27','The database has not installed the required tables.');
define('OPF_LOGIN_28','The extension has not been charged, please select another or activate it.');
define('OPF_LOGIN_29','Installation - Step 1 - Database');
define('OPF_LOGIN_30','Installation - Step 2 - System Tables');
define('OPF_LOGIN_31','Welcome');
define('OPF_LOGIN_32','Please verify that the default encoding for PHP and Apache is UTF-8');
define('OPF_LOGIN_33','Unable to overwrite the file conf/configApplication.php');
define('OPF_LOGIN_34','The configuration file was created successfully.');
define('OPF_LOGIN_35','The configuration file was not created automatically.');
define('OPF_LOGIN_36','Warning: There is no connection setup database for this application.');

//OPF_admUsr
define('OPF_ADMUSR_TITLE','Essentials - System users');
define('OPF_ADMUSR_DESC','User management system');
define('OPF_ADMUSR_1','User:');
define('OPF_ADMUSR_2','Name:');
define('OPF_ADMUSR_3','Surname:');
define('OPF_ADMUSR_4','Password:');
define('OPF_ADMUSR_5','Repeat password:');
define('OPF_ADMUSR_6','Profile:');
define('OPF_ADMUSR_7','Active:');
define('OPF_ADMUSR_8','Activate');
define('OPF_ADMUSR_9','Inactivate');
define('OPF_ADMUSR_10','Inactive');
define('OPF_ADMUSR_11','Active');
define('OPF_ADMUSR_12','you want to disable these users?');
define('OPF_ADMUSR_13','you want to enable these users?');
define('OPF_ADMUSR_14','Deleted user');
define('OPF_ADMUSR_15','The user');
define('OPF_ADMUSR_16','already exists.');
define('OPF_ADMUSR_17','The password was changed.');
define('OPF_ADMUSR_18','The password was not changed.');
define('OPF_ADMUSR_19','Passwords do not match written.');

//OPF_admTablas
define('OPF_ADMTABLAS_TITLE','Essentials - Master tables');
define('OPF_ADMTABLAS_DESC','Administration of master tables');
define('OPF_ADMTABLAS_1','Table name:');
define('OPF_ADMTABLAS_2','Description:');
define('OPF_ADMTABLAS_3','Code:');
define('OPF_ADMTABLAS_4','Deleted record');
define('OPF_ADMTABLAS_5','Deleted records');
define('OPF_ADMTABLAS_6','Detail');
define('OPF_ADMTABLAS_7','Tables');
define('OPF_ADMTABLAS_8','PHPCode');
define('OPF_ADMTABLAS_9','Copy and paste:');
define('OPF_ADMTABLAS_10','We define the class of the table from Active Record');
define('OPF_ADMTABLAS_11','Instantiate the class object');
define('OPF_ADMTABLAS_12','Consult the records associated');

#--------------------------------------------------------------

/**
 * Forms
*/
define('LABEL_FIRST_OPT_SELECT_FIELD','Select...');

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
