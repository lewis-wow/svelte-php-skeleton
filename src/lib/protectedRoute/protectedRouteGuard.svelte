<script>
    import { useNavigate, useLocation } from 'svelte-navigator';

    export let fallback;
    export let allow;

    const navigate = useNavigate();
    const location = useLocation();

    $: if (!allow) {
        navigate(fallback, {
            state: { from: $location.pathname },
            replace: true,
        });
    }
</script>

{#if allow}
    <slot />
{/if}
