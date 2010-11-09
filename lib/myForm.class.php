<?php
/**
 * Inclusion de clases para el fckeditor
 */
$pathfckEditor = 'plugin/editors/fck_editor/fckeditor.php';
require ($pathfckEditor);


/**
 * myForm
 *
 * La clase myForm es la forma de interactuar el desarrollador con los formularios.
 *
 * @uses Creacion de formularios
 * @package OSEZNO FRAMEWORK (2008-2011)
 * @version 1.6.0
 * @author Jose Ignacio Gutierrez Guzman jose.gutierrez@osezno-framework.org
 * 
 */
class myForm {

	/**
	 * Version de la clase
	 *
	 * @var string
	 */
	private $version = '1.6.2';

	/**
	 * En caso de que el form no tenga action, hacer esto.
	 *
	 * @var string
	 */
	private $onSubmitAction = 'return false';

	/**
	 * Nombre de la funcion JS que se ejecutara para pasar por parametro al evento ajax
	 * que se genere cuando el paramatro de envio sea form
	 * 
	 * @var string
	 */
	private $jsFunctionSubmitFormOnEvent = 'GetDataForm';
	
	/**
	 * Nombre de la funcion JS que se ejecutara para pasar por parametro al evento ajax
	 * que se genere cuando el paramatro de envio sea field
	 * 
	 * @var string
	 */
	private $jsFunctionSubmitFieldOnEvent = 'GetDataField';
	
	/**
	 * El tipo de parametro que se usara al cumplirse
	 * un evento configurado sobre un campo con el nmetodo addEvent
	 * 
	 *  Global: Enviara un arreglo con los valores de todos los campos del formulario
	 *  Field:  Enviara el valor del campo en el que se esta ejecutando el evento.
	 * 
	 * @var string
	 */
	private $paramTypeOnEvent = 'form';
	
	/**
	 * Extension de el archivo que la cache generara
	 *
	 * @var string
	 */
	private $cache_ext_file = '';

	/**
	 * Numero de segundos en que la cache de un documento de mantendra
	 *
	 * @var integer
	 */
	private $cache_int_seconds_time;

	/**
	 * Nombre del arreglo que almacena los campos del formulario antes de ser lanzado.
	 *
	 * @var array
	 */
	private $Objects = array();

	/**
	 * Caracter que sera tenido en cuenta para las cadenas que son compuestas por muchos campos.
	 *
	 * @var string
	 */
	private $Separador = "/-/";

	/**
	 * Caracter  que   identifica   despues   de  el
	 * dentro del nombre de un objeto del formulario
	 * el valor  colSpan  que se va a asumir por ese
	 * campo  para  que  sea  alineado correctamente
	 * dentro de la tabla del formulario.
	 *
	 * @var string
	 */
	private $colSpanIdentifier = ':';

	/**
	 * Contador interno que lleva la cuenta y genera un id unico
	 * para cada uno de los Radio buttons que se generen
	 *
	 * @var integer
	 */
	private $counterRadiosForThisForm = 0;

	/**
	 * Guarda informacion sobre los campos de un formulario que
	 * aun no se encuentra validado.
	 *
	 * @var string
	 */
	private $validationError = '';	

	/**
	 * Es un copia de los elementos que dentro del formulario deben ser obligatorios llenar
	 *
	 * @var array
	 */
	private $arrayRequiredFiled = array ();

	/**
	 * Guarda temporalmente cada uno de los
	 * valores de el formulario, para poder
	 * accederlos mas adelante y poder com
	 * pilar el formulario.
	 *
	 * @var array
	 */
	private $arrayFormElements = array ();

	/**
	 * Tiene registrados los alias de los atributos
	 * por cada fila generada en el formulario para
	 * que en la compilacion del fomrulario podamos
	 * reemplazarlos por sus respectivos valores.
	 *
	 * @var array
	 */
	private $arrayAttributesToReplaceInRow = array(
		'widthEtq',
		'widthFld',
		'colSpanEtq',
		'colSpanFld',
		'rowSpanEtq',
		'rowSpanFld'
	);
	
	/**
	 * Guarda temporalmente propiedades de cada
	 * unos de los campos referente a el colspan
	 * que ocupa cada uno de ellos en las tablas.
	 *
	 * @var array
	 */
	private $arrayFormElementsColspan = array();

	/**
	 * Guarda temporalmente propiedades de cada
	 * unos de los campos referente a el rowspan
	 * que ocupa cada uno de ellos en las tablas.
	 *
	 * @var array
	 */
	private $arrayFormElementsRowspan = array();
	
	/**
	 * Guarda los tipos de elemento por cada uno
	 * de los objetos del formulario.
	 *
	 * @var array
	 */
	private $arrayFormElementType = array();

	/**
	 * Arreglo que contiene los botones adionales que el
	 * formulario pueda tener.
	 *
	 * @var array
	 */
	private $arrayButtonList = array();

	/**
	 * Arreglo que contiene los idNames de los agrupamientos
	 * en el formulario actuales
	 *
	 * @var array
	 */
	private $arrayGroups = array();

	/**
	 * Arreglo que contiene los elementos que ya han sido
	 * incluidos dentro de los demas grupos
	 *
	 * @var array
	 */
	private $arrayElementsInGroups = array();

	/**
	 * Guarda temporalmente el HTML de cada Grupo
	 * de elementos
	 *
	 * @var mixed
	 */
	private $arrayGroupsElementsHTML = array();

	/**
	 * Contiene los id de cada uno de los
	 * agrupamientos de los grupos que se
	 * estan formando para compartir  una
	 * fila.
	 *
	 * @var mixed
	 */
	private $arrayGroupsIdInShareSpace = array();

	/**
	 * Contiene un listado de los grupos
	 * que ya fueron mostrados con ante-
	 * rioridad.
	 *
	 * @var mixed
	 */
	private $arrayGroupsShown = array();

	/**
	 * Contiene un listado de los  elementos
	 * del formulario que ya habian sido lan
	 * zados anteriormente para no volverlos
	 * a mostrar cuando termine de mostrarse
	 * cada uno de los grupos.
	 *
	 * @var mixed
	 */
	private $arrayFormElementsShown = array ();

	/**
	 * Contiene los nombres de los campos que
	 * ya habian sido definidos dentro de  la
	 * clase como objetos del formulario pero
	 * no han sido mostrados dento de   algun
	 * grupo.
	 *
	 * @var mixed
	 */
	private $arrayFormElementsToShow = array();

	/**
	 * Arreglo que contiene los nombres de los
	 * eventos que han sido definidos.
	 *
	 * @var array
	 */
	private $arrayEventsDefined = array();
	
	/**
	 * Arreglo de los campos tipo 'FILE' que estan registrados
	 * dentro del formulario para ser mostrados
	 *
	 * @var array
	 */
	private $uploaderIdArray = array();
		
	/**
	 * Verifica si un objeto tipo file ha sido
	 * agregado al formulario para mas adelante
	 * en la compilacion del formulario incluir
	 * o no el fuente javascript de dicho objeto.
	 *
	 * @var bool
	 */
	private $useAddFile = false;
			
	/**
	 * Arreglo protegido que almacena los eventos Xajax para los que se le fueron asignados
	 *
	 * @var array
	 */
	protected $objEventxJ = array();

	/**
	 * Arreglo que contiene los nombres de los objetos que tendran la propiedad Disabled
	 * dentro del formulario
	 *
	 * @var array
	 */
	protected $objDisabled = array();

	/**
	 * Arreglo que contiene los nombres de los objetos que
	 * estan referenciados como objetos del formulario que
	 * contendran un nivel de ayuda.
	 *
	 * @var array
	 */
	protected $objHelps = array ();

	/**
	 * Arreglo que contiene los nombres de los objetos que
	 * estan referenciado como  objetos del formulario que
	 * van a usar helpers, y que solo es valido para   los
	 * campos de tipo texto.
	 *
	 * @var array
	 */
	protected $objHelpers = array ();	
	
	/**
	 * El metodo que utilizara en el momento de enviar el Formulario.
	 *
	 * @var string
	 */
	public $method = 'post';
	
	/**
	 * La ruta del script a la cual va dirigida la informacion.
	 * Ejemplo valida.php
	 * @var string
	 */
	public $action;

	/**
	 * La ventana en donde se abrira la informacion enviada desde ese formulario.
	 * Valores: _self, _blank, _parent, _top
	 * @var string
	 */
	public $target = '_self';

	/**
	 * El tipo de datos que va a enviar, usualmente se utiliza para manejar acrchivos.
	 * Valores: application/x-www-form-urlencoded, multipart/form-data
	 * @var string
	 */
	public $enctype;

	/**
	 * Prefijo que usa xajax para llamar a sus funciones
	 *
	 * @var string
	 */
	public $prefAjax = '';

	/**
	 * El nombre del formulario con el que se esta interactuando.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Directorio en donde el formulario sera cacheado
	 *
	 * @var string
	 */
	public $cache_dir = 'myform_cache/';

	/**
	 * Define si se va a usar o no cache para el formulario
	 *
	 * @var boolean
	 */
	public $use_cache = false;

	/**
	 * Numero de columnas en las que se divira la vista del formulario.
	 *
	 * @var integer
	 */
	public $cols = 2;

	/**
	 * Numero en px de padding en las celdas
	 *
	 * @var integer
	 */
	public $cellPadding = 2;

	/**
	 * Numero en px de spacing entre las celdas.
	 *
	 * @var integer
	 */
	public $cellSpacing = 0;

	/**
	 * Tamano de ancho de la tabla que contiene el formulario en porcentaje o px
	 *
	 * @var string
	 */
	public $width = '100%';

	/**
	 * Tamano de alto de la tabla que contiene el formulario en porcentaje o px
	 *
	 * @var string
	 */
	public $height = '0%';

	/**
	 * Borde de la tabla, para programadores
	 *
	 * @var integer
	 */
	public $border = 0;

	/**
	 * Permite decidir si se va a usar o no
	 * una opcion en el select que  muestre
	 * un determinada etiqueta como presentacion.
	 *
	 * @var boolean
	 */
	public $selectUseFirstValue = true;

	/**
	 * Ruta de la Imagen que acompana el boton de cada uno de los Controles de calendario
	 *
	 * @var string
	 */
	public $srcImageCalendarButton  = 'calendar.gif';

	/**
	 * Path subcarpeta dentro de la carpeta principal del poryecto
	 *
	 * @var string
	 */
	private $pathImages;
	
	/**
	 * Etiqueta de la primera opcion por select
	 * que se activa solo si $objMyForm->selectUseFirstValue
	 * es igual a 'true'
	 *
	 * @var string
	 */
	public $selectStringFirstLabelOption = 'Seleccione...';

	/**
	 * Utilizar o no la fila intermedia de color diferente para
	 * diferenciar visualmente las filas de los campos en un formulario.
	 * Nota: Al activar este atributo debe tenerse en cuenta la clase
	 * de estilos que usa por medio de 'styleClassRowSeparator'
	 *
	 * @var boolean
	 */
	public $useRowSeparator = false;
	
	/**
	 * Nombre de la clase que por defecto usan los formularios
	 * 
	 * @var string
	 */
	public $styleClassForm = 'formulario';
	
	/**
	 * Nombre de la clase que por defecto usan las
	 * tablas que se crean para el formulario.
	 *
	 * @var string
	 */
	public $styleClassTableForm = 'fondo_tabla_form';

	/**
	 * Nombre de la clase que por defecto usan las
	 * filas del medio para los formularios.
	 *
	 * @var string
	 */
	public $styleClassRowSeparator = 'fondo_fila_medio';

	/**
	 * Tipo del la ayuda que mostrara el help
	 * sobre los campos que se configuraron
	 * previamente.
	 *
	 * 1, 2
	 *
	 * @var integer
	 */
	public $styleTypeHelp = 1;

	/**
	 * Nombre de la clase que por defecto usan los
	 * campos del formulario para ser mostrados.
	 *
	 * @var string
	 */
	public $styleClassFields = 'caja';

	/**
	 * Nombre de la clase que por defecto usan los
	 * los botones del formulario que seran mostrados.
	 *
	 * @var string
	 */
	public $styleClassButtons = 'boton';

	/**
	 * Nombre de la clase que por defecto usan los
	 * loas etiquetas de los campos del formulario que seran mostrados.
	 *
	 * @var string
	 */
	public $styleClassTags = 'etiqueta';

	/**
	 * Nombre de la clase que por defecto usan los
	 * fieldsets del formulario.
	 *
	 * @var string
	 */
	public $styleClassFieldsets = 'formulario_fieldset';

	/**
	 * Etiqueta del Legend del Fieldset que usara el formulario
	 *
	 * @var string
	 */
	public $strFormFieldSet = '';

	/**
	 * Parametros de Configuracion del SWFUpload
	 * 
	 * Recordar que cuando se anuncia o se hace llamado 
	 * a file object que puede ser pasado como parametro 
	 * a un evento este trae informacion del archivo
	 * que se esta intentando subir al servidor.
	 * 
	 * id : string,			    // SWFUpload file id, used for starting or cancelling and upload
	 * index : number,			// The index of this file for use in getFile(i)
	 * name : string,			// The file name. The path is not included.
	 * size : number,			// The file size in bytes
	 * type : string,			// The file type as reported by the client operating system
	 * creationdate : Date,		// The date the file was created
	 * modificationdate : Date,	// The date the file was last modified
	 * filestatus : number,		// The file's current status. Use SWFUpload.FILE_STATUS to interpret the value.
	 * 
	 */

	/**
	 * Url del archivo que sube los archivos
	 * al servidor por via post.
	 *
	 * @var string
	 */
	public $SWF_upload_url;
	# Un ejemplo de el script que sube los datos puede ser ...
	# - Inicio
	//   // Si se pretende conservar el ID de la sesion actual, se hace con un parametro GET
	//    if(isset($_GET['SessionID'])){
	//       // session_id devuelve el ID de la sesion actual, o setea el ID de la nueva sesion
	//      session_id(trim($_GET['SessionID']));
	//    }
	//   // Si se requiere iniciar sesion
	//   //session_start();
	//   // Decidimos donde vamos a poner el Archivo que subimos
	//   $folder_destino = $_SERVER['DOCUMENT_ROOT']."/".$_FILES['Filedata']['name'];
	//   // Intentamos mover el archivo al directorio destino
	//   if (@move_uploaded_file($_FILES['Filedata']['tmp_name'],$folder_destino)){
	//      // Aqui se movio
	//	  header('HTTP/1.1 200 OK');
	//      // Si el envio falla
	//   }else {
	//	  // Reportar el error
	//	  header('HTTP/1.1 404 Not Found');
	//	  // Guardar el error en un archivo
	//	  error_log("Error al intentar enviar archivo: ".$_FILES['Filedata']['name'].' '.date("Y-m-d")."\n",3,"logs.txt");
	//   }
	//   print 'ok!';
	# - Fin

	/**
	 * El nombre del campo cuando es enviado
	 * por el metodo POST, The Linux Flash Player ignores this setting.
	 *
	 * @var string
	 */
	public $SWF_file_post_name;

	/**
	 * The param_object should be a simple JavaScript object.
	 * All names and values must be strings
	 *
	 * @var string
	 */
	public $SWF_post_params = array();

	/**
	 * Los tipos de archivo que son admisibles
	 *
	 * @var array
	 */
	public $SWF_file_types = array('*.*');

	/**
	 * La descripcion de los tipos de archivo
	 * que se pueden subir al servidor
	 *
	 * @var string
	 */
	public $SWF_file_types_description = 'Todos los tipos';

	/**
	 * El tamano maximo en kilobytes
	 * para que un archivo pueda ser
	 * subido al  servidor de datos.
	 *
	 * @var integer
	 */
	public $SWF_file_size_limit = 2048;

	/**
	 * Setea si se va a mostrar o no informacion de 
	 * la capacidad max de subida por archivo en el boton
	 * que abre la ventana de dialogo para el swf_uploader
	 *
	 * @var unknown_type
	 */
	public $SWF_show_max_upload_size_info_in_button = true;

	/**
	 * Numero maximo de archivos que
	 * pueden ser subidos.
	 *
	 * @var integer
	 */
	public $SWF_file_upload_limit = 0;

	/**
	 * Numero maximo de archivos en
	 * archivos en  cola que pueden
	 * estar.
	 *
	 * @var integer
	 */
	public $SWF_file_queue_limit = 0;

	/**
	 * Url en donde se encuentra el
	 * SWF que permite la carga  de
	 * los archivos al servidor.
	 *
	 * @var string
	 */
	public $SWF_flash_url = '';
	
	/**
	 * Url de la imagen que por defecto 
	 * se va a cargar como base para
	 * dibujar el boton de carga de archivos.
	 * 
	 * @var string
	 */
	public $SWF_button_image_url = '../../img/my_form/file/XPButtonNoText_160x22.png';
	
	/**
	 * Id del span donde el button
	 * se va a alojar.
	 * 
	 * @var string
	 */
	public $SWF_button_placeholder_id = 'spanButtonPlaceholder';
	
	/**
	 * Ancho del boton en px en el formulario
	 * 
	 * @var integer
	 */
	public $SWF_button_width = 160;
	
	/**
	 * Alto del boton en px en el formulario
	 * 
	 * @var integer
	 */
	public $SWF_button_height = 22;
	
	/**
	 * Ancho de el tamano del flash.
	 *
	 * @var string
	 */
	public $SWF_flash_width = '0px';

	/**
	 * Alto de el tamano del flash.
	 *
	 * @var string
	 */
	public $SWF_flash_height = '0px';

	/**
	 * Color de piel para el flash.
	 *
	 * @var string
	 */
	public $SWF_flash_color = 'FFFFFF';

	/**
	 * Habilitar el debug o no
	 *
	 * @var bool
	 */
	public $SWF_debug = 'false';

	/**
	 * The swfUploadLoaded event is fired by flashReady. It is overridable. When swfUploadLoaded is called it is safe to call SWFUpload methods.
	 *
	 * @var string
	 */
	public $SWF_swfupload_loaded_handler = 'swfuploadLoadedHandler';

	/**
	 * Este evento se dispara inmediatamente antes de que la
	 * ventana de dialogo de seleccion de archivos sea abierta.
	 * Sin embargo el evento no va a terminar ni a cerrarse hasta
	 * que la ventana dialogo de seleccion de archivos este sea
	 * cerrada por cancelacion, o aceptacion. 
	 *
	 * Parametros que se pasan al evento: Ninguno 
	 *  
	 * @var string
	 */
	public $SWF_file_dialog_start_handler = 'fileDialogStart';

	/**
	 * No usar o tener en cuenta este evento.
	 *
	 * @var string
	 */
	public $SWF_file_queued_handler = 'fileQueued';

	/**
	 * Se ejecuta cuando existe o se produjo un
	 * error de validacion en la lista seleccionada
	 * de los archivos  que el  usuario selecciono
	 * Por ejemplo para ayudar a validar que el archivo
	 * no sea demasiado grande o que sea del tipo
	 * que se esta parametrizando.
	 *
	 * Parametros que se pasan al evento: (file object, error code, message)
	 * 
	 * @var string
	 */
	public $SWF_file_queue_error_handler = 'fileQueueError';

	/**
	 * Se ejecuta cuando se a echo click sobre el
	 * boton aceptar del cuadro de dialogo de los
	 * archivos que van a ser subidos al servidor
	 * Esto generalmente esta haciendo el cargue
	 * automatico de los archivos con "this.startUpload();"
	 *
	 * Parametros que se pasan al evento: (number of files selected, number of files queued)
	 * 
	 * @var string
	 */
	public $SWF_file_dialog_complete_handler = 'fileDialogComplete';

	/**
	 * Funcion que es llamada cuando comienza todo
	 * el cargue completo de los archivos y para que
	 * en cierta forma tambien se pueda hacer automaticamente
	 *
	 * Parametros que se pasan al evento: (file object)
	 * 
	 * @var string
	 */
	public $SWF_upload_start_handler = 'uploadStart';

	/**
	 * Se produce cuando el listado de los archivos
	 * que actualmente se han seleccionado estan en
	 * proceso de ser subidos al servidor.
	 *
	 * Parametros que se pasan al evento: (file object, bytes complete, total bytes)
	 * 
	 * @var string
	 */
	public $SWF_upload_progress_handler = 'uploadProgress';

	/**
	 * El evento es uploadError se dispara en cualquier momento
	 * cuando la carga de un archivo se interrumpe o no se completa con éxito. 
	 * El código de error parámetro indica el tipo de error que se produjo. 
	 * El código de error parámetro especifica una constante en SWFUpload.UPLOAD_ERROR.
	 * 
	 * Parametros que se pasan al evento: (file object, error code, message)
	 * 
	 * @var string
	 */
	public $SWF_upload_error_handler = 'uploadError';

	/**
	 * Este evento se ejecuta cuando un archivo es subido exitosamente
	 * al servidor, mientras tanto otros archivos pueden seguir siendo
	 * subidos.
	 *
	 * Parametros que se pasan al evento: (file object, server data)
	 *  
	 * @var string
	 */
	public $SWF_upload_success_handler = 'uploadSuccess';

	/**
	 * Este evento siempre se dispara al final de un ciclo de una carga.
	 * En este punto la carga esta completa y otra puede comenzar.
	 *
	 * Parametros que se pasan al evento: (file object)
	 * 
	 * @var string
	 */
	public $SWF_upload_complete_handler = 'uploadComplete';

	/**
	 * Enter description here...
	 *
	 * @var string
	 */
	public $SWF_debug_handler = 'debugHandler';

	/**
	 * Enter description here...
	 *
	 * @var array
	 */
	public $SWF_custom_settings = array();

	/**
	 * Ruta de la imagen que acompaña el boton
	 * examinar para el cargue de los archivos
	 *
	 * @var string
	 */
	public $SWF_src_img_button = '';

	/**
	 * Texto que esta dentro del boton
	 * quen  examina   los   archivos.
	 *
	 * @var string
	 */
	public $SWF_str_etq_button = 'Examinar';

	/**
	 * Decidir si por upload se pueden se
	 * leccionar  varios  archivos  o no.
	 *
	 * @var boolean
	 */
	public $SWF_upload_several_files = false;

	# Atributos de inicio de configuracion para el editor FCKeditor

	/**
	 * Ruta base de acceso para encontrar los script del editor
	 * Se necesita para llamar correctamente al FCKeditor
	 * Normalmente se puede localizar en URL_BASE_PROJECT.'/lib/plugin/editors/fck_editor/';
	 *
	 * @var string
	 */
	public $FCK_editor_BasePath = '';

	/**
	 * Ancho de FCKeditor
	 *
	 * @var string
	 */
	public $FCK_editor_Width  = '100%';

	/**
	 * Alto del FCKeditor
	 *
	 * @var string
	 */
	public $FCK_editor_Height = '200';

	/**
	 * Idioma por defecto a mostrar
	 *
	 * @var string
	 */
	public $FCK_editor_Laguage = 'es';

	/**
	 * Grupo de barras a seleccionar
	 *
	 * @var string
	 */
	public $FCK_editor_ToolbarSet = 'Default';

	/**
	 * Constructor de la clase de generacion de formularios
	 *
	 * @param string  $nomForm  	Nombre del formulario
	 * @param string  $event 		En caso de que el form no tenga Action, entonces el boton realizara este evento
	 * @param string  $action   	El nombre del script a donde va la informacion
	 * @param string  $target   	Parametro de apertura de los datos
	 * @param string  $enctype  	Tipo de informacion que maneja
	 */
	public function __construct($name = '', $action = '', $target = '', $enctype = ''){

		$this->pathImages =  '/themes/'.THEME_NAME.'/myform/';
		
		$this->name = $name;

		if ($action)
			$this->action = $action;
			
		if ($target)
			$this->target = $target;			
			
		if ($enctype)
			$this->enctype = $enctype;
	}

	/***
	 * Retornar el error de valicacion devuelto por validateForm
	 */
	public function getValidationError (){	
		
		return $this->validationError; 
	}
		

	/**
	 * Crea un agrupamiento HTML mediante fieldSet
	 * para los  nombres de  los campos contenidos
	 * dentro del tercer parametro.
	 *
	 * @param string  $idGroup Identificador interno del fieldSet
	 * @param string  $strFieldSet Legend del fieldSet
	 * @param array   $arraystrIdFields Arreglo de nombre de objetos que seran agrupados
	 * @param integer $intCols Numero de Columnas en el que la tabla se partira
	 * @param boolean $useShowHide Usar o no propiedad para mostrar y ocultar las capas
	 * @param string  $iniVisibilitySts Si se activo la propiedad de mostrar y ocultar el fieldset, determinar el estado inicial 
	 */
	public function addGroup ($idGroup, $strFieldSet, $arraystrIdFields, $intCols = 2, $useShowHide = false, $iniVisibilitySts = 'show'){
		
		$this->arrayGroups[] = array(
			'idGroup' => $idGroup, 
			'strFieldSet' => $strFieldSet, 
			'arraystrIdFields' => $arraystrIdFields, 
			'intColsByGroup' => $intCols,
			'useShowHide' => $useShowHide,
			'iniVisibilitySts' => $iniVisibilitySts
		);

		$this->arrayFormElementsShown = array_merge($this->arrayFormElementsShown, $arraystrIdFields);
	}
	
	/**
	 * Configura el tipo de parametro que va a ser enviado a la funcion de un
	 * evento, este parametro puede ser tipo 'form' o tipo 'field'
	 * 
	 * @param $paramType	Tipo de parametro
	 */
	public function setParamTypeOnEvent ($paramType){
		
		$this->paramTypeOnEvent = $paramType;
	}
	
	/**
	 * Agregar un evento JavaScript al elemento llamado 'id' que es el elemento que queremos modificar
	 * su propiedad de OnClick, OnBlur... etc
	 * Por ejemplo, podemos crear una caja de texto sencilla por medio de
	 * $obj-> addText('Nombre:','nombre'); y despues agregar el siguiente metodo
	 *
	 * $obj->addEventJs()
	 *
	 * Para que en la obtencion del formulario ese evento sea escrito en la salida HTML
	 *
	 * @param string  $strElementIdORelemlentName  Nombre o id del objeto del formulario al que se le va a agregar un evento Js
	 * @param integer $strEventORintEvent          El metodo que deseamos realizar, puede ser un entero o directamente el nombre del evento
	 * @param string  $strFunctionORarrayFunctions El nombre de la funcion o funciones que deseamos llamar (Ajax) al momento de cumplirse el evento
	 * @param mixed   $mixedMoreParams             Arreglo con otros parametros que uno quiera pasar
	 *
	 * Valores permitidos (1->blur, 2->change, 3->click, 4->focus, 5->mouseout, 6->OnMouseOver)
	 *
	 * Hasta el momento esta metodo solo aplica para los objetos de formularios que sean
	 * -textarea
	 * -select
	 * -password
	 * -text
	 * -radiobuttons
	 * -checkbox
	 */
	public function addEventJs ($strElementIdORelemlentName,$strEventORintEvent,$strFunctionORarrayFunctions, $mixedMoreParams = ''){
		$array_eJs = array (
		1 => ' OnBlur',      'onblur' =>      ' OnBlur',
		2 => ' OnChange',    'onchange' =>    ' OnChange',
		3 => ' OnClick',     'onclick' =>     ' OnClick',
		4 => ' OnFocus',     'onfocus' =>     ' OnFocus',
		5 => ' OnMouseOut',  'onmouseout' =>  ' OnMouseOut',
		6 => ' OnMouseOver', 'onmouseover' => ' OnMouseOver');

		if (is_string($strEventORintEvent))
		$strEventORintEvent = strtolower($strEventORintEvent);

		$this->objEventxJ[$strElementIdORelemlentName] = '';
		
		$this->objEventxJ[$strElementIdORelemlentName] .= $array_eJs[$strEventORintEvent].'="';

		if (is_array($strFunctionORarrayFunctions)){
			$cantFinctions = count($strFunctionORarrayFunctions);
			for($i=0;$i<$cantFinctions;$i++){
				
				switch ($this->paramTypeOnEvent){
					case 'global':
						$this->objEventxJ[$strElementIdORelemlentName] .= $this->prefAjax.$strFunctionORarrayFunctions[$i].'('.$this->jsFunctionSubmitFormOnEvent.'(\''.$this->name.'\''.')';
					break;
					case 'field':
						$this->objEventxJ[$strElementIdORelemlentName] .= $this->prefAjax.$strFunctionORarrayFunctions[$i].'('.$this->jsFunctionSubmitFieldOnEvent.'(this.value)';
					break;
				}
				
				//Miramos si hay parametros adicionales
				if (!$mixedMoreParams)
				$this->objEventxJ[$strElementIdORelemlentName] .= ')'.'';
				else{
					$this->objEventxJ[$strElementIdORelemlentName] .= ', ';
					 
					$countMoreParams = count ($mixedMoreParams);$k=0;
					foreach($mixedMoreParams as $valParam){
						if (!is_numeric($valParam) && !$this->exists_JavascriptFormat_InParamEvent($valParam))
							$valParam = "'".$valParam."'";
						$this->objEventxJ[$strElementIdORelemlentName] .= $valParam;
						if ($k<($countMoreParams-1))
							$this->objEventxJ[$strElementIdORelemlentName] .= ', ';
						$k++;
					}
					$this->objEventxJ[$strElementIdORelemlentName] .=')';
				}
					
				if (($i+1)<$cantFinctions)
				$this->objEventxJ[$strElementIdORelemlentName] .=', ';
			}
			$this->objEventxJ[$strElementIdORelemlentName] .='"';
		}else{
			
			switch ($this->paramTypeOnEvent){
				case 'global':
					$this->objEventxJ[$strElementIdORelemlentName] .= $this->prefAjax.$strFunctionORarrayFunctions.'('.$this->jsFunctionSubmitFormOnEvent.'(\''.$this->name.'\''.')';
				break;
				case 'field':
					$this->objEventxJ[$strElementIdORelemlentName] .= $this->prefAjax.$strFunctionORarrayFunctions.'('.$this->jsFunctionSubmitFieldOnEvent.'(this.value)';
				break;
			}
			
			if (!$mixedMoreParams)
			$this->objEventxJ[$strElementIdORelemlentName] .=')'.'" ';
			else{
			 $this->objEventxJ[$strElementIdORelemlentName] .= ', ';
			 $countMoreParams = count ($mixedMoreParams);$i=0;
			 foreach($mixedMoreParams as $valParam){
			 	if (!is_numeric($valParam) && !$this->exists_JavascriptFormat_InParamEvent($valParam))
			 	    $valParam = "'".$valParam."'";
			 	$this->objEventxJ[$strElementIdORelemlentName] .= $valParam;
			 	if ($i<($countMoreParams-1))
			 		$this->objEventxJ[$strElementIdORelemlentName] .= ', ';
			 	$i++;
			 }
			 $this->objEventxJ[$strElementIdORelemlentName] .=')'.'" ';
			}
		}
	}
	
	/**
	 * Agrega la propiedad 'disabled="disabled"' a el objeto del formulario
	 * que se invoque
	 * @param string id Nombre o id del objeto del formulario al que se le va a agregar la propiedad
	 */
	public function addDisabled ($objName){
		if (!in_array($objName, $this->objDisabled)){
			$this->objDisabled[$objName] = $objName;
		}
	}

	/**
	 * Agrega el elemento a el gurpo de elementos
	 * en general de la aplicacion que  contendra
	 * una capa al pasar el mouse sobre el objeto
	 * mostrando una pequeña o determinada descri
	 * pcion del objeto del formulario con el obj
	 * etivo del que un usuario pueda tener un ni
	 * vel de ayuda para saber a que hace referen
	 * cia determinado campo.
	 *
	 * @param string $objName Nombre o id del Objeto del formulario al que se le va a agregar la ayuda
	 * @param string $strHelp Contenido de la ayuda
	 */
	public function addHelp ($objName, $strHelp){
		if (!in_array($objName, $this->objHelps)){
			$this->objHelps[$objName] = str_replace("'","\\'",str_replace('"',"'",$strHelp));
		}
	}

	/**
	 * Agregar un helper a este campo, solo  aplicando
	 * a los campos del formulario que sean campo tipo
	 * texto.
	 * Nota: Este metodo no funciona como lo hace addHelp
	 * antes de un getText, solo funciona con los addText
	 *
	 * @param String $objName      Nombre o id del objeto del formulario al que se le va a agregar el Helper
	 * @param String $mixedStrings Arreglo que contiene los items del helper que seran mostrados a medida que el usuario escriba en la caja de texto
	 */
	public function addHelper ($objName, $mixedStrings){
		if (!in_array($objName, $this->objHelpers)){
			$this->objHelpers[$objName] = $mixedStrings;
		}
	}

	/**
	 * Retorna el tipo de elemento que identificamos
	 * con el nombre del Objeto del Formulario.
	 *
	 * @param string $objName Nombre del Objeto
	 * @return string
	 */
	public function getTypeElement($objName){
		return $this->arrayFormElementType[$objName];
	}

	/**
	 * Agrega un boton a la funcionalidad del formulario
	 *
	 * @param string $strName    Nombre del Elemento
	 * @param string $strLabel   Etiqueta o valor del Elemento
	 * @param string $jsFunction Funcion xjx que ejecuta
	 * @param string $strSrcImg  Ruta de la img que lo acompana
	 * 
	 * Nota: Si desea pasar variables adicionales al evento del
	 * boton, debe agregar separado por (:) los valores que necesite
	 * 
	 */
	public function addButton ($strName, $strLabel, $jsFunction = '', $strSrcImg = ''){
		$this->arrayButtonList[] = array('strName'    =>  $strName,
                                         'strLabel'   =>  $strLabel,
                                         'jsFunction' =>  $jsFunction);
		
		$count = count($this->arrayButtonList);
		
		if ($strSrcImg)
		   $this->arrayButtonList[($count-1)]['strSrcImg'] = $GLOBALS['urlProject'].$this->pathImages.$strSrcImg;  
	}

	/**
	 * Obtiene el html de un boton
	 * necesario para ejecutar los
	 * actions en los  formularios
	 * que son creados por los usu
	 * arios.
	 *
	 * @param string $strName    Nombre del boton
	 * @param string $strLabel   Etiqueta del boton
	 * @param string $jsFunction Funcion xjx que ejecuta
	 * @param string $strSrcImg  Ruta de la img que lo acompana
	 * @return string
	 * 
	 * Nota: Si desea pasar variables adicionales al evento del
	 * boton, debe agregar separado por (:) los valores que necesite	 
	 *  
	 */
	public function getButton ($strName, $strLabel, $jsFunction = '', $strSrcImg = ''){
		$buf = '';
		$strMixedParams = '';
		
		$buf.='<button '.$this->checkIfIsDisabled($strName).' '.$this->checkIsHelping($strName).' value="'.strip_tags($strLabel).'" class="'.$this->styleClassButtons.'" type="button" name="'.$strName.'" id="'.$strName.'" ';
		if ($jsFunction){
			
			if (stripos($jsFunction,':')!==false){
				
		  		$mixedExtParams = array();
		  		
		  		
		  		$intCountPrm = count($mixedExtParams = split(':',$jsFunction));
		  		$i = 0;
		  		
		  		foreach ($mixedExtParams as $param){
					
		  			if (!$i)
					   $jsFunction = $param; 	
		  			
		  			if ($jsFunction!=$param){
		  				if (!is_numeric($param))
							$strMixedParams .= '\''.$param.'\'';
						else	
							$strMixedParams .= $param;
		  			}
		  			
		  			if (($i+1)<$intCountPrm){
						$strMixedParams .= ',';
		  			}
		  			
					$i++;					  			
		  		}
		  		
		  	}
			
			if (strpos($jsFunction,'closeWindow'))
				$buf .= ' onclick="'.$this->prefAjax.$jsFunction.'"';
			else
				$buf .= ' onclick="'.$this->prefAjax.$jsFunction.'('.$this->jsFunctionSubmitFormOnEvent.'(\''.$this->name.'\') '.$strMixedParams.')"';
		}
			
		$buf .= '>';

		$buf .= '<table border="0" cellspacing="0" cellpadding="0"><tr>';
		
		if ($strSrcImg)
			$buf .= '<td><img style="padding-right: 2px; vertical-align: bottom;" src="'.$GLOBALS['urlProject'].$this->pathImages.$strSrcImg.'" border="0"></td>';
			
		$buf.='<td class="boton_font">'.$strLabel.'</td></tr></table></button>';

		return $buf;
	}

	/**
	 * Agrega una caja de texto
	 *
	 * @param string  $etq       Etiqueta del campo
	 * @param string  $name      Nombre del campo
	 * @param string  $value     Valor incial
	 * @param integer $size      Tamano del campo
	 * @param integer $maxlength Numero maximo de caracteres
	 * @param char    $validacion_numerica (S o N)
	 * @param bool    $CampoFecha (0 o 1) Muestra un boton en el campo que facilita la seleccion de una fecha
	 * @param String  $NameFunctionCallCalendar En caso de que $CampoFecha sea 1, debe pasarse como parametro el nombre de la funcion que abrira el calendar
	 *
	 */
	public function addText($etq = '', $name = '', $value = '', $size = '', $maxlength = '', $validacion_numerica = false, $CampoFecha = false){
		$name     = $this->getColspanRowspan($name);
		$Cadena   = 'text'.$this->Separador.$etq.$this->Separador.$name.$this->Separador.$value.$this->Separador.$size.$this->Separador.$maxlength.$this->Separador.$validacion_numerica.$this->Separador.$CampoFecha;
		
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'text';
	}

	/**
	 * Devuelve una caja de texto
	 *
	 * @param string $name       Nombre del campo
	 * @param string $value      Valor incial
	 * @param integer $size      Tamano del campo
	 * @param integer $maxlength Numero maximo de caracteres
	 * @param char    $validacion_numerica (S o N)
	 * @param bool    $CampoFecha (0 o 1) Muestra un boton en el campo que facilita la seleccion de una fecha
	 * @param String  $NameFunctionCallCalendar En caso de que $CampoFecha sea 1, debe pasarse como parametro el nombre de la funcion que abrira el calendar
	 *
	 */
	public function getText($name = '', $value = '', $size = '', $maxlength = '', $validacion_numerica = false, $CampoFecha = false){
		$this->arrayFormElementType[$name] = 'text';
		$keypress = '';
		$Disabled = '';
		$LauncherCalendar = '';

		if ($validacion_numerica)
			$keypress = ' onKeyPress="return OnlyNum(event)"';

		if ($CampoFecha){
			$LauncherCalendar = '<button type="button" class="'.$this->styleClassFields.'" id="trigger_'.$name.'"  name="trigger_'.$name.'" onClick="addCalendarWindow(document.getElementById(\''.$name.'\').value, \''.$name.'\', \''.$name.'\')" /><img src="'.$GLOBALS['urlProject'].$this->pathImages.$this->srcImageCalendarButton.'" border="0"></button>';
			$LauncherCalendar .= '<div id="div_trigger_'.$name.'" name="div_trigger_'.$name.'" class="calmain" style="position:absolute;height:300px;width:300px;visibility:hidden"></div>';
			
			$Disabled = 'readonly';
		}
			
		$buf ='<input '.$this->checkIfIsDisabled($name).' '.$this->checkIsHelping($name).' class="'.$this->styleClassFields.'" type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" size="'.$size.'" '.$Disabled.' maxlength="'. $maxlength.'"'.$keypress.'  '.$this->checkExistEventJs($name).'>'.$LauncherCalendar.''."\n";
			
		return $buf;
	}

	/**
	 * Agrega una area de texto
	 *
	 * @param string  $etq       Etiqueta del campo
	 * @param string  $name      Nombre del campo
	 * @param string  $value     Valor incial
	 * @param integer $cols      Numero de columna
	 * @param integer $rows      Numero de fila
	 * @param string  $wrap      Clase y tipo de abrigo
	 *
	 */
	public function addTextArea($etq = '', $name = '', $value = '', $cols = '', $rows = '', $wrap = ''){
		$name     = $this->getColspanRowspan($name);
		$Cadena   = 'textarea'.$this->Separador.$etq.$this->Separador.$name.$this->Separador.$value.$this->Separador.$cols.$this->Separador.$rows.$this->Separador.$wrap;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'textarea';
	}

	/**
	 * Obtiene una area de texto
	 *
	 * @param string  $name      Nombre del campo
	 * @param string  $value     Valor incial
	 * @param integer $cols      Numero de columna
	 * @param integer $rows      Numero de fila
	 * @param string  $wrap      Clase y tipo de abrigo
	 *
	 */
	public function getTextArea($name = '', $value = '', $cols = '', $rows = '', $wrap = ''){
		$buf = '';
		$buf.=''.''.'<textarea '.$this->checkIsHelping($name).' class="'.$this->styleClassFields.'" name="'.$name.'" id="'.$name.'" cols="'.$cols.'" rows="'.$rows.'" wrap="'.$wrap.'" '.$this->checkExistEventJs($name).' '.$this->checkIfIsDisabled($name).'>'.$value.'</textarea>'."\n";
		$this->arrayFormElementType[$name] = 'textarea';
		return $buf;
	}

	/**
	 * Agregar un editor fckeditor al fomulario actual
	 *
	 * @param string  $etq            Etiqueta del campo generado por el FCK Editor
	 * @param string  $name           Nombre del campo generado por el FCK Editor
	 * @param string  $value          Valor inicial del campo generado por el FCK Editor
	 */
	public function addFCKeditor ($etq = '', $name = '', $value = ''){
		$name     = $this->getColspanRowspan($name);
		$Cadena   = 'fckeditor'.$this->Separador.$etq.$this->Separador.$name.$this->Separador.$value;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'fckeditor';
	}

	/**
	 * Agrega un campo de texto Oculto al formulario
	 *
	 * @param string $name      Nombre del campo
	 * @param string $value     Valor incial
	 *
	 */
	public function addHidden($name = '', $value = ''){
		$name     = $this->getColspanRowspan($name);
		$Cadena   = 'hidden'.$this->Separador.$name.$this->Separador.$value;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'hidden';
	}

	/**
	 * Obtiene un campo Oculto
	 *
	 * @param string $name      Nombre del campo
	 * @param string $value     Valor incial
	 *
	 */
	public function getHidden($name = '', $value = ''){
		$buf = '';
		$buf = '<input type="hidden" id="'.$name.'" name="'.$name.'" value="'.$value.'">'."\n";
		$this->arrayFormElementType[$name] = 'hidden';

		return $buf;
	}

	/**
	 * Agrega una caja de texto tipo password
	 *
	 * @param string $etq       Etiqueta del campo
	 * @param string $name      Nombre del campo
	 * @param string $value     Valor incial
	 * @param string $size      Tamano del campo
	 * @param string $maxlength Numero maximo de caracteres
	 *
	 */
	public function addPassword($etq = '', $name = '', $value = '', $size = '', $maxlength = ''){
		$name     = $this->getColspanRowspan($name);
		$Cadena   = 'password'.$this->Separador.$etq.$this->Separador.$name.$this->Separador.$value.$this->Separador.$size.$this->Separador.$maxlength;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'password';
	}

	/**
	 * Obtiene una caja de texto tipo password
	 *
	 * @param string $name      Nombre del campo
	 * @param string $value     Valor incial
	 * @param string $size      Tamano del campo
	 * @param string $maxlength Numero maximo de caracteres
	 *
	 */
	public function getPassword($name = '', $value = '', $size = '', $maxlength = ''){

		$buf = '';
		$buf ='<input '.$this->checkIfIsDisabled($name).' '.$this->checkIsHelping($name).' class="'.$this->styleClassFields.'" type="password" name="'.$name.'" id="'.$name.'" value="'.$value.'" size="'.$size.'" maxlength="'. $maxlength.'" '.$this->checkExistEventJs($name).'>'."\n";
		$this->arrayFormElementType[$name] = 'password';
			
		return $buf;		
	}

	/**
	 * Agrega conjunto de select para personalizar un campo fecha
	 *
	 * @param string $etq        Etiqueta del campo
	 * @param string $prefName   Prefijo para el nombre del campo
	 * @param int    $iniValA    Valor inicial para el ano
	 * @param int    $iniValM    Valor inicial del mes
	 * @param int    $iniValD    Valor inicial del dia
	 * @param int    $YearBack   Cantidad de anos atras para cagar el select, Opcional
	 * @param int    $YearFuture Cantidad de anos a futuro para cagar el select, Opcional
	 *
	 */
	public function addDate ($etq = '', $prefName = '', $iniValA = '', $iniValM = '', $iniValD = '', $YearBack = 100, $YearFuture = 20){
		$prefName = $this->getColspanRowspan($prefName);
		$arrMsese = array("1"  => "Enero",       "2" => "Febrero",
                          "3"  => "Marzo",       "4" => "Abril", 
                          "5"  => "Mayo",        "6" => "Junio", 
                          "7"  => "Julio",       "8" => "Agosto", 
                          "9"  => "Septiembre", "10" => "Octubre", 
                          "11" => "Noviembre",  "12" => "Dicembre");

		$strY = '';
		$selected = '';
		for ($i = (date("Y")-$YearBack); $i < (date("Y")+$YearFuture); $i++){
			if ($iniValA == $i)
			$selected = ' selected';
			else
			$selected = '';
			$strY .= "\t\t".'<option value="'.$i.'"'.$selected.' class="'.$this->styleClassFields.'">'.$i.'</option>'."\n";
		}

		$strM = '';
		for ($i = 0, $keys = array_keys($arrMsese); $i < count($arrMsese); $i++){
			if ($iniValM == $keys[$i])
			$selected = ' selected';
			else
			$selected = '';
			$strM .= "\t\t".'<option value="'.$keys[$i].'"'.$selected.' class="'.$this->styleClassFields.'">'.$arrMsese[$keys[$i]].'</option>'."\n";
		}


		$strD = '';
		for ($i = 1; $i <= 31; $i++){
			if ($iniValD == $i)
			$selected = ' selected';
			else
			$selected = '';
			$strD .= "\t\t".'<option value="'.$i.'"'.$selected.' class="'.$this->styleClassFields.'">'.$i.'</option>'."\n";
		}

		$Cadena = 'date'.$this->Separador.$etq.$this->Separador.$prefName.$this->Separador.$strY.$this->Separador.$strM.$this->Separador.$strD;
		$this->Objects['field'][$prefName] = $Cadena;
		$this->arrayFormElementType[$prefName] = 'date';
	}

	/**
	 * Agrega conjunto de select para personalizar un campo fecha
	 *
	 * @param string $etq        Etiqueta del campo
	 * @param string $prefName   Prefijo para el nombre del campo
	 * @param int    $iniValH    Valor inicial para la Hora
	 * @param int    $iniValM    Valor inicial para los minutos
	 *
	 */
	function addTime ($etq = '', $prefName = '', $iniValH = '', $iniValM = ''){
		$prefName = $this->getColspanRowspan($prefName);
		$strH = '';
		$selected = '';
		for ($i = 0; $i < 24; $i++){
			if ($iniValH == $i)
			$selected = ' selected';
			else
			$selected = '';

			if ($i<10)
			$label='0';
			else
			$label='';

			$strH .= "\t\t".'<option value="'.$i.'"'.$selected.'>'.$label.$i.'</option>'."\n";
		}

		$strM = '';
		for ($i = 0; $i < 60; $i+=5){
			if ($iniValM == $i)
			$selected = ' selected';
			else
			$selected = '';

			if ($i<10)
			$label = '0';
			else
			$label = '';

			$strM .= "\t\t".'<option value="'.$i.'"'.$selected.'>'.$label.$i.'</option>'."\n";
		}

		$Cadena = 'time'.$this->Separador.$etq.$this->Separador.$prefName.$this->Separador.$strH.$this->Separador.$strM;
		$this->Objects['field'][$prefName] = $Cadena;
		$this->arrayFormElementType[$prefName] = 'time';
	}

	/**
	 * Agrega conjunto de select para personalizar un campo fecha
	 *
	 * @param string $etq        Etiqueta del campo
	 * @param string $prefName   Prefijo para el nombre del campo
	 * @param int    $iniValH    Valor inicial para la Hora
	 * @param int    $iniValM    Valor inicial para los minutos
	 *
	 */
	public function getTime ($prefName = '', $iniValH = '', $iniValM = ''){
		$strH = "\t\t".'<select '.$this->checkIsHelping($prefName).' name="'.$prefName.'_H" size="1" class="'.$this->styleClassFields.'">'."\n";
		$selected = '';
		for ($i = 0; $i < 24; $i++){
			if ($iniValH == $i)
			$selected = ' selected';
			else
			$selected = '';

			if ($i<10)
			$label='0';
			else
			$label='';

			$strH .= "\t\t".'<option value="'.$i.'"'.$selected.'>'.$label.$i.'</option>'."\n";
		}
		$strH .= "\t\t".'</select>'."\n";

		$strM = "\t\t".'<select '.$this->checkIsHelping($prefName).' name="'.$prefName.'_M" size="1" class="'.$this->styleClassFields.'">'."\n";
		for ($i = 0; $i < 60; $i+=1){
			if ($iniValM == $i)
			$selected = ' selected';
			else
			$selected = '';

			if ($i<10)
			$label = '0';
			else
			$label = '';

			$strM .= "\t\t".'<option value="'.$i.'"'.$selected.'>'.$label.$i.'</option>'."\n";
		}
		$strM .= "\t\t".'</select>'."\n";
		$this->arrayFormElementType[$prefName] = 'time';

		return $strH.':'.$strM;
	}

	/**
	 * Agrega un espacio en blanco en el lugar que le corresponda
	 *
	 * @param integer $id    Identificador del espacio, este puede ser un numero consecutivo
	 * @param string  $val_e Valor en el momento del cargue dentro del formulario para la etiqueta
	 * @param string  $val_c Valor en el momento del cargue dentro del formulario para el campo
	 */
	public function addWhiteSpace ($id, $val_e = '', $val_c = ''){
		$id = $this->getColspanRowspan($id);
		$this->Objects['field']['whitespace_'.$id] = 'whitespace'.$this->Separador.$id.$this->Separador.$val_e.$this->Separador.$val_c;
		$this->arrayFormElementType[$id] = 'whitespace';
	}

	/**
	 * Agrega un comentario en una Fila especifica
	 * @param integer $id Identificador del espacio que va a utilizar, este siempre debe de ser diferente para cada uno
	 * @param string  $Coment Texto que desea mostrar en la fila
	 */
	public function addComent ($id, $Coment){
		$id     = $this->getColspanRowspan($id);
		$Cadena = 'coment'.$this->Separador.$id.$this->Separador.$Coment;
		$this->Objects['field']['coment_'.$id] = $Cadena;
		$this->arrayFormElementType[$id] = 'coment';
	}

	/**
	 * Agrega un radio button al formulario en particular.
	 * Los grupos de radio buttons se pueden formar y funcionar
	 * siempre y cuando esos radio buttons queden con el mismo
	 * nombre que permita agruparlos.
	 *
	 * @param Etiqueta $etq
	 * @param Valor    $value
	 * @param Grupo al que pertenece  $name_group
	 * @return string Id del radio button, se usa para poder agrupar mas adelante
	 */
	public function addRadioButton($etq = '', $value = '', $name_group = '', $is_checked = 'N'){
		$name = '_'.$this->counterRadiosForThisForm+=1;

		//$name = $this->getColspanRowspan($name);
		$Cadena = 'radiobutton'.$this->Separador.$etq.$this->Separador.$name.$this->Separador.$value.$this->Separador.$name_group.$this->Separador.$is_checked;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'radiobutton';
			
		return $name;
	}

	/**
	 * Obtiene el html de un radio button
	 *
	 * @param string $value Valor por defecto del Radio button
	 * @param string $name_group Nombre del radio o grupo que van a comformarlo
	 * @return string
	 */
	public function getRadioButton ($value = '', $name_group = '', $is_checked = 'N'){
		$buf = '';

		$checked = '';
		if ($is_checked=='S')
		$checked = 'checked="checked"';

		$buf .= '<input '.$this->checkExistEventJs($name_group).' '.$this->checkIsHelping($name_group).' '.$this->checkIfIsDisabled($name_group).' type="radio" name="'.$name_group.'" id="'.$name_group.'_'.$value.'" value="'.$value.'" class="'.$this->styleClassFields.'" '.$checked.'>';
		unset($this->objEventxJ[$name_group]);
		$this->arrayFormElementType[$name_group] = 'radiobutton';

		return $buf;
	}

	/**
	 * Agrega una caja checkBox al formulario, el contenido de esta caja puede
	 * ser evaluado para verificar si es '0' o '1'
	 *
	 * @param string $etq       Etiqueta del campo
	 * @param string $name      Nombre de checkbox
	 * @param char   $ini_sts   Estado inicial del Check en la carga del formulario. N = No chequeado, S = Chequeado
	 *
	 */
	public function addCheckBox($etq = '', $name = '', $ini_sts = 'N'){
		$name = $this->getColspanRowspan($name);
		$Cadena = 'checkbox'.$this->Separador.$etq.$this->Separador.$name.$this->Separador.$ini_sts;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'checkbox';

	}

	/**
	 * Obtiene una caja checkBox al formulario, el contenido de esta caja puede
	 * ser evaluado para verificar si es '0' o '1'
	 *
	 * @param string $name      Nombre de checkbox
	 * @param char   $ini_sts   Estado inicial del Check en la carga del formulario. N = No chequeado, S = Chequeado
	 *
	 */
	public function getCheckBox($name = '', $ini_sts = 'N'){
		$buf = '';

		$value = '0';
		$cheked = '';
		if ($ini_sts == 'S'){
			$cheked = 'checked';
			$value  = '1';
		}

		$onClickField = 'onclick="Check(\''.$this->name.'\', \''.$name.'\')';
			
		$onEvent = $this->checkExistEventJs($name);
		if ($onEvent){
			if (strpos(strtolower($onEvent),'onclick')){
				$addEvent = substr($onEvent,10,-2);

				$onClickField	.= ','.$addEvent;

				$onEvent = '';
			}
		}
		$onClickField  .= '"';

		$buf .= '<input '.$onEvent.' '.$this->checkIsHelping($name).' class="'.$this->styleClassFields.'" type="checkbox" name="'.$name.'" id="'.$name.'" value="'.$value.'"  '.$onClickField.'  '.$cheked.' '.$this->checkIfIsDisabled($name).'>'."\n";
		$this->arrayFormElementType[$name] = 'checkbox';

		return $buf;
	}

	/**
	 * Agrega una lista dinamica al formulario para poder seleccionar
	 * uno o varios Registros de esa lista dinamica.
	 *
	 * En construccion
	 *
	 * @param unknown_type $etq
	 * @param unknown_type $name
	 * @param unknown_type $sql
	 * @param unknown_type $idToCheckBox
	 */
	public function addList ($etq = '', $name, $sql, $idToCheckBox){
		if ($sql){
			$objDinamicList = new myDinamicList($name,$sql);

			$objDinamicList->getDinamicList($name,false);
			$objDinamicList->setColumn($name, $idToCheckBox, '',$this->getCheckBox($idToCheckBox));

			$Cadena = 'mylist'.$this->Separador.$name.$this->Separador.$etq;
			$this->Objects['field'][$name] = $Cadena;
		}
	}

	/**
	 * Agrega una combo desplegable (menu)
	 *
	 * @param string $etq       	Etiqueta del campo
	 * @param string $name      	Nombre del campo
	 * @param array  $value     	Valor incial que es un arreglo de la forma especificada
	 * @param string $size      	Tamano del campo
	 * @param string $truncar_hasta Truncar Numero maximo de caracteres al fina
	 *
	 */
	public function addSelect($etq = '', $name = '', $value = '', $selected ='', $size = '', $truncar_hasta = 100, $multiple = 0){
		$name = $this->getColspanRowspan($name);
		$buf  = '';
		if (is_array ($value)){
			if ($this->selectUseFirstValue)
				$buf .= "".'<option value="">'.htmlentities($this->selectStringFirstLabelOption).'</option>'."\n";
			
			$selectedIsArray = false;
			if (is_array($selected)){
			   $selectedIsArray = true;
			}
			
			foreach ($value as $id => $value){
				$sel = '';
				if (!$selectedIsArray){
				   if (!strcmp($id,$selected)){
				   	  $sel = ' selected';
				   }
				}else{
				   if (in_array($id,$selected)){
				      $sel = ' selected';
				   }					
				}
				
				$buf .= "\t\t".'<option value="'.$id.'"'.$sel.'>'.substr($value,0,$truncar_hasta).'</option>'."\n";
			}
			
			$buf .= "\t\t".'</select>'."\n";
			$value = $buf;
		}
		$maxlength = '';

		$Cadena   = 'select'.$this->Separador.$etq.$this->Separador.$name.$this->Separador.$value.$this->Separador.$size.$this->Separador.$maxlength.$this->Separador.$multiple;
		$this->Objects['field'][$name] = $Cadena;

		$this->arrayFormElementType[$name] = 'select';
	}

	/**
	 * Obtiene una combo desplegable (menu)
	 *
	 * @param string $name          Nombre del campo
	 * @param array  $value         Valor incial que es un arreglo de la forma especificada
	 * @param string $size          Tamano del campo
	 * @param string $truncar_hasta Truncar Numero maximo de caracteres al fina
	 *
	 */
	public  function getSelect($name = '', $value = '', $selected ='', $size = '', $truncar_hasta = 100, $multiple = 0){
		$buf = '';
		$string_multiple = '';
		if ($multiple)
		$string_multiple = ' multiple';
		$buf.= "\t\t".'<select '.$this->checkIfIsDisabled($name).' '.$this->checkIsHelping($name).' class="'.$this->styleClassFields.'" name="'.$name.'" id="'.$name.'"'.$string_multiple.' size="'.$size.'" '.$this->checkExistEventJs($name).'>'."\n";
			
		if (is_array ($value)){
			if ($this->selectUseFirstValue)
			$buf .= "\t\t".'<option value="">'.htmlentities($this->selectStringFirstLabelOption).'</option>'."\n";

			$selectedIsArray = false;
			if (is_array($selected)){
			   $selectedIsArray = true;
			}	
			
			foreach ($value as $id => $value){
				$sel = '';
				if (!$selectedIsArray){
				   if (!strcmp($id,$selected)){
				   	  $sel = ' selected';
				   }
				}else{
				   if (in_array($id,$selected)){
				      $sel = ' selected';
				   }					
				}
				
				$buf .= "\t\t".'<option value="'.$id.'"'.$sel.'>'.substr($value,0,$truncar_hasta).'</option>'."\n";
			}

			$buf .= '</select>'."\n";
		}

		$this->arrayFormElementType[$name] = 'select';

		return $buf;
	}

	/**
	 * Agrega   un  campo   de  tipo  file
	 * asincronico a el formulario actual.
	 *
	 * @param string  $etq                     Etiqueta del campo
	 * @param string  $name                    Nombre del campo
	 * @param string  $upload_url              Url del .php que recibe los datos
	 * @param string  $flash_url               Url del donde se encuentra ubicado el flash
	 * @param array   $file_types              Arreglo con los tipos de archivos que se pueden subir
	 * @param string  $file_types_description  Descripcion de los tipos de archivos que se pueden subir
	 * @param integer $file_size_limit         Limite de tamano por archivo que se puede subir
	 */
	public function addFile ($etq, $name, $upload_url, $flash_url = '../../swf/swfupload.swf', $file_types = '', $file_types_description = '', $file_size_limit = ''){
		$name = $this->getColspanRowspan($name);
		if ($file_types && is_array($file_types))
		$this->SWF_file_types = $file_types;
			
		if ($file_types_description)
		$this->SWF_file_types_description = $file_types_description;
			
		if (intval($file_size_limit))
		$this->SWF_file_size_limit = $file_size_limit;

		$this->SWF_upload_url = $upload_url;
		$this->SWF_flash_url  = $flash_url;

		$Cadena   = 'file'.$this->Separador.$etq.$this->Separador.$name;
		$this->Objects['field'][$name] = $Cadena;
		$this->uploaderIdArray[] = $name;

		$this->arrayFormElementType[$name] = 'file';
		$this->useAddFile = true;
	}

	/**
	 * Obtiene el HTML de un campo formulario
	 * tipo File asincronico.
	 *
	 * @param string $name Nombre del campo
	 * @return string
	 */
	public function getFile ($name){
		$buf = '';

		$buf.='<span id="spanButtonPlaceholder">';
		
		if ($this->SWF_src_img_button)
		   $buf.='<img style="padding-right: 3px; vertical-align: bottom;" src="'.$GLOBALS['urlProject'].$this->pathImages.$this->SWF_src_img_button.'" border="0">';
		
		$maxInfoSize = '';   
	    if ($this->SWF_show_max_upload_size_info_in_button){
	    	if ($this->SWF_file_size_limit<1024){
	           $maxFileSizeUpload = '('.$this->SWF_file_size_limit.' Kb)';
	    	}else if ($this->SWF_file_size_limit<1048576){
	    	   $maxFileSizeUpload = '('.number_format($this->SWF_file_size_limit/1024,2).' Mb)';
	    	}else{
      		   $maxFileSizeUpload = '('.number_format($this->SWF_file_size_limit/1048576,2).' Gb)';
	    	}
	       $maxInfoSize = '<font style="vertical-align: middle; font-size: 6pt; font-weight: bold;">'.$maxFileSizeUpload.'</font>';
	    }	   
		   
		$buf.= '</span><div style="text-align: left;" class="'.$this->styleClassTags.'" id="div_file_progress" name="div_file_progress"></div>';
		$this->arrayFormElementType[$name] = 'file';

		return $buf;
	}

	/**
	 * Obtiene informacion de los campos que aun no estan validados
	 * Ejemplo de arrayRequeridos $arrayRequeridos = array ('nombre_campo'=>'Etiqueta campo');
	 * Nota: Preguntar por $this->validationError para obtener un String de los campos incompletos
	 *
	 * @param array $arrayRequeridos Arreglo de datos que son obligatorios
	 * @param array $FormElements 	 Arreglo retornado por $this->DataFormToArray($dataForm);
	 * @return bool
	 */
	public function validateForm($arrayRequeridos, $FormElements){
		$this->arrayRequiredFiled = $arrayRequeridos;

		$valido= true;
		$llavesRequeridos = array_keys($arrayRequeridos);
		for ($i=0;$i<count($arrayRequeridos);$i++){
			if (!trim($FormElements[$llavesRequeridos[$i]])){
				$valido = false;
				$this->validationError .= '* '.$arrayRequeridos[$llavesRequeridos[$i]]."\n";
			}

		}
		return $valido;
	}
	
	/**
	 * Retorna el objeto del formulario como una cadena String que cumple
	 * las veces del metodo getForm, solo que aqui no es posible pasar por
	 * objeto el numero de columnas del formulario. Para hacerlo se debe pre
	 * viamente configurar el el atributo $this->Cols antes de retornar el
	 * objeto.
	 *
	 * @param integer $cols Numero de columnas que tiene el formulario
	 * @return string
	 */
	public function __toString (){
		return $this->getForm();
	}

	/**
	 * Imprime el formulario final
	 *
	 * @param integer $cols Numero de columnas
	 */
	public function showForm($cols = 2){
		print $this->getForm($cols);
	}

	/**
	 * Obtiene el HTML de un formulario previamente configurado
	 *
	 * @param integer $cols Numero de columnas que tiene el formulario
	 * @return string
	 */
	public function getForm($cols = 2){
		
		if ($cols)
			$this->cols = $cols;

		$buf = '';
		if ($this->use_cache){
			if (file_exists($this->cache_dir)){
				
				if (file_exists($fileForm = $this->cache_dir.$this->name.'___DATA___'.$this->cache_int_seconds_time.$this->cache_ext_file)){
					$arrayNomForm = split( '___', strrev($fileForm));

					list($H,$i,$s) = split(':',date("H:i:s",filemtime($fileForm)));
					$timeStampSecCreated = ($H*3600)+($i*60)+$s;
					
					list($H,$i,$s) = split(':',date("H:i:s"));
					$timeStampSecNow     = ($H*3600)+($i*60)+$s;

					if (($difer = $timeStampSecNow-$timeStampSecCreated)<= ($cacheSeconds = intval(strrev($arrayNomForm[0])))){
						$fileGestor = fopen($fileForm,'r');
						$fileContenido = fread($fileGestor,filesize($fileForm));
						fclose($fileGestor);
					}else{
						$fileGestor = fopen($fileForm,'w');
						fwrite($fileGestor,$fileContenido = $this->compileForm($this->cols));
						fclose($fileGestor);
					}

				}else{
					$fileGestor = fopen($fileForm,'w');
					fwrite($fileGestor,$fileContenido = $this->compileForm($this->cols));
					fclose($fileGestor);
				}
				
			}else{
				mkdir ($this->cache_dir,0777);
			}
			
		}else{
			$fileContenido = $this->compileForm($this->cols);
		}
		
		return $fileContenido;
	}

	/**
	 * Agrupa grupos de elementos previamente definidos
	 * para dejar un cojunto de grupos en una fila y no
	 * para que queden en filas separadas.
	 *
	 * @param string $idGroupingGroups Id del grupo de grupos
	 */
	public function shareSpaceForGroups ($arrayIdGroups){
		$this->arrayGroupsIdInShareSpace[] = array('arrayIdGroups' => $arrayIdGroups);
	}

	/*
	 * Cache de los formularios
	 */

	/**
	 * Verifica si un formulario esta o no cacheado
	 *
	 * @param string $strNomForm
	 * @return boolean
	 */
	public function isCached ($strNameForm){
		$return = false;
			
		if (file_exists($this->cache_dir.$strNameForm.session_id().$this->cache_ext_file));
			$return = true;

		return $return;
	}

	/**
	 * Configura la cache de el formualario para ser usada
	 * e activa por cada $intSeconds
	 *
	 * @param boolean $boolUseCache  Usar la cache o no
	 * @param integer $intSeconds    Numero de segundos en que la cache dura activa
	 */
	public function setCache ($boolUseCache = false, $intSeconds = 3600){
		$this->use_cache = $boolUseCache;
		$this->cache_int_seconds_time = $intSeconds;
	}

	/**
	 * Es llamada en la construccion del formulario para averiguar si en elemento de ese formulario esta
	 * ralacionada con un evento xAjax y de esa forma concatenarlo a la salida final del mismo
	 *
	 * @param string  ObjectForm Id del objeto del formulario que el buscara en el arreglo
	 */
	protected function checkExistEventJs($ObjectForm){
		$return = '';
		$array_keys = array_keys ($this->objEventxJ);

		if (in_array($ObjectForm, $array_keys)) {
			$return = $this->objEventxJ[$ObjectForm];
		}

		return $return;
	}

	/**
	 * Es llamada dentro de la construccion del
	 * formulario como un  metodo  que  ayuda a
	 * contruir  los  campos  con  un  atributo
	 * adicional  que  inhabilita  un campo del
	 * formulario  para  que  se  puedan  hacer
	 * eventos sobre el.
	 *
	 * @param string  objName Id del objeto del formulario que el buscara en el arreglo
	 */
	protected function checkIfIsDisabled ($objName){
		$disabledStr = ' disabled="disabled"';
		$return = '';
		if (in_array($objName,$this->objDisabled)){
			$return = $disabledStr;
		}

		return $return;
	}

	/**
	 * Llamada que dentro de la construccion del
	 * formulario verifica si el objeto que   se
	 * esta construyendo tiene adicionada    una
	 * cadena de ayuda relacionada.
	 *
	 * @param string $objName Nombre del objeto del formulario al que esta asociado
	 */
	protected function checkIsHelping ($objName){
		$return = '';
		$arrayKeysObjHelps = array_keys ($this->objHelps);
		if (in_array($objName,$arrayKeysObjHelps)){
			switch ($this->styleTypeHelp){
				case 1:
					$return = ' onmouseover="'.$objName.'.style.cursor=\'help\',Tip(\''.$this->objHelps[$objName].'\',BALLOON, true, ABOVE, true, FADEIN, 300, FADEOUT, 300)" ';//
					break;
				case 2:
					$return = ' onmouseover="'.$objName.'.style.cursor=\'help\',Tip(\''.$this->objHelps[$objName].'\')" ';//
					break;
			}
		}

		return $return;
	}

	/**
	 * Dentro de la llamada de contruccion del
	 * formulario verifica si el objeto que se
	 * esta construyendo tiene asociada un helper
	 * para entonces construirlo y adicionarlo
	 * al campo texto que sera mostrado en el formulario.
	 *
	 * @param string $objName Nombre del objeto del formulario al que esta asociado
	 * @return string
	 */
	protected function checkIsHasHelper ($objName){
		$return = '';
		$arrayKeysObjHelpers = array_keys ($this->objHelpers);
		if (in_array($objName,$arrayKeysObjHelpers)){
			$return .= '<script type="text/javascript">'."\n";
			if (is_array($this->objHelpers[$objName])){
				$return .= 'var '.$objName.'s = new Array (';
				foreach ($this->objHelpers[$objName] as $item){
					$return .= '"'.$item[0].'", ';
				}
				$return = substr($return,0,-2);
				$return .= ');'."\n";
				$return .= 'new AutoSuggest(document.getElementById(\''.$objName.'\'),'.$objName.'s);'."\n";
		   
			}else{
				$arrayTempItems = explode (',',$this->objHelpers[$objName]);
				if (count($arrayTempItems)){
					$return .= 'var '.$objName.'s = new Array (';
					foreach ($arrayTempItems as $item){
						$return .= '"'.trim($item).'", ';
					}
					$return = substr($return,0,-2);
					$return .= ');'."\n";
					$return .= 'new AutoSuggest(document.getElementById(\''.$objName.'\'),'.$objName.'s);'."\n";
				}
			}
			
			$return .= '</script>'."\n";
		}

		return $return;
	}
	
	/**
	 * Obtener el javascript necesario para
	 * imprimirlo en las etiquetas <head></head>
	 * para el cargar la configuracion del SWFUploader
	 *
	 */
	private function getJavaScriptSWFUploader (){
		$JS = '';
			
		$JS.= '<script type="text/javascript">'."\n";
		$JS.= 'var swfu;'."\n";
		$JS.= 'window.onload = function() {'."\n";
		$JS.= 'swfu = new SWFUpload({'."\n";

		$JS.= '// Backend Settings'."\n";
		$JS.= "\t".'upload_url : "'.$this->SWF_upload_url.'",'."\n";
			
		if (count($this->SWF_file_post_name)){
			$JS.= 'post_params : {'."\n";
			$swf_file_post_name_Keys = array_keys($this->SWF_file_post_name);
			for ($i=0;$i<count($this->SWF_file_post_name);$i++){
				$JS.= '"'.$swf_file_post_name_Keys[$i].'" : "'.$this->SWF_file_post_name[$swf_file_post_name_Keys[$i]].'"';
				if ($i!=(count($this->SWF_file_post_name)-1))
				$JS.= ',';
			}
			$JS.= "\n".'},'."\n";
		}
			
			
		$JS.= '// File Upload Settings '."\n";
		$JS.= "\t".'file_size_limit: "'.$this->SWF_file_size_limit.'",'."\n";
		$JS.= "\t".'file_types : "';
		for ($i=0;$i<count($this->SWF_file_types);$i++){
			$JS.= "".''.$this->SWF_file_types[$i].'';
			if ($i!=(count($this->SWF_file_types)-1))
			$JS.= ';';
		}
		$JS.= '",'."\n";
		$JS.= "\t".'file_types_description: "'.$this->SWF_file_types_description.'",'."\n";
		$JS.= "\t".'file_upload_limit: '.$this->SWF_file_upload_limit.','."\n";
		$JS.= "\t".'file_queue_limit: '.$this->SWF_file_queue_limit.','."\n";
			
		$JS.= '//Event Handler Settings - these functions as defined in Handlers.js'."\n";
		$JS.= '//The handlers are not part of SWFUpload but are part of my website and control how'."\n";
		$JS.= '//my website reacts to the SWFUpload events.'."\n";
		$JS.= "\t".'file_queue_error_handler: '.$this->SWF_file_queue_error_handler.','."\n";
		$JS.= "\t".'file_dialog_complete_handler: '.$this->SWF_file_dialog_complete_handler.','."\n";
		$JS.= "\t".'upload_progress_handler: '.$this->SWF_upload_progress_handler.','."\n";
		$JS.= "\t".'upload_error_handler: '.$this->SWF_upload_error_handler.','."\n";
		$JS.= "\t".'upload_success_handler: '.$this->SWF_upload_success_handler.','."\n";
		$JS.= "\t".'upload_complete_handler: '.$this->SWF_upload_complete_handler.','."\n";
		$JS.= "\t".'swfupload_loaded_handler: '.$this->SWF_swfupload_loaded_handler.','."\n";
		$JS.= "\t".'file_dialog_start_handler: '.$this->SWF_file_dialog_start_handler.','."\n";
		$JS.= "\t".'file_queued_handler: '.$this->SWF_file_queued_handler.','."\n";
		//$JS.= 'upload_start_handler: '.$this->SWF_upload_start_handler.','."\n";
		//$JS.= 'debug_handler: '.$this->SWF_debug_handler.','."\n";

		$JS.= '// Button Settings'."\n";
		$JS.= "\t".'button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,'."\n";
		$JS.= "\t".'button_cursor: SWFUpload.CURSOR.HAND,'."\n";
		
		
		$JS.= "\t".'button_image_url : "'.$this->SWF_button_image_url.'",'."\n";
		$JS.= "\t".'button_placeholder_id : "'.$this->SWF_button_placeholder_id.'",'."\n";
		$JS.= "\t".'button_width: '.$this->SWF_button_width.','."\n";
		$JS.= "\t".'button_height: '.$this->SWF_button_height.','."\n";
		
		if ($this->SWF_upload_several_files == true)
			$JS.= "\t".'button_action : SWFUpload.BUTTON_ACTION.SELECT_FILES,'."\n";
		else
			$JS.= "\t".'button_action : SWFUpload.BUTTON_ACTION.SELECT_FILE,'."\n";
		
		$JS.= "\t".'button_text : \'<span class="btnText">'.$this->SWF_str_etq_button.' ';

		/**
		 * Deprecated
		if ($this->SWF_src_img_button)
			$JS.= '<img style="padding-right: 3px; vertical-align: bottom;" src="'.$GLOBALS['urlProject'].$this->subFolder_inImg.$this->SWF_src_img_button.'" border="0">';
		*/
		$maxInfoSize = '';
		$maxFileSizeUpload = '';
		   
	    if ($this->SWF_show_max_upload_size_info_in_button){
	    	if ($this->SWF_file_size_limit<1024){
	    		$maxFileSizeUpload = $this->SWF_file_size_limit.' Kb';
	    	}else if ($this->SWF_file_size_limit<1048576){
	    	   	$maxFileSizeUpload = number_format($this->SWF_file_size_limit/1024,2).' Mb';
	    	}else{
      		   	$maxFileSizeUpload = number_format($this->SWF_file_size_limit/1048576,2).' Gb';
	    	}
	       	$maxInfoSize = '('.$maxFileSizeUpload.')';
	    }	   
			
			
		$JS.= $maxInfoSize.'</span>\','."\n";
		$JS.= "\t".'button_text_style : ".btnText { text-align: center; font-size: 9; font-weight: bold; font-family: MS Shell Dlg; }",'."\n";
		$JS.= "\t".'button_text_top_padding : 3,'."\n";
		$JS.= "\t".'button_text_left_padding : 0,'."\n"; 		
		
		$JS.= '//Flash Settings'."\n";
		$JS.= "\t".'flash_url: "'.$this->SWF_flash_url.'",'."\n";
		$JS.= "\t".'flash_width: "'.$this->SWF_flash_width.'",'."\n";
		$JS.= "\t".'flash_height: "'.$this->SWF_flash_height.'",'."\n";
		$JS.= "\t".'flash_color: "#'.$this->SWF_flash_color.'",'."\n";
			
		$JS.= '//Debug Settings'."\n";
		$JS.= "\t".'debug: '.$this->SWF_debug.''."\n";
			
		//$JS.= 'file_post_name : "'.$this->SWF_file_post_name.'",'."\n";
		/*
		 $JS.= 'custom_settings : {'."\n";
		 $swf_custom_settings_Keys = array_keys($this->SWF_custom_settings);
		 for ($i=0;$i<count($this->SWF_custom_settings);$i++){
		 $JS.= ''.$swf_custom_settings_Keys[$i].' : "'.$this->SWF_custom_settings[$swf_custom_settings_Keys[$i]].'"';
		 if ($i!=(count($this->SWF_custom_settings)-1))
		 $JS.= ',';
		 }
		 $JS.= '}'."\n";
		 */
		$JS.= '});'."\n";
		$JS.= '};'."\n";
		$JS.= '</script>'."\n";
			
		return $JS;
	}

	/**
	 * Dentro de la llamada de contruccion del  Formulario
	 * pregunta si ese nombre de campo tiene dentro  de el
	 * el caracter ':' para averiguar por el numero entero
	 * que viene despues de el,  ya que ese  numero entero
	 * representa las columnas que va a autocompletar para
	 * hacerse mas grande que los demas campos del formulario.
	 *
	 * Si existe dicho valor o no existe, este metodo guarda
	 * el valor colSpan de acuerdo al nombre del  objeto del
	 * formulario.
	 *
	 * @param string $objName Nombre del campo que va a evaluar
	 */
	private function getColspanRowspan ($objName){
		$rowspan = 0;
		$colspan = 0;
		if (strpos($objName,$this->colSpanIdentifier)){
			$arguments = explode ($this->colSpanIdentifier,$objName);
			$objName = $arguments[0];
			$this->arrayFormElementsColspan[$objName] = $arguments[1];
			if (isset($arguments[2]))
			   $this->arrayFormElementsRowspan[$objName] = $arguments[2];
			else   
			   $this->arrayFormElementsRowspan[$objName] = $rowspan;
		}else{
			$this->arrayFormElementsColspan[$objName] = $colspan;
			$this->arrayFormElementsRowspan[$objName] = $rowspan;
		}
	  
		return $objName;
	}

	/**
	 * Trata de averiguar si el parametro pasado a un evento creado
	 * es una cadena normal de texto o es una cadena formada por javascript
	 * @param $stringParam Parametro a evaluar
	 * @return boolean
	 */
	private function exists_JavascriptFormat_InParamEvent ($stringParam){
		$return = false;
		
		$arrayPosibleCadJavascript = array ('[','document','\'');
		
		foreach ($arrayPosibleCadJavascript as $char){
			if (strpos($stringParam,$char)){
				$return = true;
				break;
			}
		}
		
		return $return;
	}

	/**
	 * Compila el formulario de acuerdo con los
	 * parametros seleccionados previos.
	 *
	 * @param integer $intCols Numero de columnas
	 * @return string
	 */
	private function compileForm ($cols){
		
		$buf = ''."\n";

		$buf .= '<!--'."\n";
		$buf .= 'OSEZNO FRAMEWORK'."\n";
		$buf .= 'Generado con la clase para la creacion de Formularios myForm.class.php'."\n";
		$buf .= 'Nombre de Formulario: '.$this->name.''."\n";
		$buf .= 'Autor: Jose Ignacio Gutierrez Guzman -  joselitohacker@yahoo.es'."\n";
		$buf .= 'Version de la Clase:'.$this->version."\n";
		$buf .= '-->'."\n";

		if ($this->useAddFile)
		  $buf .= $this->getJavaScriptSWFUploader();
		
		$buf .= '<div class="'.$this->styleClassForm.'" align="center" id="div_'.$this->name.'" name="div_'.$this->name.'">'."\n";
		
		if (strlen($this->strFormFieldSet))
			$buf .= '<fieldset><legend class="'.$this->styleClassFieldsets.'">'.$this->strFormFieldSet.'</legend>'."\n";

		$this->cols = $cols;

		$buf .= '<form ';

		if ($this->action)
			$buf .= 'action="'.$this->action.'" ';

		$buf.= 'method="'.$this->method.'" ';

		if(!$this->action)
			$buf.= 'onsubmit="'.$this->onSubmitAction.'" ';

		if ($this->enctype)
			$buf.='enctype= "'.$this->enctype.'" ';
			
		$buf.= 'name="'.$this->name.'" id="'.$this->name.'" target="'.$this->target.'">'."\n";


		// Capa necesaria para ejecutar los helpers
		if (count($this->objHelpers))
			$buf .= '<div id="autosuggest"><ul></ul></div>';

		/**
		 * Creamos cada uno de los Objetos HTML
		 * con el objetivo de que mas adelante sean procesados en:
		 * Grupos, o Independientemente. No olvidar que los grupos
		 * pueden ser reagrupados en super grupos.
		 */
			
		if (count($this->Objects)){	
		$ObjectKeys = array_keys($this->Objects);
		$countObjects = count($this->Objects['field']);
		for($j=0, $objKeysFields = array_keys($this->Objects['field']); $j < $countObjects; $j++){
			$campos_f = split ($this->Separador,$this->Objects['field'][$objKeysFields[$j]]);
			switch ($campos_f[0]){
				case 'text':// Ok colSpan
					$keypress = '';
					if ($campos_f[6])
					$keypress = ' onKeyPress="return OnlyNum(event)"';

					$Disabled = '';
					$LauncherCalendar = '';

					if ($campos_f[7]){
						$LauncherCalendar = '<button type="button" class="'.$this->styleClassFields.'" id="trigger_'.$campos_f[2].'"  name="trigger_'.$campos_f[2].'" onClick="addCalendarWindow(document.getElementById(\''.$campos_f[2].'\').value, \''.$campos_f[2].'\', \''.$campos_f[2].'\')" /><img src="'.$GLOBALS['urlProject'].$this->pathImages.$this->srcImageCalendarButton.'" border="0"></button>';
						$LauncherCalendar .= '<div id="div_trigger_'.$campos_f[2].'" name="div_trigger_'.$campos_f[2].'" class="calmain" style="position:absolute;height:300px;width:300px;visibility:hidden">h</div>';
						 
						$Disabled = 'readonly';
					}
						
					$this->arrayFormElements[$campos_f[2]] = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld><input '.$this->checkIsHelping($campos_f[2]).' class="'.$this->styleClassFields.'" type="text" name="'.$campos_f[2].'" id="'.$campos_f[2].'" value="'.$campos_f[3].'" size="'.$campos_f[4].'" '.$Disabled.' maxlength="'.$campos_f[5].'"'.$keypress.''.$this->checkExistEventJs($campos_f[2]).''.$this->checkIfIsDisabled($campos_f[2]).'>'.$this->checkIsHasHelper($campos_f[2]).$LauncherCalendar.'</td>'."\n";
					break;
				case 'password':
					$this->arrayFormElements[$campos_f[2]] = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld><input '.$this->checkIsHelping($campos_f[2]).' class="'.$this->styleClassFields.'" type="password" name="'.$campos_f[2].'" id="'.$campos_f[2].'" value="'.$campos_f[3].'" size="'.$campos_f[4].'" maxlength="'.$campos_f[5].'" '.$this->checkExistEventJs($campos_f[2]).' '.$this->checkIfIsDisabled($campos_f[2]).'></td>'."\n";
					break;
				case 'file':
					$bufTemp = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld>';

					//$bufTemp .= '<button '.$this->checkIfIsDisabled($campos_f[2]).' '.$this->checkIsHelping($campos_f[2]).' class="'.$this->styleClassButtons.'" id="'.$campos_f[2].'" type="button"  onclick="'.$SWFonClick.'">';
					$bufTemp .= '<span id="spanButtonPlaceholder">';

					if ($this->SWF_src_img_button)
						$bufTemp .= '<img style="padding-right: 3px; vertical-align: bottom;" src="'.$GLOBALS['urlProject'].$this->pathImages.$this->SWF_src_img_button.'" border="0">';

					$maxInfoSize = '';   
	    			if ($this->SWF_show_max_upload_size_info_in_button){
	    				if ($this->SWF_file_size_limit<1024){
	           				$maxFileSizeUpload = '('.$this->SWF_file_size_limit.' Kb)';
	    				}else if ($this->SWF_file_size_limit<1048576){
	    	   				$maxFileSizeUpload = '('.number_format($this->SWF_file_size_limit/1024,2).' Mb)';
	    				}else{
      		   				$maxFileSizeUpload = '('.number_format($this->SWF_file_size_limit/1048576,2).' Gb)';
	    				}
	       				$maxInfoSize = '<font style="vertical-align: middle; font-size: 6pt; font-weight: bold;">'.$maxFileSizeUpload.'</font>';
	    			}	   
					
					//$bufTemp .= $this->SWF_str_etq_button.$maxInfoSize.'</button><div style="text-align: left;" class="'.$this->styleClassTags.'" id="div_file_progress" name="div_file_progress"></div>';
					$bufTemp .= '</span><div style="text-align: left;" class="'.$this->styleClassTags.'" id="div_file_progress" name="div_file_progress"></div>';
					$bufTemp .= '</td>'."\n";

					$this->arrayFormElements[$campos_f[2]] = $bufTemp;
					break;
				case 'select':
					$multiple = '';
					if ($campos_f[6])
					$multiple = ' multiple';
					$this->arrayFormElements[$campos_f[2]] = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld>'."\n\t\t".'<select '.$this->checkIsHelping($campos_f[2]).' class="'.$this->styleClassFields.'" name="'.$campos_f[2].'" id="'.$campos_f[2].'"'.$multiple.' size="'.$campos_f[4].'" '.$this->checkExistEventJs($campos_f[2]).' '.$this->checkIfIsDisabled($campos_f[2]).'>'."\n\t\t".$campos_f[3]."\t\t".'</td>'."\n";
					break;
				case 'hidden':
					$this->arrayFormElements[$campos_f[1]] = '<td rowSpanEtq colSpanEtq widthEtq>'.'<input type="hidden" name="'.$campos_f[1].'" id="'.$campos_f[1].'" value="'.$campos_f[2].'">'.'</td><td rowSpanFld colSpanFld widthFld>'."&nbsp;".'</td>'."\n";
					break;
				case 'textarea':
					$this->arrayFormElements[$campos_f[2]] = '<td rowSpanEtq style="text-align:center" colSpanEtq  class="'.$this->styleClassTags.'">'.$campos_f[1].'<br>'.
                    ''.'<textarea '.$this->checkIsHelping($campos_f[2]).' class="'.$this->styleClassFields.'" name="'.$campos_f[2].'" id="'.$campos_f[2].'" cols="'.$campos_f[4].'" rows="'.$campos_f[5].'" wrap="'.$campos_f[6].'" '.$this->checkExistEventJs($campos_f[2]).' '.$this->checkIfIsDisabled($campos_f[2]).'>'.$campos_f[3].'</textarea></td>'."\n";					 
					break;
				case 'fckeditor':
					$oFCKeditor = new FCKeditor($campos_f[2]) ;
					$oFCKeditor->BasePath = $this->FCK_editor_BasePath;
					$oFCKeditor->Value = $campos_f[3];

					$oFCKeditor->Width  = $this->FCK_editor_Width;
					$oFCKeditor->Height = $this->FCK_editor_Height;

					$oFCKeditor->Config['AutoDetectLanguage']	= false ;
					$oFCKeditor->Config['DefaultLanguage']    = $this->FCK_editor_Laguage;
					$oFCKeditor->ToolbarSet  = $this->FCK_editor_ToolbarSet;

					$this->arrayFormElements[$campos_f[2]] = ''.'<td rowSpanEtq '.$this->checkIsHelping($campos_f[2]).' style="text-align:center" colSpanEtq class="'.$this->styleClassTags.'">'.$campos_f[1]."<br>".$oFCKeditor->CreateHtml().'</td>'."\n";
					break;
				case 'mylist':

					/**
					 * TODO: Crear una lista dinamica con campos check box que permitan chequear elementos correspondientes a una tabla de base de datos o IDs asociados a un resultado de una consulta
					 */					
					
					break;
				case 'date':
					$bufTemp = '';
					$bufTemp .= '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld '.$this->checkIsHelping($campos_f[2]).'>'."\n\t\t".'<select class="'.$this->styleClassFields.'" name="'.$campos_f[2].'_Y" id="'.$campos_f[2].'_Y" '.$this->checkIfIsDisabled($campos_f[2]).'>'.$campos_f[3].'</select>/'."\t\t\n\t\t".'<select class="'.$this->styleClassFields.'" name="'.$campos_f[2].'_M" id="'.$campos_f[2].'_M" '.$this->checkIfIsDisabled($campos_f[2]).'>'.$campos_f[4].'</select>/'."\t\t\n\t\t".'<select class="'.$this->styleClassFields.'" name="'.$campos_f[2].'_D" id="'.$campos_f[2].'_D" '.$this->checkIfIsDisabled($campos_f[2]).'>'.$campos_f[5].'</select></td>'."\n";

					$this->arrayFormElements[$campos_f[2]] = $bufTemp;
					break;
				case 'whitespace':
					$this->arrayFormElements[$campos_f[1]] = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq><div name="e_'.$campos_f[1].'" id="e_'.$campos_f[1].'">'.$campos_f[2].'</div></td><td rowSpanFld colSpanFld widthFld class="'.$this->styleClassFields.'"><div name="c_'.$campos_f[1].'" id="c_'.$campos_f[1].'">'.$campos_f[3].'</div></td>'."\n";
					break;
				case 'coment':
					$this->arrayFormElements[$campos_f[1]] = '<td widthEtq rowSpanEtq class="'.$this->styleClassTags.'" colSpanEtq>'.$campos_f[2].'</td>';
					break;
				case 'checkbox':
					$value = '0';
					$cheked = '';

					if ($campos_f[3] == 'S'){
						$cheked = 'checked';
						$value  = '1';
					}

					$onClickTag   = 'onclick="checkear(\''.$this->name.'\', \''.$campos_f[2].'\'), Check(\''.$this->name.'\', \''.$campos_f[2].'\')';
					$onClickField = 'onclick="Check(\''.$this->name.'\', \''.$campos_f[2].'\')';
						
					$onEvent = $this->checkExistEventJs($campos_f[2]);
					if ($onEvent){
						if (strpos(strtolower($onEvent),'onclick')){
							$addEvent = substr($onEvent,10,-2);
							 
							$onClickTag .= ','.$addEvent;
							$onClickField	.= ','.$addEvent;

							$onEvent = '';
						}
					}
						
					$onClickTag    .= '"';
					$onClickField  .= '"';
						
					$this->arrayFormElements[$campos_f[2]] = '<td rowSpanEtq colSpanEtq '.$onClickTag.' '.$onEvent.' class="'.$this->styleClassTags.'"  widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld><input '.$onClickField.' '.$onEvent.' '.$this->checkIsHelping($campos_f[2]).' class="'.$this->styleClassFields.'" type="checkbox" name="'.$campos_f[2].'" id="'.$campos_f[2].'" value="'.$value.'"   '.$cheked.' '.$this->checkIfIsDisabled($campos_f[2]).'>'.'</td>'."\n";
					break;
				case 'time':
					$bufTemp = '';
					$bufTemp .= '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld '.$this->checkIsHelping($campos_f[2]).' widthFld>'."\n\t\t".'<select class="'.$this->styleClassFields.'" name="'.$campos_f[2].'_H" id="'.$campos_f[2].'_H" size="1" '.$this->checkExistEventJs($campos_f[2]).' '.$this->checkIfIsDisabled($campos_f[2]).'>'.$campos_f[3].'</select>:'."\n\t\t".'<select class="'.$this->styleClassFields.'" name="'.$campos_f[2].'_M" id="'.$campos_f[2].'_M" size="1" '.$this->checkExistEventJs($campos_f[2]).' '.$this->checkIfIsDisabled($campos_f[2]).'>'.$campos_f[4].'</select>'.'</td>'."\n";

					$this->arrayFormElements[$campos_f[2]] = $bufTemp;
					break;
				case 'radiobutton':

					$cheked = '';
					if ($campos_f[5] == 'S')
					$cheked = 'checked';

					$this->arrayFormElements[$campos_f[2]] = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld><input '.$this->checkIsHelping($campos_f[4]).' class="'.$this->styleClassFields.'" type="radio" name="'.$campos_f[4].'" id="'.$campos_f[4].'_'.$campos_f[3].'" value="'.$campos_f[3].'" '.$this->checkExistEventJs($campos_f[4]).' '.$this->checkIfIsDisabled($campos_f[4]).' '.$cheked.'></td>'."\n";
					break;
			}
		}
		}
		/**
		 * Creamos el HTML de cada unos de lo grupos que agrupan campos
		 */
		$countArrayGroups = count($this->arrayGroups);
		for ($kAgrupa = 0; $kAgrupa < $countArrayGroups; $kAgrupa++){
			$bufHTMLgroup = '';
			$bufHTMLgroup.= '';
			
			$hrefUseShowHideIni = '';
			$hrefUseShowHideEnd = '';
			$styleDivFieldSet = '';
			
			if ($this->arrayGroups[$kAgrupa]['useShowHide']){
				
				$hrefUseShowHideIni = '<a href="javascript:void(MostrarEsconderFieldSet(\''.$this->arrayGroups[$kAgrupa]['idGroup'].'\'))">';
				$hrefUseShowHideEnd = '</a>';
				
				switch ($this->arrayGroups[$kAgrupa]['iniVisibilitySts']){
					case 'show':
						$styleDivFieldSet = ' style="display:\'\';"';
						break;
					case 'hide':
						$styleDivFieldSet = ' style="display: none;"';
						break;
				}
			}
			
			$bufHTMLgroup .= '<fieldset><legend class="'.$this->styleClassFieldsets.'">'.$hrefUseShowHideIni.$this->arrayGroups[$kAgrupa]['strFieldSet'].$hrefUseShowHideEnd.'</legend>'."\n";
			$bufHTMLgroup .= '<div name="'.$this->arrayGroups[$kAgrupa]['idGroup'].'" id="'.$this->arrayGroups[$kAgrupa]['idGroup'].'"'.$styleDivFieldSet.'>'."\n";
			
			//  Preguntamos si el grupo en proceso es un arreglo de elementos
			if (is_array($this->arrayGroups[$kAgrupa])){
				$bufHTMLgroup .= '<table class="'.$this->styleClassTableForm.'" border="'.$this->border.'" align="center" cellpadding="'.$this->cellPadding.'" cellspacing="'.$this->cellSpacing.'" valign="top" width="100%">'."\n";
				$kCamposDe = count($this->arrayGroups[$kAgrupa]['arraystrIdFields']);
				// Calculamos cuantos filas y columna tendra este marco
				$widthCol = intval(100/($this->arrayGroups[$kAgrupa]['intColsByGroup']*2));
				# Numero de filas
				$cantCamposInGroup = count($this->arrayGroups[$kAgrupa]['arraystrIdFields']);

				$iTemp = 0;
				$numColSpan = 0;
				$cantTr = 0;
				$sumNumColSpan = 0;
				for ($i = 0; $i < $cantCamposInGroup; $i++){
						
					$nameField = $this->arrayGroups[$kAgrupa]['arraystrIdFields'][$i];

					if (!(($iTemp)%$this->arrayGroups[$kAgrupa]['intColsByGroup']) || !$iTemp){
						$htmlUseRowSeparator = '';
						if ($this->useRowSeparator){
							if (!(($cantTr+2)%2))
							$htmlUseRowSeparator = 'class = "'.$this->styleClassRowSeparator.'"';
						}
							
						$bufHTMLgroup .= "\t".'<tr '.$htmlUseRowSeparator.'>'."\n";
						$cantTr++;
					}

					if (isset($this->arrayFormElementsColspan[$nameField])){
						$numColSpan = $this->arrayFormElementsColspan[$nameField];
						$iTemp += $numColSpan;
						$sumNumColSpan += $numColSpan;
					}else{
						$numColSpan = 0;
						$iTemp++;
						$sumNumColSpan ++;
					}
						
					$attObj = $this->arrayFormElementType[$nameField];
					if ($numColSpan){
						switch($attObj){
							case 'textarea':
								$bufHTMLgroup .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
								                  array('width="'.intval($widthCol*$numColSpan).'%"','width="'.intval($widthCol*$numColSpan).'%"','colspan="'.($numColSpan*2).'"','colspan="'.($numColSpan*2).'"','',''),$this->arrayFormElements[$nameField]);
								break;
							/**
							 * TODO: Para revision
							 */	
							case 'coment':
								$bufHTMLgroup .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
								                  array('width="'.intval(($widthCol*$numColSpan)*2).'%"','','colspan="'.($numColSpan*2).'"','colspan="'.($numColSpan*2).'"','',''),$this->arrayFormElements[$nameField]);								
								break;
							/**
							 * TODO: Para revision
							 */		
							default:
								$bufHTMLgroup .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
								                  array('width="'.intval($widthCol*$numColSpan).'%"','width="'.intval($widthCol*$numColSpan).'%"','colspan="'.$numColSpan.'"','colspan="'.$numColSpan.'"','',''),$this->arrayFormElements[$nameField]);
								break;
						}
					}else{
						switch($attObj){
							case 'textarea':
								$bufHTMLgroup .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
								                  array('width="'.intval($widthCol).'%"','width="'.intval($widthCol).'%"','colspan="2"','colspan="2"','',''),$this->arrayFormElements[$nameField]);
								break;
							/**
							 * TODO: Para revision
							 */	
							case 'coment':
								$bufHTMLgroup .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
								                  array ('width="'.intval($widthCol*2).'%"','','','','',''),$this->arrayFormElements[$nameField]);								
								break;
							/**
							 * TODO: Para revision
							 */		
							default:
								$bufHTMLgroup .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
								                  array('width="'.intval($widthCol).'%"','width="'.intval($widthCol).'%"','','','',''),$this->arrayFormElements[$nameField]);
								break;
						}
					}
						
					if (!(($iTemp)%$this->arrayGroups[$kAgrupa]['intColsByGroup']) && $iTemp){
						$bufHTMLgroup .= "\t".'</tr>'."\n";
					}
				}

				//Calculamos las que faltan para completar el combo
				$tdFaltan = ($cantTr*$this->arrayGroups[$kAgrupa]['intColsByGroup'])-$sumNumColSpan;

				if ($tdFaltan){
					for ($i = 0; $i < $tdFaltan; $i++){
						$bufHTMLgroup .= "\t\t".'<td class="'.$this->styleClassTags.'">&nbsp;</td><td class="'.$this->styleClassTags.'">&nbsp;</td>'."\n";
					}
					$bufHTMLgroup .= "\t".'</tr>'."\n";
				}


				$bufHTMLgroup .= '</table>'."\n";
			}else{
				$bufHTMLgroup .= '';
			}
			
			$bufHTMLgroup .= '</div>'."\n";
			$bufHTMLgroup .= '</fieldset>'."\n\n";
			
			$this->arrayGroupsElementsHTML[$this->arrayGroups[$kAgrupa]['idGroup']] = $bufHTMLgroup;
		}

		/**
		 * Recorrer cada unos de los grupos que agrupan
		 * grupos de campos para poder dividirlos.
		 */
		$countarrayGroupsIdInShareSpace = count ($this->arrayGroupsIdInShareSpace);
		$arrayKeysGroupingGroups  = array_keys($this->arrayGroupsIdInShareSpace);
		for ($i=0;$i<$countarrayGroupsIdInShareSpace;$i++){
			// Pregunta de seguridad
			if (is_array($arrayGroupsIdInShareSpace = $this->arrayGroupsIdInShareSpace[$arrayKeysGroupingGroups[$i]]['arrayIdGroups'])){
				$buf .= '<table width="100%" border="'.$this->border.'" cellspacing="0">'."\n";
				$buf .= '<tr>'."\n";
				for ($j=0;$j<count($arrayGroupsIdInShareSpace);$j++){
					$buf.='<td width="'.intval(100/count($arrayGroupsIdInShareSpace)).'%">'.$this->arrayGroupsElementsHTML[$arrayGroupsIdInShareSpace[$j]].'</td>'."\n";
					$this->arrayGroupsShown[]=$arrayGroupsIdInShareSpace[$j];
				}
				$buf .= '</tr>'."\n";
				$buf .= '</table>'."\n";
			}
		}

		/**
		 * Mostrar cada uno de los grupos que no han sido mostrados
		 */
		for ($i=0;$i<$countArrayGroups;$i++){
			if (!in_array($this->arrayGroups[$i]['idGroup'],$this->arrayGroupsShown)){
				$buf .= $this->arrayGroupsElementsHTML[$this->arrayGroups[$i]['idGroup']];
				$this->arrayGroupsShown[]=$this->arrayGroups[$i]['idGroup'];
			}
		}

		// Calculamos los Id de los objectos definidos del formulario que no han sido definidos
		$countArrayFormElements = count($this->arrayFormElements);
		$arrayKeysFormElements = array_keys($this->arrayFormElements);
		for ($i=0;$i<$countArrayFormElements;$i++){
			if (!in_array($arrayKeysFormElements[$i],$this->arrayFormElementsShown)){
				$this->arrayFormElementsToShow[] = $arrayKeysFormElements[$i];
			}
		}

		// Imprimimos los elementos del formulario restantes
		$buf .= '<table border="'.$this->border.'" align="center" cellpadding="'.$this->cellPadding.'" cellspacing="'.$this->cellSpacing.'" valign="top" width="'.$this->width.'" height="'.$this->height.'">'."\n";
		$widthCol = intval(100/($this->cols*2));
		$cantCamposToShow = count($this->arrayFormElementsToShow);

		$iTemp = 0;
		$numColSpan = 0;
		$cantTr = 0;
		$sumNumColSpan = 0;
		for ($i = 0; $i < $cantCamposToShow; $i++){
				
			$nameField = $this->arrayFormElementsToShow[$i];

			if (!(($iTemp)%$this->cols) || !$iTemp){
				$htmlUseRowSeparator = '';
				if ($this->useRowSeparator){
					if (!(($cantTr+2)%2))
					$htmlUseRowSeparator = ' class = "'.$this->styleClassRowSeparator.'"';
				}
					
				$buf .= "\t".'<tr'.$htmlUseRowSeparator.'>'."\n";
				$cantTr++;
			}

			if (isset($this->arrayFormElementsColspan[$nameField])){
				if($this->arrayFormElementsColspan[$nameField]){
					$numColSpan = $this->arrayFormElementsColspan[$nameField];
					$iTemp += $numColSpan;
					$sumNumColSpan += $numColSpan;
				}else{
					$numColSpan = 0;
					$iTemp++;
					$sumNumColSpan ++;
				}
			}else{
				$numColSpan = 0;
				$iTemp++;
				$sumNumColSpan ++;
			}
				
			$attObj = $this->arrayFormElementType[$nameField];
			if ($numColSpan){
				switch($attObj){
					case 'textarea':
						$buf .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
						         array('width="'.intval($widthCol*$numColSpan).'%"','width="'.intval($widthCol*$numColSpan).'%"','colspan="'.($numColSpan*2).'"','colspan="'.($numColSpan*2).'"','',''),$this->arrayFormElements[$nameField]);
						break;
					default:
						$buf .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
						         array('width="'.intval($widthCol*$numColSpan).'%"','width="'.intval($widthCol*$numColSpan).'%"','colspan="'.$numColSpan.'"','colspan="'.$numColSpan.'"','',''),$this->arrayFormElements[$nameField]);
						break;
				}
			}else{
				switch($attObj){
					case 'textarea':
						$buf .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
						         array('width="'.intval($widthCol).'%"','width="'.intval($widthCol).'%"','colspan="2"','colspan="2"','',''),$this->arrayFormElements[$nameField]);
						break;
					default:
						$buf .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
						         array('width="'.intval($widthCol).'%"','width="'.intval($widthCol).'%"','','','',''),$this->arrayFormElements[$nameField]);
						break;
				}
			}
			
			if (!(($iTemp)%$this->cols) && $iTemp){
				$buf .= "\t".'</tr>'."\n";
			}

		}

		$tdFaltan = ($cantTr*$this->cols)-$sumNumColSpan;
		if ($tdFaltan){
			for ($i = 0; $i < $tdFaltan; $i++){
				$buf .= "\t\t".'<td class="'.$this->styleClassTags.'">&nbsp;</td><td class="'.$this->styleClassTags.'">&nbsp;</td>'."\n";
			}
			$buf .= "\t".'</tr>'."\n";
		}

		$buf .= '</table>'."\n";

		$buf .= '<table border="'.$this->border.'" align="center" width="'.$this->width.'">'."\n";
		$buf .= '<tr>';

		$countArrayButtonList = count ($this->arrayButtonList);
		$intWidth = 100;
		
		if ($countArrayButtonList)
			$intWidth = $intWidth / ($countArrayButtonList);
			
		$strMixedParams = '';
			
		// Para mostrar los demas botones
		for ($j = 0; $j < $countArrayButtonList; $j++){
			$buf .= '<td align="center" style="text-align:center" width="'.$intWidth.'%">';

			$buf .= '<button '.$this->checkIsHelping($this->arrayButtonList[$j]['strName']).' '.$this->checkIfIsDisabled($this->arrayButtonList[$j]['strName']).' value="'.trim(strip_tags($this->arrayButtonList[$j]['strLabel'])).'" class="'.$this->styleClassButtons.'" type="submit" name="'.$this->arrayButtonList[$j]['strName'].'" id="'.$this->arrayButtonList[$j]['strName'].'" ';
			
			if ($this->arrayButtonList[$j]['jsFunction'] && !$this->action){

				$jsFunction = $this->arrayButtonList[$j]['jsFunction'];
				
				if (stripos($jsFunction,':')!==false){
					
	  				$mixedExtParams = array();
		  			$strMixedParams = '';
		  		
		  			$intCountPrm = count($mixedExtParams = split(':',$jsFunction));
		  			$iExtParams = 0;
		  		
		  			foreach ($mixedExtParams as $param){
					
		  				if (!$iExtParams)
					   		$jsFunction = $param; 	
		  			
		  				if ($jsFunction!=$param){
		  					if (!is_numeric($param))
								$strMixedParams .= '\''.$param.'\'';
							else	
								$strMixedParams .= $param;
		  				}
		  			
		  				if (($iExtParams+1)<$intCountPrm){
							$strMixedParams .= ',';
		  				}
		  			
						$iExtParams++;					  			
		  			}
		  		}
				
				$buf .= ' onclick="'.$this->prefAjax.$jsFunction.'('.$this->jsFunctionSubmitFormOnEvent.'(\''.$this->name.'\')'.$strMixedParams.')"';
				
			}else if ($this->arrayButtonList[$j]['jsFunction'] && $this->action){
				
				$buf .= ' onclick="'.$this->prefAjax.$this->arrayButtonList[$j]['jsFunction'].'('.$this->jsFunctionSubmitFormOnEvent.'(\''.$this->name.'\')'.$strMixedParams.')"';
			}else{
				$buf .= ' onclick="'.$this->name.'.submit()" ';
			}
			$buf .= '>';

			$buf.='<table border="0" cellpadding="0" cellspacing="0"><tr>';
			
			if (isset($this->arrayButtonList[$j]['strSrcImg']))
				$buf .= '<td><img style="padding-right: 2px;" src="'.$this->arrayButtonList[$j]['strSrcImg'].'" border="0"></td>';

			$buf.='<td class="boton_font">'.$this->arrayButtonList[$j]['strLabel'].'</td></tr></table>';

			$buf.='</button></td>';
		}

		$buf .='</tr>';
		$buf .= '</table>'."\n";

		$buf .= '</form>'."\n";

		if (strlen($this->strFormFieldSet))
			$buf .= '</fieldset>'."\n";
			
		$buf .= '</div>'."\n";

		$buf .= '<!-- Fin de Formulario: '.$this->name.' -->'."\n";

		return $buf;
	}	
	
	// Fin de la Clase
}
?>