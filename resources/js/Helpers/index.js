import { ref, inject } from 'vue';

export * from './body'

export * from './methods'

export default function useHelper() {

    const Swal = inject('Swal');

    const defineTitle = (title) => {
        let sistema = "Api-Sistema";
        document.title = title +" | "+sistema
    }
    const mostrarresultadoalert = (mytitle) => {
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: mytitle,
            showConfirmButton: false,
            timer: 1500
        })
    }
    const soloNumeros = (evt) => {
        evt = (evt) ? evt : window.event
        var charCode = (evt.which) ? evt.which : evt.keyCode

        if((charCode > 31 && (charCode< 48 || charCode > 57)) && charCode !=48 )
        {
            evt.preventDefault()
        } else {
            return true
        }
    }
    const slugify = (text) => {
        return text
        .toString()
        .normalize()
        .toLowerCase()
        .trim()
        .replace(/\s+/g,'-')
        .replace(/[^\w\-]+/g,'')
        .replace(/\-\-+/g, '-')
    }

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    const carpetaFotoUsuarios =  'storage/usuarios/';

    return {
        Swal, Toast,carpetaFotoUsuarios,
        soloNumeros, defineTitle, slugify, mostrarresultadoalert,
    }
}
