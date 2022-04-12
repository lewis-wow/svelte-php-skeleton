<script>
    import { post } from '../api';
</script>

home!
<button on:click="{(e) => post('/api/test').then(console.log)}"
    >Fetch from api!</button
>
