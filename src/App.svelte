<script>
    /** Router page, every routes should be in /src/routes folder */

    import './scss/main.scss'; //global scss for each page

    import { Router, Link, Route } from 'svelte-routing';

    /** import every route from /src/routes */
    import Home from './routes/home.svelte';
    import About from './routes/about.svelte';
</script>

<main>
    <Router>
        <div>
            <Route path="/about">
                <About />
            </Route>
            <Route path="/">
                <Home />
            </Route>
        </div>
    </Router>
</main>
