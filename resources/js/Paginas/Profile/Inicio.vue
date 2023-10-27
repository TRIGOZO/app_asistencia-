<script setup>
  import jwt_decode from 'jwt-decode'
  import { ref, onMounted } from 'vue';
  import { defineTitle } from '@/Helpers';
  import useHelper from '@/Helpers';  
  import ContentHeader from '@/Componentes/ContentHeader.vue';
  import useDatosSession from '@/Composables/session';
  import usePersonal from '@/Composables/personal'
  import FormPassword from './formpassword.vue'
  import PerfilForm from './Edit.vue'
  import useUsuario from '@/Composables/usuario.js'
  import imgAvatar from '../../../../public/img/avatar.png';
  const { usuario, role } = useDatosSession();
  const { errors, personal, obtenerPersonaldetalle } = usePersonal();
  const { obtenerUsuario2, usuario2 } = useUsuario();
  const { openModal } = useHelper();
  const titleHeader = ref({
      titulo: "Perfil",
      subTitulo: "",
      icon: "",
      vista: ""
  });
  const form = ref({
      id : '',
      user_id : '',
      username:'',
      nombres:'',
      apellido_paterno:'',
      apellido_materno:'',
      sexo:'',
      fecha_nacimiento:'',
      estado_civil_id:'',
      direccion:'',
      telefono:'',
      celular:'',
      email:'',
      tienehijos:'',      
      profesion_id:'',   
      cargo_id:'',        
      errors:[]
  });
  const formpassword = ref({
    current_password : '',
    password : '',
    password_confirmation : '',
    errors:[]
  });
  onMounted(() => {
      defineTitle(titleHeader.value.titulo)
      obtenerdatospersonal()
  })
  const obtenerdatospersonal = async() =>{
    const user_id = localStorage.getItem('userSession') ? JSON.parse( JSON.stringify(jwt_decode(localStorage.getItem('userSession')).user)) : null;
    await obtenerUsuario2(user_id)
    if(user_id != null) await obtenerPersonaldetalle(usuario2.value.personal_id);
  }

  const EditarPerfil = () => {
    obtenerdatospersonal()
    openModal('#modalusuario')
    var titulo = document.getElementById("modalusuarioLabel");
    titulo.textContent = 'Editar Datos Personales';
    form.value.id=personal.value.id,
    form.value.username = usuario.value.username,
    form.value.user_id = usuario.value.id,
    form.value.nombres = personal.value.nombres,
    form.value.apellido_paterno = personal.value.apellido_paterno,
    form.value.apellido_materno = personal.value.apellido_materno,
    form.value.sexo = personal.value.sexo,
    form.value.fecha_nacimiento = personal.value.fecha_nacimiento,
    form.value.estado_civil_id = personal.value.estado_civil_id,
    form.value.direccion = personal.value.direccion,
    form.value.telefono = personal.value.telefono,
    form.value.celular = personal.value.celular,
    form.value.email = personal.value.email,
    form.value.tienehijos = personal.value.tienehijos,      
    form.value.profesion_id = personal.value.profesion_id,   
    form.value.cargo_id = personal.value.cargo_id  
  }
const formcambiarclave = () => {
  openModal('#modalupdatepassword')
  var titulo = document.getElementById("modalupdatepasswordLabel");
  titulo.textContent = 'Cambiar Password';     
}
</script>
<template>
    <ContentHeader :title-header="titleHeader"></ContentHeader>
    <div class="app-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle" :src="imgAvatar" alt="User profile">
                </div>
                <h3 class="profile-username text-center">{{ usuario.username }}</h3>
                <p class="text-muted text-center">{{ role.nombre }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Cargo : </b> <a class="float-right">{{ personal.cargo_nombre }}</a>
                  </li>
                  <li class="list-group-item">
                    <b>Rol</b> <a class="float-right">{{role.nombre}}</a>
                  </li>
                  <li class="list-group-item d-flex justify-content-center">
                    <button type="button" class="btn btn-info" title="Cambiar contraseña" @click="formcambiarclave()">
                      <i class="fas fa-lock"></i>CAMBIAR CONTRASEÑA 
                    </button>&nbsp;&nbsp;&nbsp;&nbsp;
                    <!-- <button type="button" class="btn btn-info" title="Cambiar Pin">
                      <i class="fa-solid fa-hashtag"></i>
                    </button> -->
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <li class="nav-item"><a class="nav-link active" href="#datospersonales" data-toggle="tab">Datos Personales</a></li>
                  <li class="nav-item"><a class="nav-link btn btn-warning" href="#" @click.prevent="EditarPerfil()">Editar <i class="fa fa-pen"></i></a></li>
                </ul>
              </div>
              <div class="card-body">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>DNI: </strong>{{ personal.numero_dni }}</li>
                    <li class="list-group-item"><strong>Nombres: </strong>{{ personal.nombres }}</li>
                    <li class="list-group-item"><strong>Apellido Paterno: </strong>{{ personal.apellido_paterno }}</li>
                    <li class="list-group-item"><strong>Apellido Materno: </strong>{{ personal.apellido_materno }}</li>
                    <li class="list-group-item"><strong>Sexo: </strong>{{ personal.sexo }}</li>
                    <li class="list-group-item"><strong>Fecha de Nacimiento: </strong>{{ personal.fecha_nacimiento }}</li>
                    <li class="list-group-item"><strong>Estado Civil: </strong>{{ personal.estado_civil_nombre }}</li>
                    <li class="list-group-item"><strong>Dirección: </strong>{{ personal.direccion }}</li>
                    <li class="list-group-item"><strong>Teléfono: </strong>{{ personal.telefono }}</li>
                    <li class="list-group-item"><strong>Celular: </strong>{{ personal.celular }}</li>
                    <li class="list-group-item"><strong>Email: </strong>{{ personal.email }}</li>
                    <li class="list-group-item"><strong>Tiene Hijos: </strong>{{ personal.tienehijos }}</li>
                    <li class="list-group-item"><strong>Profesión: </strong>{{ personal.profesiones_nombre }}</li>
                    <li class="list-group-item"><strong>Cargo: </strong>{{ personal.cargo_nombre }}</li>
                    <li class="list-group-item"><strong>Establecimiento: </strong>{{ personal.establecimiento }}</li>
                  </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <perfil-form :form="form" @cargardatos="obtenerdatospersonal"></perfil-form>
      <form-password :form="formpassword"></form-password>
    </div>
</template>

