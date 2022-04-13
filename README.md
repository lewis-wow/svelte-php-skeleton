# Svelte + PHP

## Editing
Edit `/src` for frontend and `/public` for backend.
Don't edit `/public/build`, it is a dist for Svelte transpiler.

## Install dependencies (Javascript)
```bash
npm install
```

## Install dependencies (PHP)
```bash
composer install
```

## Start PHP server
```bash
npm run php
```

## Transpile Javascript (Client)
```bash
npm run build
```

## API routes
`/public/router/api.php`

## Api requests
```
    import { post, get, del, put } from '../api';
    post('/api/test').then(console.log);
```
