<script setup>
import { onMounted, ref } from 'vue';
import DashboardLayout from "../Layouts/DashboardLayout.vue";
import { computed } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)

defineProps({
  cantUsers: Number,
  conectedUsers: Number,
  cantSolicitudes: Number,
  cantNoticias: Number,
});

let hora = ref('');
setInterval(()=>{
  // crea un nuevo objeto `Date`
  let today = new Date();
  // obtener la fecha y la hora
  hora.value = today.toLocaleString();
}, 1000);

</script>
<template>
  <DashboardLayout :user="user"/>
  <main id="main" class="main">

    <div class="pagetitle">
      <h1><i class="bi bi-grid"></i> Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><Link href="/"><i class="bi bi-house"></i> Inicio</Link></li>
          <li class="breadcrumb-item active"><i class="bi bi-grid"></i> Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Left side columns -->
        <div class="col-lg-12">
          <div class="row">
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Usuario <span>| {{user.email}}</span></h5>
                  <Link :href="`/usuario/perfil/${user.id}`" class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <img class="rounded-circle col-12" :src="`/img/profile/${user.imagen}`">
                    </div>
                    <div class="ps-3">
                      <h6 class="fs-6 fw-bold">{{user.name}}</h6>
                      <span class="text-white small pt-1 fw-bold badge bg-primary">{{user.roles[0].name}}  </span><span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </Link>
                </div>
              </div>
            </div>
            <div class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Fecha <span>| Hora</span></h5>
                  <a href="#" class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-clock-fill"></i>
                    </div>
                    <div class="ps-4">
                      <h6 class="fs-5">{{hora}}</h6>
                      <span class="text-danger small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <div v-if="$page.props.permissions.includes('ver-usuario')" class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Usuarios <span>| Conectados</span></h5>
                  <Link href="/usuarios" class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person-check-fill"></i>
                    </div>
                    <div class="ps-3">
                      <h6 id="conectados">{{conectedUsers}}</h6>
                      <span class="text-success small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </Link>
                </div>
              </div>
            </div>
            <div v-if="$page.props.permissions.includes('ver-usuario')" class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Usuarios <span>| Registrados</span></h5>
                  <Link href="/usuarios" class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-person-fill-add"></i>
                    </div>
                    <div class="ps-3">
                      <h6>{{cantUsers}}</h6>
                      <span class="text-danger small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </Link>
                </div>
              </div>
            </div>
            <div v-if="$page.props.permissions.includes('ver-solicitud(todas)') || $page.props.permissions.includes('ver-solicitud(usuario)')" class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Solicitudes <span>| Pendientes</span></h5>
                  <Link href="/solicitudes" class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6 class="fs-5">{{ cantSolicitudes }} Solicitudes</h6>
                      <span class="small pt-1 badge bg-warning fw-bold" >pendientes</span><span class="text-muted small pt-2 ps-1"> a revisión.</span>
                    </div>
                  </Link>
                </div>
              </div>
            </div>
            <div v-if="$page.props.permissions.includes('ver-noticia')" class="col-xxl-4 col-md-4">
              <div class="card info-card sales-card">
                <div class="card-body">
                  <h5 class="card-title">Noticias <span>| Publicadas</span></h5>
                  <Link href="/noticias" class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-newspaper"></i>
                    </div>
                    <div class="ps-4">
                      <h6> {{ cantNoticias }}</h6>
                      <span class="text-danger small pt-1 fw-bold"></span> <span class="text-muted small pt-2 ps-1"></span>
                    </div>
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
</template>

<style scoped>
@import "/public/css/dashboard.css";
</style>
