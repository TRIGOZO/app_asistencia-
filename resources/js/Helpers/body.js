export const cargarClasesLoginLayout = () => {
    const partBody = document.body
    if(partBody)
    {
        partBody.classList.remove('layout-fixed');
        partBody.classList.remove('sidebar-expand-lg');
        partBody.classList.remove('sidebar-mini');        
        partBody.classList.add('login-page');
        partBody.classList.add('bg-body-secondary');
    }
}

export const cargarClasesPrincipalLayout = () => {
    const partBody = document.body
    if(partBody)
    {
        partBody.classList.remove('login-page');
        partBody.classList.add('layout-fixed');
        partBody.classList.add('sidebar-expand-lg');
        partBody.classList.add('sidebar-mini');
        partBody.classList.remove('bg-body-secondary');
        
    }
}
