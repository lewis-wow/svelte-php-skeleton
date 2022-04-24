<script>
    import { createEventDispatcher } from 'svelte';
    const dispatch = createEventDispatcher();

    $: isOnline = navigator.onLine || false;

    const updateOnlineStatus = () => {
        isOnline = navigator.onLine || false;
        dispatch('update', { online: isOnline });
    };
</script>

<svelte:window
    on:online="{updateOnlineStatus}"
    on:offline="{updateOnlineStatus}"
    on:load="{updateOnlineStatus}"
/>

{#if isOnline}
    <slot name="online" />
{:else}
    <slot name="offline" />
{/if}
