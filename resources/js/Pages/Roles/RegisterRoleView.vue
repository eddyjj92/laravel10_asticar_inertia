<script setup>
import {computed, onMounted, ref} from 'vue';
import Swal from 'sweetalert2';
import DashboardLayout from "../../Layouts/DashboardLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user)

defineProps({
    permisos: Object,
});

const form = useForm({
  nombre: null,
  permisos: [],
})

let permConfig = ref([]);
let permRoles = ref([]);
let permUsers = ref([]);
let permServicios = ref([]);
let permSolicitudes = ref([]);
let permNoticias = ref([]);
let permImages = ref([]);
let permMensajes = ref([]);

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1200,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

onMounted(()=>{
   page.props.permisos.forEach(permiso =>{
     if(permiso.name.includes('config')){
       permConfig.value.push(permiso);
     }
     if(permiso.name.includes('rol')){
       permRoles.value.push(permiso);
     }
     if(permiso.name.includes('usuario') && !permiso.name.includes('ver-solicitud')){
       permUsers.value.push(permiso);
     }
     if(permiso.name.includes('servicio')){
       permServicios.value.push(permiso);
     }
     if(permiso.name.includes('solicitud')){
       permSolicitudes.value.push(permiso);
     }
     if(permiso.name.includes('noticia')){
       permNoticias.value.push(permiso);
     }
     if(permiso.name.includes('imagen')){
       permImages.value.push(permiso);
     }
     if(permiso.name.includes('mensaje')){
       permMensajes.value.push(permiso);
     }
   })

})

const addPerm = (id) => {
  if(form.permisos.indexOf(id) !== -1){
    form.permisos = form.permisos.filter(animal => animal !== id);
  }else{
    form.permisos.push(id);
  }
}

const options = {
  preserveScroll: true,
  onError: errors => {
    Swal.fire({
      icon: 'error',
      title: 'Validación',
      text: errors.validacion
    })
    const audio = new Audio("/audio/click-error.wav");
    audio.play();
    spinner.value = 'visually-hidden';
    span.value = '';
  },
}

let spinner = ref('visually-hidden');
let span = ref('');
const loader = () => {
  spinner.value = '';
  span.value = 'visually-hidden';
}

function submit() {
  loader();
  form.post('/roles/registrar', options)
}

</script>

<template>
  <DashboardLayout :user="user"/>
  <main id="main" class="main">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><Link href="/roles"><i class="bi bi-person"></i> Roles</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person-rolodex"></i> Registrar Rol de Usuario</li>
      </ol>
    </nav>
    <div class="container">
      <div class="container">
        <div class="row align-items-center justify-content-center g-5">
          <div class="col-lg-12 wow fadeInUp border border-4 rounded rounded-4 bg-white " data-wow-delay="0.5s">
            <form @submit.prevent="submit" class="p-2">
              <div class="row align-items-center justify-content-center g-3">
                <h2 class="text-center mb-1" style="color: black"><i class="bi bi-person-rolodex"></i> Registrar Rol de Usuario</h2>
                <div class="col-lg-12">
                  <div class="form-floating">
                    <input v-model="form.nombre" type="text" class="form-control" id="role" placeholder="Nombre Rol de Usuario">
                    <label for="role"><i class="bi bi-person-rolodex"></i> Nombre Rol de Usuario</label>
                  </div>
                </div>
                <div class="col-lg-12">
                  <table class="table">
                    <tbody>
                    <tr>
                      <th colspan="2"><h5 class="text-center fw-bold"><i class="bi bi-check-circle-fill"></i> Otorgar Permisos</h5></th>
                    </tr>
                    <tr>
                      <th>Configuración</th>
                      <td style="width: 90%">
                        <div class="row w-100">
                          <div class="col-lg-4" v-for="(permiso,index) in permConfig" :key="index">
                            <label :for="`checkconfig${index}`"><input :id="`checkconfig${index}`" type="checkbox" @click="addPerm(permiso.id, )"> {{permiso.name}}</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>Roles de Usuario</th>
                      <td style="width: 90%">
                        <div class="row w-100 align-content-around">
                          <div class="col-lg-4" v-for="(permiso,index) in permRoles" :key="index">
                            <label :for="`checkroles${index}`"><input :id="`checkroles${index}`" type="checkbox" @click="addPerm(permiso.id)"> {{permiso.name}}</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>Usuarios</th>
                      <td style="width: 90%">
                        <div class="row w-100 align-content-around">
                          <div class="col-lg-4" v-for="(permiso,index) in permUsers" :key="index">
                            <label :for="`checkusuarios${index}`"><input :id="`checkusuarios${index}`" type="checkbox" @click="addPerm(permiso.id)"> {{permiso.name}}</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>Servicios</th>
                      <td style="width: 90%">
                        <div class="row w-100 align-content-around">
                          <div class="col-lg-4" v-for="(permiso,index) in permServicios" :key="index">
                            <label :for="`checkservicios${index}`"><input :id="`checkservicios${index}`" type="checkbox" @click="addPerm(permiso.id)"> {{permiso.name}}</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>Solicitudes</th>
                      <td style="width: 90%">
                        <div class="row w-100 align-content-around">
                          <div class="col-lg-4" v-for="(permiso,index) in permSolicitudes" :key="index">
                            <label :for="`checksolicitudes${index}`"><input :id="`checksolicitudes${index}`" type="checkbox" @click="addPerm(permiso.id)"> {{permiso.name}}</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>Noticias</th>
                      <td style="width: 90%">
                        <div class="row w-100 align-content-around">
                          <div class="col-lg-4" v-for="(permiso,index) in permNoticias" :key="index">
                            <label :for="`checknoticias${index}`"><input :id="`checknoticias${index}`" type="checkbox" @click="addPerm(permiso.id)"> {{permiso.name}}</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>Galería de Imágenes</th>
                      <td style="width: 90%">
                        <div class="row w-100 align-content-around">
                          <div class="col-lg-4" v-for="(permiso,index) in permImages" :key="index">
                            <label :for="`checkimages${index}`"><input :id="`checkimages${index}`" type="checkbox" @click="addPerm(permiso.id, this.checked)"> {{permiso.name}}</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <th>Mensajes</th>
                      <td style="width: 90%">
                        <div class="row w-100 align-content-around">
                          <div class="col-lg-4" v-for="(permiso,index) in permMensajes" :key="index">
                            <label :for="`checkmenejes${index}`"><input :id="`checkmenejes${index}`" type="checkbox" @click="addPerm(permiso.id)"> {{permiso.name}}</label>
                          </div>
                        </div>
                      </td>
                    </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-12 mb-3">
                  <button :disabled="form.processing" class="btn btn-primary rounded-pill py-3 px-5 w-100" style="background: #0a53be" type="submit">
                    <div :class="spinner" class="d-flex justify-content-center">
                      <div  class="spinner-border" role="status">
                        <span class="sr-only">Loading...</span>
                      </div>
                    </div>
                    <span :class="span">
                      <i class="bi bi-person-rolodex"></i>
                      Registrar Rol de Usuario
                    </span>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<style scoped>
@import "/public/css/dashboard.css";
/*@import "/src/assets/vendor/mdb/css/mdb.min.css";*/
</style>
