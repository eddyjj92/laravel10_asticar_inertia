<script setup>
import DashboardLayout from "../../Layouts/DashboardLayout.vue";
import { ref, computed, onMounted } from 'vue';
import Swal from 'sweetalert2';
import {usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)

defineProps({
  errors: Object
});

const form = useForm({
  nombre: null,
  descripcion: null,
})

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

const options = {
  preserveScroll: true,
  onError: errors => {
    Swal.fire({
      icon: 'error',
      title: 'Validación',
      text: errors.validacion
    })
  },
  onSuccess: page => {
    Toast.fire({
      icon: 'success',
      title: page.props.flash.message,
    })
  },
}

function submit() {
  form.post('/servicios/registrar', options)
}

</script>

<template>
  <DashboardLayout :user="user"/>
  <main id="main" class="main">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><Link href="/servicios"><i class="fa fa-server"></i> Servicios</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-plus-circle-fill"></i> Registrar</li>
      </ol>
    </nav>
    <div class="container">
      <div class="container">
        <div class="row align-items-center justify-content-center g-5">
          <div class="col-lg-12 wow fadeInUp border border-4 rounded rounded-4 bg-white " data-wow-delay="0.5s">
            <form @submit.prevent="submit" class="p-2">
              <div class="row align-items-center justify-content-center g-3 mt-1">
                <h2 class="text-center mb-1" style="color: black"><i class="fa fa-server"></i> Registrar Servicio</h2>
                <div class="col-lg-12">
                  <div class="form-floating">
                    <input v-model="form.nombre" type="text" class="form-control" id="nombre" placeholder="Servicio">
                    <label for="nombre"><i class="fa fa-server"></i> Servicio</label>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div class="form-floating">
                    <textarea v-model="form.descripcion" style="min-height:150px" class="form-control" id="descripcion" cols="30" rows="10" placeholder="Descripción"></textarea>
                    <label for="descripcion"><i class="bi bi-text-wrap"></i> Descripción</label>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <button :disabled="form.processing" class="btn btn-primary rounded-pill py-3 px-5 w-100" style="background: #0a53be" type="submit"><i class="bi bi-plus-circle-fill"></i> Registrar Servicio</button>
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
</style>
