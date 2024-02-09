(() => {
   'use strict';

   const getStoredTheme = () => localStorage.getItem('theme');
   const setStoredTheme = theme => localStorage.setItem('theme', theme);

   const getPreferredTheme = () => {
       const storedTheme = getStoredTheme();
       if (storedTheme) {
           return storedTheme;
       }
       return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
   };

   const setTheme = theme => {
       if (theme === 'auto') {
           theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
       }
       document.documentElement.setAttribute('data-bs-theme', theme);
   };

   setTheme(getPreferredTheme());

   window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
       const storedTheme = getStoredTheme();
       if (storedTheme === 'auto') {
           setTheme('auto');
       }
   });

   window.addEventListener('DOMContentLoaded', () => {
       const checkbox = document.querySelector('#checkbox');
       const currentTheme = getPreferredTheme();
       if (currentTheme === 'dark') {
           checkbox.checked = true;
       }

       checkbox.addEventListener('change', () => {
           const theme = checkbox.checked ? 'dark' : 'light';
           setStoredTheme(theme);
           setTheme(theme);
       });

       // Add an event listener for the system theme change
       window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
           const newColorScheme = e.matches ? 'dark' : 'light';
           setTheme(newColorScheme);
       });
   });
})();
