<script setup>
import { ref, onMounted } from "vue";
import { Link } from '@inertiajs/vue3'

defineProps({
  noticias:Object,
});

onMounted(()=>{
  var swiper = new Swiper(".mySwiper", {
    effect: "coverflow",
    grabCursor: true,
    centeredSlides: true,
    slidesPerView: "auto",
    coverflowEffect: {
      rotate: 50,
      stretch: 0,
      depth: 100,
      modifier: 1,
      slideShadows: true,
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    spaceBetween: 30,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
  });

})
</script>

<template>
  <div class="container-xxl py-5" id="blog">
    <div class="container">
      <div class="mx-auto text-center wow fadeInUp" data-wow-delay="0.1s" style="max-width: 600px;">
        <h1 class="mb-3">Blog de Noticias</h1>
        <p class="mb-5">Manténgase al día con nuestras últimas noticias, informaciones y nuevas ofertas. </p>
      </div>

      <!-- Swiper -->
      <div class="swiper mySwiper">
        <div class="swiper-wrapper">
          <div v-for="(noticia, index) in noticias" :key="index" class="swiper-slide">
            <div class="w-100 wow fadeInUp" data-wow-delay="0.3s">
              <div class="price-item rounded overflow-hidden">
                <div v-if="(index % 2) === 0" class="bg-primary p-4">
                  <div class="text-white">
                    <img class="rounded rounded-3 w-100" style="max-height: 150px" :src="`img/noticias/${noticia.imagen}`">
                  </div>
                  <h5 class="text-white mt-2">{{noticia.titulo.substring(0,60)}}...</h5>
                  <small class="text-white mt-2">Publica: {{noticia.publicado_por}}</small><br>
                  <small class="text-white mt-2">Fecha: {{noticia.created_at}}</small>
                </div>
                <div v-else class="bg-dark p-4">
                  <div class="text-white">
                    <img class="rounded rounded-3 w-100 h-100" :src="`/img/noticias/${noticia.imagen}`">
                  </div>
                  <h5 class="text-white mt-2">{{noticia.titulo.substring(0,50)}}...</h5>
                  <small class="text-white mt-2">Publica: {{noticia.publicado_por}}</small><br>
                  <small class="text-white mt-2">Fecha: {{noticia.created_at}}</small>
                </div>
                <div class="p-4">
                  <div class="d-flex justify-content-between mb-3"><span>{{noticia.noticia.substring(0,150)}}...</span><i class="fa fa-check text-success pt-1"></i></div>
                  <Link v-if="(index % 2) === 0" :href="`/noticias/ver/${noticia.id}`" class="btn btn-primary rounded-pill py-2 px-4 mt-3 w-100"><i class="bi bi-eye-fill"></i> Ver Noticia</Link>
                  <Link v-else :href="`/noticias/ver/${noticia.id}`" class="btn btn-dark rounded-pill py-2 px-4 mt-3 w-100"><i class="bi bi-eye-fill"></i> Ver Noticia</Link>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-pagination"></div>
      </div>

    </div>
  </div>
  <!-- Pricing End -->

</template>

<style scoped>
html,
body {
  position: relative;
  height: 100%;
}

body {
  background: #eee;
  font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
  font-size: 14px;
  color: #000;
  margin: 0;
  padding: 0;
}

.swiper {
  width: 100%;
  padding-top: 30px;
  padding-bottom: 30px;
}

.swiper-slide {
  background-position: center;
  background-size: cover;
  width: 300px;
  height: 600px;
}

.swiper-slide img {
  display: block;
  width: 100%;
}
</style>

