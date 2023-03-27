//main-body app sidebar-mini ltr
//ltr error-page1 main-body bg-light text-dark error-3 login-img

export const cargarClasesLoginLayout = () => {
    const partbody = document.body
    if(partbody)
    {
        partbody.classList.remove('nav-fixed')
        partbody.classList.add('bg-primary')
    }
}

export const cargarClasesDefaultLayout = () => {
    const partbody = document.body
    if(partbody)
    {
        partbody.classList.remove('bg-primary')
        partbody.classList.add('nav-fixed')
    }
}
