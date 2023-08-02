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
import Galleria from 'primevue/galleria';

const page = usePage()
const user = computed(() => page.props.auth.user)

defineProps({
  images: Object,
});

const form = useForm({
  imagenes: [],
})

const form2 = useForm({
  imagenes_seleccionadas: [],
})

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

const options2 = {
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
      var myModalEl = document.querySelector('#eliminarImagenesModal')
      var modal = bootstrap.Modal.getOrCreateInstance(myModalEl)
      modal.hide();
      router.get('/imagenes');
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  }
}

let dtConfig = {
  "order": [[ 0, 'asc' ]],
  columnDefs: [{target: 0,visible: false,},],
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
      text:      '<i class="bi bi-trash"></i>',
      action: function ( e, dt, node, config ) {
          NProgress.configure({ showSpinner: true });
          NProgress.inc();
          form2.post(`/imagenes/eliminar`, options2);
      },
      className: 'text-white bg-danger rounded fw-bold border-black border-2 border',
    },
  ],
}

onMounted(()=>{
  $('#eliminarImagenesTable').DataTable(dtConfig);
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
      router.get('/imagenes');
    })
    const audio = new Audio("/audio/Notification-bonus-points.mp3");
    audio.play();
  }
}

function submit() {
  if(form.imagenes == ""){
    Swal.fire({
      icon: 'warning',
      title: 'Validación',
      text: 'No se han seleccionado imágenes'
    }).then(()=>{
      $('#imagen').click();
    })
  }else{
    NProgress.configure({ showSpinner: true });
    NProgress.inc();
    form.post('/imagenes/registrar', options)
  }
}

const deleteImages = () =>{
  var myModalEl = document.querySelector('#eliminarImagenesModal')
  var modal = bootstrap.Modal.getOrCreateInstance(myModalEl)
  modal.show();
}

let checkAll = ref(false);
const checkboxCheckedAll = (checked) => {
  if(checked){
    page.props.images.forEach(image => {
      form2.imagenes_seleccionadas.push(image.id);
    })
    checkAll.value = true;
  }else{
    form2.imagenes_seleccionadas = []
    checkAll.value = false;
  }
}

const checkboxChecked = (id) => {
  if(form2.imagenes_seleccionadas.includes(id)){
    form2.imagenes_seleccionadas =  form2.imagenes_seleccionadas.filter(image => image !== id);
  }else{
    form2.imagenes_seleccionadas.push(id)
  }
}

</script>

<template>
  <DashboardLayout :user="user" />
  <main id="main" class="main">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-image"></i> Galería de Imágenes</li>
      </ol>
    </nav>
    <div class="mb-2 d-flex">
      <form v-if="$page.props.permissions.includes('crear-imagen')" @submit.prevent="submit" class="d-flex">
        <div class="w-100">
          <input @input="form.imagenes = $event.target.files" name="images[]" multiple accept=".jpg, .jpeg, .png, .webp" class="form-control bg-white" id="imagen" type="file" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Seleccionar Imágenes para subir al Servidor`" data-bs-delay='{"show":0,"hide":0}' />
        </div>
        <button class="btn btn-primary mx-2"><i class="bi bi-upload" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Subir Imágenes al Servidor`" data-bs-delay='{"show":0,"hide":0}'></i></button>
      </form>
      <button v-if="$page.props.permissions.includes('eliminar-imagen')" @click="deleteImages" class="btn btn-danger"><i class="bi bi-trash" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Eliminar Imágenes`" data-bs-delay='{"show":0,"hide":0}'></i></button>
      <button @click="router.get('/imagenes')" class="btn btn-secondary mx-2" data-bs-toggle="tooltip" data-bs-placement="top" :data-bs-title="`Reproducir desde el principio`" data-bs-delay='{"show":0,"hide":0}'><i class="bi bi-play-btn"></i></button>
    </div>
    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
      {{ form.progress.percentage }}%
    </progress>
    <Galleria :value="images" :numVisible="4" containerStyle="max-width: 100%;"
              :circular="true" :autoPlay="true" :transitionInterval="3000">
      <template #item="slotProps">
        <img :src="`/img/portadas/${slotProps.item.imagen}`" :alt="slotProps.item.alt" style="width: 100%; display: block;height: 65vh" />
      </template>
      <template #thumbnail="slotProps">
        <img class="img" :src="`/img/portadas/${slotProps.item.imagen}`" :alt="slotProps.item.alt" style="display: block" />
      </template>
    </Galleria>
  </main>

  <!-- Modal -->
  <div class="modal  fade" id="eliminarImagenesModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel"><i class="fa bi-trash-fill"></i> Eliminar Imágenes</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <table class="table table-striped table-responsive w-100" id="eliminarImagenesTable">
            <thead>
              <tr>
                <th>Id</th>
                <th style="width: 15%"><input @click="checkboxCheckedAll($event.target.checked)" type="checkbox"></th>
                <th>Imágen</th>
                <th>Nombre Archivo</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="image in images">
                <td>{{image.id}}</td>
                <td><input :checked="checkAll" @click="checkboxChecked(image.id)" type="checkbox"></td>
                <td><img style="width:100px" :src="`/img/portadas/${image.imagen}`" /></td>
                <td>{{image.imagen}}</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="bi bi-x-circle-fill"></i> Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
@import "/public/css/dashboard.css";

img {
  border: 1px solid #ddd; /* Gray border */
  border-radius: 4px;  /* Rounded border */
  padding: 2px; /* Some padding */
  width: 120px; /* Set a small width */
  height: 60px;
}

/* Add a hover effect (blue shadow) */
img:hover {
  box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
}
</style>


