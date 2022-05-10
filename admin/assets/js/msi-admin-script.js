const { __, _x, _n, sprintf } = wp.i18n;
/**
 * Funcion encargada de agregar una nueva fila con todos sus elementos al listado de redes sociales.
 */
const  add_new_item_rrss = () => {
    const rrss_list = document.getElementById('rrss-list')

    const new_li    = document.createElement('li')
    const move_cnt  = document.createElement('div')
    const move_img  = document.createElement('img')
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
    move_img.setAttribute( 'src', msi_data.plugins_url + '/my-site-info/admin/assets/img/move-icon.svg')
    move_cnt.append(move_img)

    icon_cnt.setAttribute( 'class', 'rrss-icon-cnt' )
    icon.setAttribute( 'src', msi_data.plugins_url + '/my-site-info/admin/assets/img/image-icon.svg')
    icon_file.setAttribute( 'type', 'file' )
    icon_file.setAttribute( 'name', 'rrss_icon[]' )
    icon_file.setAttribute( 'class', 'input-file' )
    icon_file.onchange = evt => {
        const [file] = icon_file.files
        if (file) {
          icon.src = URL.createObjectURL(file)
        }
    }
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
    new_li.append(name_cnt)
    new_li.append(url_cnt)
    new_li.append(close_cnt)
    rrss_list.append(new_li)
}

/**
 * Oculta la fila con el placeholder en el listado de redes sociales
 */
const hide_rrss_row_placeholder = () => {
    document.getElementById('empty-rrss-row').classList.add('no-display')
}

/**
 * Muestra la fila con el placeholder en el listado de redes sociales
 */
const show_rrss_row_placeholder = () => {
    document.getElementById('empty-rrss-row').classList.remove('no-display')
}

/**
 * Valida que un string contenga uno o mas correos separados por comas tengan un formato de correo electronico.
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
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    return false
}

/**
 * Elimina la fila seleccionada, disparada desde un evento clic sobre el botón cerrar.
 * 
 * @param {object} element Elemento desde que se dispara el evento
 */
const close_row = event => {
    var element = (event.target || event.srcElement)
    element.closest('li').remove()
    const rrss_rows = document.querySelectorAll('.rrss-row').length
    if ( rrss_rows == 0 ) {
        show_rrss_row_placeholder()
    }
}

/**
 * Elimina la fila seleccionada de la lista de fuentes a cargar en el sitio.
 * 
 * @param {object} event Elemento desde el que se dispara el evento
 */
const close_fonts_row = event => {
    var element = (event.target || event.srcElement)
    element.closest('li').remove()
    const rrss_rows = document.querySelectorAll('.font-row').length
}

/**
 * Agrega un evento clic a todos los botones cerrar, para asignar la funcion a las filas agregadas dinamicamente.
 * Este código solo funcionara sobre elementos que ya esten creados al momento de cargar la pagina y no sobre los creados de manera dinamica.
 */
const close_row_buttons = document.querySelectorAll('.close-btn')
close_row_buttons.forEach( btn_close => {
    btn_close.addEventListener('click', function( evt ) {
        close_row( evt )
    });
})

/**
 * Controlador para agregar un row a la lista de redes sociales, además controla que se muestre u oculte el placeholder mientras la lista esta vacia.
 */
const add_rrss_button = document.getElementById('btn-add-social-network')
add_rrss_button.addEventListener( 'click', function( evt ) {
    add_new_item_rrss()
    const rrss_rows = document.querySelectorAll('.rrss-row').length
    if ( rrss_rows > 0 ) {
        hide_rrss_row_placeholder()
    }
    slist(document.getElementById("rrss-list"))
});

window.addEventListener("DOMContentLoaded", () => {
    slist(document.getElementById("rrss-list"));
});

const slist = target => {
    target.classList.add("slist");
    let items = target.getElementsByTagName("li"), current = null;

    for (let i of items) {
        i.draggable = true;

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
            if (i != current) {
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
        };
    }
}

/**
 * Según el modo elegido, se cambiarán los campos del formulario para admitir imagenes o colocar la etiqueta del icono para cada red social.
 * @since 1.1.0
 */
const rrss_mode_selection = document.querySelector('.rrss-mode-selection')
rrss_mode_selection.addEventListener( "change", function( evt ) {
    const mode = evt.target.value
    if ( 'rrss-mode-fonts' == mode ) {
        document.getElementById('fonts-urls').classList.remove('no-display');
        // TODO
        // Presentar nuevo campo para url con las fuentes
        // Cambiar formato de lista con campos
        // Guardar los datos en una nueva lista o modificar la existente
    } else {
        // TODO
        // Reestablecer funcionamiento a modo de v1.0.0
        document.getElementById('fonts-urls').classList.add('no-display');
    }
})

/**
 * Crea un nodo li con los elementos necesarios para cargar un archivo de fuente.
 * @since 1.1.0
 */
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
    icon_file.setAttribute('name', 'font-file')
    close_cnt.classList.add('close-cnt')
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
