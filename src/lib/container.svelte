<section class="container">
    <slot />
</section>

<style>
    .container {
        max-width: 90%;
        margin-left: auto;
        margin-right: auto;
    }

    /* A media query for a large screen */
    @media (min-width: 1170px) {
        .container {
            max-width: 1170px;
        }
    }
</style>
