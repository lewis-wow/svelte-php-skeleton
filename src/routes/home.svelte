<script>
    import { post } from '../api';
    import { Link } from 'svelte-navigator';

    // using $lib alias for /src/lib folder
    import Container from '$lib/container.svelte';
</script>

<Container>
    <h1>Home page!</h1>

    <Link to="/about">About page</Link>

    <button
        on:click="{(e) =>
            post('/api/test', { test: 'test' }).then(console.log)}"
        >Fetch from api!</button
    >
</Container>
