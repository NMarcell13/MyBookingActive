if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/sw.js')
        .then((registration) => {
          console.log('ServiceWorker regisztráció sikeres:', registration.scope);
        })
        .catch((error) => {
          console.log('ServiceWorker regisztráció sikertelen:', error);
        });
    });
  }