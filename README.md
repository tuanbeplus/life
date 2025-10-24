# Life Program WordPress Theme

A modern WordPress theme built with Vue 3, Vite, and PostCSS for the Life Program project.

## Tech Stack

- **Frontend Framework**: Vue 3 with `<script setup>` SFCs
- **Build Tool**: Vite 5
- **Styling**: PostCSS with custom media queries, mixins, and nested syntax
- **Node Version**: 22 (specified in .nvmrc)
- **PHP**: WordPress theme functions and templates

## Prerequisites

- Node.js 22 (use `nvm use` to switch to the correct version)
- WordPress installation
- PHP 7.4 or higher

## Installation

1. Clone or download this theme into your WordPress themes directory:
   ```bash
   wp-content/themes/life/
   ```

2. Install Node.js dependencies:
   ```bash
   npm install
   ```

3. Activate the theme in WordPress Admin under Appearance > Themes

## Development

### Running Development Server

Start the Vite development server with hot module replacement:

```bash
npm run dev
```

This will start the Vite dev server and watch for changes in your Vue components and styles.

### Building for Production

Build and minify assets for production:

```bash
npm run build
```

Built files will be output to the `public/` directory.

### Preview Production Build

Preview the production build locally:

```bash
npm run preview
```

## Project Structure

- `/src/` - Vue components, JavaScript, and PostCSS files
- `/public/` - Compiled assets (generated, not tracked in git)
- `/assets/` - Static assets, images, and compiled CSS
- `/inc/` - PHP includes and helper functions
- `/page-templates/` - WordPress page templates
- `/partials/` - Reusable PHP template parts
- `/emails/` - Email templates
- `/acf-json/` - Advanced Custom Fields JSON exports
- `/form-submissions/` - Gravity Forms submission logs

## Key Dependencies

- **@vuepic/vue-datepicker** - Vue 3 datepicker component
- **@vueuse/core** - Collection of Vue composition utilities
- **axios** - HTTP client for API requests
- **fslightbox-vue** - Lightbox for images and videos
- **mitt** - Event emitter for Vue
- **dialog-polyfill** - Dialog element polyfill

## IDE Setup

### Recommended

- [VS Code](https://code.visualstudio.com/)
- [Vue - Official](https://marketplace.visualstudio.com/items?itemName=Vue.volar) extension (previously Volar)
- Disable Vetur if installed

### Configuration Files

- `.editorconfig` - Editor configuration for consistent coding styles
- `eslint.config.js` - ESLint configuration for code linting
- `vite.config.js` - Vite build configuration
- `postcss.config.cjs` - PostCSS configuration
- `jsconfig.json` - JavaScript configuration for IDE

## Notes

- This theme uses local storage for membership system parameters (not cookies)
- Form submissions are logged in `/form-submissions/`
- The theme integrates with Gravity Forms and Salesforce

## License

ISC
