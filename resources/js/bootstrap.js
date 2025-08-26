import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
  forceTLS: true,
  authEndpoint: '/broadcasting/auth',
  auth: {
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  }
});

// (optional) basic logging:
window.Echo.connector.pusher.connection.bind('connected', () => {
  console.log('[Echo] connected');
});
window.Echo.connector.pusher.connection.bind('error', (err) => {
  console.error('[Echo] error', err);
});
