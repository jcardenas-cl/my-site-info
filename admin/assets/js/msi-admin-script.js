const { __, _x, _n, sprintf } = wp.i18n;
/**
 * Funcion encargada de agregar una nueva fila con todos sus elementos al listado de redes sociales.
 * 
 * @since 1.0.0
 */
const  add_new_item_rrss = () => {
    const rrss_list = document.getElementById('rrss-list')

    const new_li    = document.createElement('li')
    const move_cnt  = document.createElement('div')
    
    const font_cnt  = document.createElement('div')
    const font_input= document.createElement('input')
    const icon_cnt  = document.createElement('div')
    const icon_lbl  = document.createElement('label')
    const icon_file = document.createElement('input')
    const current_ic= document.createElement('input')
    const icon      = document.createElement('img')
    const url_cnt   = document.createElement('div')
    const txt_url   = document.createElement('input')
    const name_cnt  = document.createElement('div')
    const txt_name  = document.createElement('input')
    const close_cnt = document.createElement('div')
    const close     = document.createTextNode('X')

    new_li.setAttribute( 'class', 'rrss-row' )

    move_cnt.setAttribute( 'class', 'handler-cnt' )
    move_cnt.innerHTML = rrss_list.getElementsByTagName('li').length + 1

    icon_cnt.setAttribute( 'class', 'rrss-icon-cnt' )
    icon.setAttribute( 'src', msi_data.plugins_url + '/my-site-info/admin/assets/img/image-icon.svg')
    icon_file.setAttribute( 'type', 'file' )
    icon_file.setAttribute( 'name', 'rrss_icon[]' )
    icon_file.setAttribute( 'class', 'input-file' )
    icon_file.onchange = evt => { change_icon_preview( evt ) }
    current_ic.setAttribute( 'type', 'hidden' )
    current_ic.setAttribute( 'name', 'current_icon[]' )
    current_ic.setAttribute( 'value',  msi_data.plugins_url + '/my-site-info/admin/assets/img/image-icon.svg')
    icon_lbl.append(icon_file)
    icon_lbl.append(icon)
    icon_cnt.append(icon_lbl)
    icon_cnt.append(current_ic)

    url_cnt.setAttribute( 'class', 'url-cnt' )
    txt_url.setAttribute( 'type', 'url' )
    txt_url.setAttribute( 'placeholder', 'Url' )
    txt_url.setAttribute( 'name', 'rrss_url[]' )
    url_cnt.append(txt_url)

    font_cnt.setAttribute( 'class', 'rrss-font-cnt' )
    font_input.setAttribute( 'name', 'rrss_font[]' )
    font_input.setAttribute( 'type', 'text' )
    font_input.setAttribute( 'class', 'input-font' )
    font_input.setAttribute( 'placeholder', '<i class="icon-rrss"></i>' )
    font_cnt.append(font_input)

    name_cnt.setAttribute( 'class', 'name-cnt' )
    txt_name.setAttribute( 'type', 'text' )
    txt_name.setAttribute( 'placeholder', 'Nombre' )
    txt_name.setAttribute( 'name', 'rrss_name[]' )
    name_cnt.append(txt_name)

    close_cnt.setAttribute( 'class', 'close-btn' )
    close_cnt.onclick = evt => { close_row(evt) }
    close_cnt.append(close)

    new_li.append(move_cnt)
    new_li.append(icon_cnt)
    new_li.append(font_cnt)
    new_li.append(name_cnt)
    new_li.append(url_cnt)
    new_li.append(close_cnt)
    rrss_list.append(new_li)
}

/**
 * Oculta la fila con el placeholder en el listado de redes sociales
 * 
 * @since 1.0.0
 */
const hide_rrss_row_placeholder = () => {
    document.getElementById('empty-rrss-row').classList.add('no-display')
}

/**
 * Muestra la fila con el placeholder en el listado de redes sociales
 * 
 * @since 1.0.0
 */
const show_rrss_row_placeholder = () => {
    document.getElementById('empty-rrss-row').classList.remove('no-display')
}

/**
 * Valida que un string contenga uno o mas correos separados por comas tengan un formato de correo electronico.
 * 
 * @since 1.0.0
 * 
 * @param {string} str_emails Cadena con una lista de correos, esta puede estar separada por comas.
 * @return {bool} True de ser valido, false en caso contrario
 */
const msi_is_valid_email_list = str_emails => {
    const valid_regex_format    = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    const email_list            = str_emails.split(',')
    for ( email in email_list ) {
        if ( !email_list[email].trim().match(valid_regex_format) )  {
            return false
        }
    }

    return true
}

/**
 * Valida si uno o mas telefonos, separados por coma, tienen el formato valido de número telefonico.
 * Solo se admite el simbolo "+" y números.
 * 
 * @since 1.0.0
 * 
 * @param {string} str_phones Cadena con uno o mas teléfonos a validar
 * @returns {bool} True en caso de ser valido, false en caso contrario
 */
const msi_is_valid_phone_list = str_phones => {
    const phone_list = str_phones.split(',')
    for ( phone in phone_list ) {
        var phone_item = phone_list[phone]
        phone_item = phone_item.trim()
        if ( !(/^\d+$/.test(phone_item.substring(1))) || ( !(/^\d+$/.test(phone_item.charAt(0))) && phone_item.charAt(0) != '+' ) ) {
            return false
        }
    }

    return true
}

/**
 * Funcion ejecutada al realizar el submit del formulario.
 * 
 * @since 1.0.0
 */
const msi_check_and_format = () => {
    const cellphone_values  = document.getElementById('txt-mobile-phone').value
    const email_values      = document.getElementById('txt-email').value
    const phone_values      = document.getElementById('txt-phone').value
    const whatsapp_phones   = document.getElementById('txt-whatsapp').value

    var valid_cellphones    = true
    var valid_emails        = true
    var valid_phones        = true
    var valid_wsp_phones    = true

    // Reiniciar errores marcados
    document.getElementById('txt-mobile-phone').classList.remove('error')
    document.getElementById('txt-email').classList.remove('error')
    document.getElementById('txt-phone').classList.remove('error')
    document.getElementById('txt-whatsapp').classList.remove('error')

    if ( '' != cellphone_values.trim() && !msi_is_valid_phone_list( cellphone_values ) ) {
        valid_cellphones = false
        document.getElementById('txt-mobile-phone').classList.add('error')
    }

    if ( '' != email_values.trim() && !msi_is_valid_email_list( email_values ) ) {
        valid_emails = false
        document.getElementById('txt-email').classList.add('error')
    }

    if ( '' != phone_values.trim() && !msi_is_valid_phone_list( phone_values ) ) {
        valid_phones = false
        document.getElementById('txt-phone').classList.add('error')
    }

    if ( '' != whatsapp_phones && !msi_is_valid_phone_list( whatsapp_phones ) ) {
        valid_wsp_phones = false
        document.getElementById('txt-whatsapp').classList.add('error')
    }

    if ( valid_cellphones && valid_emails && valid_phones && valid_wsp_phones ) {
        return true
    }

    alert(__("Favor, revise los campos marcados", "my_site_info"))
    document.body.scrollTop             = 0;
    document.documentElement.scrollTop  = 0;
    return false
}

/**
 * Elimina la fila seleccionada en lista de redes sociales, disparada desde un evento clic sobre el botón cerrar.
 * 
 * @since 1.0.0
 * 
 * @param {object} element Elemento desde que se dispara el evento
 */
const close_row = event => {
    var element = (event.target || event.srcElement)
    element.closest('li').remove()
    reindex_rrss_list()
}

/**
 * Elimina la fila seleccionada de la lista de fuentes a cargar en el sitio.
 * 
 * @since 1.0.0
 * 
 * @param {object} event Elemento desde el que se dispara el evento
 */
const close_fonts_row = event => {
    var element = (event.target || event.srcElement)
    element.closest('li').remove()
}

/**
 * Cambia la previsualizacion del icono al ser seleccionado para subir, para filas que ya hayan sido registradas previamente y creadas de manera dinamica.
 * 
 * @since 1.1.0
 * @param {event} event Evento onchange
 */
const change_icon_preview = event => {
    var element = (event.target || event.srcElement)
    var icon    = element.parentNode.querySelector('img')
    
    const [file] = element.files
    if (file) {
        icon.src = URL.createObjectURL(file)
    }
    
}

/**
 * Vuelve a asignar el número de red social cuando se reordena por interacción del usuario
 * 
 * @since 1.2.0
 */
const reindex_rrss_list = () => {
    let i = 1
    const rrss_list_li = document.getElementById('rrss-list').querySelectorAll('li')
    rrss_list_li.forEach( element => {
        element.querySelector('.handler-cnt').innerHTML = i
        i++
    });
}

/**
 * Agrega un evento clic a todos los botones cerrar, para asignar la funcion a las filas agregadas dinamicamente.
 * Este código solo funcionara sobre elementos que ya esten creados al momento de cargar la pagina y no sobre los creados de manera dinamica.
 * 
 * @since 1.0.0
 */
const close_row_buttons = document.querySelectorAll('.close-btn')
close_row_buttons.forEach( btn_close => {
    btn_close.addEventListener('click', function( evt ) {
        close_row( evt )
    });
})

/**
 * Agrega un evento clic a todos los botones cerrar, para asignar la funcion a las filas agregadas dinamicamente.
 * Este código solo funcionara sobre elementos que ya esten creados al momento de cargar la pagina y no sobre los creados de manera dinamica.
 * 
 * @since 1.0.0
 */
 const close_font_row_buttons = document.querySelectorAll('.close-font-btn')
 close_font_row_buttons.forEach( btn_close => {
     btn_close.addEventListener('click', function( evt ) {
         close_fonts_row( evt )
     });
 })

/**
 * Agrega un evento onchange a los elementos del tipo input file que ya fueron creados anteriormente.
 * Permite cambiar la previsualización del icono al seleccionarlo para ser subido
 * 
 * @since 1.0.0
 */
const rrss_icon_files = document.querySelectorAll('.input-file')
rrss_icon_files.forEach( icon_file => {
    icon_file.addEventListener( 'change', function ( evt ) {
        change_icon_preview( evt )
    })
})

/**
 * Controlador para agregar un row a la lista de redes sociales, además controla que se muestre u oculte el placeholder mientras la lista esta vacia.
 * 
 * @since 1.0.0
 * @update Desde la version 1.2.0 solo se encarga de agregar una nueva fila e reiniciar slist, ya no se oculta el placeholder para agregar una nueva fila por cambios de diseño.
 */
const add_rrss_button = document.getElementById('btn-add-social-network')
add_rrss_button.addEventListener( 'click', function( evt ) {
    add_new_item_rrss()
    slist(document.getElementById("rrss-list"))
});

window.addEventListener("DOMContentLoaded", () => {
    slist(document.getElementById("rrss-list"));
});

const slist = target => {
    target.classList.add("slist");
    let items = target.getElementsByTagName("li"), current = null;

    for (let i of items) {
        // Mod para que ciertos elementos no sean arrastrables
        if ( 'false' != i.getAttribute('draggable') ) {
            i.draggable = true;
        }

        i.ondragstart = (ev) => {
            current = i;
            for (let it of items) {
                if (it != current) {
                    it.classList.add("hint");
                }
            }
        };

        i.ondragenter = (ev) => {
            if (i != current) {
                i.classList.add("active");
            }
        };

        i.ondragleave = evt => {
            if ( !i.contains(evt.fromElement) ) {
                i.classList.remove("active");
            }
        };

        i.ondragend = () => {
            for (let it of items) {
                it.classList.remove("hint");
                it.classList.remove("active");
            }
        };

        i.ondragover = (evt) => {
            evt.preventDefault();
        };

        i.ondrop = (evt) => {
            evt.preventDefault();
            // Mod para que se pueda soltar solo en elementos que también sean arrastrables
            if ( i != current && i.getAttribute('draggable') == 'true' ) {
                let currentpos = 0, droppedpos = 0;
                for (let it = 0; it < items.length; it++) {
                    if (current == items[it]) {
                        currentpos = it;
                    }
                    if (i == items[it]) {
                        droppedpos = it;
                    }
                }
                if (currentpos < droppedpos) {
                    i.parentNode.insertBefore(current, i.nextSibling);
                } else {
                    i.parentNode.insertBefore(current, i);
                }
            }

            reindex_rrss_list()
        };
    }
}

/**
 * Según el modo elegido, se cambiarán los campos del formulario para admitir imagenes o colocar la etiqueta del icono para cada red social.
 * 
 * @since 1.1.0
 */
const rrss_mode_selection = document.querySelector('.rrss-mode-selection')
rrss_mode_selection.addEventListener( "change", function( evt ) {
    const mode = evt.target.value
    if ( 'rrss-mode-fonts' == mode ) {
        document.getElementById('fonts-urls-section').classList.remove('no-display');
        document.getElementById('rrss-list').classList.replace('mode-images', 'mode-fonts')
    } else {
        document.getElementById('fonts-urls-section').classList.add('no-display');
        document.getElementById('rrss-list').classList.replace('mode-fonts', 'mode-images')
    }
})

/**
 * Crea un nodo li con los elementos necesarios para cargar un archivo de fuente.
 * 
 * @since 1.1.0
 * @deprecated Desde la version 1.2.0 se usa la mecanica de arrastre
 */
/*
const add_font = document.getElementById('add-font-button')
add_font.addEventListener( 'click', function( evt ) {
    const new_li    = document.createElement('li')
    const file_cnt  = document.createElement('div')
    const icon_file = document.createElement('input')
    const close_cnt = document.createElement('div')
    const close     = document.createTextNode('X')
    const url_cnt   = document.createElement('div')
    const url_text  = document.createTextNode(__('Aquí se mostrará la url de la fuente una vez cargada', 'my_site_info'))
    const url_hidden= document.createElement('input')

    new_li.classList.add('font-row')
    file_cnt.classList.add('file')
    icon_file.setAttribute('type', 'file')
    icon_file.setAttribute('name', 'font_file[]')
    close_cnt.classList.add('close-font-btn')
    close_cnt.onclick = evt => { close_fonts_row( evt ) }
    url_hidden.setAttribute('type','hidden')
    url_hidden.setAttribute('name', 'current_font_url[]')

    file_cnt.append(icon_file)
    close_cnt.append(close)
    url_cnt.append(url_text)
    url_cnt.append(url_hidden)
    new_li.append(file_cnt)
    new_li.append(close_cnt)
    new_li.append(url_cnt)
    document.getElementById('fonts-list').append(new_li)
})
*/
/**
 * Controlador para ocultar o mostrar informacion en bloques tipo acordión
 * 
 * @since 1.2.0
 */
const show_toggle_triggers = document.querySelectorAll('.show-toggle')
show_toggle_triggers.forEach( btn_trigger => {
    btn_trigger.addEventListener('click', function() {
        const root = btn_trigger.parentNode
        if ( root.classList.contains('msi-hidden') ) {
            root.classList.replace( 'msi-hidden', 'msi-display' )
        } else {
            root.classList.replace( 'msi-display', 'msi-hidden' )
        }
    });
})

/**
 * Evitar el comportamiento por defecto de todos los eventos
 * 
 * @since 1.2.0
 */
const drop_area_fonts = document.getElementById('upload-fonts-container')
;['dragenter', 'dragover', 'dragleave', 'drop'].forEach( event_name => {
    drop_area_fonts.addEventListener( event_name, function( e ) {
        e.preventDefault()
        e.stopPropagation()
    }, false)
})

/**
 * Agregar clase para resaltar acciones de drag n drop del usuario.
 * 
 * @since 1.2.0
 */
;['dragenter', 'dragover'].forEach( event_name => {
    drop_area_fonts.addEventListener( event_name, function() {
        drop_area_fonts.classList.add('highlight')
    }, false)
})


/**
 * Quita la clase de resaltado por acciones de drag n drop del usuario.
 * 
 * @since 1.2.0
 */
;['dragleave', 'drop'].forEach( event_name => {
    drop_area_fonts.addEventListener( event_name, function() {
        drop_area_fonts.classList.remove('highlight')
    }, false)
})

/**
 * Función usada para agregar los archivos subidos mediante drag n' drop al input file del formulario.
 * 
 * @since 1.2.0
 * 
 * @param {event} evt Evento disparado al subir archivos
 */
const handle_drop_fonts = async (evt) => {
    const input_file    = document.querySelector('#font_file')
    input_file.files    = evt.dataTransfer.files
    const response      = await msi_process_upload_queue( evt.dataTransfer.files )
    
    setTimeout( () => {
        msi_progress_bar(0)
    }, 1000)

    input_file.files    = null
    msi_set_uploaded_fonts( response )
    
}
drop_area_fonts.addEventListener( 'drop', handle_drop_fonts, false)

/**
 * 
 * @param {json} fonts_urls Objeto JSON con las url de las fuentes subidas
 */
const msi_set_uploaded_fonts = fonts_urls => {
    const urls_container    = document.getElementsByClassName('fonts-urls')[0]
    
    urls_container.innerHTML    = ''
    fonts_urls.forEach(font_url => {
        const font_row          = document.createElement('div')
        const img_copy          = document.createElement('img')
        const url_input         = document.createElement('input')

        font_row.classList.add('font-row')
        img_copy.setAttribute('src', `${msi_data.plugins_url}/my-site-info/admin/assets/img/copy-icon.svg`)
        url_input.setAttribute('type','url')
        url_input.setAttribute('value', font_url)

        font_row.appendChild(img_copy)
        font_row.appendChild(url_input)

        urls_container.insertAdjacentElement('beforeend', font_row)
    });
}

/**
 * Función encargada de procesar la cola con las subidas pendientes de fuentes. Además llama a la función encargada de mostrar la barra de progreso.
 */
const msi_process_upload_queue = async (queued_files) => {
    let list            = []
    const queue_length  = queued_files.length
    let queue_index     = 0
    for ( const queued_file of queued_files) {
        const result = await msi_upload_font( queued_file )
        if ( result.status == 'ok' ) {
            list = result.list
            queue_index++
            msi_progress_bar( queue_index * 100 / queue_length )
        }
    }

    return JSON.parse(list)
}

/**
 * Función encargada de subir la fuente al servidor, es llamada por cada archivo seleccionado.
 * @since 1.2.0
 * 
 * @param {file} file Archivo a ser cargado al servidor
 * @return {json} Objeto JSON con los datos de la subida
 */
const msi_upload_font = async (file) => {
    let form_data = new FormData()
    form_data.append( 'file', file )
    form_data.append( 'action', 'upload_font' )
    const promise = await fetch( msi_data.ajax_url, {
        'method': 'post',
        'body': form_data
    })
    return await promise.json()
}

/**
 * Pequeña función encargada de pintar la barra de progreso a medida que se suben las fuentes
 * @param {float} percentage 
 */
const msi_progress_bar = percentage => {
    const adjusted_percent  = Math.floor(percentage)
    document.getElementById('fonts-progress-bar').style.width = adjusted_percent + '%'
    
}

/**
 * Mostrar el listado de archivos seleccionados en pantalla.
 * 
 * @since 1.2.0
 */
 const list_selected_fonts = () => {
    const font_files    = document.querySelector('#font_file').files
    const fonts_array   = Array.from(font_files)
    let fonts_selected  = '';
    fonts_array.forEach( font => {
        fonts_selected += `<div>${font.name}</div>`
    })
    document.querySelector('.upload-data').innerHTML = fonts_selected
}