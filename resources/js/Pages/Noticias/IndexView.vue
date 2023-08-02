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

defineProps({
  noticias: Object,
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

let hidden = ref('visually-hidden');
if(page.props.permissions.includes('crear-usuario')){
  hidden.value = '';
}
let dtConfig = {
  "order": [[ 0, 'desc' ]],
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
      text:      '<i class="fa fa-newspaper"> Publicar Noticia</i>',
      action: function ( e, dt, node, config ) {
        router.get('/noticias/registrar');
      },
      className: `${hidden.value} text-white bg-success rounded fw-bold border-black border-2 border`,
    },
  ],
}

onMounted(()=>{
    $('#noticiasTable').DataTable(dtConfig);
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
      title: pages.props.flash.message,
    }).then(()=>{
      router.get('/noticias');
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  }
}

const deleteNoticia = (id) =>{
  Swal.fire({
    title: 'Eliminar Noticia',
    text: "¿Está seguro q desea eliminar esta noticia?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      router.delete(`/noticias/eliminar/${id}`, options)
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
        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-newspaper"></i> Blog de Noticias</li>
      </ol>
    </nav>
    <div class="table-responsive">
      <table class="table table-hover table-striped table-responsive w-100" id="noticiasTable">
        <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Imágen</th>
          <th>Publicado Por</th>
          <th>Fecha Publicación</th>
          <th>Acciones</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="noticia in noticias" :key="noticia.id">
          <td>{{noticia.id}}</td>
          <td>{{noticia.titulo}}</td>
          <td style="min-width: 160px"><img class="rounded rounded-3 w-100" style="height: 100px" :src="`/img/noticias/${noticia.imagen}`"></td>
          <td>{{noticia.publicado_por}}</td>
          <td>{{noticia.created_at}}</td>
          <td width="150px">
            <Link v-if="$page.props.permissions.includes('ver-noticia')" :href="`/noticias/ver/${noticia.id}`" class="btn btn-success m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Ver Noticia`" data-bs-delay='{"show":0,"hide":0}'><i class="bi bi-eye fs-6"></i></Link>
            <Link v-if="$page.props.permissions.includes('editar-noticia')" :href="`/noticias/editar/${noticia.id}`"  class="btn btn-info m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Editar Noticia`" data-bs-delay='{"show":0,"hide":0}'><i class="bi bi-pencil-square fs-6"></i></Link>
            <button v-if="$page.props.permissions.includes('eliminar-noticia')" @click="deleteNoticia(noticia.id)" class="btn btn-danger m-1 rounded-3" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Eliminar Noticia`" data-bs-delay='{"show":0,"hide":0}'> <i class="bi bi-trash fs-6"></i></button>
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
