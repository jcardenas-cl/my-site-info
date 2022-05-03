# my-site-info
Pequeño plugin para llenar información común de un sitio, como redes sociales, ubicación, medios de contacto, etc.
Su funcionamiento esta orientado al desarrollo, ya que se trata de una tarea repetitiva que suele ocurrir en todos los sitios, es por eso que con este plugin, se agrega una nueva entrada en el panel de opciones de WordPress que permite agregar redes sociales (icono, nombre y url). Tambien otros como un casillero para Google Maps y metodos de contacto.

## Como funciona?
El plugin tiene una lista de caracteristicas predefinidas como agregar las redes sociales del sitio, correos de contacto, telefonos tanto celular como fijo entre otros.
Cada una de esas listas puede ser exhibida en el sitio mediante shortcodes.
Esos shortcodes son:

- [msi_show_rrss_bar] Para mostrar las redes sociales registradas. Al hacer clic, envia a la red social en una pestaña nueva.
- [msi_show_mobile_phone_bar] Para mostrar una lista con los teléfonos celulares. Al hacer clic, se puede llamar directamente.
- [msi_show_phone_bar] Lista con los teléfonos fijos. Al hacer clic, se puede llamar directamente.
- [msi_show_email_bar] Lista con los correos electronicos registrados. Al hacer clic en un elemento se despliega el cliente de correos por defecto del usuario para poder enviar un correo electonico.
- [msi_show_whatsapp_bar] Lista con los telefonos y una cuenta de WhatsApp asociada, al hacer clic en un elemento ocupa la api de WhatsApp para desplegar el chat en el navegador por defecto o en la aplicación.

## Parametros de shortcodes
Todos los shortcodes antes mencionados, admiten 2 parametros para configurar la información desplegada, estos parametros son:
- limit: Cantidad de elementos a mostrar, su valor por defecto es la cantidad de elementos guardados.
- start: Index desde donde se debe empezar a mostrar, su valor por defecto es 0.

Es decir que si por ejemplo, queremos que en una lista de 5 correos de contacto, mostrar solamente los ultimos 2, podemos llamar:
[msi_show_email_bar start=2 limit=2]

## Estilos
Este plugin cuenta con estilos simples pensados para que sea sencillo adaptarlo a las necesidades de cada sitio, todos los shortcodes son definidos como listas y cada lista tiene una clase especifica, además de esa clase en la lista, se agrega un contenedor con la clase "msi-container" la cual no tiene ningun estilo definido, por lo que en caso de necesitar sobreescribir un estilo, se puede ocupar esa clase para que tenga una mayor prioridad en los estilos.