<script>
    import './css/main.scss';

    import { Router, Link, Route } from 'svelte-routing';
    import Home from './routes/home.svelte';
    import About from './routes/about.svelte';
</script>

<main>
    <Router>
        <nav>
            <Link to="/">Home</Link>
            <Link to="/about">About</Link>
        </nav>
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
