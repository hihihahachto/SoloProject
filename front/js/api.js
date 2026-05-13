// front/js/api.js
const API = '/SoloProject/api/index.php';

async function apiRequest(endpoint, method = 'GET', data = null) {
    const options = {
        method: method,
        headers: {
            'Content-Type': 'application/json',
        }
    };

    if (data && (method === 'POST' || method === 'PUT' || method === 'PATCH')) {
        options.body = JSON.stringify(data);
    }

    let url = `${API}`;
    if (endpoint) {
        url += `?q=${endpoint}`;
    }

    const response = await fetch(url, options);
    return await response.json();
}

const AnimalsAPI = {
    getAll: () => apiRequest('animals'),
    getOne: (id) => apiRequest(`animals/${id}`),
    create: (data) => apiRequest('animals', 'POST', data),
    update: (id, data) => apiRequest(`animals/${id}`, 'PUT', data),
    patch: (id, data) => apiRequest(`animals/${id}`, 'PATCH', data),
    delete: (id) => apiRequest(`animals/${id}`, 'DELETE')
};

const VolunteersAPI = {
    getAll: () => apiRequest('volunteers'),
    create: (data) => apiRequest('volunteers', 'POST', data)
};