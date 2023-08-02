<script setup>
import { onMounted,onUnmounted, ref } from 'vue'
import {Link, usePage} from '@inertiajs/vue3'
const { props } = usePage();
import { router } from '@inertiajs/vue3'
import Swal from "sweetalert2";

const page = usePage();

defineProps({
  user: Object,
});

var refreshIntervalId = null;

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

if(page.props.flash.message){
  Toast.fire({
    icon: 'success',
    title: page.props.flash.message
  })
  const audio = new Audio("/audio/Notification-bonus-points.mp3");
  audio.play();
}

if(page.props.errors.validacion){
  Toast.fire({
    icon: 'error',
    title: page.props.errors.validacion
  })
  const audio = new Audio("/audio/click-error.wav");
  audio.play();
}

onUnmounted(()=>{
  clearInterval(refreshIntervalId);
})

onMounted(()=>{

  refreshIntervalId = setInterval(()=>{
    router.reload()
  }, 20000);


  (function() {
    "use strict";

    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
      el = el.trim()
      if (all) {
        return [...document.querySelectorAll(el)]
      } else {
        return document.querySelector(el)
      }
    }

    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
      if (all) {
        select(el, all).forEach(e => e.addEventListener(type, listener))
      } else {
        select(el, all).addEventListener(type, listener)
      }
    }

    /**
     * Easy on scroll event listener
     */
    const onscroll = (el, listener) => {
      el.addEventListener('scroll', listener)
    }

    /**
     * Sidebar toggle
     */
    if (select('.toggle-sidebar-btn')) {
      on('click', '.toggle-sidebar-btn', function(e) {
        select('body').classList.toggle('toggle-sidebar')
      })
    }

    /**
     * Search bar toggle
     */
    if (select('.search-bar-toggle')) {
      on('click', '.search-bar-toggle', function(e) {
        select('.search-bar').classList.toggle('search-bar-show')
      })
    }

    /**
     * Navbar links active state on scroll
     */
    let navbarlinks = select('#navbar .scrollto', true)
    const navbarlinksActive = () => {
      let position = window.scrollY + 200
      navbarlinks.forEach(navbarlink => {
        if (!navbarlink.hash) return
        let section = select(navbarlink.hash)
        if (!section) return
        if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
          navbarlink.classList.add('active')
        } else {
          navbarlink.classList.remove('active')
        }
      })
    }
    window.addEventListener('load', navbarlinksActive)
    onscroll(document, navbarlinksActive)

    /**
     * Toggle .header-scrolled class to #header when page is scrolled
     */
    let selectHeader = select('#header')
    if (selectHeader) {
      const headerScrolled = () => {
        if (window.scrollY > 100) {
          selectHeader.classList.add('header-scrolled')
        } else {
          selectHeader.classList.remove('header-scrolled')
        }
      }
      window.addEventListener('load', headerScrolled)
      onscroll(document, headerScrolled)
    }

    /**
     * Back to top button
     */
    let backtotop = select('.back-to-top')
    if (backtotop) {
      const toggleBacktotop = () => {
        if (window.scrollY > 100) {
          backtotop.classList.add('active')
        } else {
          backtotop.classList.remove('active')
        }
      }
      window.addEventListener('load', toggleBacktotop)
      onscroll(document, toggleBacktotop)
    }

    /**
     * Initiate tooltips
     */
    let oldTooltip = document.querySelectorAll('.tooltip');
    if(oldTooltip) oldTooltip.forEach(tp => { tp.remove() });
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

  })();
})

</script>

<template>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <Link href="/" class="logo d-flex align-items-center" style="text-align:center">
        <img style="width: 100px" src="/img/asticar.png" alt="Astilleros del Caribe">
      </Link>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!--<div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div>-->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!--<li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li>-->

<!--        <li class="nav-item dropdown" style="margin-right: -20px">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number" style="right: 8px !important;">4</span>
          </a>&lt;!&ndash; End Notification Icon &ndash;&gt;
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>
          </ul>
        </li>-->

        <li id="msg" v-if="$page.props.permissions.includes('ver-mensaje')" class="nav-item dropdown" style="margin-right: -20px">
          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span v-if="$page.props.mensajesSinLeer.length !== 0" class="badge bg-success badge-number" style="right: 8px !important;">{{$page.props.mensajesSinLeer.length}}</span>
          </a><!-- End Messages Icon -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              Tiene {{$page.props.mensajesSinLeer.length}} nuevos mensajes.
              <Link href="/mensajes"><span class="badge rounded-pill bg-primary p-2 ms-2">Ver Todos</span></Link>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li v-for="mensaje in $page.props.mensajesSinLeer" class="message-item border-bottom">
              <Link :href="`/mensajes/ver/${mensaje.id}`">
                <img src="" alt="" class="rounded-circle">
                <div>
                  <h4>{{mensaje.persona}}</h4>
                  <p>{{mensaje.asunto}}</p>
                  <p>{{mensaje.created_at}}</p>
                </div>
              </Link>
            </li>
            <li v-if="$page.props.mensajesSinLeer.length === 0" class="message-item border-bottom">
              <a href="#">
                <img src="" alt="" class="rounded-circle">
                <div>
                  <h4>Sin Mensajes</h4>
                  <p>No tiene nuevos mensajes en su buzón.</p>
                </div>
              </a>
            </li>
            <li class="dropdown-footer">
              <Link href="/mensajes">Ver Todos los Mensajes</Link>
            </li>
          </ul>
        </li>

        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img :src="`/img/profile/${user.imagen}`" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">{{user.email}}</span>
          </a><!-- End Profile Iamge Icon -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>{{user.name}}</h6>
              <span class="badge bg-primary">{{user.roles[0].name}}</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <Link class="dropdown-item d-flex align-items-center" :href="`/`">
                <i class="bi bi-house"></i>
                <span>Inicio</span>
              </Link>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <Link class="dropdown-item d-flex align-items-center" :href="`/usuario/perfil/${user.id}`">
                <i class="bi bi-person"></i>
                <span>Perfil</span>
              </Link>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li v-if="$page.props.permissions.includes('ver-config')">
              <Link class="dropdown-item d-flex align-items-center" href="/configs">
                <i class="bi bi-gear"></i>
                <span>Configuracion</span>
              </Link>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <Link  class="dropdown-item d-flex align-items-center" href="/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar Sesión</span>
              </Link>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <Link class="nav-link " href="/dashboard">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </Link>
      </li>
      <li v-if="$page.props.permissions.includes('ver-config') || $page.props.permissions.includes('ver-rol')" class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-gear-fill"></i><span>Configuracion</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li v-if="$page.props.permissions.includes('ver-config')">
            <Link href="/configs">
              <i class="fa fa-cogs fs-6"></i><span>Generales</span>
            </Link>
          </li>
          <li v-if="$page.props.permissions.includes('ver-rol')">
            <Link href="/roles">
              <i class="bi bi-shield-check fs-6"></i><span>Roles y Permisos</span>
            </Link>
          </li>
        </ul>
      </li><!-- End Components Nav -->
      <li v-if="$page.props.permissions.includes('ver-usuario')" class="nav-item">
        <Link class="nav-link collapsed" href="/usuarios">
          <i class="bi bi-person"></i>
          <span>Usuarios</span>
        </Link>
      </li>
      <li v-if="$page.props.permissions.includes('ver-servicio')" class="nav-item">
        <Link class="nav-link collapsed" href="/servicios">
          <i class="fa fa-server"></i>
          <span>Servicios</span>
        </Link>
      </li>
      <li v-if="$page.props.permissions.includes('ver-solicitud(todas)') || $page.props.permissions.includes('ver-solicitud(usuario)')" class="nav-item">
        <Link class="nav-link collapsed" href="/solicitudes">
          <i class="bi bi-book-half"></i>
          <span>Solicitudes</span>
        </Link>
      </li>
      <li v-if="$page.props.permissions.includes('ver-noticia')" class="nav-item">
        <Link class="nav-link collapsed" href="/noticias">
          <i class="bi bi-newspaper"></i>
          <span>Blog de Noticias</span>
        </Link>
      </li>
      <li v-if="$page.props.permissions.includes('ver-imagen')" class="nav-item">
        <Link class="nav-link collapsed" href="/imagenes">
          <i class="bi bi-image"></i>
          <span>Galería</span>
        </Link>
      </li>
      <li class="nav-item">
        <Link class="nav-link collapsed" href="/logout">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Cerrar Sesión</span>
        </Link>
      </li>
    </ul>
  </aside>

</template>

<style scoped >
@import "/public/css/dashboard.css";
/*@import "/src/assets/vendor/mdb/css/mdb.min.css";*/
</style>
