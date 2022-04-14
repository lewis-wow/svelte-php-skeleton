<script>
    import { Route } from 'svelte-routing';
    import ProtectedRouteGuard from './protectedRouteGuard.svelte';

    export let path;
    export let fallback = '/';
    export let allow = true;
</script>

<Route path="{path}" let:params let:location let:navigate>
    <ProtectedRouteGuard
        allow="{allow}"
        fallback="{fallback}"
        location="{location}"
    >
        <slot params="{params}" location="{location}" navigate="{navigate}" />
    </ProtectedRouteGuard>
</Route>
