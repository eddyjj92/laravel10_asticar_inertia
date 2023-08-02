<script setup>
import {computed, onMounted, ref} from 'vue';
import Swal from 'sweetalert2';
import DashboardLayout from "../../Layouts/DashboardLayout.vue";
import {usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { useForm } from '@inertiajs/vue3'
import NProgress from 'nprogress';

const page = usePage()
const user = computed(() => page.props.auth.user)
let archivo = ref(null);

defineProps({
  mensajes: Object,
});

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

let dtConfig = {
  "order": [[ 4, 'desc' ]],
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

onMounted(()=>{
    $('#mensajesTable').DataTable(dtConfig);
})

const options = {
  preserveScroll: true,
  onError: errors => {
    Swal.fire({
      icon: 'error',
      title: 'Error',
      text: errors.validacion
    })
    const audio = new Audio("/audio/click-error.wav");
    audio.play();
  },
  onSuccess: pagen => {
    Toast.fire({
      icon: 'success',
      title: 'Mensaje Eliminado con Éxito'
    }).then(()=>{
      router.get(`/mensajes`);
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  },
}

const deleteMensaje = (id) =>{
  Swal.fire({
    title: 'Eliminar Mensaje',
    text: "¿Está seguro q desea eliminar este mensaje?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/mensajes/eliminar/${id}`, options)
    }
  })
}

</script>

<template>
  <DashboardLayout :user="user" />
  <main id="main" class="main">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-mail-bulk"></i> Mensajes</li>
      </ol>
    </nav>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-responsive w-100" id="mensajesTable">
        <thead>
        <tr>
          <th hidden>Id</th>
          <th>Nombre</th>
          <th>Correo</th>
          <th>Asunto</th>
          <th>Fecha</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="msg in mensajes" :key="msg.id">
          <td hidden>{{msg.id}}</td>
          <td>{{msg.persona}}</td>
          <td>{{msg.correo}}</td>
          <td>{{msg.asunto}}</td>
          <td>{{msg.created_at}}</td>
          <td><span class="badge bg-primary" v-if="msg.estado"><i class="bi bi-check-all"></i> Leido</span><span class="badge bg-secondary" v-else><i class="fa fa-mail-bulk"></i> Sin leer</span></td>
          <td width="120px">
            <Link v-if="$page.props.permissions.includes('ver-mensaje')" :href="`/mensajes/ver/${msg.id}`"  class="btn btn-success m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Ver Mensaje`" data-bs-delay='{"show":0,"hide":0}'><i class="bi bi-eye-fill"></i></Link>
            <button v-if="$page.props.permissions.includes('eliminar-mensaje')" @click="deleteMensaje(msg.id)" class="btn btn-danger m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Eliminar Mensaje`"> <i class="bi bi-trash fs-6"></i></button>
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
