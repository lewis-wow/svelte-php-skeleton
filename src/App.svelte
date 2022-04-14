<script>
    /** Router page, every routes should be in /src/routes folder */

    import './scss/main.scss'; //global scss for each page

    import { Router, Route } from 'svelte-navigator';
    import ProtectedRoute from '$lib/protectedRoute/index.svelte';

    /** import every route from /src/routes */
    import Home from './routes/home.svelte';
    import About from './routes/about.svelte';
    import PrivateRoute from './routes/private.svelte';

    export let url = '';

    /** should be edited as loggedIn for example */
    let allowProtectedRoute = false;
</script>

<main>
    <Router url="{url}" basepath="/" primary="{true}">
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
                allow="{allowProtectedRoute}"
            >
                <PrivateRoute />
            </ProtectedRoute>

            <Route path="/*">
                <!-- 404 path -->
            </Route>
        </div>
    </Router>
</main>
