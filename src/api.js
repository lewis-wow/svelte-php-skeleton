async function send({ method, path, body, token, headers = [] }) {
    const opts = { method, headers: {} };
    opts.headers['Content-Type'] = 'application/json';

    if (body) {
        opts.body = JSON.stringify(body);
    }

    if (headers) {
        opts.headers = Object.fromEntries(headers.map(({ key, value }) => [key, value]));
    }

    if (token) {
        opts.headers['Authorization'] = `Bearer ${token}`;
    }

    return fetch(`${path}`, opts).then(async (r) => {
        if (r.status >= 200 && r.status < 400) {
            return await r.text();
        } else {
            return await r.text();
        }
    }).then((str) => {
        try {
            return JSON.parse(str);
        } catch (err) {
            return str;
        }
    });
}

export function get(path, token = null) {
    return send({ method: 'GET', path, body: null, token })
}

export function del(path, token = null) {
    return send({ method: 'DELETE', path, body: null, token })
}

export function post(path, body, token = null) {
    return send({ method: 'POST', path, body, token })
}

export function put(path, body, token = null, headers = []) {
    return send({ method: 'PUT', path, body, token, headers })
}
