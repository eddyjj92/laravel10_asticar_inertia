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
let archivo = ref(null);

defineProps({
  servicios: Object,
});

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

let hidden = ref('visually-hidden');
if(page.props.permissions.includes('crear-servicio')){
  hidden.value = '';
}
let dtConfig = {
  rowReorder: true,
  colReorder: true,
  language: {
    url: `/datatables/es`
  },
  dom: 'lBfrtip',
  select: true,
  lengthMenu: [
    [10, 25, 50, 100, -1],
    ['10 Filas', '25 Filas', '50 Filas', '100 Filas', 'Todo']
  ],
  buttons: [
    {
      text:      '<i class="bi-plus-circle-dotted"> Registrar Servicio</i>',
      action: function ( e, dt, node, config ) {
        router.get('/servicios/registrar');
      },
      className: `${hidden.value} text-white bg-success rounded fw-bold border-black border-2 border`,
    },
  ],
}

onMounted(()=>{
    $('#servicesTable').DataTable(dtConfig);
})

const options = {
  preserveScroll: true,
  onError: errors => {
    Swal.fire({
      icon: 'error',
      title: 'Validación',
      text: errors.validacion
    });
    const audio = new Audio("/audio/click-error.wav");
    audio.play();
  },
  onSuccess: page => {
    Toast.fire({
      icon: 'success',
      title: page.props.flash.message,
    }).then(()=>{
      router.get(`/servicios`);
    });
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  },
}

const eliminarServicio = async(id) => {
  await Swal.fire({
    title: 'Eliminar Servicios',
    text: `¿Está seguro q desea eliminar este servicio ?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
        router.delete(`/servicios/eliminar/${id}`, options)
    }
  })
}

</script>

<template>
  <DashboardLayout :user="user"/>
  <main id="main" class="main">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-server"></i> Servicios</li>
      </ol>
    </nav>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-responsive w-100" id="servicesTable">
        <thead>
        <tr>
          <th hidden>ID</th>
          <th>Servicio</th>
          <th>Descripción</th>
          <th>Habilitado</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="service in servicios" :key="service.id">
          <td hidden>{{service.id}}</td>
          <td>{{service.nombre}}</td>
          <td>{{service.descripcion}}</td>
          <td><input :disabled="!$page.props.permissions.includes('habilitar-servicio')" type="checkbox" @click="router.get(`/servicios/enable_disable/${service.id}`)" v-model="service.habilitado"></td>
          <td width="150px">
            <Link v-if="$page.props.permissions.includes('editar-servicio')" :href="`/servicios/editar/${service.id}`" class="btn btn-info m-1 rounded-3"><i class="bi bi-pencil-square fs-6"></i></Link>
            <button v-if="$page.props.permissions.includes('eliminar-servicio')" @click="eliminarServicio(service.id)" class="btn btn-danger m-1 rounded-3"> <i class="bi bi-trash fs-6"></i></button>
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
