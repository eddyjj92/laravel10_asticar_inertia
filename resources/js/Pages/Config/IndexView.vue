<script setup>
import {computed, onMounted, ref} from 'vue';
import Swal from 'sweetalert2';
import DashboardLayout from "../../Layouts/DashboardLayout.vue";
import {usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)


defineProps({
  configs: Object,
});

const configs = page.props.configs;

const form1 = useForm({
  id: 1,
  config: {
    nombre: configs[0].config.nombre,
    descripcion: configs[0].config.descripcion
  }
})

const form2 = useForm({
  id: 2,
  imagen: null,
  config: {
    titulo: configs[1].config.titulo,
    descripcion: configs[1].config.descripcion
  }
})

const form3 = useForm({
  id: 3,
  config: {
    telefonos: configs[2].config.telefonos,
    correos: configs[2].config.correos,
    direccion: configs[2].config.direccion,
    redes:{
      facebook: configs[2].config.redes.facebook,
      instagram: configs[2].config.redes.instagram,
      twitter: configs[2].config.redes.twitter,
    }
  }
})

let imagen = ref(`/img/portadas/${configs[1].config.imagen}`);

let dtConfig = {
  order: [[0, 'asc']],
  columnDefs: [{
    targets: [0],
    visible: false
  }],
  language: {
    url: `/datatables/es`
  },
  dom: 'lfrtip',
  select: true,
  lengthMenu: [
    [10, 25, 50, 100, -1],
    ['10 Filas', '25 Filas', '50 Filas', '100 Filas', 'Todo']
  ],
}

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

onMounted(()=>{
    $('#configTable').DataTable(dtConfig);
})

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
  },
  onSuccess: pages =>{
    Toast.fire({
      icon: 'success',
      title: 'Configuración Guardada con Éxito'
    }).then(()=>{
      imagen.value = `/img/portadas/${pages.props.configs[1].config.imagen}`;
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  }
}

const submit = (form) =>{
  form.post('/config/actualizar', options)
}
</script>

<template>
  <DashboardLayout :user="user"/>
  <main id="main" class="main">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-cogs"></i> Configuración</li>
      </ol>
    </nav>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-responsive w-100" id="configTable">
        <thead>
        <tr>
          <th>Id</th>
          <th><h2 class="text-center mb-1" style="color: black"><i class="fa fa-cogs"></i> Configuraciones Generales</h2></th>
        </tr>
        </thead>
        <tbody>
         <tr>
           <td>1</td>
           <td>
             <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
               <ol class="breadcrumb">
                 <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
                 <li class="breadcrumb-item active" aria-current="page"><a href="#"><i class="fa fa-cogs"></i> Configuración</a></li>
                 <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-buildings-fill"></i> Datos Generales de la Empresa</li>
               </ol>
             </nav>
             <div class="container">
               <div class="container">
                 <div class="row align-items-center justify-content-center g-5">
                   <div class="col-lg-12 wow border border-4 rounded rounded-4 bg-white ">
                     <form @submit.prevent="submit(form1)" class="p-4">
                       <div class="row align-items-center justify-content-center g-3">
                         <div class="col-lg-12 pt-4">
                           <div class="form-floating">
                             <input v-model="form1.config.nombre" type="text" class="form-control" id="nombre" placeholder="Nombre">
                             <label for="nombre"><i class="bi bi-buildings-fill"></i> Nombre Empresa</label>
                           </div>
                         </div>
                         <div class="col-lg-12">
                           <div class="form-floating">
                             <textarea style="min-height: 150px" v-model="form1.config.descripcion" type="text" class="form-control" id="descripcion" placeholder="Descripción General"></textarea>
                             <label for="descripcion"><i class="bi bi-text-paragraph"></i> Descripción General</label>
                           </div>
                         </div>
                         <div class="col-12 mb-3">
                           <button :disabled="form1.processing" class="btn btn-primary rounded-pill py-3 px-5 w-100" style="background: #0a53be" type="submit"><i class="bi bi-save2-fill"></i> Guardar Cambios</button>
                         </div>
                       </div>
                     </form>
                   </div>
                 </div>
               </div>
             </div>
           </td>
         </tr>
         <tr>
           <td>2</td>
           <td>
             <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
               <ol class="breadcrumb">
                 <li class="breadcrumb-item"><Link to="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
                 <li class="breadcrumb-item active" aria-current="page"><a href="#"><i class="fa fa-cogs"></i> Configuración</a></li>
                 <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-server"></i> Servicios Generales</li>
               </ol>
             </nav>
             <div class="container">
               <div class="container">
                 <div class="row align-items-center justify-content-center g-5">
                   <div class="col-lg-12 wow border border-4 rounded rounded-4 bg-white ">
                     <form @submit.prevent="submit(form2)" class="p-4">
                       <div class="row align-items-center justify-content-center g-3">
                         <div class="col-lg-12 pt-4">
                           <div class="form-floating">
                             <input v-model="form2.config.titulo" type="text" class="form-control" id="name" placeholder="Nombre">
                             <label for="name"><i class="fa fa-server"></i> Título Servicios</label>
                           </div>
                         </div>
                         <div class="col-lg-12">
                           <div>
                             <label for="imagen" class="form-label small fst-italic fw-bold">Imágen</label>
                             <input @input="form2.imagen = $event.target.files[0]" class="form-control form-control-lg bg-white" id="imagen" type="file"/>
                           </div>
                         </div>
                         <div class="col-lg-8">
                           <div class="form-floating">
                             <textarea style="min-height: 150px" v-model="form2.config.descripcion" type="text" class="form-control" id="descripcion2" placeholder="Descripción General"></textarea>
                             <label for="descripcion2"><i class="bi bi-text-paragraph"></i> Servicios Generales</label>
                           </div>
                         </div>
                         <div class="col-lg-4">
                           <div class="col-12 m-2 row align-items-center justify-content-center" style="height: 150px">
                             <img style="text-align:center;height: 150px; border-radius: 10px !important;" :src="imagen" alt="Vista Previa">
                           </div>
                         </div>
                         <div class="col-12 mb-3">
                           <button :disabled="form2.processing" class="btn btn-primary rounded-pill py-3 px-5 w-100" style="background: #0a53be" type="submit"><i class="bi bi-save2-fill"></i> Guardar Cambios</button>
                         </div>
                       </div>
                     </form>
                   </div>
                 </div>
               </div>
             </div>
           </td>
         </tr>
         <tr>
           <td>3</td>
           <td>
             <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
               <ol class="breadcrumb">
                 <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
                 <li class="breadcrumb-item active" aria-current="page"><a href="#"><i class="fa fa-cogs"></i> Configuración</a></li>
                 <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-phone-alt"></i> Contactos</li>
               </ol>
             </nav>
             <div class="container">
               <div class="container">
                 <div class="row align-items-center justify-content-center g-5">
                   <div class="col-lg-12 wow border border-4 rounded rounded-4 bg-white ">
                     <form @submit.prevent="submit(form3)" class="p-4">
                       <div class="row align-items-center justify-content-center g-3">
                         <div class="col-lg-12 pt-4">
                           <div class="form-floating">
                             <input v-model="form3.config.telefonos" type="text" class="form-control" id="telefonos" placeholder="Télefonos">
                             <label for="telefonos"><i class="fa fa-phone"></i> Télefonos</label>
                           </div>
                         </div>
                         <div class="col-lg-12">
                           <div class="form-floating">
                             <input v-model="form3.config.correos" type="text" class="form-control" id="correos" placeholder="Correos">
                             <label for="correos"><i class="fa fa-mail-bulk"></i> Correos</label>
                           </div>
                         </div>
                         <div class="col-lg-12">
                           <div class="form-floating">
                             <input v-model="form3.config.direccion" type="text" class="form-control" id="direccion" placeholder="Dirección">
                             <label for="direccion"><i class="fa fa-directions"></i> Dirección</label>
                           </div>
                         </div>
                         <div class="col-lg-12">
                           <div class="form-floating">
                             <input v-model="form3.config.redes.facebook" type="text" class="form-control" id="facebook" placeholder="Enlace Cuenta Facebook">
                             <label for="facebook"><i class="bi bi-facebook"></i> Enlace Cuenta Facebook</label>
                           </div>
                         </div>
                         <div class="col-lg-12">
                           <div class="form-floating">
                             <input v-model="form3.config.redes.instagram" type="text" class="form-control" id="instagram" placeholder="Enlace Cuenta Instagram">
                             <label for="instagram"><i class="bi bi-instagram"></i> Enlace Cuenta Instagram</label>
                           </div>
                         </div>
                         <div class="col-lg-12">
                           <div class="form-floating">
                             <input v-model="form3.config.redes.twitter" type="text" class="form-control" id="twitter" placeholder="Enlace Cuenta Twitter">
                             <label for="twitter"><i class="bi bi-twitter"></i> Enlace Cuenta Twitter</label>
                           </div>
                         </div>
                         <div class="col-12 mb-3">
                           <button :disabled="form3.processing" class="btn btn-primary rounded-pill py-3 px-5 w-100" style="background: #0a53be" type="submit"><i class="bi bi-save2-fill"></i> Guardar Cambios</button>
                         </div>
                       </div>
                     </form>
                   </div>
                 </div>
               </div>
             </div>
           </td>
         </tr>
        </tbody>
      </table>
    </div>
  </main>
</template>

<style scoped>
@import "/public/css/dashboard.css";
</style>
