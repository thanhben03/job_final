import Echo from 'laravel-echo';

import Pusher from 'pusher-js';
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '9c0f2c0b02f71527fa5f',
    cluster: 'ap1',
    forceTLS: true
});
