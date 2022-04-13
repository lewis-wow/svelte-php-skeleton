<script>
    import { post } from '../api';
    import { Link } from 'svelte-routing';
</script>

<h1>Home page!</h1>

<Link to="/about">About page</Link>

<button on:click="{(e) => post('/api/test').then(console.log)}"
    >Fetch from api!</button
>
