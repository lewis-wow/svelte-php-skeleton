<script>
    import { post } from '../api'
    import { Link } from 'svelte-routing'

    // using $lib alias for /src/lib folder
    import Container from '$lib/container.svelte'

    import Offline from '$lib/offline/index.svelte'
</script>

<Container>
    <h1>Home page!</h1>

    <Link to="/about">About page</Link>

    <button on:click={(e) => post('/api/test', { test: 'test' }).then(console.log)}
        >Fetch from api!</button
    >

    <Offline on:update={console.log}>
        <span slot="online">online</span>
        <span slot="offline">offline</span>
    </Offline>
</Container>

<style>
    button {
        color: blue;
    }

    button:hover {
        color: green;
    }
</style>
