<script>
    import Redirect from './redirect.svelte';

    export let fallback;
    export let allow;
    export let location;
</script>

{#if allow}
    <slot />
{:else}
    <Redirect to="{fallback}" state="{{ from: location.pathname }}" />
{/if}
