[![](http://www.osezno-framework.org/templates/web/imagenes/tarjeta.jpg)](http://www.osezno-framework.org/)



## What is Osezno PHP Framework? ##
Osezno PHP Framework is a development tool written in PHP type framework under license GPL which was conceived with the objective of supporting the daily tasks of a developer of PHP's employer, student programming, or a freelance programmer. No matter if the development is small or great; Osezno PHP Framework breaks that division through simplicity, ensuring quality in the development of the code, a high degree of readability and organization of the same when apply your code style.

"Osezno PHP Framework is designed for easy learning, is betting on simplicity, allowing the developer to focus on the ultimate goal of their work and not in writing of additional code libraries."

Want to know what you can do with Osezno php framework? Enter the Demos section, examples ready for use on your PC! You'll notice that it is easy to learn.

Osezno PHP Framework is also designed for quick and excellent results without a lot of code on a web project of high, medium or small requirements in your company, school or need personal to develop.

In a little over 3 years of applied research, we wanted to contribute development open source software. Osezno PHP Framework is 100% Open Source and 100% Colombian.

We invite you to try our tool. In this learning process you will have enough support and enough help on the scope that Osezno PHP framework can cover.

We look forward your questions and concerns that you want to share with us.

## ¿Que es Osezno PHP Framework? ##
Osezno PHP Framework es una herramienta de desarrollo escrito en PHP tipo framework bajo licencia GPL que fue concebida con el ánimo de apoyar las tareas diarias de un desarrollador de PHP en la empresa donde labora, de un estudiante de programación, o de un programador independiente. No importa si el desarrollo es pequeño o es grande; Osezno php framework rompe esa división a traves de la simplicidad, asegurando una calidad en el desarrollo del código, un alto grado de legibilidad y una organización del mismo cuando presenta su estilo de código.

Osezno PHP Framework está diseñado para aprender fácil, le apuesta a la simple permitiéndole al desarrollador concentrarse en el objetivo final de su trabajo y no en la escritura de código adicional como librerías.

#### Osezno Php Framework te permite: ####

Definir plantillas Html con áreas de trabajo que puedes reemplazar por contenidos como Pestañas (En las que agrupas dos o más vistas dentro de un módulo), Formularios, Listas dinámicas (Muestras el contenido de una consulta SQL donde paginas, ordenas, filtras y exportas su contenido).

Aplicar tendencias de programación y tecnologías como: Active record (Abstraes tu bases de datos a objetos del lenguaje de programación PHP), Ajax (Usamos un plugin llamado xajax) todo sobre un patrón de construcción de software MVC (Modelo Vista Controlador) en donde los eventos de usuario como Clicks sobre botones son manejados por sus propia clase sobre las vistas (Plantillas Html).

José Ignacio Gutierréz Guzmán. <_jose.gutierrez@osezno-framework.org_>



---

**Current Version/Estado actual:** 1.0 RC 2

**Requirements/Requerimientos de software:** Php >= 5.1.6, php\_pdo, php\_pdo\_pgsql, php\_pdo\_mysql

---

### ¿Como trabaja? how it works? ###
**_template.tpl_** _(Plantilla con código Html / Html code template)_
```
<html>
<head>
</head>
<body>
<!-- Definimos areas en la plantilla / Areas are defined in the template-->
<div align="center">{content}</div>  
</body>
</html>
```
**_index.php_** _(Despliega la vista / Displays the view)_
```
<?php

 include 'handlerEvent.php';
 
 // Asignamos a las areas de la plantilla los contenidos / Assigned content areas
 $objOsezno->assign('content',$datamodel->getForm());
 
 //Mostramos la plantilla / Show the template
 $objOsezno->call_template('template.tpl');

?> 
```
**_dataModel.php_** _(Modelo de datos / Data model)_
```

<?php

 include 'configMod.php';

 class datamodel {

   public function getForm (){

      $myForm = new myForm('form1');
      
      // Agregamos objetos a un formulario / Add objects to the user form
      $myForm->addText('Su nombre:','nam');

      $myForm->addButton('btn1','Send');

      // Agregamos eventos a los objetos / Add events to the form objects
      $myForm->addEvent('btn1','onclick','myEvent');

      return $myForm->getForm();
   }

 }

 $datamodel = new datamodel;

?>

```
**_handlerEvent.php_** _(Administra los eventos de usuario / Manage user events)_
```
<?php

 include 'dataModel.php';
 
 class events extends myController {
    
     // Declaramos los eventos de usuario / Declare (Build) user events
     public function myEvent ($dataForm){

        $this->alert('Su nombre es:'.$dataForm['nam']);

	return $this->response;
     }
	
 }

$objEventos = new eventos($objxAjax);
$objOsezno  = new osezno($objxAjax,$theme);
 
$objOsezno->setPathFolderTemplates(PATH_TEMPLATES);
$objxAjax->processRequest();

?>
```

---

&lt;wiki:gadget url="http://www.ohloh.net/p/133715/widgets/project\_users.xml?style=green" height="100" border="0"/&gt;
| **Lenguajes usados** | **Estadisticas** | **Costos** |
|:---------------------|:-----------------|:-----------|
| &lt;wiki:gadget url="http://www.ohloh.net/p/133715/widgets/project\_languages.xml" border="0" height="200" width="350" /&gt; | &lt;wiki:gadget url="http://www.ohloh.net/p/133715/widgets/project\_basic\_stats.xml" height="220" border="0"/&gt; | &lt;wiki:gadget url="http://www.ohloh.net/p/133715/widgets/project\_cocomo.xml" height="250" border="0"/&gt; |