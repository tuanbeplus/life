import { createApp } from 'vue/dist/vue.esm-bundler.js';
import './css/app.css'
import useHealthCheck from '#/useHealthCheck.js'
import useUtils from '#/useUtils.js'

import SvgLogoPrimary from '~/svg/logo/LogoPrimary.vue'
import SvgEdgeCurve1 from '~/svg/section-edge-curve/EdgeCurve1.vue'
import SvgEdgeCurve2 from '~/svg/section-edge-curve/EdgeCurve2.vue'
import SvgEdgeCurve3 from '~/svg/section-edge-curve/EdgeCurve3.vue'
import SvgIconFb from '~/svg/social/IconFb.vue'
import SvgIconLinkedin from '~/svg/social/IconLinkedin.vue'
import SvgIconInsta from '~/svg/social/IconInsta.vue'
import SvgIconGlobe from '~/svg/ui/IconGlobe.vue'
import SvgIconDocument from '~/svg/ui/IconDocument.vue'
import SvgChevDown from '~/svg/ui/ChevDown.vue'

import ContentTabs from '~/widget/ContentTabs.vue'
import ContentTabsTabs from '~/widget/ContentTabsTabs.vue'
import ContentGiantTabs from '~/widget/ContentGiantTabs.vue'
import SmlTabsOverGiant from '~/widget/SmlTabsOverGiant.vue'
import GiantTabsOverSml from '~/widget/GiantTabsOverSml.vue'
import PathwaySteps from '~/widget/PathwaySteps.vue'
import BoxSlideshow from '~/widget/BoxSlideshow.vue'
import VidPlayer from '~/widget/VidPlayer.vue'
import SelectSml from '~/widget/SelectSml.vue'
import StoryContainer from '~/widget/StoryContainer.vue'
import FormWrap from '~/widget/FormWrap.vue'
import AjaxForm from '~/widget/AjaxForm.vue'
import FooterNavAccordion from '~/widget/FooterNavAccordion.vue'
import SlideInBlock from '~/widget/SlideInBlock.vue'

import HealthCheckTrigger from '~/widget/modal-triggers/HealthCheckTrigger.vue'
import ContactTriggerPcos from '~/widget/modal-triggers/ContactTriggerPcos.vue'
import ContactTriggerGestational from '~/widget/modal-triggers/ContactTriggerGestational.vue'

import HealthCheck from '~/modals/HealthCheck.vue'
import ContactModalPcos from '~/modals/ContactModalPcos.vue'
import ContactModalGestational from '~/modals/ContactModalGestational.vue'
import ContactModalFacilitatorEoi from '~/modals/ContactModalFacilitatorEoi.vue'
import ContactModalThcEoi from '~/modals/ContactModalThcEoi.vue'
import ContactModalProviderSignupEoi from '~/modals/ContactModalProviderSignupEoi.vue'
import ContactModalWorkplace from '~/modals/ContactModalWorkplace.vue'
import ContactModalCommunityOrgAndGroups from '~/modals/ContactModalCommunityOrgAndGroups.vue'
import InlineDialogShare from '~/modals/InlineDialogShare.vue'
import InlineDialogShareModal from '~/modals/InlineDialogShareModal.vue'

import TopNavSearch from '~/top-nav/TopNavSearch.vue'
import TopNavSearchTrigger from '~/top-nav/TopNavSearchTrigger.vue'
import TopNavLangSelector from '~/top-nav/TopNavLangSelector.vue'
import MobileNav from '~/top-nav/MobileNav.vue'
import MobileMenuToggler from '~/top-nav/MobileMenuToggler.vue'

import BlogIndexTabbed from '~/blog/BlogIndexTabbed.vue'
import VideoSlideshow from '~/VideoSlideshow.vue'
import TestimonialsSlideshow from '~/TestimonialsSlideshow.vue'
import GetInvolvedTabs from '~/GetInvolvedTabs.vue'

import SubscribeForm from '~/contact-forms/SubscribeForm.vue'

import SingleAccordion from '~/deprecate/SingleAccordion.vue'

const { healthCheck, healthCheckTriggers } = useHealthCheck()
const { eListen } = useUtils()

document.addEventListener('DOMContentLoaded', () => {
  
  const appEl = document.getElementById('app')
  // console.log('appEl', appEl)
  const app = createApp({
    components: {
      SvgLogoPrimary,
      SvgEdgeCurve1,
      SvgEdgeCurve2,
      SvgEdgeCurve3,
      SvgIconFb,
      SvgIconLinkedin,
      SvgIconInsta,
      SvgIconGlobe,
      SvgIconDocument,
      SvgChevDown,
  
      ContentTabs,
      ContentTabsTabs,
      ContentGiantTabs,
      SmlTabsOverGiant,
      GiantTabsOverSml,
      PathwaySteps,
      BoxSlideshow,
      VidPlayer,
      SelectSml,
      StoryContainer,
      FormWrap,
      AjaxForm,
      FooterNavAccordion,
      SlideInBlock,
  
      HealthCheckTrigger,
      ContactTriggerPcos,
      ContactTriggerGestational,
  
      HealthCheck,
      ContactModalPcos,
      ContactModalGestational,
      ContactModalFacilitatorEoi,
      ContactModalProviderSignupEoi,
      ContactModalThcEoi,
      ContactModalWorkplace,
      ContactModalCommunityOrgAndGroups,
      InlineDialogShare,
      InlineDialogShareModal,

      TopNavSearch,
      TopNavSearchTrigger,
      TopNavLangSelector,
      MobileNav,
      MobileMenuToggler,
  
      BlogIndexTabbed,
      VideoSlideshow,
      TestimonialsSlideshow,
      GetInvolvedTabs,

      SubscribeForm,

      SingleAccordion,
    },
    config: {
      devtools: true,
    },
    mounted() {
      const topNav = document.getElementById('top-nav')
      let lastScrollTop = 0
      window.addEventListener('scroll', () => {
        let scrollTop = window.scrollY || document.documentElement.scrollTop
        let triggerHeight = topNav.offsetHeight
        if (scrollTop > triggerHeight && scrollTop > lastScrollTop) {
          topNav.classList.add('hidden')
        } else {
          topNav.classList.remove('hidden')
        }
        lastScrollTop = scrollTop
      });
      healthCheckTriggers.forEach(trigger => {
        eListen({
          selector: `a[href$="#${trigger.frag}"]`,
          callback: e => {
            e.preventDefault()
            healthCheck(trigger.lang).open()
          },
        })
        if (window.location.hash === `#${trigger.frag}`) {
          healthCheck(trigger.lang).open()
        }
      })
      // find iframes inside of appEl
      const iframes = appEl.querySelectorAll('iframe')
      if (iframes.length > 0) {
        iframes.forEach(iframe => {
          const table = iframe.closest('table')
          if (table) {
            table.classList.add('-has-video')
          }
        })
      }
    },
  })
  // console.log('app', app)
  
  
  app.mount(appEl)
});




