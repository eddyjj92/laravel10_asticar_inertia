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
  roles: Object,
  errors: Object
});

const Toast = Swal.mixin({
  toast: true,
  position: 'top-end',
  showConfirmButton: false,
  timer: 1500,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.addEventListener('mouseenter', Swal.stopTimer)
    toast.addEventListener('mouseleave', Swal.resumeTimer)
  }
})

const form = useForm({
  nombre: null,
  correo: null,
  telefono: null,
  entidad: null,
  ocupacion: null,
  rolUsuario: null,
  password: null,
  password2: null,
  avatar: null,
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
}

function submit() {
  form.post('/usuario/registrar', options)
}


</script>

<template>
  <DashboardLayout :user="user"/>
  <main id="main" class="main">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><Link to="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><Link href="/usuarios"><i class="bi bi-person"></i> Usuarios</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-person"></i> Registrar</li>
      </ol>
    </nav>
    <div class="container">
      <div class="container">
        <div class="row align-items-center justify-content-center g-5">
          <div class="col-lg-12 wow fadeInUp border border-4 rounded rounded-4 bg-white " data-wow-delay="0.5s">
            <form @submit.prevent="submit" class="p-2">
              <div class="row align-items-center justify-content-center g-3">
                <h2 class="text-center mb-1" style="color: black"><i class="bi bi-person-add"></i> Nuevo Usuario</h2>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.nombre" type="text" class="form-control" id="name" placeholder="Nombre">
                    <label for="name"><i class="bi bi-person"></i> Nombre</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.correo" type="text" class="form-control" id="correo" placeholder="Correo">
                    <label for="correo"><i class="bi bi-at"></i> Correo</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.telefono" type="text" class="form-control" id="telefono" placeholder="Teléfono">
                    <label for="telefono"><i class="bi bi-phone"></i> Teléfono</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.entidad" type="text" class="form-control" id="entidad" placeholder="Entidad">
                    <label for="entidad"><i class="bi bi-building"></i> Entidad</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.ocupacion" type="text" class="form-control" id="ocupacion" placeholder="Ocupación">
                    <label for="ocupacion"><i class="bi bi-person-rolodex"></i> Ocupación</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <select v-model="form.rolUsuario" type="text" class="form-select" id="role">
                      <option :value="null" selected>Seleccione Rol de Usuario</option>
                      <option v-for="role in roles" :value="role.id" selected>{{role.name}}</option>
                    </select>
                    <label for="role"><i class="bi bi-person-rolodex"></i> Rol de Usuario</label>
                  </div>
                </div>
                <div class="col-lg-12">
                  <div>
                    <label for="imagen" class="form-label small fst-italic fw-bold">Imágen Perfil (Opcional)</label>
                    <input @input="form.avatar = $event.target.files[0]" class="form-control form-control-lg bg-white" id="imagen" type="file"/>
                  </div>
                  <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                    {{ form.progress.percentage }}%
                  </progress>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.password" type="password" class="form-control" id="password" placeholder="Contraseña">
                    <label for="password"><i class="bi bi-key-fill"></i> Contraseña</label>
                  </div>
                </div>
                <div class="col-lg-6">
                  <div class="form-floating">
                    <input v-model="form.password2" type="password" class="form-control" id="password2" placeholder="Contraseña">
                    <label for="password2"><i class="bi bi-key-fill"></i>  Contraseña</label>
                  </div>
                </div>
                <div class="col-12 mb-3">
                  <button :disabled="form.processing" class="btn btn-primary rounded-pill py-3 px-5 w-100" style="background: #0a53be" type="submit"><i class="bi bi-person-plus"></i> Registrar Usuario</button>
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
