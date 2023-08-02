<script setup>
import DashboardLayout from "../../Layouts/DashboardLayout.vue";
import { ref, computed, onMounted } from 'vue';
import Swal from 'sweetalert2';
import {router, usePage} from "@inertiajs/vue3";
import { Link } from '@inertiajs/vue3'
import { useForm } from '@inertiajs/vue3'

const page = usePage()
const user = computed(() => page.props.auth.user)

defineProps({
  noticia: Object
});

const form = useForm({
  id: page.props.noticia.id,
  titulo: page.props.noticia.titulo,
  noticia: page.props.noticia.noticia,
  imagen: page.props.noticia.imagen,
  publicado_por: page.props.noticia.publicado_por,
  fecha: page.props.noticia.created_at,
})

</script>

<template>
  <DashboardLayout :user="user"/>
  <main id="main" class="main">
    <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><Link href="/dashboard"><i class="bi bi-house"></i> Dashboard</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><Link href="/noticias"><i class="bi bi-newspaper"></i> Noticias</Link></li>
        <li class="breadcrumb-item active" aria-current="page"><i class="bi bi-eye"></i> Ver Noticia</li>
      </ol>
    </nav>
    <div class="container">
      <div class="container">
        <div class="row align-items-center justify-content-center g-5">
          <div class="col-lg-12 wow fadeInUp border border-4 rounded rounded-4 bg-white " data-wow-delay="0.5s">
            <div class="row mb-3 align-items-center justify-content-center">
              <div class="col-12 row align-items-center justify-content-center my-2">
                <img style="border-radius: 40px !important;" class="m-1 col-lg-4" :src="`/img/noticias/${form.imagen}`">
              </div>
              <div class="col-12 row align-items-center justify-content-center">
                <Link v-if="$page.props.permissions.includes('editar-noticia')" :href="`/noticias/editar/${form.id}`" class="btn btn-primary"><i class="bi bi-pencil-square"></i> Editar</Link>
                <table class="table">
                  <tbody>
                  <tr>
                    <th>Título</th>
                    <td>{{ form.titulo }}</td>
                  </tr>
                  <tr>
                    <th>Fecha</th>
                    <td>{{ form.fecha }}</td>
                  </tr>
                  <tr>
                    <th>Publicado Por:</th>
                    <td>{{ form.publicado_por }}</td>
                  </tr>
                  <tr>
                    <th>Noticia</th>
                    <td>{{ form.noticia }}</td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          </div>
        </div>
      </div>
  </main>
</template>

<style scoped>
@import "/public/css/dashboard.css";
</style>
