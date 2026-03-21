// postcss.config.js

import autoprefixer from 'autoprefixer';
import postcssTailwind from '@tailwindcss/postcss';

export default {
  plugins: [
    postcssTailwind,
    autoprefixer,
  ],
}