<script setup>
import {onMounted, ref} from "vue";
import { Carousel, Slide, Navigation } from 'vue3-carousel'
import 'vue3-carousel/dist/carousel.css'
import {router, usePage} from '@inertiajs/vue3'
import { computed } from 'vue';

const { props } = usePage();

defineProps({
  images:Object,
  configs: Object
});


const visit = () =>{
  router.get(`/solicitudes/registrar`)
}
</script>

<template>
  <div class="container-xxl bg-primary hero-header">
    <div class="container">
      <div class="row g-5 align-items-center">
        <div class="col-lg-5 text-center text-lg-start">
          <h2 class="text-white mb-4 animated slideInDown text-center" style="text-align: justify">{{configs[0].config.nombre}}</h2>
          <p class="text-white pb-3 animated slideInDown" style="text-align: justify">{{configs[0].config.descripcion}}</p>
          <div class="position-relative w-100 mt-3">
            <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" style="height: 58px;">
            <Link @click="visit" href="/solicitudes/registrar" class="btn btn-primary rounded-pill py-2 px-3 shadow-none position-absolute top-0 end-0 m-2" style="width: 96%"><i class="fa fa-server"></i> Solicitar Servicio</Link>
          </div>
        </div>
        <div class="col-lg-7 text-center text-lg-start">
          <Carousel :wrap-around="true" :autoplay="3000">
            <Slide v-for="image in images" :key="image.id">
              <div class="carousel__item">
                <img class="rounded rounded-3 w-100" style="min-height: 400px !important;max-height:400px !important;" :src="`img/portadas/${image.imagen}`">
              </div>
            </Slide>
            <template #addons>
              <Navigation />
              <Pagination />
            </template>
          </Carousel>
        </div>
      </div>
    </div>
  </div>
</template>

<style>
.carousel__item {
  min-height: 400px;
  width: 100%;
  background-color: var(--vc-clr-primary);
  color: var(--vc-clr-white);
  font-size: 20px;
  border-radius: 8px;
  justify-content: center;
  align-items: center;
}

.carousel__slide {
  padding: 10px;
}

.carousel__prev,
.carousel__next {
  color: #0d6efd;
  box-sizing: content-box;
  border: 5px solid white;
}
</style>
