<template>
  <div
    class="mobile-menu-toggler"
    @click="toggleMenu"
  >
    <SvgIconHamburger />
  </div>
</template>
<script setup>
import SvgIconHamburger from '~/svg/ui/IconHamburger.vue'
import useMobileNav from '#/useMobileNav.js'

const { mobileNavIsOpen } = useMobileNav()

const toggleMenu = () => {
  mobileNavIsOpen.value = !mobileNavIsOpen.value
}

</script>