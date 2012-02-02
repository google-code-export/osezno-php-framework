<?php
	
	/**
	 * Essentials OPF
	 */

	// Botones comunes
	define('LABEL_BTN_SAVE', 'Guardar');
	define('LABEL_BTN_ADD', 'Agregar');
	define('LABEL_BTN_CANCEL', 'Cancelar');
	
	// Access error
	define('OPF_ACCESS_NOT_VERIFY_ERROR','Codigo de seguridad.');
	define('OPF_ACCESS_NOT_VERIFY_DETAIL','No es posible verificar el acceso, �Esta accediendo desde el menu?');
	define('OPF_ACCESS_NOT_PERMITED_ERROR','Acceso no permitido.');
	define('OPF_ACCESS_NOT_PERMITED_DETAIL','No cuenta con los suficientes privilegios del sistema para acceder a este modulo.');
	
	//OPF_bit
	define('OPF_BIT_TITLE','Essentials - Bitacora del sistema');
	define('OPF_BIT_DESC','Registro de eventos de usuarios sobre el sistema');
	
	//EOPF General
	define('MSG_CAMBIOS_GUARDADOS','Cambios guardados');
	define('MSG_CAMPOS_REQUERIDOS','Campos requeridos');
	define('YES','Si');
	define('NO','No');
	
	// Listas dinamicas
	define('OPF_FIELD_ID','Id');
	define('OPF_FIELD_DATETIME','Fecha Hora');
	define('OPF_FIELD_IP','Ip');
	define('OPF_FIELD_URL','Url');
	define('OPF_FIELD_TABLA','Tabla');
	define('OPF_FIELD_USUARIO','Usuario');
	define('OPF_FIELD_ACTUALIZADO','Actualizado');
	define('OPF_FIELD_MODIFICAR','Modificar');
	define('OPF_FIELD_ELIMINAR','Eliminar');
	define('OPF_FIELD_DETALLE','Detalle');
	define('OPF_FIELD_CODIGO','C�digo');
	define('OPF_FIELD_DESCRIPCION','Descripci�n');
	define('OPF_FIELD_NOMBRE','Nombre');
	define('OPF_FIELD_APELLIDO','Apellido');
	define('OPF_FIELD_PERFIL','Perfil');
	define('OPF_FIELD_ESTADO','Estado');
	define('OPF_FIELD_PADRE','Padre');
	define('OPF_FIELD_ORDEN','Ord');
	define('OPF_FIELD_MENU','Menu');
	define('OPF_FIELD_INGRESO','Ingreso');
	define('OPF_FIELD_FILE','Archivo');
	define('OPF_FIELD_PESO','Peso');
	define('OPF_FIELD_SESSNAME','Sesi�n');
	define('OPF_FIELD_CERRAR','Cerrar');
	define('OPF_FIELD_ICON', 'Icono');
	define('OPF_FIELD_CONFIRM_ELIMINAR','�Desea eliminar el registro?');
	define('OPF_FIELD_CONFIRM_ELIMINAR_VARIOS','�Desea eliminar estos registros?');
	
	// OPF_scaffold
	define('OPF_SCAFF_TITLE','Essentials - Andamiaje');
	define('OPF_SCAFF_DESC','Generaci�n asistida de modulos sobre tablas de la DB');
	define('OPF_SCAFF_1','Nuevo andamio - Paso 1');
	define('OPF_SCAFF_2','Campos del formulario - Paso 2');
	define('OPF_SCAFF_3','Combos selecci�n - Paso 3');
	define('OPF_SCAFF_4','Atributos y campos de grilla - Paso 4');
	define('OPF_SCAFF_5','Nombre y descripci�n del modulo - Paso 5');
	define('OPF_SCAFF_6','No es posible crear el directorio:');
	define('OPF_SCAFF_7_A','El directorio');
	define('OPF_SCAFF_7_B','ya existe,');
	define('OPF_SCAFF_7_C','�desea sobre escribir los archivos?');
	define('OPF_SCAFF_8_A','Error al eliminar al sobre escribir el directorio');
	define('OPF_SCAFF_8_B','Por favor borrelo manualmente.');
	define('OPF_SCAFF_9','La suma total de anchos de columnas debe ser igual al ancho total de la grilla.');
	define('OPF_SCAFF_10','Por favor verifique que la tabla exista y que tenga al menos 1 registro en ella.');
	define('OPF_SCAFF_11','Nombre del modulo:');
	define('OPF_SCAFF_12','Descripci�n:');
	define('OPF_SCAFF_13','Anterior');
	define('OPF_SCAFF_14','Siguiente');
	define('OPF_SCAFF_15','Finalizar');
	define('OPF_SCAFF_16','Campo');
	define('OPF_SCAFF_17','Etiqueta');
	define('OPF_SCAFF_18','Ancho');
	define('OPF_SCAFF_19','Ancho total:');
	define('OPF_SCAFF_20','Formulario filtro:');
	define('OPF_SCAFF_21','Exportar datos:');
	define('OPF_SCAFF_22','Paginaci�n:');
	define('OPF_SCAFF_23','Ordenammiento:');
	define('OPF_SCAFF_24','Editar:');
	define('OPF_SCAFF_25','Eliminar:');
	define('OPF_SCAFF_26','Eliminaci�n multiple:');
	define('OPF_SCAFF_27','Atributos');
	define('OPF_SCAFF_28','Campos');
	define('OPF_SCAFF_29','Tabla');
	define('OPF_SCAFF_30','Texto');
	define('OPF_SCAFF_31','N�merico');
	define('OPF_SCAFF_32','Selecci�n');
	define('OPF_SCAFF_33','Fecha');
	define('OPF_SCAFF_34','Area texto');
	define('OPF_SCAFF_35','Booleano');
	define('OPF_SCAFF_36','Tipo');
	define('OPF_SCAFF_37','Llave primaria');
	define('OPF_SCAFF_38','Nombre de la tabla:');
	define('OPF_SCAFF_39','Escriba aqui el nombre de la tabla');
	
	
	// OPF_useronline
	define('OPF_USRONLINE_TITLE','Essentials - Usuarios en linea');
	define('OPF_USRONLINE_DESC','Administraci�n y vista de usuarios en linea');
	define('OPF_USRONLINE_1','La sesi�n fue finalizada.');
	define('OPF_USRONLINE_2','Error cerrando la sesi�n.');
	define('OPF_USRONLINE_3','�Cerrar esta sesi�n?');
	
	// OPF_profiles
	define('OPF_PROFILES_TITLE','Essentials - Administraci�n de perfiles');
	define('OPF_PROFILES_DESC','Administre aqu� los perfiles de acceso de los usuarios');
	define('OPF_PROFILES_1','�Desea cancelar el proceso?');
	define('OPF_PROFILES_2','Registro eliminado');
	define('OPF_PROFILES_3','Perfiles');
	define('OPF_PROFILES_4','Permisos');
	define('OPF_PROFILES_5','Nombre del Perfil:');
	define('OPF_PROFILES_6','Descripci�n:');
	
	// OPF_passwd
	define('OPF_PASSWD_TITLE','Essentials - Cambio de contrase�a de acceso');
	define('OPF_PASSWD_DESC','Cambie desde aqui su clave de acceso');
	define('OPF_PASSWD_1','Las claves no coinciden.');
	define('OPF_PASSWD_2','La clave actual no es valida.');
	define('OPF_PASSWD_3','Nombre de usuario no valido');
	define('OPF_PASSWD_4','Usuario:');
	define('OPF_PASSWD_5','Actual clave:');
	define('OPF_PASSWD_6','Nueva clave:');
	define('OPF_PASSWD_7','Repetir clave:');
	
	// OPF_options
	define('OPF_OPTIONS_1','Abrir todo');
	define('OPF_OPTIONS_2','Cerrar todo');
	
	// OPF_menu
	define('OPF_MENU_TITLE','Essentials - Administraci�n de Menu');
	define('OPF_MENU_DESC','Administre las opciones disponibles del menu');
	define('OPF_MENU_1','Registro eliminado');
	define('OPF_MENU_2','Opci�n del menu');
	define('OPF_MENU_3','El padre no puede ser el mismo');
	define('OPF_MENU_4','Descripci�n:');
	define('OPF_MENU_5','Ubicaci�n:');
	define('OPF_MENU_6','Num Ord:');
	define('OPF_MENU_7','URL:');
	define('OPF_MENU_8','Explorar');
		
	//OPF_logout
	define('OPF_LOGOUT_1','Cerrando sesi�n... por favor espere.');
	
	//OPF_login
	define('OPF_LOGIN_1','Usuario o clave no validos');
	define('OPF_LOGIN_2','Usuario:');
	define('OPF_LOGIN_3','Clave:');
	define('OPF_LOGIN_4','Ingresar');	
	define('OPF_LOGIN_5','Recordar usuario');
	define('OPF_LOGIN_6','Imposible conectarse a la base de datos.');
	define('OPF_LOGIN_7','Instalaci�n');
	define('OPF_LOGIN_8','Seleccione Motor:');
	define('OPF_LOGIN_9','Usuario:');
	define('OPF_LOGIN_10','Contrase�a:');
	define('OPF_LOGIN_11','Servidor:');
	define('OPF_LOGIN_12','Base de datos:');
	define('OPF_LOGIN_12A','Codificaci�n:');
	define('OPF_LOGIN_13','Puerto:');
	define('OPF_LOGIN_14','Crear tablas');
	define('OPF_LOGIN_15','Las tablas fueron instaladas. Essentials Osezno PHP Framework fue instalado.');
	define('OPF_LOGIN_16','Aceptar');
	define('OPF_LOGIN_17','Crear base de datos');
	define('OPF_LOGIN_18','No es posible crear la base de datos.');
	define('OPF_LOGIN_19','La base de datos fue creada.');
	define('OPF_LOGIN_20','Imposible crear la base de datos.');
	define('OPF_LOGIN_21','Imposible seleccionar la base de datos.');
	define('OPF_LOGIN_22','Por favor complete los campos requeridos.');
	define('OPF_LOGIN_23','Imposible conectarse al servidor.');
	define('OPF_LOGIN_24','Conexi�n a base de datos.');
	define('OPF_LOGIN_25','Configuraci�n');
	define('OPF_LOGIN_26','Antes de comenzar por favor asegurate de configurar las variables de conexi�n a la base de datos de la siguiente forma. Recuerda que el usuario y la clave de acceso por defecto es root');
	define('OPF_LOGIN_27','La base de datos no tiene instaladas las tablas requeridas.');
	define('OPF_LOGIN_28','La extensi�n no ha sido cargada, por favor seleccione otra o active esta.');
	define('OPF_LOGIN_29','Instalaci�n - Paso 1 - Base de datos');
	define('OPF_LOGIN_30','Instalaci�n - Paso 2 - Tablas del sistema');
	define('OPF_LOGIN_31','Bienvenido');
	
	//OPF_admUsr
	define('OPF_ADMUSR_TITLE','Essentials - Usuarios del sistema');
	define('OPF_ADMUSR_DESC','Administraci�n de usuarios del sistema');
	define('OPF_ADMUSR_1','Usuario:');
	define('OPF_ADMUSR_2','Nombres:');
	define('OPF_ADMUSR_3','Apellidos:');
	define('OPF_ADMUSR_4','Contrase�a:');
	define('OPF_ADMUSR_5','Repetir contrase�a:');
	define('OPF_ADMUSR_6','Perfil:');
	define('OPF_ADMUSR_7','Activo:');
	define('OPF_ADMUSR_8','Activar');
	define('OPF_ADMUSR_9','Inactivar');
	define('OPF_ADMUSR_10','Inactivo');
	define('OPF_ADMUSR_11','Activo');
	define('OPF_ADMUSR_12','�Desea Inhabilitar estos usuarios?');
	define('OPF_ADMUSR_13','�Desea Habilitar estos usuarios?');
	define('OPF_ADMUSR_14','Usuario eliminado');
	define('OPF_ADMUSR_15','El usuario');
	define('OPF_ADMUSR_16','ya existe.');
	define('OPF_ADMUSR_17','La clave fue cambiada.');
	define('OPF_ADMUSR_18','La clave NO fue cambiada.');
	define('OPF_ADMUSR_19','Las contrase�as escritas no coinciden.');
	
	//OPF_admTablas
	define('OPF_ADMTABLAS_TITLE','Essentials - Maestro de tablas');
	define('OPF_ADMTABLAS_DESC','Administraci�n de tablas del sistema');
	define('OPF_ADMTABLAS_1','Nombre tabla:');
	define('OPF_ADMTABLAS_2','Descripci�n:');
	define('OPF_ADMTABLAS_3','C�digo:');
	define('OPF_ADMTABLAS_4','Registro eliminado');
	define('OPF_ADMTABLAS_5','Registros eliminados');
	define('OPF_ADMTABLAS_6','Detalle');
	define('OPF_ADMTABLAS_7','Tablas');
	define('OPF_ADMTABLAS_8','<? Codigo ?>');
	define('OPF_ADMTABLAS_9','Copie y pegue este codigo:');
	define('OPF_ADMTABLAS_10','Definimos la clase de la tabla desde Active Record');
	define('OPF_ADMTABLAS_11','Instanciamos el objeto de la clase');
	define('OPF_ADMTABLAS_12','Consultamos los registros asociados');
	
	#--------------------------------------------------------------

	/**
	 * Formularios
	 */
	define('LABEL_FIRST_OPT_SELECT_FIELD','Seleccione...');
	
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
	define('LABEL_USELIMIT_RULE_FORM','L�mite');
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
	define('MSG_FAILED_SHOW_FILTER_NO_RECORDS_FOUND','No es posible agregar filtros pues no se encontraron regitros.');
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