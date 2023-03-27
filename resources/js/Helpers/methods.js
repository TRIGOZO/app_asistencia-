// import jwt_decode from 'jwt-decode';

// export const dataParamsPagination = ( data) => {
//     return "?page=" + data.page + "&paginacion="+ data.paginacion + "&buscar=" +data.buscar;
// }
// export const getConfigHeader = () => {

//     if(localStorage.getItem('token-api'))
//     {
//          let token = jwt_decode(localStorage.getItem('token-api')).token

//         return {
//             headers:{
//                 'Authorization': 'Bearer ' + token
//             }
//         }
//     }
// }

// export const getConfigHeaderUpload = () => {

//     if(localStorage.getItem('token-api'))
//     {
//          let token = jwt_decode(localStorage.getItem('token-api')).token

//         return {
//             headers:{
//                 'Authorization': 'Bearer ' + token,
//                 'Content-Type': 'multipart/form-data'
//             }
//         }
//     }
// }
