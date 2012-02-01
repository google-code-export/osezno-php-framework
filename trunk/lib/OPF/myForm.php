<?php
	
/**
 * myForm
 *
 * La clase myForm permite al desarrollador crear/generar diferentes formas de formularios.
 *
 * @uses Creacion de formularios
 * @package OPF
 * @version 1.6.0
 * @author José Ignacio Gutiérrez Guzmán <jose.gutierrez@osezno-framework.org>
 */
class OPF_myForm {

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
	private $paramTypeOnEvent = 'global';
	
	/**
	 * Extension de el archivo que la cache generara
	 *
	 * @var string
	 */
	private $cache_ext_file = '.mfc';

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
		'widthCell',
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
	 * Elementos que reciben trato especial al aplicar colspan
	 * 
	 * @var array
	 */
	private $arrayTypeElemSpecial = array ('textarea','button','coment','WYSIWYG');
	
	/**
	 * Instancias creadas de CKEditor
	 * 
	 * @var array
	 */
	private $arrayCKEditorInstances = array();
	
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
	 * Verifica si un objeto tipo file ha sido
	 * agregado al formulario despues de haber
	 * cargado la pagina.
	 *
	 * @var bool
	 */
	public $useAddFileAfterLoad = false;

	/**
	 * Arreglo protegido que almacena los eventos Xajax para los que se le fueron asignados
	 *
	 * @var array
	 */
	private $objEventxJ = array();

	/**
	 * Arreglo que contiene los nombres de los objetos que tendran la propiedad Disabled
	 * dentro del formulario
	 *
	 * @var array
	 */
	private $objDisabled = array();
	
	/**
	* Arreglo que contiene los nombres de los objetos y el valor de la propiedad autocomplete
	* dentro del formulario
	*
	* @var array
	*/
	private $objAutoComplete = array();

	/**
	 * Arreglo que contiene los nombres de los objetos que
	 * estan referenciados como objetos del formulario que
	 * contendran un nivel de ayuda.
	 *
	 * @var array
	 */
	private $objHelps = array ();

	/**
	 * Editor WYSIWYG que se va a usar.
	 * 
	 * @var string
	 */
	private $WYSIWYG_type = 'ck_editor';
	
	/**
	 * Listado de editores disponibles para usar.
	 * 
	 * @var array
	 */
	private $WYSIWYGtypeEditorAvailable = array(
	
		'ck_editor'=>'ckeditor.php'
	);
	
	/**
	 * Metodo (method) del formulario.
	 * 
	 * El metodo que utilizara en el momento de enviar el Formulario.
	 * @var string
	 */
	public $method = 'post';
	
	/**
	 * Accion (action) del formulario.
	 * 
	 * La ruta del script que procesara los datos. 
	 * @var string
	 */
	public $action;

	/**
	 * Objetivo (target) del formulario.
	 * 
	 * La ventana en donde se abrira la informacion enviada desde ese formulario. (_self, _blank, _parent, _top)
	 * @var string
	 */
	public $target = '_self';

	/**
	 * Tipo MIME (Enctype) del formulario.
	 * 
	 * El tipo de datos que va a enviar, usualmente se utiliza para manejar acrchivos. (application/x-www-form-urlencoded, multipart/form-data)
	 * @var string
	 */
	public $enctype;

	/**
	 * Prefijo xajax.
	 * 
	 * Prefijo que usa xajax para llamar a sus funciones.
	 * @var string
	 */
	public $prefAjax = '';

	/**
	 * Nombre (name) del formulario.
	 * 
	 * El nombre del formulario con el que se esta interactuando.
	 * @var string
	 */
	public $name;

	/**
	 * Directorio cache.
	 * 
	 * Directorio en donde el formulario sera cacheado si la opcion esta habilitada.
	 * @var string
	 */
	public $cache_dir = 'myform_cache/';

	/**
	 * Usar cache.
	 * 
	 * Define si se va a usar o no cache para el formulario.
	 * @var boolean
	 */
	public $use_cache = false;

	/**
	 * Columnas.
	 * 	 
	 * Numero de columnas en las que se divira la vista del formulario. Un campo sera ubicado en cada columna.
	 * @var integer
	 */
	public $cols = 2;

	/**
	 * Anchura interior de celda.
	 * 
	 * Anchura interior de una celda, en este caso para el formulario.
	 * @var integer
	 */
	public $cellPadding = 2;

	/**
	 * Espacio entre celdas.
	 * 
	 * Espacion interior entre celdas, en este caso para el formulario.
	 * @var integer
	 */
	public $cellSpacing = 0;

	/**
	 * Ancho de formulario.
	 * 
	 * Tamano de ancho de la tabla que contiene el formulario en porcentaje o px.
	 * @var string
	 */
	public $width = '97%';

	/**
	 * Alto de formulario.
	 * 
	 * Tamano de alto de la tabla que contiene el formulario en porcentaje o px.
	 * @var string
	 */
	public $height = '0%';

	/**
	 * Borde de tabla.
	 * 
	 * Borde de la tabla que contiene el formulario.
	 * @var integer
	 */
	public $border = 0;

	/**
	 * Usar pirmer valor en campos tipo select.
	 * 
	 * Permite decidir si se va a usar o no una opcion en el select que  muestre un etiqueta por defecto como presentacion segun el idioma que utilize.
	 * @var boolean
	 */
	public $selectUseFirstValue = true;

	/**
	 * SRC imagen boton calendario.
	 * 
	 * Ruta de la Imagen que acompana el boton de cada uno de los Controles de calendario.
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
	 * Etiqueta primer opcion en campos tipo SELECT
	 * 
	 * Etiqueta de la primera opcion por select que se activa solo si $objMyForm->selectUseFirstValue es igual a 'true'.
	 * @var string
	 */
	public $selectStringFirstLabelOption = LABEL_FIRST_OPT_SELECT_FIELD;

	/**
	 * Usar distincion de filas.
	 * 
	 * Utilizar o no la fila intermedia de color diferente para diferenciar visualmente las filas de los campos en un formulario.
	 * Nota: Al activar este atributo debe tenerse en cuenta la clase de estilos que usa por medio de 'styleClassRowSeparator'
	 * @var boolean
	 */
	public $useRowSeparator = false;
	
	/**
	 * Clase CSS Formularios
	 * 
	 * Nombre de la clase que por defecto usan los formularios.
	 * @var string
	 */
	public $styleClassForm = 'formulario';
	
	/**
	 * Clase CSS tabla formulario.
	 * 
	 * Nombre de la clase que por defecto usan las tablas que se crean para el formulario.
	 * @var string
	 */
	public $styleClassTableForm = 'fondo_tabla_form';

	/**
	 * Clase CSS filas intermedias.
	 * 
	 * Nombre de la clase que por defecto usan las filas del medio para los formularios cuando $myForm->useRowSeparator es true.
	 * @var string
	 */
	public $styleClassRowSeparator = 'fondo_fila_medio';

	/**
	 * Clase CSS Ayudas tipo.
	 * 
	 * Tipo del la ayuda que mostrara el help sobre los campos que se configuraron previamente (1 ó 2).
	 * @var integer
	 */
	public $styleTypeHelp = 1;

	/**
	 * Clase CSS Campos.
	 * 
	 * Nombre de la clase que por defecto usan los campos del formulario para ser mostrados.
	 * @var string
	 */
	public $styleClassFields = 'caja';

	/**
	 * Clase CSS Botones.
	 * 
	 * Nombre de la clase que por defecto usan los los botones del formulario que seran mostrados.
	 * @var string
	 */
	public $styleClassButtons = 'boton';

	/**
	 * Clase CSS etiquetas.
	 * 
	 * Nombre de la clase que por defecto usan las etiquetas de los campos del formulario que seran mostrados.
	 * @var string
	 */
	public $styleClassTags = 'etiqueta';

	/**
	 * Clase CSS comentarios.
	 * 
	 * Nombre de la clase que por defecto usan los comentarios dentro del formulario.
	 * @var string
	 */
	public $styleClassComments = 'comentario';
	
	/**
	 * Clase CSS Fieldset.
	 * 
	 * Nombre de la clase que por defecto usan los fieldsets del formulario.
	 * @var string
	 */
	public $styleClassFieldsets = 'formulario_fieldset';

	/**
	 * Etiqueta Legend formulario.
	 * 
	 * Etiqueta del Legend del Fieldset que usara el formulario.
	 * @var string
	 */
	public $strFormFieldSet = '';
	
	/**
	 * Id DIV
	 * 
	 * Id del span donde el button se va a alojar.
	 * @var string
	 */
	public $FILE_button_placeholder_id = 'spanButtonPlaceholder';
	
	/**
	 * Atributos seteados en cada obeto tipo file,
	 * 
	 * @var array
	 */
	private $FILES_atts = array();
	
	/**
	 * Atributos permitidos a modificar en cada addFile o getFile
	 */
	private $FILES_atts_ = array(
	
		'upload_url'=>'',
	
		'file_post_name'=>array(),
	
		'post_params'=>array(),
	
		'file_types'=>array('*.*'),
	
		'file_types_description'=>'Todos los tipos',
	
		'size_limit'=>2048,
	
		'show_max_upload_size_info_in_button'=>true,
	
		'file_upload_limit'=>0,
	
		'file_queue_limit'=>0,
	
		'flash_url'=>'',
	
		'button_image_url'=>'button_file.gif',
	
		'button_width'=>160,
	
		'button_height'=>22,
	
		'flash_width'=>'0px',
	
		'flash_height'=>'0px',
	
		'flash_color'=>'FFFFFF',
	
		'debug'=>'false',
	
		'swfupload_loaded_handler'=>'swfuploadLoadedHandler',
	
		'file_dialog_start_handler'=>'fileDialogStart',
	
		'file_queued_handler'=>'fileQueued',
	
		'file_queue_error_handler'=>'fileQueueError',
	
		'file_dialog_complete_handler'=>'fileDialogComplete',
	
		'upload_start_handler'=>'uploadStart',
	
		'upload_progress_handler'=>'uploadProgress',
	
		'upload_error_handler'=>'uploadError',
	
		'upload_success_handler'=>'uploadSuccess',
	
		'upload_complete_handler'=>'uploadComplete',
	
		'debug_handler'=>'debugHandler',
	
		'custom_settings'=>array(),
	
		'str_etq_button'=>'Examinar',
	
		'upload_several_files'=>'false'
	
 	);
	
	/**
	 * Configura un atributo sobre un objeto tipo file.
	 * 
	 * Solo los siguientes parametros estan admitidos:
	 * upload_url: Url del script que procesa las peticiones de envio de archivos al servidor cuando exite un campo tipo file.
	 * file_post_name: El nombre del campo cuando es enviado por el metodo POST, The Linux Flash Player ignores this setting.
	 * post_params: Post params on file object. The param_object should be a simple JavaScript object. All names and values must be strings.
	 * file_types: Los tipos de archivo que son admisibles al seleccionarlos. (Ejemplo: admitir solo archivos tipo txt y php seria array('*.php','*.txt'))
	 * file_types_description: La descripcion de los tipos de archivo que se pueden subir al servidor, esta etiqueta aparecera en el cuadro de dialogo de seleccion de archivos.
	 * size_limit: El tamano maximo en kilobytes para que un archivo pueda ser subido al  servidor de datos.
	 * show_max_upload_size_info_in_button: Configura si se va a mostrar o no informacion de la capacidad max de subida por archivo en el boton que abre la ventana de dialogo para el swf_uploader.
	 * file_upload_limit: Numero maximo de archivos que pueden ser subidos en un intento (cero es sin limite).
	 * file_queue_limit: Numero maximo de archivos en archivos en  cola que pueden estar (cero es sin limite).
	 * flash_url: Url en donde se encuentra el SWF que permite la carga  de los archivos al servidor.
	 * button_image_url: Fuente de la imagen que por defecto se va a cargar como base para dibujar el boton de carga de archivos.
	 * button_width: Ancho del boton en px en el formulario.
	 * button_height: Alto del boton en px en el formulario.
	 * flash_width: Ancho de el tamano del flash.
	 * flash_height: Alto de el tamano del flash.
	 * flash_color: Color de fondo para el flash.
	 * debug: Habilitar el debug o no
	 * swfupload_loaded_handler: The swfUploadLoaded event is fired by flashReady. It is overridable. When swfUploadLoaded is called it is safe to call SWFUpload methods.
	 * file_dialog_start_handler: Este evento se dispara inmediatamente antes de que la ventana de dialogo de seleccion de archivos sea abierta. Sin embargo el evento no va a terminar ni a cerrarse hasta que la ventana dialogo de seleccion de archivos este sea cerrada por cancelacion, o aceptacion.
	 * file_queued_handler: No usar o tener en cuenta este evento.
	 * file_queue_error_handler: Se ejecuta cuando existe o se produjo un error de validacion en la lista seleccionada de los archivos  que el  usuario selecciono. Por ejemplo para ayudar a validar que el archivo no sea demasiado grande o que sea del tipo que se esta parametrizando. Parametros que se pasan al evento: (file object, error code, message)
	 * file_dialog_complete_handler: Se ejecuta cuando se a echo click sobre el boton aceptar del cuadro de dialogo de los archivos que van a ser subidos al servidor. Esto generalmente esta haciendo el cargue automatico de los archivos con "this.startUpload();" Parametros que se pasan al evento: (number of files selected, number of files queued)
	 * upload_start_handler: Funcion que es llamada cuando comienza todo el cargue completo de los archivos y para que en cierta forma tambien se pueda hacer automaticamente. Parametros que se pasan al evento: (file object)
	 * upload_progress_handler: Se produce cuando el listado de los archivos que actualmente se han seleccionado estan en proceso de ser subidos al servidor. Parametros que se pasan al evento: (file object, bytes complete, total bytes)
	 * upload_error_handler: El evento es uploadError se dispara en cualquier momento cuando la carga de un archivo se interrumpe o no se completa con éxito. El código de error parámetro indica el tipo de error que se produjo. El código de error parámetro especifica una constante en SWFUpload.UPLOAD_ERROR. Parametros que se pasan al evento: (file object, error code, message)
	 * upload_success_handler: Este evento se ejecuta cuando un archivo es subido exitosamente al servidor, mientras tanto otros archivos pueden seguir siendo subidos. Parametros que se pasan al evento: (file object, server data)
	 * upload_complete_handler: Este evento siempre se dispara al final de un ciclo de una carga. En este punto la carga esta completa y otra puede comenzar. Parametros que se pasan al evento: (file object)
	 * debug_handler: debugHandler
	 * custom_settings: Custom settings
	 * str_etq_button: Texto que esta dentro del boton quen  examina   los   archivos.
	 * upload_several_files: Decidir si por upload se pueden se leccionar  varios  archivos  o no.
	 * 
	 * Ejemplo:
	 *<code>
	 *
	 *<?php
	 *
	 * $myForm = new OPF_myForm('form1');
	 *
	 * $myForm->addFile('Archivo:','file1');
	 * 
	 * // Configura el atributo 'str_etq_button' para este objeto, en este caso la etiqueta del botón de carga de archivo.
	 * $myForm->setAttFile('file1','str_etq_button','Buscar...');
	 *
	 * $myForm->getForm(1);
	 *
	 *?>
	 *
	 *</code> 
	 * 
	 * @param string $nameObj Nombre dle objeto
	 * @param string $attName Nombre del atributo
	 * @param string $attValue Valor para el atributo
	 */
	public function setAttFile ($nameObj, $attName, $attValue){

		$return = false;
		
		if (isset($this->FILES_atts_[$attName])){
			
			$this->FILES_atts[$nameObj][$attName] = $attValue;
			
			$return = true;
		}
		
		return $return;
	}
	
	private function setAttFileAuto($nameObj){
		
		$nameObj = $this->getColspanRowspan($nameObj);
		
		foreach ($this->FILES_atts_ as $attNom => $attVal){
			
			if (isset($this->FILES_atts[$nameObj][$attNom])){
				if ($this->FILES_atts_[$attNom] == $this->FILES_atts[$nameObj][$attNom])
			
					$this->FILES_atts[$nameObj][$attNom] = $attVal;
			}else
				$this->FILES_atts[$nameObj][$attNom] = $attVal;
			
		}
		
	}
	
	
	# Atributos de inicio de configuracion para el editor CKeditor

	/**
	 * Ruta fisica Editor
	 * 
	 * Ruta base de acceso para encontrar los script del editor.
	 * Se calcula automaticamente en el contructor.
	 * El valor por defecto es URL_BASE_PROJECT.'/plugin/editors/ck_editor/'.
	 * @var string
	 */
	private $WYSIWYG_editor_BasePath = '';

	/**
	 * Ancho WYSIWYG
	 *
	 * Ancho del WYSIWYG
	 * @var string
	 */
	private $WYSIWYG_editor_Width  = '100%';

	/**
	 * Alto WYSIWYG
	 *
	 * Alto del WYSIWYG
	 * @var string
	 */
	private $WYSIWYG_editor_Height = '200';

	/**
	 * Idioma WYSIWYG
	 *
	 * Idioma por defecto en el WYSIWYG
	 * @var string
	 */
	private $WYSIWYG_editor_Laguage = 'es';

	/**
	 * Barra herramientas CKeditor
	 * 
	 * Grupo de barras a seleccionar para el CKeditor
	 * @var string
	 */
	private $WYSIWYG_editor_ToolbarSet = 'Default';

	/**
	 * Constructor
	 * 
	 * Inicia la creación de un formulario para mas adelante poder definir campos dentro de el.
	 * <code>
	 * 
	 * Ejemplo 1:
	 * Formulario simple.
	 * <?php
	 * 
	 * $myForm = new OPF_myForm('form_name');
	 * 
	 * echo $myForm->getForm();
	 * 
	 * ?>
	 * Salida HTML:
	 * <form onsubmit="return false" method="post" name="editar" id="editar" target="_self">
	 * </form>
	 * 
	 * Ejemplo 2:
	 * Formulario a un script.
	 * <?php
	 * 
	 * $myForm = new OPF_myForm('form_name','process.php');
	 * 
	 * echo $myForm->getForm();
	 * 
	 * ?>
	 * Salida HTML:
	 * <form onsubmit="return false" action="process.php" method="post" name="editar" id="editar" target="_self">
	 * </form>	
	 * 
	 * </code>
	 * @param string  $nomForm  Nombre del formulario.
	 * @param string  $action   Action del formulario.
	 * @param string  $target   Target del formulario.
	 * @param string  $enctype  Tipo MIME del formulario.
	 */
	public function __construct($name = '', $action = '', $target = '', $enctype = ''){

		$this->WYSIWYG_editor_BasePath = URL_BASE_PROJECT.'plugin/editors/'.$this->WYSIWYG_type.'/';
		
		$this->pathImages =  'themes/'.THEME_NAME.'/myform/';
		
		$this->name = $name;

		if ($action)
			$this->action = $action;
			
		if ($target)
			$this->target = $target;			
			
		if ($enctype)
			$this->enctype = $enctype;
	}

	/**
	 * Agregar caja de texto
	 *
	 * Agrega una caja de texto que sera mostrada cuando se obtenga el contenido del formulario.
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'.
	 * <code>
	 * Ejemplo:
	 * <?php
	 * 
	 * $myForm = new OPF_myForm('form1');
	 * 
	 * $myForm->addText('Nombre:','nom');
	 *
	 * # Un nombre de objeto seguido de un ':valor_numerico' significa la asignacion de un valor numerico al atributo colspan de este objeto en el formulario.
	 * 
	 * $myForm->addText('Apellido:','ape:2');
	 * 
	 * echo $myForm->getForm();
	 * 
	 * ?>
	 * </code>
	 * @param string  $etq Etiqueta
	 * @param string  $name Nombre
	 * @param string  $value Valor
	 * @param integer $size Tamano
	 * @param integer $maxlength Maximo numero de caracteres
	 * @param boolean $validacion_numerica Validar
	 * @param boolean $CampoFecha Campo fecha (funcionalidad)
	 */
	public function addText($etq = '', $name = '', $value = '', $size = '', $maxlength = '', $validacion_numerica = false, $CampoFecha = false){
		$name     = $this->getColspanRowspan($name);
		$Cadena   = 'text'.$this->Separador.htmlentities($etq).$this->Separador.$name.$this->Separador.$value.$this->Separador.$size.$this->Separador.$maxlength.$this->Separador.$validacion_numerica.$this->Separador.$CampoFecha;
		
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'text';
	}
		
	/**
	 * Agregar campo de unica seleccion
	 *
	 * Agrega un campo de unica seleccion con los valores por parametro
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText()
	 * @param string $etq Etiqueta
	 * @param string $name Nombre
	 * @param array  $value	Valor incial que es un arreglo de la forma especificada
	 * @param string $selected Valor seleccionado por defecto
	 * @param string $size Tamano (Cantidad de opciones que muestra)
	 * @param string $truncar_hasta Truncar Numero maximo de caracteres por opcion
	 * @param boolean $multiple Es un campo de seleccion multiple.
	 */
	public function addSelect($etq = '', $name = '', $value = '', $selected ='', $size = '', $truncar_hasta = 0, $multiple = false){
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
				
				if ($truncar_hasta)
					$value = substr($value,0,$truncar_hasta);
					
				$buf .= "\t\t".'<option value="'.$id.'"'.$sel.'>'.$value.'</option>'."\n";
			}
			
			$buf .= "\t\t".'</select>'."\n";
			$value = $buf;
		}
		$maxlength = '';

		$Cadena   = 'select'.$this->Separador.htmlentities($etq).$this->Separador.$name.$this->Separador.$value.$this->Separador.$size.$this->Separador.$maxlength.$this->Separador.$multiple;
		$this->Objects['field'][$name] = $Cadena;

		$this->arrayFormElementType[$name] = 'select';
	}

	/**
	 * Agrega una caja de selección.
	 * 
	 * Agrega una caja de selección al formulario, el contenido de esta caja puede ser evaluado para verificar si es true o false
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText()
	 * @param string $etq Etiqueta del campo
	 * @param string $name Nombre de checkbox
	 * @param boolean $ini_sts  Marcado por defecto o no (false ó true)
	 *
	 */
	public function addCheckBox($etq = '', $name = '', $ini_sts = false){
		$name = $this->getColspanRowspan($name);
		$Cadena = 'checkbox'.$this->Separador.htmlentities($etq).$this->Separador.$name.$this->Separador.$ini_sts;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'checkbox';

	}

	/**
	 * Agrega un botón de opción.
	 * 
	 * Agrega un botón de opcion al formulario en particular.
	 * Los grupos de radio buttons se pueden formar y funcionar
	 * siempre y cuando esos radio buttons queden con el mismo
	 * nombre que permita agruparlos.
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText()
	 *
	 * @param string $etq Etiqueta 
	 * @param string $value Valor
	 * @param string $name_group Grupo al que pertenece
	 * @param boolean $is_checked Marcado por defecto o no (false ó true)
	 * @return string Id del radio button, se usa para poder agrupar mas adelante
	 */
	public function addRadioButton($etq = '', $value = '', $name_group = '', $is_checked = false){
		$name = $name_group.'_'.$this->counterRadiosForThisForm+=1;

		//$name = $this->getColspanRowspan($name);
		$Cadena = 'radiobutton'.$this->Separador.htmlentities($etq).$this->Separador.$name.$this->Separador.$value.$this->Separador.$name_group.$this->Separador.$is_checked;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'radiobutton';
			
		return $name;
	}
	
	/**
	 * Agrega una caja de texto tipo contraseña.
	 * 
	 * Agrega una caja de texto tipo contraseña al formulario.
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText() 
	 * @param string $etq Etiqueta del campo
	 * @param string $name Nombre del campo
	 * @param string $value Valor incial
	 * @param string $size Tamano del campo
	 * @param string $maxlength Numero maximo de caracteres
	 */
	public function addPassword($etq = '', $name = '', $value = '', $size = '', $maxlength = ''){
		$name     = $this->getColspanRowspan($name);
		$Cadena   = 'password'.$this->Separador.htmlentities($etq).$this->Separador.$name.$this->Separador.$value.$this->Separador.$size.$this->Separador.$maxlength;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'password';
	}	

	/**
	 * Agrega una area de texto
	 *
	 * Agrega una area de texto al formulario.
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText()
	 * @param string $etq Etiqueta del campo
	 * @param string $name Nombre del campo
	 * @param string $value Valor incial
	 * @param integer $cols Numero de columnas
	 * @param integer $rows Numero de filas
	 * @param string $wrap Clase y tipo de abrigo
	 */
	public function addTextArea($etq = '', $name = '', $value = '', $cols = '', $rows = '', $wrap = ''){
		$name     = $this->getColspanRowspan($name);
		$Cadena   = 'textarea'.$this->Separador.htmlentities($etq).$this->Separador.$name.$this->Separador.$value.$this->Separador.$cols.$this->Separador.$rows.$this->Separador.$wrap;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'textarea';
	}

	/**
	 * Agrega un campo tipo oculto
	 *
	 * Agrega un campo oculto al formulario.
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText()
	 * @param string $name Nombre del campo
	 * @param string $value Valor incial
	 */
	public function addHidden($name = '', $value = ''){
		$name     = $this->getColspanRowspan($name);
		$Cadena   = 'hidden'.$this->Separador.$name.$this->Separador.$value;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'hidden';
	}
		
	/**
	 * 
	 * Agrega un campo de tipo archivo.
	 *
	 * Agrega un campo de tipo archivo al formulario.
	 * Los campos de tipo archivo no dependen del manejo general de los otros campos
	 * pues estos trabajan independientemente con base en un control de tipo flash
	 * que con la ayuda de un script procesa el contenido del archivo.
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText()
	 * 
	 * Ejemplo:
	 * <code>
	 * 
	 * index.php
	 * <?php
	 * 
	 * $myForm = new OPF_myForm('form1');
	 * 
	 * $myForm->addFile('Seleccione archivo(s):','archivo','upload.php');
	 * 
	 * echo $myForm->getForm(1);
	 * 
	 * ?>
	 * 
	 * upload.php 
	 * <?php
	 *  
	 *  // Creamos o abrimos un archivo de registro 
	 * 	$x = fopen('log.txt','a');
	 *  
	 *  // Validamos que el archivo(s) se haya(n) copiado
	 *  if (move_uploaded_file($_FILES['Filedata']['tmp_name'],'files/'.$_FILES['Filedata']['name'])){
	 *	
	 *     fwrite($x,'Archivo subido y copiado de '.$_FILES['Filedata']['tmp_name'].' a '.$_FILES['Filedata']['name']."\r\n");
	 *	
	 *  }else{
	 *	
	 *     fwrite($x,'Problemas al copiar el archivo '.$_FILES['Filedata']['name']."\r\n");
	 *	
	 *  }
	 *
	 * //Cerramos el archivo de registro y finalizamos ala ejecución del script.
	 * fclose($x);
 	 * exit(0);
	 * 
	 * // En este script, copiamos el/los archivo(s) seleccionados de la carpeta temporal a una final llamada 'files' que esta ubicada a nivel del script.
	 * 
	 * ?>
	 * </code>
	 * 
	 * @param string $etq Etiqueta del campo
	 * @param string $name del campo
	 * @param string $upload_url Url del archivo php que recibe los datos
	 * @param array  $file_types Arreglo con los tipos de archivos que se pueden subir
	 * @param string $file_types_description  Descripcion de los tipos de archivos que se pueden subir
	 * @param integer $file_size_limit Limite de tamano por archivo que se puede subir
	 */
	public function addFile ($etq, $name, $upload_url, $file_types = '', $file_types_description = '', $file_size_limit = ''){
		
		$this->setAttFileAuto($name);
		
		$flash_url = $GLOBALS['urlProject'].'swf/swfupload.swf';
		
		$name = $this->getColspanRowspan($name);
		
		if ($file_types && is_array($file_types))
			$this->setAttFile($name, 'file_types', $file_types);
			
		if ($file_types_description)
			$this->setAttFile($name,'file_types_description',$file_types_description);
			
		if (intval($file_size_limit))
			$this->setAttFile($name,'size_limit',$file_size_limit);

		$this->setAttFile($name,'upload_url',$upload_url);	
		
		$this->setAttFile($name,'flash_url',$flash_url);

		$Cadena   = 'file'.$this->Separador.htmlentities($etq).$this->Separador.$name;
		$this->Objects['field'][$name] = $Cadena;
		$this->uploaderIdArray[] = $name;

		$this->arrayFormElementType[$name] = 'file';
		
        if(!$this->useAddFileAfterLoad)
           $this->useAddFile = true;
	}

	/**
	 * Agregar un editor WYSIWYG.
	 *
	 * Agrega un editor WYSIWYG al formulario actual.
	 * Un editor WYSIWYG es un campo textarea modificado y enriquecido con herramientas para la edicion avanzada de su contenido.
	 * Por ejemplo es posible editar contenido HTML, como tablas, viñetas e imagenes.
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText()
	 *
	 * Nota Importante: Cuando se selecciona 'ck_editor' como editor WYSIWYG este no podra ser mostrado correctamente en contenido de ventanas modales o pestañas.
	 * 
	 * Ejemplo:
	 * <code>
	 * 
	 * index.php
	 * <?php
	 * 
	 * $myForm = new OPF_myForm('form1');
	 * 
	 * $myForm->addCKeditor ('Contenido:','contenido');
	 * 
	 * $myForm->addButton('btn1','Enviar');
 	 *	
 	 * $myForm->addEvent('btn1','onclick','dataSend');
	 * 
	 * echo $myForm->fgetForm(1);
	 * 
	 * ?>
	 * 
	 * handlerEvent.php
	 * <?php
	 * 
	 * class events extends OPF_myController {
     *  
     *    public function dataSend ($dataForm){
     *		  
     *        $this->script($dataForm['contenido']);
     * 
     *        return $this->response;
     *    }
     *   
     * }
     * 
	 * ?>
	 * 
	 * </code>
	 * @param string  $etq Etiqueta del campo generado por el CKEditor
	 * @param string  $name Nombre del campo generado por el CKEditor
	 * @param string  $value Valor inicial del campo generado por el CKEditor
	 * @param integer $width Ancho
	 * @param integer $height Alto
	 * @param string  $toolbarset Juego de barra de herramientas
	 */
	public function addWYSIWYGeditor ($etq = '', $name = '', $value = '', $width = '', $height = '', $toolbarset = ''){
		
		$this->arrayCKEditorInstances[] = $name;
		
		if ($width)
			$this->WYSIWYG_editor_Width = $width;
			
		if ($height)
			$this->WYSIWYG_editor_Height = $height;
			
		if ($toolbarset)
			$this->WYSIWYG_editor_ToolbarSet = $toolbarset;
			
		$name     = $this->getColspanRowspan($name);
		$Cadena   = 'WYSIWYG'.$this->Separador.$etq.$this->Separador.$name.$this->Separador.$value;
		$this->Objects['field'][$name] = $Cadena;
		$this->arrayFormElementType[$name] = 'WYSIWYG';
	}
		
	/**
	 * Agrega un comentario.
	 * 
	 * Agrega un comentario escrito para complementar con informacion un formulario.
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText()
	 * @param string $id Identificador del comentario que va a utilizar
	 * @param string  $Coment Texto que desea mostrar en la fila
	 */
	public function addComment ($id, $Coment){
		$id     = $this->getColspanRowspan($id);
		$Cadena = 'coment'.$this->Separador.$id.$this->Separador.$Coment;
		$this->Objects['field']['coment_'.$id] = $Cadena;
		$this->arrayFormElementType[$id] = 'coment';
	}

	/**
	 * Agrega un espacio en blanco. 
	 *
	 * En ocaciones los campos no son suficientes para incluir datos en un formulario. El metodo addFreeObject permite agregar un objeto creado por el usuario.
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText()
	 * <code>
	 * Ejemplo:
	 * 
	 * $myForm = new OPF_myForm ('form1');
	 * 
	 * $object = '<img src="logo.gif">';
	 * 
	 * # Dentro del valor del objeto podemos agregar el valor que queramos. 
	 * $myForm->addFreeObject('fo1','Imagen',$object);
	 * 
	 * echo $myForm->getForm();
	 * 
	 * </code>
	 * @param string $id Identificador del objeto libre
	 * @param string  $val_e Valor en el momento del cargue dentro del formulario para la etiqueta
	 * @param string  $val_c Valor en el momento del cargue dentro del formulario para el campo
	 */
	public function addFreeObject ($id, $etq = '', $value = ''){
		$id = $this->getColspanRowspan($id);
		$this->Objects['field']['whitespace_'.$id] = 'whitespace'.$this->Separador.$id.$this->Separador.htmlentities($etq).$this->Separador.$value;
		$this->arrayFormElementType[$id] = 'whitespace';
	}
	
	/**
	 * Agrega un boton.
	 * 
	 * Agrega un boton a la salida del formulario. Los botones normalmente encapsulan algun evento del usuario, por ejemplo guardar algun dato o hacer una consulta.
	 * Para agregar un evento a un boton y hacerlo funcional pruebe el metodo addEvent.
	 * Es posible asignar un valor al atributo colspan en la salida de este objeto. Para asignarlo se debe escribir seguido del nombre del objeto ':valor_numerico'. Ver ejemplo en la documentacion de myForm::addText()
	 * @param string $strName Nombre del Elemento
	 * @param string $strLabel Etiqueta o valor del Elemento
	 * @param string $strSrcImg Nombre de la imagen que lo acompaña.
	 */
	public function addButton ($strName, $strLabel = '', $strSrcImg = ''){
		
		if ($strSrcImg)
		   $strSrcImg = $GLOBALS['urlProject'].$this->pathImages.$strSrcImg;
		
		$name     = $this->getColspanRowspan($strName);
		
		$Cadena   = 'button'.$this->Separador.$name.$this->Separador.htmlentities($strLabel).$this->Separador.$strSrcImg;
		
		$this->Objects['field'][$name] = $Cadena;
		
		$this->arrayFormElementType[$name] = 'button';
	}

	/**
	 * Retorna el HTML de una caja de texto.
	 *
	 * Retorna el HTML de una caja de texto que puede ser usado en cualquier parte de un script.
	 * Opera de identica forma al metodo addText solo que aqui se retorna inmediatamente el codigo HTML y no se agrega a la salida del formulario.
	 * @param string $name Nombre del campo
	 * @param string $value Valor incial
	 * @param integer $size Tamano del campo
	 * @param integer $maxlength Numero maximo de caracteres
	 * @param boolean $validacion_numerica
	 * @param boolean $CampoFecha Muestra un boton en el campo que facilita la seleccion de una fecha
	 */
	public function getText($name = '', $value = '', $size = '', $maxlength = '', $validacion_numerica = false, $CampoFecha = false){
		
		$this->arrayFormElementType[$name] = 'text';
		
		$strEvents = '';
		
		$keypress = '';
		
		$utilyVal = '';
		
		$LauncherCalendar = '';

		if ($validacion_numerica)
		
			$keypress = ' onKeyPress="return OnlyNum(event)"';

		if ($CampoFecha){
			
			$utilyVal = 'onKeyUp="CalendarFormat( this );" onBlur="BlurDate( this )"';
			
			$LauncherCalendar = '<td><button '.$this->checkIfIsDisabled($name).' type="button" class="boton_cal" id="trigger_'.$name.'"  name="trigger_'.$name.'" onClick="addCalendarWindow(document.forms[\''.$this->name.'\'].elements[\''.$name.'\'].value, \''.$name.'\', \''.$name.'\', \''.$this->name.'\')" /><img src="'.$GLOBALS['urlProject'].$this->pathImages.$this->srcImageCalendarButton.'" border="0"></button></td>';
		}else 
			$strEvents = $this->checkExistEventJs($name);
			
		$buf ='<table cellpadding="0" border="0" cellspacing="0"><tr><td><input '.$this->checkAutoCompleteStatus($name).'  '.$this->checkIfIsDisabled($name).' '.$this->checkIsHelping($name).' class="'.$this->styleClassFields.'" type="text" name="'.$name.'" id="'.$name.'" value="'.$value.'" size="'.$size.'" '.$utilyVal.' maxlength="'. $maxlength.'"'.$keypress.' '.$strEvents.'></td>'.$LauncherCalendar.'</tr></table>'."\n";
			
		return $buf;
	}
	
	/**
	 * Obtiene campo de unica seleccion.
	 * 
	 * Obtiene un campo de unica seleccion con los valores por parametro.
	 * Opera de identica forma al metodo addSelect solo que aqui se retorna inmediatamente el codigo HTML y no se agrega a la salida del formulario.
	 * @param string $name Nombre
	 * @param array  $value Valor
	 * @param string $selected Valor seleccionado por defecto
	 * @param string $size Tamano del campo
	 * @param string $truncar_hasta Truncar Numero maximo de caracteres por opcion
	 * @param boolean $multiple Es un campo de seleccion multiple.
	 */
	public  function getSelect($name = '', $value = '', $selected ='', $size = '', $truncar_hasta = 0, $multiple = false){
		
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
				
				if ($truncar_hasta)
					$value = substr($value,0,$truncar_hasta);
					
				$buf .= "\t\t".'<option value="'.$id.'"'.$sel.'>'.$value.'</option>'."\n";
			}

			$buf .= '</select>'."\n";
		}

		$this->arrayFormElementType[$name] = 'select';

		return $buf;
	}
	
	/**
	 * Obtiene un caja de seleccion.
	 * 
	 * Obtiene el HTML de una caja de seleccion al formulario.
	 * Opera de identica forma al metodo addCheckBox solo que aqui se retorna inmediatamente el codigo HTML y no se agrega a la salida del formulario.
	 * @param string $name Nombre de checkbox.
	 * @param boolean $ini_sts Estado inicial del Check en la carga del formulario. (True o False).
	 */
	public function getCheckBox($name = '', $ini_sts = false){
		$buf = '';

		$cheked = '';
		if ($ini_sts == true){
			$cheked = 'checked';
		}

		$onEvent = $this->checkExistEventJs($name);
		
		$buf .= '<input '.$onEvent.' '.$this->checkIsHelping($name).' class="'.$this->styleClassFields.'" type="checkbox" name="'.$name.'" id="'.$name.'"  '.$cheked.' '.$this->checkIfIsDisabled($name).'>'."\n";
		
		$this->arrayFormElementType[$name] = 'checkbox';

		return $buf;
	}
	
	/**
	 * Obtiene un botón de opción.
	 * 
	 * Opera de identica forma al metodo addRadioButton solo que aqui se retorna inmediatamente el codigo HTML y no se agrega a la salida del formulario.
	 * @param string $value Valor por defecto del Radio button
	 * @param string $name_group Nombre del radio o grupo que van a comformarlo
	 * @param boolean $is_checked Estado inicial del boton de selección. (true o false)
	 * @return string
	 */
	public function getRadioButton ($value = '', $name_group = '', $is_checked = false){
		
		$buf = '';

		$checked = '';
		
		if ($is_checked==true)
		
			$checked = 'checked="checked"';

		$buf .= '<input '.$this->checkExistEventJs($name_group).' '.$this->checkIsHelping($name_group).' '.$this->checkIfIsDisabled($name_group).' type="radio" name="'.$name_group.'" id="'.$name_group.'_'.$value.'" value="'.$value.'" class="'.$this->styleClassFields.'" '.$checked.'>';

		$this->arrayFormElementType[$name_group] = 'radiobutton';

		return $buf;
	}	
		
	/**
	 * Obtiene una caja de texto tipo password
	 *
	 * Opera de identica forma al metodo addPassword solo que aqui se retorna inmediatamente el codigo HTML y no se agrega a la salida del formulario.
	 * @param string $name Nombre del campo
	 * @param string $value Valor incial
	 * @param string $size Tamano del campo
	 * @param string $maxlength Numero maximo de caracteres
	 */
	public function getPassword($name = '', $value = '', $size = '', $maxlength = ''){

		$buf = '';
		$buf ='<input '.$this->checkAutoCompleteStatus($name).' '.$this->checkIfIsDisabled($name).' '.$this->checkIsHelping($name).' class="'.$this->styleClassFields.'" type="password" name="'.$name.'" id="'.$name.'" value="'.$value.'" size="'.$size.'" maxlength="'. $maxlength.'" '.$this->checkExistEventJs($name).'>'."\n";
		$this->arrayFormElementType[$name] = 'password';
			
		return $buf;		
	}
		
	/**
	 * Obtiene una area de texto
	 * 
	 * Opera de identica forma al metodo addTextArea solo que aqui se retorna inmediatamente el codigo HTML y no se agrega a la salida del formulario.
	 * @param string  $name  Nombre del campo
	 * @param string  $value Valor incial
	 * @param integer $cols Numero de columna
	 * @param integer $rows Numero de fila
	 * @param string  $wrap Clase y tipo de abrigo
	 */
	public function getTextArea($name = '', $value = '', $cols = '', $rows = '', $wrap = ''){
		$buf = '';
		$buf.=''.''.'<textarea '.$this->checkIsHelping($name).' class="'.$this->styleClassFields.'" name="'.$name.'" id="'.$name.'" cols="'.$cols.'" rows="'.$rows.'" wrap="'.$wrap.'" '.$this->checkExistEventJs($name).' '.$this->checkIfIsDisabled($name).'>'.$value.'</textarea>'."\n";
		$this->arrayFormElementType[$name] = 'textarea';
		return $buf;
	}

	/**
	 * Obtiene un campo Oculto
	 *
	 * Opera de identica forma al metodo addHidden solo que aqui se retorna inmediatamente el codigo HTML y no se agrega a la salida del formulario.
	 * @param string $name Nombre del campo
	 * @param string $value Valor incial
	 */
	public function getHidden($name = '', $value = ''){
		$buf = '';
		$buf = '<input type="hidden" id="'.$name.'" name="'.$name.'" value="'.$value.'">'."\n";
		$this->arrayFormElementType[$name] = 'hidden';

		return $buf;
	}

	/**
	 * Obtiene el HTML de un campo formulario tipo File asincronico.
	 *
	 * Opera de identica forma al metodo addFile solo que aqui se retorna inmediatamente el codigo HTML y no se agrega a la salida del formulario.
	 * @param string $name Nombre del campo
	 * @return string
	 */
	public function getFile ($name, $upload_url, $file_types = '', $file_types_description = '', $file_size_limit = ''){
		$buf = '';

		$this->setAttFileAuto($name);
		
		$flash_url = $GLOBALS['urlProject'].'swf/swfupload.swf';
		
		if ($file_types && is_array($file_types))
			$this->setAttFile($name,'file_types',$file_types);
		
		if ($file_types_description)
			$this->setAttFile($name,'file_types_description',$file_types_description);
		
		if (intval($file_size_limit))
			$this->setAttFile($name,'size_limit',$file_size_limit);
		
		$this->setAttFile($name,'upload_url',$upload_url);
		$this->setAttFile($name,'flash_url',$flash_url);
		
		$buf.='<span id="spanButtonPlaceholder'.$name.'">';
		
		/**
		 * Deprecated
		if ($this->FILE_src_img_button)
		   $buf.='<img style="padding-right: 3px; vertical-align: bottom;" src="'.$GLOBALS['urlProject'].$this->pathImages.$this->FILE_src_img_button.'" border="0">';
		 */  
		
		$maxInfoSize = '';   
	    if ($this->FILES_atts[$name]['show_max_upload_size_info_in_button']){
	    	if ($this->FILES_atts[$name]['size_limit']<1024){
	           $maxFileSizeUpload = '('.$this->FILES_atts[$name]['size_limit'].' Kb)';
	    	}else if ($this->FILES_atts[$name]['size_limit']<1048576){
	    	   $maxFileSizeUpload = '('.number_format($this->FILES_atts[$name]['size_limit']/1024,2).' Mb)';
	    	}else{
      		   $maxFileSizeUpload = '('.number_format($this->FILES_atts[$name]['size_limit']/1048576,2).' Gb)';
	    	}
	       $maxInfoSize = '<font style="vertical-align: middle; font-size: 6pt; font-weight: bold;">'.$maxFileSizeUpload.'</font>';
	    }	   
		   
		$buf.= '</span><div style="text-align: left;" class="'.$this->styleClassTags.'" id="div_file_progress" name="div_file_progress"></div>';
		$this->arrayFormElementType[$name] = 'file';

		return $this->getJavaScriptSWFUploader($name).$buf;
	}
	
	/**
	 * Obtiene un botón.
	 *
	 * Obtiene el codigo HTML. Los botones normalmente encapsulan algun evento del usuario, por ejemplo guardar algun dato o hacer una consulta.
	 * Para agregar un evento a un boton y hacerlo funcional pruebe el metodo addEvent antes de obtener el botón. 
	 * @param string $strName  Nombre del boton.
	 * @param string $strLabel Etiqueta del boton.
	 * @param string $strSrcImg  Nombre de la imagen que lo acompaña.
	 * @return string
	 */
	public function getButton ($strName, $strLabel = '', $strSrcImg = ''){
		$buf = '';
		$strMixedParams = '';
		
		$buf.='<button '.$this->checkIfIsDisabled($strName).' '.$this->checkIsHelping($strName).' value="'.strip_tags($strLabel).'" class="'.$this->styleClassButtons.'" type="button" name="'.$strName.'" id="'.$strName.'" ';
		$buf .= $this->checkExistEventJs($strName).'>';

		$buf .= '<table border="0" cellspacing="0" cellpadding="0" width="100%"><tr>';
		
		if ($strSrcImg)
			$buf .= '<td align="right"><img style="padding-right: 2px; vertical-align: middle;" src="'.$GLOBALS['urlProject'].$this->pathImages.$strSrcImg.'" border="0"></td>';
			
		$buf.='<td class="boton_font">'.str_replace(' ','&nbsp;',$strLabel).'</td></tr></table></button>';

		return $buf;
	}	

	/**
	 * Agregar un agrupamiento.
	 * 
	 * Crea un agrupamiento HTML mediante fieldSet para los  nombres de  los campos seleccionados.
	 * Cuando un formulario tiene demasiados campos es posible organizar el formulario de tal forma que
	 * se vea un poco mejor organizado, clasificando los campos por tipos que hacia la vista del usuario
	 * le sea permitido mas facilmente ir hacia ellos. Por ejemplo podriamos agrupar los datos personales
	 * de los datos no personales de un formulario de lectura de datos de un cliente bancario.
	 * 
	 * <code>
	 * 
	 * Ejemplo:
	 * <?php
	 * 
	 * $myForm = new OPF_myForm('form1');
	 * 
	 * $myForm->addText('Nombre:','nom');
	 * 
	 * $myForm->addText('Apellido:','ape');
	 * 
	 * $myForm->addCheckBox('Futbol:','fut');
	 * 
	 * $myForm->addCheckBox('Tenis:','tns');
	 * 
	 * // Agrupamos en un fieldset los campos que pertenecen a esta categoria.
	 * $myForm->addGroup('gp1','Datos personales',array('nom','ape'));
	 * 
	 * // Agrupamos en un fieldset los campos que pertenecen a esta categoria. 
	 * $myForm->addGroup('gp2','Deportes que practica',array('fut','tns'));
	 *  
	 * echo $myForm->getForm();
	 * 
	 * ?>
	 * 
	 * </code>
	 * 
	 * @param string  $idGroup Identificador interno del fieldSet
	 * @param string  $strFieldSet Legend del fieldSet
	 * @param array   $arraystrIdFields Arreglo de nombre de objetos que seran agrupados
	 * @param integer $intCols Numero de Columnas en el que la tabla se partira
	 * @param boolean $useShowHide Usar o no propiedad para mostrar y ocultar las capas
	 * @param string  $iniVisibilitySts Si se activo la propiedad de mostrar y ocultar el fieldset, determinar el estado inicial 
	 */
	public function addGroup ($idGroup, $strFieldSet = '', $arraystrIdFields = array(), $intCols = 2, $useShowHide = false, $iniVisibilitySts = 'show'){
		
		$this->arrayGroups[] = array(
			'idGroup' => $idGroup, 
			'strFieldSet' => htmlentities($strFieldSet), 
			'arraystrIdFields' => $arraystrIdFields, 
			'intColsByGroup' => $intCols,
			'useShowHide' => $useShowHide,
			'iniVisibilitySts' => $iniVisibilitySts
		);

		$this->arrayFormElementsShown = array_merge($this->arrayFormElementsShown, $arraystrIdFields);
	}
	
	/**
	 * Agrega un evento al objeto.
	 * 
	 * Agrega un evento JavaScript que sera administrado por la clase myController al id relacionado al objeto del formulario.
	 * <code>
	 * 
	 * index.php
	 * <?php
	 * 
	 * $myForm = new OPF_myForm('form1');
	 * 
	 * $myForm->addText('Nombre:','nom');
	 * 
	 * $myForm->addButton('btn1','Enviar');
	 * 
	 * // Es posible definir 1 o mas eventos sobre un objeto del formulario. 
	 * // Para definir mas de un evento se puede asociar en un arreglo los nombres de los eventos que queremos ejecutar.  
	 * $myForm->addEvent('btn1','onclick','onClickEvent');
	 *  
	 * // Los eventos pueden ayudar a validar cierto tipo de información.
	 * $myForm->addEvent('nom','onchange','onChangeEvent');
	 *  
	 * $myForm->getForm(1);
	 * 
	 * ?>
	 * 
	 * handlerEvent.php
	 * <?php
	 * 
	 *  class events extends OPF_myController {
     *    
     *    // Los eventos se declaran en el handlerEvent en donde se codifican por separado. 
     *    
     *    public function onClickEvent ($dataForm){
     *		  
     *		  $this->alert('Su nombre es:'.$dataForm['nom']);
     * 
     *        return $this->response;
     *    }
     *   
     *    public function onChangeEvent ($dataForm){
     *    
     *    	  if (strlen($dataForm['nom'])<4){
     *    
     *            $this->alert('Su nombre es demasiado corto');
     *    	  }
     *    
     *        return $this->response;
     *    }
     *   
     *  }
	 * 
	 * ?>
	 * 
	 * </code>
	 * @param string  $objName   Nombre o id del objeto del formulario al que se le va a agregar un evento. El objeto debe ser textarea, select, password, text, radiobutton, checkbox o button para que sea posible agregar el evento.  
	 * @param integer $event     El metodo que deseamos realizar, puede ser un entero o directamente el nombre del evento. (1 ó onblur, 2 ó onchange, 3 ó onclick, 4 ó onfocus, 5 ó onmouseout, 6 ó onmouseover)
	 * @param string  $functions El nombre de la funcion o funciones que deseamos llamar al momento de cumplirse el evento
	 * @param string $param1 Parametro número 1...
	 * @param string $param2 Parametro número 2...
	 * @param string $param3 Parametro número 3...
	 * ...
	 */
	public function addEvent($objName,$event,$functions){
		
		$buf = '';
		
		$array_eJs = array(
		1 => ' OnBlur',      'onblur' =>      ' OnBlur',
		2 => ' OnChange',    'onchange' =>    ' OnChange',
		3 => ' OnClick',     'onclick' =>     ' OnClick',
		4 => ' OnFocus',     'onfocus' =>     ' OnFocus',
		5 => ' OnMouseOut',  'onmouseout' =>  ' OnMouseOut',
		6 => ' OnMouseOver', 'onmouseover' => ' OnMouseOver');

		$numArg = func_num_args();
 		
 		if ($numArg >= 4){
 			
 			$buf .= ', ';
 			
 			for($i=3;$i<$numArg;$i++){
 					
 				if (is_array(func_get_arg($i))){
 					
 					$buf .= 'GetArray(  ';
 					
 					foreach (func_get_arg($i) as $key => $value){
 						
 						$buf .= '\''.$key.'\', ';
 						
 						if (is_array($value)){
 						
 							$buf .= 'GetArray(  ';
 							
 							foreach ($value as $key_arr => $value_arr){
 								
 								$buf .= '\''.$key_arr.'\', ';
 								
 								$buf .= '\''.addslashes(str_replace('"',"'",$value_arr)).'\', ';
 								
 							}
 							
 							$buf = substr($buf,0,-2).'), ';
 							
 						}else
 							$buf .= '\''.addslashes(str_replace('"',"'",$value)).'\', ';
 							
 					}
 					
 					$buf = substr($buf,0,-2).'), ';
 					
 				}else{
 					
 					$buf .= '\''.func_get_arg($i).'\', ';
 					
 				}
 						
 			}

 			$buf = substr($buf,0,-2);
 		}
		
		if (is_string($event))
			$event = strtolower($event);

		$this->objEventxJ[$objName] = '';
		
		$this->objEventxJ[$objName] .= $array_eJs[$event].'="';

		if (is_array($functions)){
			
			$cantFinctions = count($functions);
			
			for($i=0;$i<$cantFinctions;$i++){
				
				switch ($this->paramTypeOnEvent){
					
					case 'global':
						
						$this->objEventxJ[$objName] .= $this->prefAjax.$functions[$i].'('.$this->jsFunctionSubmitFormOnEvent.'(\''.$this->name.'\'';
						
						if (count($this->arrayCKEditorInstances))
							
							$this->objEventxJ[$objName] .= ', CKEDITOR.instances, CKEditorInstances';
						
						$this->objEventxJ[$objName] .= ')';
						
					break;
					case 'field':
						
						$this->objEventxJ[$objName] .= $this->prefAjax.$functions[$i].'('.$this->jsFunctionSubmitFieldOnEvent.'(this.value)';
						
					break;
				}
 		
				if (!$numArg)
					$this->objEventxJ[$objName] .= ')';
				else
					$this->objEventxJ[$objName] .= ' '.$buf.')';
				
				if (($i+1)<$cantFinctions)
					$this->objEventxJ[$objName] .=', ';
			}
			$this->objEventxJ[$objName] .='"';
		}else{
			
			switch ($this->paramTypeOnEvent){
				
				case 'global':
					
					$this->objEventxJ[$objName] .= $this->prefAjax.$functions.'('.$this->jsFunctionSubmitFormOnEvent.'(\''.$this->name.'\'';
					
					if (count($this->arrayCKEditorInstances))
							
						$this->objEventxJ[$objName] .= ', CKEDITOR.instances, CKEditorInstances';
					
					$this->objEventxJ[$objName] .= ')';
				break;
				case 'field':
					
					$this->objEventxJ[$objName] .= $this->prefAjax.$functions.'('.$this->jsFunctionSubmitFieldOnEvent.'(this.value)';
				break;
			}
			
			$this->objEventxJ[$objName] .=$buf.')"';
			
		}
		
	}
	
	/**
	 * Configura tipo de parametro sobre eventos.
	 * 
	 * Configura el tipo de parametro que va a ser enviado a la funcion de un evento, 
	 * este parametro puede ser tipo 'global' o tipo 'field'.
	 * 'form' enviara los datos del formulario asociado al objeto, mientras que 'field' el valor del objeto en el evento.
	 * 
	 * Ejemplo:
	 *<code>
	 * 
	 *index.php
	 *<?php
	 * 
	 * $myForm = new OPF_myForm('form1');
	 * 
	 * $myForm->addText('Nombre:','nom');
	 * 
	 * $myForm->addButton('btn1','Enviar');
	 *
	 * $myForm->setParamTypeOnEvent('field');
	 * 
	 * $myForm->addEvent('nom','onchange','onChangeEvent');
	 *
	 * $myForm->setParamTypeOnEvent('global');
	 * 
	 * $myForm->addEvent('btn1','onclick','onClickEvent'); 
	 *  
	 * $myForm->getForm(1);
	 * 
	 *?>
	 * 
	 *handlerEvent.php
	 *<?php
	 * 
	 *  class events extends OPF_myController {
     *    
     *    public function onClickEvent ($dataForm){
     *		  
     *		  $this->alert('Su nombre es:'.$dataForm['nom']);
     * 
     *        return $this->response;
     *    }
     *   
     *    public function onChangeEvent ($nom){
     *    
     *    	  $this->alert('Su nombre es:'.$nom);
     *    
     *        return $this->response;
     *    }
     *   
     *  }
	 * 
	 *?>
	 * 
	 *</code>
	 * @param string $paramType	Tipo de parametro ('global' o 'field')
	 */
	public function setParamTypeOnEvent ($paramType){
		
		$typeParams = array('global','field');
		
		if (in_array($paramType,$typeParams))
			$this->paramTypeOnEvent = $paramType;
	}	
		
	/**
	 * Desabilita un objeto.
	 * 
	 * Agrega la propiedad 'disabled="disabled"' a el objeto del formulario que se invoque.
	 	 *<code>
	 * 
	 *index.php
	 *<?php
	 * 
	 * $myForm = new OPF_myForm('form1');
	 * 
	 * $myForm->addText('Nombre:','nom');
	 * 
	 * $myForm->addDisabled('nom');
	 * 
	 * $myForm->getForm(1);
	 * 
	 *?>
	 *</code>
	 * @param string $objName id Nombre o id del objeto
	 */
	public function addDisabled ($objName){
		if (!in_array($objName, $this->objDisabled)){
			$this->objDisabled[$objName] = $objName;
		}
	}
	
	/**
	* Habilita o desabilita el autocomplete en una caja de texto.
	*
	* Agrega la propiedad 'autocomplete="on/off"' en la caja de texto del formulario que se invoque.
	*<code>
	*
	*index.php
	*<?php
	*
	* $myForm = new OPF_myForm('form1');
	*
	* $myForm->addText('Nombre:','nom');
	*
	* $myForm->setAutoComplete('nom',false);
	*
	* $myForm->getForm(1);
	*
	*?>
	*</code>
	* @param string $objName id Nombre o id del objeto
	*/
	public function setAutoComplete ($objName, $value){
		
		if (is_bool($value)){
		
			$this->objAutoComplete[$objName] = $value;
		}
	}
	
	/**
	 * Agrega un tip informativo.
	 * 
	 * Agrega un tip informativo sobre el objeto al pasar el puntero del mouse sobre él.
	 * @param string $objName Nombre o id del Objeto
	 * @param string $strHelp Contenido de la ayuda
	 */
	public function addHelp ($objName, $strHelp){
		if (!in_array($objName, $this->objHelps)){
			$this->objHelps[$objName] = str_replace("'","\\'",str_replace('"',"'",htmlentities($strHelp)));
		}
	}
	
	/**
	 * Agrupa fieldsets declarados previamente con myForm::addGroup
	 * 
	 * Agrupa grupos de elementos previamente definidos para dejar un cojunto de grupos en una fila y no queden en filas separadas.
	 * <code>
	 * 
	 * Ejemplo:
	 * <?php
	 * 
	 * $myForm = new OPF_myForm('form1');
	 * 
	 * $myForm->addText('Nombre:','nom');
	 * 
	 * $myForm->addText('Apellido:','ape');
	 * 
	 * $myForm->addCheckBox('Futbol:','fut');
	 * 
	 * $myForm->addCheckBox('Tenis:','tns');
	 * 
	 * $myForm->addGroup('gp1','Datos personales',array('nom','ape'));
	 * 
	 * $myForm->addGroup('gp2','Deportes que practica',array('fut','tns'));
	 *
	 * $myForm->groupGroups(array('gp1','gp2'));
	 *  
	 * echo $myForm->getForm();
	 * 
	 * ?>
	 * 
	 * </code>
	 * @param string $idGroupingGroups Id del grupo de grupos
	 */
	public function groupGroups ($arrayIdGroups){
		
		$this->arrayGroupsIdInShareSpace[] = array('arrayIdGroups' => $arrayIdGroups);
	}
	
	/**
	 * Obtiene el formulario.
	 * 
	 * Obtiene el HTML de un formulario previamente configurado.
	 * @param integer $cols Numero de columnas que tendra el formulario.
	 * @return string
	 */
	public function getForm($cols = 2){
		
		$this->cols = $cols;
			
		return $this->compileForm($this->cols);
	}
	
	/**
	 * Imprime el formulario final.
	 * 
	 * Imprime el formulario final.
	 * @param integer $cols Numero de columnas que tendra el formulario.
	 */
	public function showForm($cols = 2){
		print $this->getForm($cols);
	}
	
	/**
	 * Configura el editor WYSIWYG a usar en el formulario.
	 * 
	 * Configura el editor WYSIWYG a usar dentro del formulario.
	 * @param string $editor_name Nombre del editor a usar de los disponibles CKEditor(ck_editor)
	 */
	public function setWYSIWYGeditorToUse ($editor_name){
		
		if (isset($this->WYSIWYGtypeEditorAvailable[$editor_name]))
			
			$this->WYSIWYG_type = $editor_name;
	}
		
	/**
	 * Es llamada en la construccion del formulario para averiguar si en elemento de ese formulario esta
	 * ralacionada con un evento xAjax y de esa forma concatenarlo a la salida final del mismo
	 *
	 * @param string  ObjectForm Id del objeto del formulario que el buscara en el arreglo
	 */
	private function checkExistEventJs($ObjectForm){
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
	private function checkIfIsDisabled ($objName){
		$disabledStr = ' disabled="disabled"';
		$return = '';
		if (in_array($objName,$this->objDisabled)){
			$return = $disabledStr;
		}

		return $return;
	}

	/**
	* Es llamada dentro de la construccion del
	* formulario como un  metodo  que  ayuda a
	* contruir  los  campos  con  un  atributo
	* adicional  que  permite a un campo de tipo
	* texto o password que tenga activo o no el
	* atributo autocomplete.
	*
	* @param string  objName Id del objeto del formulario que el buscara en el arreglo
	*/
	private function checkAutoCompleteStatus ($objName){
		
		$return = '';
		
		if (isset($this->objAutoComplete[$objName])){
			
			$return = 'autocomplete="';
			
			if ($this->objAutoComplete[$objName] == true)
				$return .= 'on';
			else
				$return .= 'off';
			
			$return .= '"';
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
	private function checkIsHelping ($objName){
		
		$return = '';
		
		$arrayKeysObjHelps = array_keys ($this->objHelps);
		
		if (in_array($objName,$arrayKeysObjHelps)){
			
			switch ($this->styleTypeHelp){
				case 1:
					
					$return = ' onmouseover="Tip(\''.$this->objHelps[$objName].'\', BALLOON, true,  ABOVE, false, PADDING, 8, FOLLOWSCROLL, true, STICKY, true), getElementById(\''.$objName.'\').style.cursor=\'help\'" ';//
					
				break;
				case 2:
					
					$return = ' onmouseover="getElementById(\''.$objName.'\').style.cursor=\'help\',Tip(\''.$this->objHelps[$objName].'\', ABOVE, true, PADDING, 8, FOLLOWSCROLL, true, STICKY, true)" ';//
					
				break;
			}
		}

		return $return;
	}

	/**
	 * Obtener el javascript necesario para
	 * imprimirlo en las etiquetas <head></head>
	 * para el cargar la configuracion del SWFUploader
	 *
	 */
	private function getJavaScriptSWFUploader ($names){
		
		$JS = '';
			
		$JS.= '<script type="text/javascript">'."\n";
		
		if (!is_array($names)){
			
			$JS.= 'var swfu'.$names.';'."\n";
			
		}else{
			
			$JS.= 'var ';
			
			foreach ($names as $name){
				
				$JS.= 'swfu'.$name.', ';
			}
			
			$JS = substr($JS, 0,-2).';'."\n";
			
		}	
		
		$JS.= 'window.onload = function() {'."\n";
		
		if (!is_array($names)){
			
			$JS.= $this->getJavaScriptSWFUploaderPerVar($names);
			
		}else{

			foreach ($names as $name){
			
				$JS.= $this->getJavaScriptSWFUploaderPerVar($name);
			}
		}
		
		
		
		$JS.= '};'."\n";
		
		$JS.= '</script>'."\n";
			
		return $JS;
	}

	private function getJavaScriptSWFUploaderPerVar ($nameVar){
		
		$JSPerVar = '';
		
		$JSPerVar.= 'swfu'.$nameVar.' = new SWFUpload({'."\n";

		$JSPerVar.= '// Backend Settings'."\n";
		$JSPerVar.= "\t".'upload_url : "'.$this->FILES_atts[$nameVar]['upload_url'].'",'."\n";
			
		if (count($this->FILES_atts[$nameVar]['file_post_name'])){
			$JSPerVar.= 'post_params : {'."\n";
			$swf_file_post_name_Keys = array_keys($this->FILES_atts[$nameVar]['file_post_name']);
			for ($i=0;$i<count($this->FILES_atts[$nameVar]['file_post_name']);$i++){
				$JSPerVar.= '"'.$swf_file_post_name_Keys[$i].'" : "'.$this->FILES_atts[$nameVar]['file_post_name'][$swf_file_post_name_Keys[$i]].'"';
				if ($i!=(count($this->FILES_atts[$nameVar]['file_post_name'])-1))
				$JSPerVar.= ',';
			}
			$JSPerVar.= "\n".'},'."\n";
		}
			
			
		$JSPerVar.= '// File Upload Settings '."\n";
		$JSPerVar.= "\t".'file_size_limit: "'.$this->FILES_atts[$nameVar]['size_limit'].'",'."\n";
		$JSPerVar.= "\t".'file_types : "';
		for ($i=0;$i<count($this->FILES_atts[$nameVar]['file_types']);$i++){
			$JSPerVar.= "".''.$this->FILES_atts[$nameVar]['file_types'][$i].'';
			if ($i!=(count($this->FILES_atts[$nameVar]['file_types'])-1))
			$JSPerVar.= ';';
		}
		$JSPerVar.= '",'."\n";
		$JSPerVar.= "\t".'file_types_description: "'.$this->FILES_atts[$nameVar]['file_types_description'].'",'."\n";
		$JSPerVar.= "\t".'file_upload_limit: '.$this->FILES_atts[$nameVar]['file_upload_limit'].','."\n";
		$JSPerVar.= "\t".'file_queue_limit: '.$this->FILES_atts[$nameVar]['file_queue_limit'].','."\n";
			
		$JSPerVar.= '//Event Handler Settings - these functions as defined in Handlers.js'."\n";
		$JSPerVar.= '//The handlers are not part of SWFUpload but are part of my website and control how'."\n";
		$JSPerVar.= '//my website reacts to the SWFUpload events.'."\n";
		$JSPerVar.= "\t".'file_queue_error_handler: '.$this->FILES_atts[$nameVar]['file_queue_error_handler'].','."\n";
		$JSPerVar.= "\t".'file_dialog_complete_handler: '.$this->FILES_atts[$nameVar]['file_dialog_complete_handler'].','."\n";
		$JSPerVar.= "\t".'upload_progress_handler: '.$this->FILES_atts[$nameVar]['upload_progress_handler'].','."\n";
		$JSPerVar.= "\t".'upload_error_handler: '.$this->FILES_atts[$nameVar]['upload_error_handler'].','."\n";
		$JSPerVar.= "\t".'upload_success_handler: '.$this->FILES_atts[$nameVar]['upload_success_handler'].','."\n";
		$JSPerVar.= "\t".'upload_complete_handler: '.$this->FILES_atts[$nameVar]['upload_complete_handler'].','."\n";
		$JSPerVar.= "\t".'swfupload_loaded_handler: '.$this->FILES_atts[$nameVar]['swfupload_loaded_handler'].','."\n";
		$JSPerVar.= "\t".'file_dialog_start_handler: '.$this->FILES_atts[$nameVar]['file_dialog_start_handler'].','."\n";
		$JSPerVar.= "\t".'file_queued_handler: '.$this->FILES_atts[$nameVar]['file_queued_handler'].','."\n";
		//$JS.= 'upload_start_handler: '.$this->FILE_upload_start_handler.','."\n";
		//$JS.= 'debug_handler: '.$this->FILE_debug_handler.','."\n";

		$JSPerVar.= '// Button Settings'."\n";
		$JSPerVar.= "\t".'button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,'."\n";
		$JSPerVar.= "\t".'button_cursor: SWFUpload.CURSOR.HAND,'."\n";
		
		
		$JSPerVar.= "\t".'button_image_url : "'.$GLOBALS['urlProject'].$this->pathImages.$this->FILES_atts[$nameVar]['button_image_url'].'",'."\n";
		$JSPerVar.= "\t".'button_placeholder_id : "'.$this->FILE_button_placeholder_id.$nameVar.'",'."\n";
		$JSPerVar.= "\t".'button_width: '.$this->FILES_atts[$nameVar]['button_width'].','."\n";
		$JSPerVar.= "\t".'button_height: '.$this->FILES_atts[$nameVar]['button_height'].','."\n";
		
		if ($this->FILES_atts[$nameVar]['upload_several_files'] == true)
			$JSPerVar.= "\t".'button_action : SWFUpload.BUTTON_ACTION.SELECT_FILES,'."\n";
		else
			$JSPerVar.= "\t".'button_action : SWFUpload.BUTTON_ACTION.SELECT_FILE,'."\n";
		
		$JSPerVar.= "\t".'button_text : \'<span class="btnText">'.$this->FILES_atts[$nameVar]['str_etq_button'].' ';

		/**
		 * Deprecated
		if ($this->FILE_src_img_button)
			$JS.= '<img style="padding-right: 3px; vertical-align: bottom;" src="'.$GLOBALS['urlProject'].$this->pathImages.$this->FILE_src_img_button.'" border="0">';
		*/
		
		$maxInfoSize = '';
		$maxFileSizeUpload = '';
		   
	    if ($this->FILES_atts[$nameVar]['show_max_upload_size_info_in_button']){
	    	if ($this->FILES_atts[$nameVar]['size_limit']<1024){
	    		$maxFileSizeUpload = $this->FILES_atts[$nameVar]['size_limit'].' Kb';
	    	}else if ($this->FILES_atts[$nameVar]['size_limit']<1048576){
	    	   	$maxFileSizeUpload = number_format($this->FILES_atts[$nameVar]['size_limit']/1024,2).' Mb';
	    	}else{
      		   	$maxFileSizeUpload = number_format($this->FILES_atts[$nameVar]['size_limit']/1048576,2).' Gb';
	    	}
	       	$maxInfoSize = '('.$maxFileSizeUpload.')';
	    }	   
			
			
		$JSPerVar.= $maxInfoSize.'</span>\','."\n";
		$JSPerVar.= "\t".'button_text_style : ".btnText { text-align: center; font-size: 9; font-weight: bold; font-family: MS Shell Dlg; }",'."\n";
		$JSPerVar.= "\t".'button_text_top_padding : 3,'."\n";
		$JSPerVar.= "\t".'button_text_left_padding : 0,'."\n"; 		
		
		$JSPerVar.= '//Flash Settings'."\n";
		$JSPerVar.= "\t".'flash_url: "'.$this->FILES_atts[$nameVar]['flash_url'].'",'."\n";
		$JSPerVar.= "\t".'flash_width: "'.$this->FILES_atts[$nameVar]['flash_width'].'",'."\n";
		$JSPerVar.= "\t".'flash_height: "'.$this->FILES_atts[$nameVar]['flash_height'].'",'."\n";
		$JSPerVar.= "\t".'flash_color: "#'.$this->FILES_atts[$nameVar]['flash_color'].'",'."\n";
			
		$JSPerVar.= '//Debug Settings'."\n";
		$JSPerVar.= "\t".'debug: '.$this->FILES_atts[$nameVar]['debug'].''."\n";
			
		//$JS.= 'file_post_name : "'.$this->FILE_file_post_name.'",'."\n";
		/*
		 $JS.= 'custom_settings : {'."\n";
		 $swf_custom_settings_Keys = array_keys($this->FILE_custom_settings);
		 for ($i=0;$i<count($this->FILE_custom_settings);$i++){
		 $JS.= ''.$swf_custom_settings_Keys[$i].' : "'.$this->FILE_custom_settings[$swf_custom_settings_Keys[$i]].'"';
		 if ($i!=(count($this->FILE_custom_settings)-1))
		 $JS.= ',';
		 }
		 $JS.= '}'."\n";
		 */
		$JSPerVar.= '});'."\n";
		
		return $JSPerVar;
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

		if (count($this->arrayCKEditorInstances)){
			
			$buf .= '<script type=\'text/javascript\'>'."\n";
			
			$buf .= "\t".'var CKEditorInstances = new Object();'."\n";
			
			foreach ($this->arrayCKEditorInstances as $instance){
			
				$buf .= "\t".'CKEditorInstances["'.$this->getColspanRowspan($instance).'"] = "'.$this->getColspanRowspan($instance).'";'."\n";
			}
			
			$buf .= '</script>'."\n";
		}
		
		
		
		$buf .= '<!--'."\n";
		$buf .= 'OSEZNO PHP FRAMEWORK'."\n";
		$buf .= 'Generado con la clase para la creacion de Formularios myForm.class.php'."\n";
		$buf .= 'Formulario: '.$this->name.''."\n";
		$buf .= 'Autor: Jose Ignacio Gutierrez Guzman <http://www.osezno-framework.org/joselitohacker/>'."\n";
		$buf .= '-->'."\n";

		if ($this->useAddFile && !$this->useAddFileAfterLoad){
		
		  $buf .= $this->getJavaScriptSWFUploader($this->uploaderIdArray);
		  
        }

		$this->cols = $cols;

		$buf .= '<form ';

		$buf.= 'onsubmit="'.$this->onSubmitAction.'" ';
		
		if ($this->action)
			$buf .= 'action="'.$this->action.'" ';
				
			
		$buf.= 'method="'.$this->method.'" ';

		if ($this->enctype)
			$buf.='enctype= "'.$this->enctype.'" ';
			
		$buf.= 'name="'.$this->name.'" id="'.$this->name.'" target="'.$this->target.'">'."\n";

		$buf .= '<div class="'.$this->styleClassForm.'" align="center" id="div_'.$this->name.'" name="div_'.$this->name.'">'."\n";
		
		if (strlen($this->strFormFieldSet))
			$buf .= '<fieldset><legend class="'.$this->styleClassFieldsets.'">'.$this->strFormFieldSet.'</legend>'."\n";
		
		# Creamos cada uno de los Objetos HTML con el objetivo de que mas adelante sean procesados en: Grupos, o Independientemente. 
			
		if (count($this->Objects)){	
		   $ObjectKeys = array_keys($this->Objects);
		
		   $countObjects = count($this->Objects['field']);
		
		for($j=0, $objKeysFields = array_keys($this->Objects['field']); $j < $countObjects; $j++){
			
			$campos_f = explode ($this->Separador,$this->Objects['field'][$objKeysFields[$j]]);
			
			switch ($campos_f[0]){
				
				case 'text':// Ok colSpan
					
					$strEvents = '';
					
					$keypress = '';
					
					if ($campos_f[6])
						
						$keypress = ' onKeyPress="return OnlyNum(event)"';
						
					$utilyVal = '';
					
					$LauncherCalendar = '';

					if ($campos_f[7]){
						
						$utilyVal = 'onKeyUp="CalendarFormat( this );" onBlur="BlurDate( this )"'; 
						
						$LauncherCalendar = '<td><button '.$this->checkIfIsDisabled($campos_f[2]).' type="button" class="boton_cal" id="trigger_'.$campos_f[2].'"  name="trigger_'.$campos_f[2].'" onClick="addCalendarWindow(document.forms[\''.$this->name.'\'].elements[\''.$campos_f[2].'\'].value, \''.$campos_f[2].'\', \''.$campos_f[2].'\', \''.$this->name.'\')" /><img src="'.$GLOBALS['urlProject'].$this->pathImages.$this->srcImageCalendarButton.'" border="0"></button></td>';
						
					}else 
						$strEvents = $this->checkExistEventJs($campos_f[2]);

					$this->arrayFormElements[$campos_f[2]] = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld><table cellpadding="0" border="0" cellspacing="0"><tr><td><input '.$this->checkAutoCompleteStatus($campos_f[2]).' '.$this->checkIsHelping($campos_f[2]).' class="'.$this->styleClassFields.'" type="text" name="'.$campos_f[2].'" id="'.$campos_f[2].'" value="'.$campos_f[3].'" size="'.$campos_f[4].'" '.$utilyVal.' maxlength="'.$campos_f[5].'"'.$keypress.''.$strEvents.''.$this->checkIfIsDisabled($campos_f[2]).'></td>'.$LauncherCalendar.'</tr></table></td>'."\n";
					
					break;
				case 'password':
					
					$this->arrayFormElements[$campos_f[2]] = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld><input '.$this->checkAutoCompleteStatus($campos_f[2]).' '.$this->checkIsHelping($campos_f[2]).' class="'.$this->styleClassFields.'" type="password" name="'.$campos_f[2].'" id="'.$campos_f[2].'" value="'.$campos_f[3].'" size="'.$campos_f[4].'" maxlength="'.$campos_f[5].'" '.$this->checkExistEventJs($campos_f[2]).' '.$this->checkIfIsDisabled($campos_f[2]).'></td>'."\n";
					break;
				case 'file':
					
					$bufTemp = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld>';

					//$bufTemp .= '<button '.$this->checkIfIsDisabled($campos_f[2]).' '.$this->checkIsHelping($campos_f[2]).' class="'.$this->styleClassButtons.'" id="'.$campos_f[2].'" type="button"  onclick="'.$SWFonClick.'">';
					$bufTemp .= '<span id="'.$this->FILE_button_placeholder_id.''.$campos_f[2].'">';
					
					/**
					 *	Deprecated 
					if ($this->FILE_src_img_button)
						$bufTemp .= '<img style="padding-right: 3px; vertical-align: bottom;" src="'.$GLOBALS['urlProject'].$this->pathImages.$this->FILE_src_img_button.'" border="0">';
					*/	

					$maxInfoSize = '';
					   
	    			if ($this->FILES_atts[$campos_f[2]]['show_max_upload_size_info_in_button']){
	    				
	    				if ($this->FILES_atts[$campos_f[2]]['size_limit']<1024){
	    					
	           				$maxFileSizeUpload = '('.$this->FILES_atts[$campos_f[2]]['size_limit'].' Kb)';
	           				
	    				}else if ($this->FILES_atts[$campos_f[2]]['size_limit']<1048576){
	    					
	    	   				$maxFileSizeUpload = '('.number_format($this->FILES_atts[$campos_f[2]]['size_limit']/1024,2).' Mb)';
	    	   				
	    				}else{
	    					
      		   				$maxFileSizeUpload = '('.number_format($this->FILES_atts[$campos_f[2]]['size_limit']/1048576,2).' Gb)';
	    				}
	    				
	       				$maxInfoSize = '<font style="vertical-align: middle; font-size: 6pt; font-weight: bold;">'.$maxFileSizeUpload.'</font>';
	    			}	   
					
					//$bufTemp .= $this->FILE_str_etq_button.$maxInfoSize.'</button><div style="text-align: left;" class="'.$this->styleClassTags.'" id="div_file_progress" name="div_file_progress"></div>';
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
				case 'WYSIWYG':
					
					switch ($this->WYSIWYG_type){
						
						case 'ck_editor':

							$pathckEditor = $GLOBALS['folderProject'].'plugin/editors/ck_editor/ckeditor.php';
							
							require ($pathckEditor);
							
							$oCKeditor = new CKeditor();
							
							$events = array();
					
							$config = array();
					
							$oCKeditor->returnOutput = true;
					
							$oCKeditor->basePath = $this->WYSIWYG_editor_BasePath;
					
							$oCKeditor->config['width']  = $this->WYSIWYG_editor_Width;
					
							$oCKeditor->config['height'] = $this->WYSIWYG_editor_Height;
							
							$oCKeditor->config['toolbar_Basic'] = array(
							
								array('Source','Preview','ShowBlocks'),
									
								array('Cut','Copy','Paste','PasteText','PasteFromWord'),
									
								array('Find','Replace'),
									
								array('Bold','Italic','Underline','Strike','-','Subscript','Superscript'),
									
								array('NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'),
									
								array('JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'),
									
								array('BidiLtr', 'BidiRtl'),
									
								array('Link','Unlink','Anchor'),
									
								array('Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'),
									
								array('Format','Font','FontSize'),
									
								array('TextColor','BGColor'),
								
								array('About')
							);
							
							$oCKeditor->config['toolbar'] = 'Basic';
							
							$oCKeditor->config['skin'] = 'kama';

							$this->arrayFormElements[$campos_f[2]] = ''.'<td rowSpanEtq '.$this->checkIsHelping($campos_f[2]).' style="text-align:center" colSpanEtq class="'.$this->styleClassTags.'">'.$campos_f[1]."<br>".$oCKeditor->editor($campos_f[2],$campos_f[3],$events,$config).'</td>'."\n";
							
						break;
					}
					
					break;
				case 'mylist':

					/**
					 * TODO: Crear una lista dinamica con campos check box que permitan chequear elementos correspondientes a una tabla de base de datos o IDs asociados a un resultado de una consulta
					 */					
					
					break;
				case 'whitespace':
					
					$this->arrayFormElements[$campos_f[1]] = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq><div name="e_'.$campos_f[1].'" id="e_'.$campos_f[1].'">'.$campos_f[2].'</div></td><td rowSpanFld colSpanFld widthFld class="'.$this->styleClassFields.'"><div name="c_'.$campos_f[1].'" id="c_'.$campos_f[1].'">'.$campos_f[3].'</div></td>'."\n";
					break;
				case 'coment':
					
					$this->arrayFormElements[$campos_f[1]] = '<td widthCell rowSpanEtq class="'.$this->styleClassComments.'" colSpanEtq>'.$campos_f[2].'</td>';
					break;
				case 'checkbox':
					
					$cheked = '';
					if ($campos_f[3] == true)
						$cheked = 'checked';

					$onClickTag = '';
					
					if (!$this->checkIfIsDisabled($campos_f[2]))
					
						$onClickTag  = 'onclick="checkear(\''.$campos_f[2].'\')"';
						
					$onEvent = $this->checkExistEventJs($campos_f[2]);
					
					if ($onEvent && !$this->checkIfIsDisabled($campos_f[2])){
						
						$onClickTag  = str_ireplace('onclick="','onclick="checkear(\''.$campos_f[2].'\'),',$onEvent);
						
					}
						
					$this->arrayFormElements[$campos_f[2]] = '<td rowSpanEtq colSpanEtq '.$onClickTag.' class="'.$this->styleClassTags.'"  widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld><input '.$onEvent.' '.$this->checkIsHelping($campos_f[2]).' class="'.$this->styleClassFields.'" type="checkbox" name="'.$campos_f[2].'" id="'.$campos_f[2].'" '.$cheked.' '.$this->checkIfIsDisabled($campos_f[2]).'>'.'</td>'."\n";
					break;
				case 'radiobutton':

					$cheked = '';
					
					if ($campos_f[5] == true)
						$cheked = 'checked';

					$this->arrayFormElements[$campos_f[2]] = '<td rowSpanEtq colSpanEtq class="'.$this->styleClassTags.'" widthEtq>'.$campos_f[1].'</td>'.'<td rowSpanFld colSpanFld widthFld><input '.$this->checkIsHelping($campos_f[4]).' class="'.$this->styleClassFields.'" type="radio" name="'.$campos_f[4].'" id="'.$campos_f[4].'_'.$campos_f[3].'" value="'.$campos_f[3].'" '.$this->checkExistEventJs($campos_f[4]).' '.$this->checkIfIsDisabled($campos_f[4]).' '.$cheked.'></td>'."\n";
					break;
				case 'button':
					
					$bufButton = '<button '.$this->checkIsHelping($campos_f[1]).' '.$this->checkIfIsDisabled($campos_f[1]).' value="'.trim(strip_tags($campos_f[2])).'" class="'.$this->styleClassButtons.'" type="submit" name="'.$campos_f[1].'" id="'.$campos_f[1].'" '.$this->checkExistEventJs($campos_f[1]);
			
					$bufButton .= '>';

					$bufButton .= '<table width="100%" border="0" cellpadding="0" cellspacing="0"><tr>';
			
					if ($campos_f[3])
						$bufButton .= '<td align="right"><img style="padding-right: 2px;" src="'.$campos_f[3].'" border="0"></td>';

					$bufButton .= '<td class="boton_font">'.str_replace(' ','&nbsp;',$campos_f[2]).'</td></tr></table>';

					$bufButton .= '</button>';
					
					$this->arrayFormElements[$campos_f[1]] = '<td widthCell rowSpanEtq style="text-align:center" colSpanEtq>'.$bufButton.'</td>';
					
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
			
			$bufHTMLgroup .= '<fieldset style="width:'.$this->width.'"><legend class="'.$this->styleClassFieldsets.'">'.$hrefUseShowHideIni.$this->arrayGroups[$kAgrupa]['strFieldSet'].$hrefUseShowHideEnd.'</legend>'."\n";
			
			$bufHTMLgroup .= '<div name="'.$this->arrayGroups[$kAgrupa]['idGroup'].'" id="'.$this->arrayGroups[$kAgrupa]['idGroup'].'"'.$styleDivFieldSet.'>'."\n";
			
			#  Preguntamos si el grupo en proceso es un arreglo de elementos
			
			if (is_array($this->arrayGroups[$kAgrupa])){
				
				$bufHTMLgroup .= '<table class="'.$this->styleClassTableForm.'" border="'.$this->border.'" align="center" cellpadding="'.$this->cellPadding.'" cellspacing="'.$this->cellSpacing.'" valign="top" width="100%">'."\n";
				
				$kCamposDe = count($this->arrayGroups[$kAgrupa]['arraystrIdFields']);
				
				# Calculamos cuantos filas y columna tendra este marco
				
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
						
						if (in_array($attObj,$this->arrayTypeElemSpecial)){
							
							$bufHTMLgroup .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
								                  array('width="'.intval($widthCol*$numColSpan).'%"',
								                  		'width="'.intval($widthCol*$numColSpan).'%"',
								                  		'width="'.intval($widthCol*$numColSpan).'%"',
								                  		'colspan="'.($numColSpan*2).'"',
								                  		'colspan="'.($numColSpan*2).'"',
								                  		'',
								                  		''),$this->arrayFormElements[$nameField]);
						}else{
							
							$bufHTMLgroup .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
								                  array('',
								                  		'width="'.intval($widthCol*$numColSpan).'%"',
								                  		'width="'.intval($widthCol*$numColSpan).'%"',
								                  		'colspan="'.$numColSpan.'"',
								                  		'colspan="'.$numColSpan.'"',
								                  		'',
								                  		''),$this->arrayFormElements[$nameField]);
						}
						
					}else{
						
						if (in_array($attObj,$this->arrayTypeElemSpecial)){
							
							$bufHTMLgroup .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
								                  array('width="'.intval($widthCol*2).'%"',
								                  		'width="'.intval($widthCol).'%"',
								                  		'width="'.intval($widthCol).'%"',
								                  		'colspan="2"','colspan="2"',
								                  		'',
								                  		''),$this->arrayFormElements[$nameField]);
						}else{
							
							$bufHTMLgroup .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
								                  array('',
								                  		'width="'.intval($widthCol).'%"',
								                  		'width="'.intval($widthCol).'%"',
								                  		'',
								                  		'',
								                  		'',
								                  		''),$this->arrayFormElements[$nameField]);
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
				
				$buf .= '<table width="'.$this->width.'" border="'.$this->border.'" cellspacing="0">'."\n";
				
				$buf .= '<tr>'."\n";
				
				$countArGpIdInShSp = count($arrayGroupsIdInShareSpace);
				
				for ($j=0;$j<$countArGpIdInShSp;$j++){
					
					$buf.='<td width="'.intval(100/count($arrayGroupsIdInShareSpace)).'%" align="center">'.str_replace('width:'.$this->width.'','width:'.(($this->width/$countArGpIdInShSp)-17),$this->arrayGroupsElementsHTML[$arrayGroupsIdInShareSpace[$j]]).'</td>'."\n";
					
					$this->arrayGroupsShown[]=$arrayGroupsIdInShareSpace[$j];
				}
				
				$buf .= '</tr>'."\n";
				
				$buf .= '</table>'."\n";
			}
		}

		
		# Mostrar cada uno de los grupos que no han sido mostrados

		for ($i=0;$i<$countArrayGroups;$i++){
			
			if (!in_array($this->arrayGroups[$i]['idGroup'],$this->arrayGroupsShown)){
				
				$buf .= $this->arrayGroupsElementsHTML[$this->arrayGroups[$i]['idGroup']];
				
				$this->arrayGroupsShown[]=$this->arrayGroups[$i]['idGroup'];
			}
		}

		# Calculamos los Id de los objectos definidos del formulario que no han sido definidos
		
		$countArrayFormElements = count($this->arrayFormElements);
		
		$arrayKeysFormElements = array_keys($this->arrayFormElements);
		
		for ($i=0;$i<$countArrayFormElements;$i++){
			
			if (!in_array($arrayKeysFormElements[$i],$this->arrayFormElementsShown)){
				
				$this->arrayFormElementsToShow[] = $arrayKeysFormElements[$i];
			}
		}

		# Imprimimos los elementos del formulario restantes
		
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
				
				if (in_array($attObj,$this->arrayTypeElemSpecial)){
					
					$buf .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
						         array(
						         	'',
						         	'width="'.intval($widthCol*$numColSpan).'%"',
						         	'width="'.intval($widthCol*$numColSpan).'%"',
						         	'colspan="'.($numColSpan*2).'"',
						         	'colspan="'.($numColSpan*2).'"',
						         	'',
						         	''),$this->arrayFormElements[$nameField]);
				}else{
					
					$buf .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
						         array(
						         	'',
						         	'width="'.intval($widthCol*$numColSpan).'%"',
						         	'width="'.intval($widthCol*$numColSpan).'%"',
						         	'colspan="'.$numColSpan.'"',
						         	'colspan="'.$numColSpan.'"',
						         	'',
						         	''),$this->arrayFormElements[$nameField]);
				}
				
			}else{
				
				if (in_array($attObj,$this->arrayTypeElemSpecial)){
					
					$buf .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
						         array(
						         	'width="'.intval($widthCol*2).'%"',
						         	'width="'.intval($widthCol).'%"',
						         	'width="'.intval($widthCol).'%"',
						         	'colspan="2"',
						         	'colspan="2"',
						         	'',
						         	''),$this->arrayFormElements[$nameField]);
				}else{
					
					$buf .=  "\t\t".str_replace($this->arrayAttributesToReplaceInRow,
						         array(
						         	'',
						         	'width="'.intval($widthCol).'%"',
						         	'width="'.intval($widthCol).'%"',
						         	'',
						         	'',
						         	'',
						         	''),$this->arrayFormElements[$nameField]);
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
		
		if (strlen($this->strFormFieldSet))
			$buf .= '</fieldset>'."\n";
			
		$buf .= '</div>'."\n";
		
		$buf .= '</form>'."\n";

		

		$buf .= '<!-- Fin de Formulario: '.$this->name.' -->'."\n";

		return $buf;
	}	
	
	// Fin de la Clase
}
?>