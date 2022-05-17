module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
    './node_modules/@protonemedia/inertiajs-tables-laravel-query-builder/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/forms'),
  ],
  content: [
    './node_modules/@protonemedia/**/*.{js,vue}',
  ]
}
