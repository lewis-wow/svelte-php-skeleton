<section class="container">
    <slot />
</section>

<style lang="scss">
    .container {
        max-width: 90%;
        margin-left: auto;
        margin-right: auto;

        /* A media query for a large screen */
        @media (--xl-viewport) {
            max-width: 1170px;
        }
    }
</style>
