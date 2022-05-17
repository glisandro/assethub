require('./bootstrap');

import { createApp, h } from 'vue'
import { createInertiaApp, Head, Link } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import {
  Checkbox,
  Form,
  File,
  Group,
  Input,
  Radio,
  Select,
  Submit,
  Textarea,
} from "@protonemedia/form-components-pro-vue3-tailwind3-simple";

InertiaProgress.init({
  // The delay after which the progress bar will
  // appear during navigation, in milliseconds.
  delay: 250,

  // The color of the progress bar.
  color: '#29d',

  // Whether to include the default NProgress styles.
  includeCSS: true,

  // Whether the NProgress spinner will be shown.
  showSpinner: true,
})

const app = createInertiaApp({
  resolve: name => require(`./Pages/${name}`),
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .use(plugin)
      .mixin({ methods: { route: window.route} })
      .component('InertiaHead', Head)
      .component('InertiaLink', Link)
      .component('Checkbox', Checkbox)
      .component('Form', Form)
      .component('File', File)
      .component('Group', Group)
      .component('Input', Input)
      .component('Radio', Radio)
      .component('Select', Select)
      .component('Submit', Submit)
      .component('Textarea', Textarea)
      .mount(el)
  },
})
