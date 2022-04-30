<script>
    /** Router page, every routes should be in /src/routes folder */

    import './scss/main.scss'; //global scss for each page

    import { Router, Route } from 'svelte-routing';
    import ProtectedRoute from '$lib/protectedRoute/index.svelte';

    /** import fallback routes */
    import Page404 from './routes/404.svelte';

    /** import stores */
    import user from './stores/user';

    /** import every route from /src/routes */
    import Home from './routes/home.svelte';
    import About from './routes/about.svelte';
    import PrivateRoute from './routes/private.svelte';

    /** url given from server if using ssr, if you are not using ssr, keep it empty */
    export let url = '';
</script>

<div>
    <Router url="{url}" basepath="/">
        <div>
            <Route path="/">
                <Home />
            </Route>

            <Route path="/about">
                <About />
            </Route>

            <ProtectedRoute
                path="/protected"
                fallback="/"
                allow="{$user.loggedIn}"
            >
                <PrivateRoute />
            </ProtectedRoute>

            <Route path="/*">
                <Page404 />
            </Route>
        </div>
    </Router>
</div>
