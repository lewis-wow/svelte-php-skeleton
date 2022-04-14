<script>
    import { Route } from 'svelte-navigator';
    import ProtectedRouteGuard from './protectedRouteGuard.svelte';

    export let path;
    export let fallback = '/';
    export let allow = true;
</script>

<Route path="{path}" let:params let:location let:navigate>
    <ProtectedRouteGuard allow="{allow}" fallback="{fallback}">
        <slot params="{params}" location="{location}" navigate="{navigate}" />
    </ProtectedRouteGuard>
</Route>
