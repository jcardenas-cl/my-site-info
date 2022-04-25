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
    current_ic.setAttribute( 'name', 'current-icon[]' )
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

const msi_check_and_format = () => {
    // realizar validacion de campos

    return true
}

/**
 * Elimina la fila seleccionada, disparada desde un evento clic sobre el botón cerrar.
 * 
 * @param {object} element Elemento desde que se dispara el evento
 */
const close_row = event => {
    var element = (event.target || event.srcElement)
    element.closest('li').remove()
}

/**
 * Agrega un evento clic a todos los botones cerrar, para asignar la funcion a las filas agregadas dinamicamente.
 */
const close_row_buttons = document.querySelectorAll('.close-btn')
close_row_buttons.forEach( btn_close => {
    btn_close.addEventListener('click', function( evt ) {
         close_row( evt )
    });
})

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