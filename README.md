# my-site-info
Pequeño plugin para llenar información común de un sitio, como redes sociales, ubicación, medios de contacto, etc.
Su funcionamiento esta orientado al desarrollo, ya que se trata de una tarea repetitiva que suele ocurrir en todos los sitios, es por eso que con este plugin, se agrega una nueva entrada en el panel de opciones de WordPress que permite agregar redes sociales (icono, nombre y url). Tambien otros como un casillero para Google Maps y metodos de contacto.

## ¿Como instalar?
Para realizar la instalación de este plugin, simplemente presiona sobre el botón "Code" y luego pulsa sobre la opción "Download zip". A continuación descomprime el archivo y renombra la carpeta "my-site-info-main" a "my-site-info". Luego sube esa carpeta al directorio donde se alojan los plugins de tu sitio, suele ser en /wp-content/plugins/, pero puede que en algunos casos especificos se encuentre en otra ruta.
Posterior a eso solo debes activar el plugin mediante el panel de control de WordPress.

## ¿Donde ingresar la información?
Para guardar las distintas redes sociales, medios de contacto y ubicación, nos dirigimos a la seccion "Apariencia" en la barra lateral de WordPress y seleccionamos el item "Info. contacto y ubicación". Allí podremos ver una lista en donde podremos cargar las redes sociales con un icono, nombre de la red y su url. Ademas hay espacios para colocar telefonos de contacto, correos y números de WhatsApp. Tambien hay campos para alojar la información como direccion fisica, mapa de Google Maps (o cualquier código HTML para insertar un mapa).

### Opciones
Además de guardar esta información, el plugin admite algunas opciones de configuración, como por ejemplo el estilo en que se mostrará las redes sociales, ya sea solo con sus iconos o iconos y además el nombre de la red. Por defecto se mostrará solo el icono siendo esta la opción mas frecuente. 

## Agregar redes sociales
Se puede agregar un número ilimitado de redes sociales a la configuración del sitio. Los datos requeridos seran el icono (o fuente), nombre de la red y la url de destino al hacer clic sobre la red. En en caso de el nombre y la url, la forma de cargar los datos es simplemente a través de un texbox, distinto es el caso del icono, ya que dependiendo 
de el modo, permite o seleccionar una imágen o ingresar el tag para ser mostrado.

### Mediante imágenes
Este es el metodo mas sencillo y directo para agregar redes sociales, solo debes elegir una imagen adecuada a la red social que tenga un formato jpg, png o svg y cargarla en la 
fila correspondiente. Por defecto las imagenes se mostraran a 30px de ancho, pero podrás cambiar esta medida mediante reglas css que insertes mediante una hoja de estilos u cualquier otro medio. Como siempre, lo ideal es que las imagenes tengan una medida y peso adecuado, probablemente tambíen será una buena idea que cuente con transparencia para que no provoque problemas con el fondo del sitio.

### Mediante fuentes
Considerar que para usar este método, es ideal tener conocimientos de CSS y HTML.
Un metodo alternativo de ocupar este plugin en su apartado de redes sociales, es que los iconos se muestren a partir de fuentes, es decir que en vez de mostrar una imágen se usará un código HTML que puede ser algo como *<i class="icon-facebook"></i>*, esto tiene como ventaja que eventualmente podriamos agrandar el tamaño de los iconos o cambiar su color, sin tener que volver a descargar la imágen de la red social.
Existen paginas como fontello en donde se provee una serie de iconos de manera gratuita e incluso cargar iconos nuevos para usarlos en tu sitio. Una vez dicho esto, veamos como realizar la carga mediante fuentes.
Lo primero será seleccionar la opción "Mediante fuentes" en la selección de como se realizará la carga de iconos, hecho eso, la pantalla mostrará algunas opciones adicionales a solo cargar mediante imagenes, estos campos permite cargar los archivos de fuente y además el archivo CSS que enlaza a dichos archivos de fuente, ahora veremos que hacer en cada campo.

#### Archivos de fuentes
El primer campo nos permitirá cargar tantos archivos de fuentes como sean necesarios, suelen ser varios formatos ya que dependiento del navegador se puede utilizar un caso distinto, por ejemplo, Internet Explorer hace uso de archivos .eot, pero Chrome de archivos .woff.
Mediante el botón "Haga clic aquí para agregar una fuente" seleccionamos una por una las fuentes a usar, fijandonos en cargar todas las extensiones necesarias. También podemos reemplazar o borrar uno de los archivos de ser necesario.
Una vez seleccionadas todas las fuentes, pulsamos el botón "Guardar" ubicado al final del formulario, esto es un paso importante ya que necesitamos la URL de cada archivo para el siguiente paso.

#### Reemplazar las url de las fuentes
Con las URL de todas las fuentes, nos queda reemplazar las rutas en el archivo CSS que las llama, inicialmente esas rutas son relativas en el archivo CSS, por lo que posiblemente no coincidan con la url real que tendrán una vez cargadas al sitio. Asi que abriendo el archivo CSS que contiene las rutas a las fuentes, reemplazamos las URL relativas y las reemplazamos por las absolutas entregadas en la pantalla, es decir que se debe transformar de algo como esto:
```
@font-face { font-family: 'font_name';
src: url('../font/font_name.eot?16052275');
src: url('../font/font_name.eot?16052275#iefix') format('embedded-opentype'),
url('../font/font_name.woff2?16052275') format('woff2'),
url('../font/font_name.woff?16052275') format('woff'),
url('../font/font_name.ttf?16052275') format('truetype'),
url('../font/font_name.svg?16052275#font_name') format('svg');
font-weight: normal;
font-style: normal;
}
```
... a algo como esto:
```
@font-face { font-family: 'font_name';
src: url('https://mysite.com/wp-content/uploads/2022/06/font_name.eot?16052275');
src: url('https://mysite.com/wp-content/uploads/2022/06/font_name.eot?16052275#iefix') format('embedded-opentype'),
url('https://mysite.com/wp-content/uploads/2022/06/font_name.woff2?16052275') format('woff2'),
url('https://mysite.com/wp-content/uploads/2022/06/font/font_name.woff?16052275') format('woff'),
url('https://mysite.com/wp-content/uploads/2022/06/font/font_name.ttf?16052275') format('truetype'),
url('https://mysite.com/wp-content/uploads/2022/06/font/font_name.svg?16052275#font_name') format('svg');
font-weight: normal;
font-style: normal;
}
```
Con las rutas reemplazadas guardarmos el archivo.

#### Subir el archivo CSS
La última parte de esto es subir el archivo CSS modificado al sitio, esto lo hacemos mediante el campo con la etiqueta *Archivo CSS* en la cual solo seleccionamos el archivo y pulsamos "abrir" en la ventana de selección. Hecho eso, guardamos el formulario para cargar el archivo.
Considerar que en el caso de subir o reemplazar una fuente, probablemente también se deba volver a cargar este archivo, pues la URL sera distinta.

#### Cargar la etiqueta HTML con la fuente
El último paso es insertar la etiqueta con el icono, en el caso de fontello, suele ser algo como *<i class="icon-linkedin"></i>"*, pero puede variar dependiendo de como hayas conseguido las fuentes. Con la etiqueta determinada, solo la ingresamos en el campo especificado para ello que es el primer campo desde izquierda a derecha.

Con todos esos pasos ya se debe ver las redes sociales y sus iconos correspondientes con fuentes.

## ¿Como mostrar la información?
El plugin tiene una lista de caracteristicas predefinidas como agregar las redes sociales del sitio, correos de contacto, telefonos tanto celular como fijo entre otros.
Cada una de esas listas puede ser exhibida en el sitio mediante shortcodes.
Esos shortcodes son:

- [msi_show_rrss_bar] Para mostrar las redes sociales registradas. Al hacer clic, envia a la red social en una pestaña nueva.
- [msi_show_mobile_phone_bar] Para mostrar una lista con los teléfonos celulares. Al hacer clic, se puede llamar directamente.
- [msi_show_phone_bar] Lista con los teléfonos fijos. Al hacer clic, se puede llamar directamente.
- [msi_show_email_bar] Lista con los correos electronicos registrados. Al hacer clic en un elemento se despliega el cliente de correos por defecto del usuario para poder enviar un correo electonico.
- [msi_show_whatsapp_bar] Lista con los telefonos y una cuenta de WhatsApp asociada, al hacer clic en un elemento ocupa la API de WhatsApp para desplegar el chat en el navegador por defecto o en la aplicación.
- [msi_show_address] Muestra la dirección guardada en el sitio.
- [msi_show_map] Inserta código HTML con el iframe de Google Maps (o servicio similar) en el sitio.

## Parametros de shortcodes
Todos los shortcodes antes mencionados, con la excepción de *msi_show_address* y *msi_show_map*, admiten 2 parametros para configurar la información desplegada, estos parametros son:
- limit: Cantidad de elementos a mostrar, su valor por defecto es la cantidad de elementos guardados.
- start: Index desde donde se debe empezar a mostrar, su valor por defecto es 0.

Es decir que si por ejemplo, queremos que en una lista de 5 correos de contacto, mostrar solamente los ultimos 2, podemos llamar:
[msi_show_email_bar start=2 limit=2]

Para el caso de las redes sociales, admite un parametro adicional que es *layout*, este parametro permite sobre escribir la configuración guardada y definir de manera explicita cual es el layout para mostrar las redes sociales, siendo *layout-1* solo iconos, y *layout-2* iconos y además su nombre.

## Estilos
Este plugin cuenta con estilos simples pensados para que sea sencillo adaptarlo a las necesidades de cada sitio, todos los shortcodes son definidos como listas y cada lista tiene una clase especifica, además de esa clase en la lista, se agrega un contenedor con la clase "msi-container" la cual no tiene ningún estilo definido, por lo que en caso de necesitar sobreescribir un estilo, se puede ocupar esa clase para que tenga una mayor prioridad.