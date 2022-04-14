import App from './App.svelte';

/** create the app without any props */
const app = new App({
    target: document.getElementById("root"),
    props: {}
});

export default app;
