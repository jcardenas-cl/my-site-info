# my-site-info
Pequeño plugin para llenar información común de un sitio, como redes sociales, ubicación, medios de contacto, etc.
Su funcionamiento esta orientado al desarrollo, ya que se trata de una tarea repetitiva que suele ocurrir en todos los sitios, es por eso que con este plugin, se agrega una nueva entrada en el panel de opciones de WordPress que permite agregar redes sociales (icono, nombre y url). Tambien otros como un casillero para Google Maps y metodos de contacto.

## Donde ingresar la información?
Para guardar las distintas redes sociales, medios de contacto y ubicación, nos dirigimos a la seccion Apariencia en la barra lateral de WordPress y seleccionamos el item "Info. contacto y ubicación". Allí podremos ver una lista en donde podremos cargar las redes sociales con un icono, nombre de la red y su url. Ademas hay espacios para colocar telefonos de contacto, correos y números de WhatsApp. Tambien hay campos para alojar la información como direccion fisica, mapa de Google Maps (o cualquier código HTML para insertar un mapa).

### Opciones
Además de guardar esta información, el plugin admite algunas opciones de configuración, como por ejemplo el estilo en que se mostrará las redes sociales, ya sea solo con sus iconos o iconos y además el nombre de la red. Por defecto se mostrará solo el icono siendo esta la opción mas frecuente. Próximamente se admitirá que además de imagenes para las redes sociales, se pueda hacer mediante el uso de fuentes (como Fontello).

## Como mostrar la información?
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

Para el caso de las redes sociales, admite un parametro adicional que es *layout*, este parametro permite sobre escribir la configuración guardada y definir de manera explicita cual es el layout para mostrar las redes sociales, siendo *layout-1* solo iconos, y *layout-2* iconos y además su nombre.

## Estilos
Este plugin cuenta con estilos simples pensados para que sea sencillo adaptarlo a las necesidades de cada sitio, todos los shortcodes son definidos como listas y cada lista tiene una clase especifica, además de esa clase en la lista, se agrega un contenedor con la clase "msi-container" la cual no tiene ningun estilo definido, por lo que en caso de necesitar sobreescribir un estilo, se puede ocupar esa clase para que tenga una mayor prioridad en los estilos.