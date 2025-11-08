import axios from 'axios';

const api = axios.create({
  baseURL: import.meta.env.VITE_API_URL || '/',
  timeout: 10000
});

api.interceptors.request.use(config => {
  config.headers = config.headers || {}
  config.headers['Accept-Language'] = localStorage.getItem('lang') || 'hu'
  return config
});

export default api;