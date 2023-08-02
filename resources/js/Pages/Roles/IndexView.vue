<script setup>
import {computed, onMounted, ref} from 'vue';
import Swal from 'sweetalert2';
import DashboardLayout from "../../Layouts/DashboardLayout.vue";
import {usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'

const page = usePage()
const user = computed(() => page.props.auth.user)

defineProps({
  roles: Object,
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
if(page.props.permissions.includes('crear-usuario')){
  hidden.value = '';
}
let dtConfig = {
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
      text:      '<i class="bi-plus"> Registrar Rol</i>',
      action: function ( e, dt, node, config ) {
        router.get('/roles/registrar');
      },
      className: `${hidden.value} text-white bg-success rounded fw-bold border-black border-2 border`,
    },
  ],
}

onMounted(()=>{
    $('#rolesTable').DataTable(dtConfig);
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
    page.props.users = pagen.props.users;
    Toast.fire({
      icon: 'success',
      title: 'Rol de Usuario Eliminado con Éxito'
    }).then(()=>{
      router.get(`/roles`);
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  },
}

const deleteRole = async(id) => {
  await Swal.fire({
    title: 'Eliminar Rol de Usuario',
    text: `¿Está seguro q desea eliminar este rol ?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/roles/eliminar/${id}`, options)
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
        <li class="breadcrumb-item active" aria-current="page"><i class="fa fa-server"></i> Roles de Usuario</li>
      </ol>
    </nav>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-responsive w-100" id="rolesTable">
        <thead>
        <tr>
          <th hidden>ID</th>
          <th>Rol de Usuario</th>
          <th>Permisos</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="rol in roles" :key="rol.id">
          <td hidden>{{rol.id}}</td>
          <td>
            <span v-if="rol" class="badge text-bg-primary m-1 fs-5" style="background-color: #0a53be">{{rol.name}}</span>
          </td>
          <td style="width: 60%">
            <span v-for="permiso in rol.permissions" class="badge text-bg-primary bg-primary m-1">{{permiso.name}}</span>
          </td>
          <td width="150px">
            <Link v-if="$page.props.permissions.includes('editar-rol')" :href="`/roles/editar/${rol.id}`" class="btn btn-info m-1 rounded-3"><i class="bi bi-pencil-square fs-6"></i></Link>
            <button v-if="$page.props.permissions.includes('eliminar-rol')" @click="deleteRole(rol.id)" class="btn btn-danger m-1 rounded-3"> <i class="bi bi-trash fs-6"></i></button>
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
